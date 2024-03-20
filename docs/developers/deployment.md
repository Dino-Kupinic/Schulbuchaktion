# Deployment

::: info
The frontend operates as a "Single Page
Application" [SPA](https://nuxt.com/docs/guide/concepts/rendering#client-side-rendering), requiring the client to
handle all rendering tasks. It's essential to acknowledge that due to this architecture, there may be limitations in
terms of SEO optimization.

However, it's worth noting that the application's primary use case doesn't heavily rely on
search engine visibility, since it is meant to be used as an internal tool.
:::

## Frontend

1. run build

```bash
pnpm run build
```

2. check if everything works as it should

```bash
pnpm run preview
```

3. Head to `http://localhost:3000/`
4. All generated assets can be found in `./output`

::: tip
Further information regarding deployment can be found on https://nuxt.com/deploy
:::

## Backend

The latest information regarding deploying symfony can be found
here: https://symfony.com/doc/current/deployment.html#symfony-deployment-basics

## Docs

::: tip
The documentation uses the same principle as the frontend. More
info: https://vitepress.dev/guide/what-is-vitepress#performance
:::

1. run build

```bash
pnpm run docs:build
```

2. check if everything works as it should

```bash
pnpm run docs:preview
```

3. Head to `http://localhost:4173/`
4. All generated assets can be found in `./vitepress/dist`

::: tip
Further information regarding deployment can be found on https://vitepress.dev/guide/deploy
:::
