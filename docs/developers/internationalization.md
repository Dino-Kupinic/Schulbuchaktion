# Internationalization

Currently, Schulbuchaktion only supports **English** and **German**.
For translations, we make use of the vue i18n library and corresponding nuxt module.

## Translating

Locales can be found in `/frontend/locales`. In this directory is a JSON file for each language.
Short forms are used to identify a language, e.g. `en-US.json`.

### Adding a new language

This is done very simply by just adding a new file in the `/locales` directory.
You can copy the `en-US.json` file and replace the fields.

Next, you must add the language to the `currentLocales` (`/frontend/config/i18n.ts`) array:

```ts
export const currentLocales: LocaleObject[] = [
  {
    code: "en-US",
    file: "en-US.json",
    name: "English",
  },
  {
    code: "de-DE",
    file: "de-DE.json",
    name: "Deutsch",
  },
  { // [!code ++]
    code: "jp-JP", // [!code ++]
    file: "jp-JP.json", // [!code ++]
    name: "日本語", // [!code ++]
  }, // [!code ++]
]
```
