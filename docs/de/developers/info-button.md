# Info-Button

Der Info-Button der Schulbuchaktion erscheint in der **Nav-Bar**.
Er enthält zusätzlich den Git-Hash des letzten Commits sowie
den Zeitpunkt, an dem die Webapp zuletzt gestartet wurde.

Auch die Version der Webapp wird angezeigt.

Außerdem zeigt es die aktuelle Version von
[Nuxt](https://nuxt.com/) und [Vue](https://vuejs.org/), welche wir derzeit verwenden, an.

## Konfiguration

Für die **Laufzeit** der App verwendet der `<NavInfoButton />` die
`runtimeConfig`, die der `nuxt.config.ts` wie folgt hinzugefügt wurde

```ts
runtimeConfig: {
  public: {
    buildTime: Date.now(),
    gitHeadSha: execaSync("git", ["rev-parse", "HEAD"]).stdout.trim(),
    clientVersion: pkg.version
  }
}
```

Diese Konfiguration kann als solche verwendet werden, um die Laufzeit wie folgt zu erhalten

```ts
const runtime = useRuntimeConfig()
```

Um dann die `Buildtime` der Webapp zu erhalten, wird die folgende Zeile verwendet

```ts
const buildTime = new Date(runtime.public.buildTime as number)
```

Um die [Nuxt](https://nuxt.com/) und [Vue](https://vuejs.org/) Version zu erhalten,
wurden diese aus den folgenden Dateien importiert

- Vue

```ts
import { version as versionVue } from "vue"
```

- Nuxt

```ts
import { version as versionNuxt } from "nuxt/package.json"
```

