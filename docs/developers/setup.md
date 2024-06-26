# Setup

## Installation for Development

1. clone the repository:

```bash
git clone https://github.com/Dino-Kupinic/Schulbuchaktion.git
```

## Frontend

1. go into the frontend directory

```bash
cd frontend
```

2. install packages

```bash
pnpm i
```

::: tip
If you don't have pnpm installed, checkout https://pnpm.io/installation to install for your operating system.
:::

3. define environment variables

Create a `.env` file and checkout the `.env.example`. Copy the content into your `.env` and replace
the following fields with your own. You may edit some existing fields aswell.

| Field         | Description                                                                    |
|---------------|--------------------------------------------------------------------------------|
| `BACKEND_URL` | URL to the Symfony Backend server (e.g. `http://localhost:8000/api/v1` in dev) |

Make sure to include the `/api/v1` suffix at the end of the URL. This environment variable is used for the Base URL for
fetch requests.

4. run dev server

```bash
pnpm run dev
```

5. Head to `http://localhost:3000/`

If it works, great!

::: warning
Following instruction is optional and may be skipped. If you have slow internet, it may take a while to
install Chrome, Safari and Firefox (~150 MB)
:::

6. Install playwright browsers

```
npx playwright install
```

## Backend

1. go into the backend directory

```bash
cd ../backend
```

or

```bash
cd backend
```

2. define environment variables

Create a `.env` file and checkout the `.env.example`. Copy the content into your `.env` and replace
the following fields with your own. You may edit some existing fields aswell.

| Field                      | Description                                                                                                                         |
|----------------------------|-------------------------------------------------------------------------------------------------------------------------------------|
| `APP_SECRET`               | A secret key that's used to secure your application's services.                                                                     |
| `SECRET_PASSWORD`          | Database password                                                                                                                   |
| `USERNAME`                 | Database user                                                                                                                       |
| `BIND_PORT`                | Database port                                                                                                                       |
| `DATABASE_URL`             | The URL String to your database. It will use the env variables above.                                                               |
| `LDAP_PORT`                | The port of your LDAP server.                                                                                                       |
| `LDAP_URL`                 | The URL of your LDAP server.                                                                                                        |
| `LDAP_BASE`                | The base of your LDAP server. (`dc=schulbuchaktion,dc=env`)                                                                         |
| `ROLES`                    | String of all roles seperated with commas (default `'SBA_ADMIN,SBA_LEHRER,SBA_FV,SBA_AV'`)                                          |
| `SBA_ADMIN`                | Group number of the admin group. (default `500`)                                                                                    |
| `SBA_LEHRER`               | Group number of the teacher group. (default `501`)                                                                                  |
| `SBA_FV`                   | Group number of the subject responsible group. (default `502`)                                                                      |
| `SBA_AV`                   | Group number of the head of department group. (default `503`)                                                                       |
| `TOKEN_TIMEOUT`            | How long a token is valid. (default `1800`)                                                                                         |
| `HOURS_AHEAD`              | Timezone (default `2`)                                                                                                              |
| `JWT_SECRET_ABSOLUT_PATH`  | The absolute path to the private key for the JWT.                                                                                   |
| `CORS_ALLOW_ORIGIN`        | The origin that is allowed to access the API. (default `localhost`)                                                                 |
| `TOKEN_NAME`               | Name of Cookie which contains bearer token (default `bearer`)                                                                       |
| `CADDY_MERCURE_JWT_SECRET` | Used to securely sign JWTs for client authentication and authorization in a Caddy server setup with Mercure.                        |
| `TRUSTED_PROXIES`          | Specifies the IP addresses or ranges of proxies that are trusted to correctly set client-related headers in a server configuration. |
| `TRUSTED_HOSTS`            | Specifies a list of hostnames or patterns that are considered trusted and allowed to make requests.                                 |
| `CADDY_MERCURE_URL`        | Specifies the URL of the Mercure hub used by the Caddy server.                                                                      |
| `CADDY_MERCURE_PUBLIC_URL` | Specifies the publicly accessible URL of the Mercure hub.                                                                           |
| `HTTP_PORT`                | Port which will be open for http connections. (default `80`)                                                                        |
| `HTTPS_PORT`               | Port which will be open for https connections. (default `443`)                                                                      |
| `SHELL_VERBOSITY`          | Verbosity level of server and symfony. (default `0`)                                                                                |

::: danger
For the `APP_SECRET` checkout https://symfony.com/doc/current/reference/configuration/framework.html#secret to see the
latest requirements.
:::

3. start docker

```bash
docker compose up -d
```

::: tip
If you don't have docker installed, checkout https://www.docker.com/products/docker-desktop/ to install for your
operating system.
:::

4. install dependencies

```bash
composer update
```

::: danger
If you get errors, you might have to comment out modules like `ldap` or `zip` in your `php.ini` file. Composer will tell
you what to do.
:::

5. start the dev server

```bash
symfony server:start
```

::: warning
If you don't have symfony cli installed, checkout https://symfony.com/download#step-1-install-symfony-cli to install
for your operating system.
:::

6. head to `http://127.0.0.1:8000`

## Docs

1. go into the docs directory

```bash
cd ../docs
```

or

```bash
cd docs
```

2. install packages

```bash
pnpm i
```

::: tip
If you don't have pnpm installed, checkout https://pnpm.io/installation to install for your operating system.
:::

3. run dev server

```bash
pnpm run docs:dev
```

4. Head to `http://localhost:5173/`
