type LocaleObject = {
  code: string
  file: string
  name: string
}

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
]
