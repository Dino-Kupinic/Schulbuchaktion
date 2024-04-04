import {defineConfig} from "vitepress"
import {search as deSearch} from "./de"

export const shared = defineConfig({
  title: "Schulbuchaktion",
  sitemap: {
    hostname: "https://schulbuchaktion-docs.vercel.app",
  },
  head: [
    ["link", {rel: "icon", type: "image/png", href: "/favicon.png"}],
    ["link", {rel: "icon", type: "image/svg+xml", href: "/htl-steyr.svg"}],
    ["meta", {property: "og:type", content: "website"}],
    ["meta", {property: "og:locale", content: "en"}],
    ["meta", {property: "og:title", content: "Schulbuchaktion | Official Schulbuchaktion Documentation"}],
    ["meta", {property: "og:site_name", content: "Schulbuchaktion"}],
    ["meta", {property: "og:url", content: "https://schulbuchaktion-docs.vercel.app/"}],
  ],
  themeConfig: {
    logo: {
      src: "/htl-logo.svg",
    },
    socialLinks: [
      {
        icon: "github",
        link: "https://github.com/Dino-Kupinic/Schulbuchaktion.git",
      },
    ],
    search: {
      provider: "local",
      options: {
        locales: {...deSearch},
      },
    },
  },
})