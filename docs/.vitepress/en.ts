import {DefaultTheme, defineConfig} from "vitepress"

export const en = defineConfig({
  lang: "en-US",
  description: "Official Schulbuchaktion Documentation",
  themeConfig: {
    nav: nav(),
    sidebar: {
      "/users/": {
        base: "/users/",
        items: sidebarUsers(),
      },
      "/developers/": {
        base: "/developers/",
        items: sidebarDevelopers(),
      },
    },
    footer: {
      message: "Released under the MIT License.",
      copyright: "Copyright © 2024-present Nixx Labs",
    },
  },
})

function nav(): DefaultTheme.NavItem[] {
  return [
    {
      text: "Home",
      link: "/",
    },
    {
      text: "Users",
      link: "/users/getting-started",
    },
    {
      text: "Developers",
      link: "/developers/setup",
    },
  ]
}

function sidebarUsers(): DefaultTheme.SidebarItem[] {
  return [
    {
      text: "Introduction",
      collapsed: false,
      items: [
        {
          text: "Getting Started",
          link: "getting-started",
        },
        {
          text: "Authentication",
          link: "auth",
        },
        {
          text: "Getting help",
          link: "help",
        },
      ],
    },
    {
      text: "Customization",
      collapsed: false,
      items: [
        {
          text: "Changing the theme colors",
          link: "theme-colors",
        },
        {
          text: "Altering between light and dark mode",
          link: "light-dark-mode",
        },
        {
          text: "Language",
          link: "language-settings",
        },
      ],
    },
  ]
}

function sidebarDevelopers(): DefaultTheme.SidebarItem[] {
  return [
    {
      text: "Introduction",
      collapsed: false,
      items: [
        {
          text: "Setup",
          link: "setup",
        },
        {
          text: "Extending",
          link: "extending",
        },
        {
          text: "Deployment",
          link: "deployment",
        },
        {
          text: "Editing Documentation",
          link: "documentation",
        },
      ],
    },
    {
      text: "Conventions",
      collapsed: false,
      items: [
        {
          text: "Code Style",
          link: "code-style",
        },
        {
          text: "Commits",
          link: "commits",
        },
        {
          text: "Git Flow",
          link: "git-flow",
        },
        {
          text: "Issues",
          link: "issues",
        },
        {
          text: "Pull Requests",
          link: "pull-requests",
        },
        {
          text: "Milestones",
          link: "milestones",
        },
      ],
    },
    {
      text: "Authentication",
      collapsed: false,
      items: [
        {
          text: "LDAP",
          link: "ldap",
        },
      ],
    },
  ]
}