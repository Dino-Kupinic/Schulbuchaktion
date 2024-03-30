// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  app: {
    head: {
      title: "Schulbuchaktion",
    },
  },
  css: [
    "~/assets/styles/main.css",
  ],
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
      crossOriginEmbedderPolicy: process.env.NODE_ENV === "development" ? "unsafe-none" : "require-corp",
    },
  },
  colorMode: {
    classSuffix: "",
    preference: "system",
    fallback: "light",
  },
  typescript: {
    typeCheck: true,
    strict: true,
  },
  modules: [
    "@pinia/nuxt",
    "@nuxtjs/i18n",
    "@formkit/auto-animate",
    "@vueuse/nuxt",
    "@nuxt/test-utils",
    "@pinia-plugin-persistedstate/nuxt",
    "@nuxtjs/color-mode",
    "@nuxt/ui",
    "nuxt-csurf",
    "@vite-pwa/nuxt",
    "nuxt-typed-router",
    "nuxt-viewport",
    "nuxt-security",
  ],
})