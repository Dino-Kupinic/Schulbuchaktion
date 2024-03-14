import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "Schulbuchaktion Docs",
  description: "Official Schulbuchaktion Documentation",
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Users', link: '/userSection/' },
      { text: 'Developers', link: '/developerSection/' },
      {
        text: "Language",
        items: [
          {text: 'German', link: '/de/'},
          {text: 'English', link: '/'}
        ]
      }
    ],

    socialLinks: [
      { icon: "github", link: 'https://github.com/Dino-Kupinic/Schulbuchaktion.git' },
    ]
  }
})
