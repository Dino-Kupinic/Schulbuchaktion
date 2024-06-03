# Deployment

[[toc]]

## Docker

1. configure each `.env` in `/frontend` and `/backend` properly

2. check (and adjust) each **nginx** configuration

3. run docker compose

```bash
docker compose up -d
```

::: tip
If you don't have docker installed, checkout https://www.docker.com/.
:::

4. deploy in the cloud or your container infrastructure :tada:

## Classic

Build each service seperately and deploy yourself without docker.

### Frontend

::: info
The frontend operates as a "Single Page
Application" [SPA](https://nuxt.com/docs/guide/concepts/rendering#client-side-rendering).
:::

1. run generate

```bash
pnpm run generate
```

::: tip
If you don't have pnpm installed, checkout https://pnpm.io/installation to install for your operating system.
:::

2. check if everything works as it should

```bash
pnpm run preview
```

3. Head to `http://localhost:3000/`
4. All generated static assets can be found in `./output/public`

::: tip
Further information regarding deployment can be found on https://nuxt.com/deploy
:::

### Backend

The latest information regarding deploying symfony can be found
here: https://symfony.com/doc/current/deployment.html#symfony-deployment-basics

### Docs

1. run build

```bash
pnpm run docs:build
```

::: tip
If you don't have pnpm installed, checkout https://pnpm.io/installation to install for your operating system.
:::

2. check if everything works as it should

```bash
pnpm run docs:preview
```

3. Head to `http://localhost:4173/`
4. All generated assets can be found in `./vitepress/dist`

::: tip
Further information regarding deployment can be found on https://vitepress.dev/guide/deploy
:::
