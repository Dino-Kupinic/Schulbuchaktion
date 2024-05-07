// https://nuxt.com/docs/api/configuration/nuxt-config
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
  security: {
    headers: {
      crossOriginEmbedderPolicy:
        process.env.NODE_ENV === "development" ? "unsafe-none" : "require-corp",
    },
  },
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
  routeRules: { "/api/**": { cors: true } },
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
    "nuxt-security",
  ],
})
