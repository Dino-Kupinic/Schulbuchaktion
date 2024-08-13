import { currentLocales } from "./config/i18n"
import pkg from "./package.json"
import { execaSync } from "execa"

function getGitHeadSha() {
  try {
    return execaSync("git", ["rev-parse", "HEAD"]).stdout.trim()
  } catch {
    return undefined
  }
}

export default defineNuxtConfig({
  hooks: {
    "prerender:routes"({ routes }) {
      routes.clear()
    },
  },

  ssr: false,
  spaLoadingTemplate: true,

  devtools: {
    enabled: true,
  },

  runtimeConfig: {
    public: {
      baseURL: process.env.BACKEND_API,
      buildTime: Date.now(),
      gitHeadSha: getGitHeadSha(),
      clientVersion: pkg.version,
    },
  },

  app: {
    head: {
      title: "Schulbuchaktion",
    },
  },

  css: ["~/assets/styles/main.css"],

  components: [
    {
      path: "~/components",
      pathPrefix: false,
    },
  ],

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

  compatibilityDate: "2024-08-13"
})