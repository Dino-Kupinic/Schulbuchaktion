import { currentLocales } from "./config/i18n"
import pkg from "./package.json"
import { execaSync } from "execa"

export default defineNuxtConfig({
  app: {
    head: {
      title: "Schulbuchaktion",
    },
  },
  css: ["~/assets/styles/main.css"],
  devtools: {
    enabled: true,
  },
  ssr: false,
  spaLoadingTemplate: true,
  components: [
    {
      path: "~/components",
      pathPrefix: false,
    },
  ],
  runtimeConfig: {
    public: {
      baseURL: process.env.BACKEND_API,
      buildTime: Date.now(),
      gitHeadSha: execaSync("git", ["rev-parse", "HEAD"]).stdout.trim(),
      clientVersion: pkg.version,
    },
  },
  colorMode: {
    classSuffix: "",
    preference: "system",
    fallback: "light",
  },
  postcss: {
    plugins: {
      "postcss-import": {},
      "tailwindcss/nesting": {},
      tailwindcss: {},
      autoprefixer: {},
    },
  },
  typescript: {
    typeCheck: true,
    strict: true,
  },
  eslint: {},
  i18n: {
    locales: currentLocales,
    detectBrowserLanguage: false,
    langDir: "locales",
    defaultLocale: "en-US",
    vueI18n: "~/config/i18n.config.ts",
  },
  modules: [
    "@pinia/nuxt",
    "@nuxtjs/i18n",
    "@formkit/auto-animate",
    "@vueuse/nuxt",
    "@nuxt/eslint",
    "@nuxt/test-utils",
    "@pinia-plugin-persistedstate/nuxt",
    "@nuxtjs/color-mode",
    "@nuxt/ui",
    "@vite-pwa/nuxt",
    "nuxt-typed-router",
    "nuxt-viewport",
    "floating-vue/nuxt",
  ],
})
