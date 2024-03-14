import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  rewrites: {
    'packages/de/index.md': 'de/indexGerman.md',
    'packages/en/index.md': 'en/indexGerman.md',
  },
  title: "Schulbuchaktion Docs",
  description: "Official Schulbuchaktion Documentation",
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    nav: [
      { text: 'Home', link: '/en/' },
      { text: 'Users', link: 'userSection/'},
      { text: 'Developers', link: 'developerSection/'},
      {
        text: "Language",
        items: [
          {text: 'German', link: '/de/'},
          {text: 'English', link: '/en/'}
        ]
      },
    ],

    socialLinks: [
      { icon: "github", link: 'https://github.com/Dino-Kupinic/Schulbuchaktion.git' },
    ]
  }
})
