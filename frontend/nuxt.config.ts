// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: [
    "@pinia/nuxt",
    "@nuxtjs/tailwindcss",
    "@nuxtjs/i18n",
    "@vueuse/nuxt",
    "@nuxtjs/color-mode",
    "@nuxt/test-utils",
    "nuxt-icon",
    "@pinia-plugin-persistedstate/nuxt",
    "@nuxtjs/storybook",
    "@vite-pwa/nuxt",
    "nuxt-viewport",
  ],
  pinia: {
    storesDirs: ["./stores/**"],
  },
})