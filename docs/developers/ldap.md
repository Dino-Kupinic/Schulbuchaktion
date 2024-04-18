# LDAP
::: info
LDAP authentication will connect to the server which is declared in the .env file and try
to authenticate the given user in combination with the given password. The authentication will
return a [JWT](https://jwt.io).
:::

## LoginController

### Overview
The `LoginController` is a Symfony controller responsible for handling authentication requests. It contains an action
method `index()` mapped to the route `/ldaps`, which authenticates users and generates authentication tokens.

### Code Breakdown
```php
class LoginController extends AbstractController
{
  #[Route('/ldaps', name: 'app_ldap')]
  public function index(AuthService $authService, Request $request, Kernel $kernel): Response
  {
    $user = $request->get("usr");
    $pwd = $request->get("pwd");
    $status = $authService->authenticateUser($user, $pwd);

    $key = file_get_contents($kernel->getProjectDir() . "/config/jwt/private.pem");
    $token = new AuthToken($key);
    $token->setValue(['user' => $user, 'authorized' => $status]);

    return new JsonResponse($token, 200, [], true);
  }
}
```

### Functionality
+ **Authentication**: It accepts a username (`usr`) and password (`pwd`) parameters from the request and authenticates the user
  using an instance of AuthService.
+ **Token Generation**: Upon successful authentication, it generates an authentication token using the AuthToken class and
  returns it as a JSON response.
+ **Route**: The action method is mapped to the `/ldaps` route.


## AuthService

### Overview
The `AuthService` class provides functionality for authenticating users against an LDAP server.

### Code Breakdown
```php
class AuthService
{
  public function authenticateUser($user, $password): bool
  {
    $success = null;
    try {
      $ds = ldap_connect($_ENV["LDAP_URL"]) or throw new Exception("Could not connect to LDAP server.");
      if ($ds) {
        // LDAP-Request for Test-Environment
        $userDN = "cn=$user,ou=TestUsers," . $_ENV["LDAP_BASE"];

        // Attempt to bind to the LDAP server with user credentials
        $success = @ldap_bind($ds, $userDN, $password) or throw new Exception("Error trying to bind: " . ldap_error($ds));

        ldap_close($ds);
      }
    } catch (Exception $e) {
      $success = false;
    }
    return $success;
  }
}
```

### Functionality
+ **LDAP Connection**: It establishes a connection to the LDAP server specified in the environment variable `LDAP_URL`.
+ **Authentication**: It attempts to bind to the LDAP server using the provided user credentials (`$user` and `$password`) within the specified LDAP base.
+ **Error Handling**: It catches any exceptions that occur during the authentication process and returns false in case of failure.

## AuthToken

### Overview
The `AuthToken` class is responsible for encoding and decoding JSON Web Tokens (JWTs) using a provided key.

### Code Breakdown
```php
class AuthToken
{
  private string $key;
  public string $jwtString;
  public bool $success;

  // ...

  private function encode(array $data): string // [!code highlight]
  {
    try {
      $data = array_merge($data, ['iat' => (int)date('U')]);
      return JWT::encode($data, $this->key);
    } catch (Exception $e) {
      throw new JWTEncodeFailureException(JWTEncodeFailureException::INVALID_CONFIG, 'An error occurred while trying to encode the JWT token.', $e);
    }
  }

  public function decode($token): array // [!code highlight]
  {
    try {
      return (array)JWT::decode($token, $this->key);
    } catch (Exception $e) {
      throw new JWTDecodeFailureException(JWTDecodeFailureException::INVALID_TOKEN, 'Invalid JWT Token', $e);
    }
  }

  // ...
}
```

### Functionality
+ **Token Encoding**: It encodes a payload into a JWT using the provided key.
+ **Token Decoding**: It decodes a JWT token using the provided key.
+ **Exception Handling**: It catches exceptions during encoding and decoding processes and throws appropriate exceptions.
