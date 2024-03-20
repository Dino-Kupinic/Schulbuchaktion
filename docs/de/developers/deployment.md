# Deployment

::: info
Die Frontend-Anwendung funktioniert als "Single Page
Application" [SPA](https://nuxt.com/docs/guide/concepts/rendering#client-side-rendering), was bedeutet, dass der Client
alle Rendering-Aufgaben übernimmt. Es ist wichtig zu beachten, dass aufgrund dieser Architektur möglicherweise
Einschränkungen in Bezug auf die SEO-Optimierung bestehen.

Es ist jedoch erwähnenswert, dass das Hauptanwendungsfall der Anwendung nicht stark von der Sichtbarkeit in
Suchmaschinen abhängt, da sie als internes Tool konzipiert ist.
:::

## Frontend

1. Build ausführen

```bash
pnpm run build
```

2. Überprüfen, ob alles wie erwartet funktioniert

```bash
pnpm run preview
```

3. Gehe zu http://localhost:3000/
4. Alle generierten Assets befinden sich in ./output

::: tip TIPP
Weitere Informationen zur Bereitstellung finden Sie unter https://nuxt.com/deploy
:::

## Backend

Die neuesten Informationen zur Bereitstellung von Symfony finden Sie
hier: https://symfony.com/doc/current/deployment.html#symfony-deployment-basics

## Docs

::: tip TIPP
Die Dokumentation verwendet das gleiche Prinzip wie das Frontend. Weitere
Infos: https://vitepress.dev/guide/what-is-vitepress#performance
:::

1. Build ausführen

```bash
pnpm run docs:build
```

2. Überprüfen, ob alles wie erwartet funktioniert

```bash
pnpm run docs:preview
```

3. Gehe zu http://localhost:4173/
4. Alle generierten Assets befinden sich in `./vitepress/dist`

::: tip
Weitere Informationen zur Bereitstellung finden Sie unter https://vitepress.dev/guide/deploy
:::
