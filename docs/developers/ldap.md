# LDAP
::: info
LDAP authentication will connect to the server which is declared in the .env file and try
to authenticate the given user in combination with the given password. The authentication will
return a [JWT](https://jwt.io).
:::

::: warning
You have to configure `config/packages/lexik_jwt_authentication.yaml` first, to run<br> `php bin/console lexik:jwt:generate-keypair`!
:::

## Group Check
In order to use the group check and mapping of user roles correctly, you have to configure 3 properties in your `.env`.
The numbers you configure represent the group GID in LDAP.<br>
Roles:
- `SBA_ADMIN`
- `SBA_USER`
- `SBA_GUEST`

Default role if none of these groups can be found: `SBA_NOT_PERMITTED`

## LoginController

### Overview
The `LoginController` is a Symfony controller responsible for handling authentication requests. It contains an action
method `index()` mapped to the route `/api/v1/login`, which authenticates users and generates authentication tokens.

### Functionality
+ **Authentication**: It accepts username (usr) and password (pwd) parameters from the request and authenticates the user
  using an instance of AuthService.
+ **Token Generation**: Upon successful authentication, it generates an authentication token using the AuthToken class and
  returns it as a JSON response.
+ **Route**: The action method is mapped to the `/api/v1/login` route.


## AuthService

### Overview
The `AuthService` class provides functionality for authenticating users against an LDAP server.

### Functionality
+ **LDAP Connection**: It establishes a connection to the LDAP server specified in the environment variable LDAP_URL.
+ **Token Handling**: Creates, deletes outdated and validates Tokens for secure token handling
+ **Authentication**: It attempts to bind to the LDAP server using the provided user credentials (`$user` and `$password`) within the specified LDAP base.
+ **Error Handling**: It catches any exceptions that occur during the authentication process and returns false in case of failure.

## AuthToken

### Overview
The `AuthToken` class is responsible for encoding and decoding JSON Web Tokens (JWTs) using a provided key.

### Functionality
+ **Token Encoding**: It encodes a payload into a JWT using the provided key.
+ **Token Decoding**: It decodes a JWT token using the provided key.
+ **Exception Handling**: It catches exceptions during encoding and decoding processes and throws appropriate exceptions.
