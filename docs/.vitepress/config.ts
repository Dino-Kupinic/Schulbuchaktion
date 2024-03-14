import {defineConfig} from "vitepress"

export default defineConfig({
  title: "Schulbuchaktion",
  description: "Official Schulbuchaktion Documentation",
  themeConfig: {
    nav: [
      {text: "Home", link: "/"},
      {text: "Users", link: "userSection/"},
      {text: "Developers", link: "developerSection/"},
    ],
    logo: {src: "/assets/htl-logo.svg"},
    socialLinks: [
      {icon: "github", link: "https://github.com/Dino-Kupinic/Schulbuchaktion.git"},
    ],
    search: {
      provider: "local",
    },
    footer: {
      message: "Released under the MIT License.",
      copyright: "Copyright © 2024-present Nixx Labs",
    },
  },
  locales: {
    root: {
      label: "English",
      lang: "en",
    },
    de: {
      label: "Deutsch",
      lang: "de",
      link: "/de/",
    },
  },
})
