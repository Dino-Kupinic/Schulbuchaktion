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

  #[ORM\Column(length: 255)]
  private ?string $role = null;

  public function __construct(string $username = null, string $role = "SBA_NOT_PERMITTED", bool $authenticated = null, EntityManagerInterface $em = null)
  {
    if (empty(AuthToken::$key)) {
      self::$key = file_get_contents($_ENV["JWT_SECRET_ABSOLUT_PATH"]);
      self::$timezone = new DateTimeZone("Europe/Vienna");
    }
    $this->timeStamp = new DateTime();
    $this->timeStamp->setTimezone(self::$timezone);

    if (!is_null($username) && $authenticated) {
      $this->username = $username;
      $this->role = $role;
      $this->authenticated = $authenticated;
      $timeStamp = (int)$this->timeStamp->format('U');
      $em->persist($this);
      $em->flush();

      $id = $this->id;
      $this->jwtString = $this->encode(compact('id', 'username', 'role', 'authenticated', 'timeStamp'));
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

  public function getRole(): ?string
  {
    return $this->role;
  }

  public function setRole(string $role): static
  {
    $this->role = $role;

    return $this;
  }


}
