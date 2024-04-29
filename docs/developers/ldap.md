# LDAP
::: info
LDAP authentication will connect to the server which is declared in the .env file and try
to authenticate the given user in combination with the given password. The authentication will
return a [JWT](https://jwt.io).
:::

::: warning
You have to configure `config/packages/lexik_jwt_authentication.yaml` first, to run<br> `php bin/console lexik:jwt:generate-keypair`!
:::


## LoginController

### Overview
The `LoginController` is a Symfony controller responsible for handling authentication requests. It contains an action
method `index()` mapped to the route `/api/v1`, which authenticates users and generates authentication tokens.

### Code Breakdown
```php
<?php

namespace App\Controller;

use App\Repository\AuthTokenRepository;
use App\Service\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1', name: 'login.')]
class LoginController extends AbstractController
{
  #[Route(name: 'index')]
  public function index(AuthService $authService, Request $request): Response
  {
    $user = $request->get("usr");
    $pwd = $request->get("pwd");

    $token = $authService->createToken($user, $pwd);

    return new JsonResponse(['token' => $token]);
  }
}

```

### Functionality
+ **Authentication**: It accepts username (usr) and password (pwd) parameters from the request and authenticates the user
  using an instance of AuthService.
+ **Token Generation**: Upon successful authentication, it generates an authentication token using the AuthToken class and
  returns it as a JSON response.
+ **Route**: The action method is mapped to the /api/v1 route.


## AuthService

### Overview
The `AuthService` class provides functionality for authenticating users against an LDAP server.

### Code Breakdown
```php
<?php

namespace App\Service;

use App\Entity\AuthToken;
use App\Repository\AuthTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Exception;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

class AuthService
{
  private EntityManagerInterface $em;
  private AuthTokenRepository $authTokenRepository;

  /**
   * @param EntityManagerInterface $em
   * @param AuthTokenRepository $authTokenRepository
   */
  public function __construct(EntityManagerInterface $em, AuthTokenRepository $authTokenRepository)
  {
    $this->em = $em;
    $this->authTokenRepository = $authTokenRepository;
  }


  public function authenticateUser($user, $password): bool
  {
    $success = false;
    try {
      $ds = ldap_connect($_ENV["LDAP_URL"]) or throw new Exception("Could not connect to LDAP server.");
      ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
      if ($ds) {
        /**
         * LDAP-Request for school
         *
         * $r = ldap_bind($ds) or throw new Exception("Error trying to bind: " . ldap_error($ds));
         * $sr = ldap_search($ds, $_ENV["SCHULE_BASE"], "cn=$user", array("dn")) or throw new LdapException ("Error in search query: " . ldap_error($ds));
         * $res = ldap_get_entries($ds, $sr);
         * $userDN = $res[0]['dn'];
         */

        /**
         * LDAP-Request for Test-Environment
         */
        $userDN = "cn=$user," . $_ENV["LDAP_BASE"];

        $success = @ldap_bind($ds, $userDN, $password) or throw new Exception("Error trying to bind: " . ldap_error($ds));

        ldap_close($ds);
      }
    } catch (Exception) {
      $success = false;
    }
    return $success;
  }

  public function createToken(string $user, string $password): string
  {
    $status = $this->authenticateUser($user, $password);
    return new AuthToken($user, $status, $this->em);
  }

  public function checkToken(string $JWTString): bool
  {
    $this->optimizeTable();
    try {
      $token = new AuthToken();
      $token->setJwtString($JWTString);
      $dbToken = $this->em->getRepository(AuthToken::class)->find($token->getId());
      if ($token->isValid($dbToken)) {
        $this->updateTime($dbToken);
        return true;
      } else return false;

    } catch (Exception $e) {
      return false;
    }
  }

  private function updateTime(AuthToken $token): void
  {
    $token->setTimeStamp(time());
    $this->em->persist($token);
    $this->em->flush();

  }

  private function optimizeTable(): void
  {
    $now = time() + 3600 * (int)$_ENV['HOURS_AHEAD'];
    $timeOuteDate = date('c', $now - $_ENV['TOKEN_TIMEOUT']);
    $tokens = $this->authTokenRepository->findExpiredTokens($timeOuteDate);

    foreach ($tokens as $token) {
      $this->em->remove($token);
    }
    $this->em->flush();
  }
}



?>
```

### Functionality
+ **LDAP Connection**: It establishes a connection to the LDAP server specified in the environment variable LDAP_URL.
+ **Token Handling**: Creates, deletes outdated and validates Tokens for secure token handling
+ **Authentication**: It attempts to bind to the LDAP server using the provided user credentials (`$user` and `$password`) within the specified LDAP base.
+ **Error Handling**: It catches any exceptions that occur during the authentication process and returns false in case of failure.

## AuthToken

### Overview
The `AuthToken` class is responsible for encoding and decoding JSON Web Tokens (JWTs) using a provided key.

### Code Breakdown
```php
<?php

namespace App\Entity;

use App\Repository\AuthTokenRepository;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use JWT\Authentication\JWT;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;

#[ORM\Entity(repositoryClass: AuthTokenRepository::class)]
class AuthToken
{
  private static string $key = '';
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(type: Types::TEXT, nullable: true)]
  private ?string $jwtString = null;

  #[ORM\Column(length: 255)]
  private ?string $username = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE)]
  private ?DateTimeInterface $timeStamp = null;

  #[ORM\Column]
  private ?bool $authenticated = null;

  private static DateTimeZone $timezone;


  public function __construct(string $username = null, bool $authenticated = null, EntityManagerInterface $em = null)
  {
    if (empty(AuthToken::$key)) {
      self::$key = file_get_contents("$_SERVER[PWD]/config/jwt/private.pem");
      self::$timezone = new DateTimeZone("Europe/Vienna");
    }

    $this->timeStamp = new DateTime();
    $this->timeStamp->setTimezone(self::$timezone);

    if (!is_null($username) && $authenticated) {
      $this->username = $username;
      $this->authenticated = $authenticated;
      $timeStamp = (int)$this->timeStamp->format('U');
      $em->persist($this);
      $em->flush();

      $id = $this->id;
      $this->jwtString = $this->encode(compact('id', 'username', 'authenticated', 'timeStamp'));
      $em->persist($this);
      $em->flush();
    } else $this->jwtString = $this->encode(compact('authenticated'));
  }

  public function setId(?int $id): void
  {
    $this->id = $id;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getJwtString(): ?string
  {
    return $this->jwtString;
  }

  public function setJwtString(string $jwtString): static
  {
    $this->jwtString = $jwtString;

    if (!$jwtString == '') {
      foreach ($this->decode($jwtString) as $key => $value) {
        $function = 'set' . ucfirst($key);

        if (strcmp($key, 'timeStamp') == 0) $this->timeStamp->setTimestamp($value);
        else $this->$function($value);
      }
    }

    return $this;
  }

  public function getUsername(): ?string
  {
    return $this->username;
  }

  public function setUsername(string $username): static
  {
    $this->username = $username;

    return $this;
  }

  public function getTimeStamp(): ?DateTimeInterface
  {
    return $this->timeStamp;
  }

  public function setTimeStamp(int $timeStamp): static
  {
    $this->timeStamp = new DateTime();
    $this->timeStamp->setTimezone(self::$timezone);
    $this->timeStamp->setTimestamp($timeStamp);

    return $this;
  }

  public function isAuthenticated(): ?bool
  {
    return $this->authenticated;
  }

  public function setAuthenticated(bool $authenticated): static
  {
    $this->authenticated = $authenticated;

    return $this;
  }

  private function encode(array $data): string
  {
    try {
      return JWT::encode($data, self::$key);
    } catch (Exception $e) {
      throw new JWTEncodeFailureException(JWTEncodeFailureException::INVALID_CONFIG, 'An error occurred while trying to encode the JWT token.', $e);
    }
  }

  private function decode($token = null): array
  {
    if (is_null($token)) $token = $this->jwtString;
    try {
      return (array)JWT::decode($token, self::$key);
    } catch (Exception $e) {
      throw new JWTDecodeFailureException(JWTDecodeFailureException::INVALID_TOKEN, 'Invalid JWT Token', $e);
    }
  }

  public function isValid(AuthToken $otherToken = null): bool
  {
    try {
      if (empty(array_diff($this->decode(), $this->decode($otherToken->jwtString)))) {
        $sig1 = explode('.', $this->jwtString)[2];
        $sig2 = explode('.', $otherToken->jwtString)[2];
        return strcmp($sig1, $sig2) == 0;
      } else return false;
    } catch (JWTDecodeFailureException $e) {
      return false;
    }
  }

  public function __toString(): string
  {
    return $this->jwtString;
  }


}

```

### Functionality
+ **Token Encoding**: It encodes a payload into a JWT using the provided key.
+ **Token Decoding**: It decodes a JWT token using the provided key.
+ **Exception Handling**: It catches exceptions during encoding and decoding processes and throws appropriate exceptions.
