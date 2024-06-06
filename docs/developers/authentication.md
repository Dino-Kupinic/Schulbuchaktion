# Sign in/out

Schulbuchaktion uses LDAP for authentication.
Username and password are only used to authenticate against the LDAP server, which means there is no user database table.

## Bearer Token

The backend API returns a JWT Token after an authentication attempt.
Encoding the token is done using the `HS256` algorithm. For that we use the `jwt-decode` library.

### Payload

The payload (as of `v0.12.1`) of the token contains the following information:

```json {5}
{
  "id": 5,
  "username": "testuser",
  "role": "NOT_PERMITTED",
  "authenticated": true,
  "timeStamp": 1717410359
}
```

The authenticated field is used to determine if the user is authenticated or not.
Curious about the `role` field? Visit the [Security](./security) page.

## Route Guard Middleware

The `auth` middleware is used to protect routes from unauthorized access.
In Nuxt, it is registered globally and run on each route change.

```ts
// ...

// Redirect to login if not authenticated
if (!authenticated && to.path !== "/login") {
  return navigateTo("/login")
}

// prevent from going to login if already authenticated
if (authenticated && to.path === "/login") {
  return navigateTo("/")
}

// ...
```

Make sure to read the [Documentation](https://nuxt.com/docs/guide/directory-structure/middleware) for more information.


