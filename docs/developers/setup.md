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

3. run dev server

```bash
pnpm run dev
```

4. Head to http://localhost:3000/

## Backend

1. go into the backend directory

```bash
cd ../backend
```

2. define environment variables

Create a `.env` file and checkout the `.env.example`. Copy the content into your `.env` and replace
the `SECRET_PASSWORD`, `USERNAME`, `BIND_PORT`, `APP_SECRET`  fields with your own.

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
composer install
```

5. start the dev server

```bash
symfony server:start
```

::: warning
If you don't have symfony cli installed, checkout https://symfony.com/download#step-1-install-symfony-cli to install
for your operating system.
:::

6. head to http://127.0.0.1:8000

## Docs

1. go into the docs directory

```bash
cd ../docs
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

4. Head to http://localhost:5173/
