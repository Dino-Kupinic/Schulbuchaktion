# Info Button

The info button of the "Schulbuchaktion" appears in its **Nav-Bar**.
It contains the git hash of the latest commit in addition
to the time when the webapp was last built.

The version of the Webapp is also displayed.

Besides that it displays the current version of
[Nuxt](https://nuxt.com/) and [Vue](https://vuejs.org/) we are using.

## Configuration

For the **runtime** the `<NavInfoButton />` component uses the
`runtimeConfig` which has been added to the `nuxt.config.ts` like this

```ts
runtimeConfig: {
  public: {
    buildTime: Date.now(),
    gitHeadSha: execaSync("git", ["rev-parse", "HEAD"]).stdout.trim(),
    clientVersion: pkg.version
  }
}
```

This config can be used as such to get the runtime

```ts
const runtime = useRuntimeConfig()
```

To then get the `buildtime` of the webapp the following line is used

```ts
const buildTime = new Date(runtime.public.buildTime as number)
```

To get the [Nuxt](https://nuxt.com/) and [Vue](https://vuejs.org/) version
we simply imported the versions from the following files

- Vue

```ts
import { version as versionVue } from "vue"
```

- Nuxt

```ts
import { version as versionNuxt } from "nuxt/package.json"
```










