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
          text: "Questions & Answers",
          link: "q&a",
        },
        {
          text: "Getting help",
          link: "help",
        },
        {
          text: "Report a bug",
          link: "report-bug",
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
    {
      text: "User",
      collapsed: false,
      items: [
        {
          text: "Accessing User related Settings",
          link: "nav-user"
        }
      ]
    },
    {
      text: "Navigation",
      collapsed: false,
      items: [
        {
          text: "Navigation Bar",
          link: "navigation"
        }
      ]
    }
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
        {
          text: "API",
          link: "api",
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
    {
      text: "Internationalization",
      collapsed: false,
      items: [
        {
          text: "i18n",
          link: "internationalization",
        },
      ],
    },
    {
      text: "Data Persistence",
      collapsed: false,
      items: [
        {
          text: "Database",
          link: "database"
        },
        {
          text: "XLSX Import",
          link: "import",
        },
        {
          text: "Services",
          link: "services",
        },
      ],
    },
    {
      text: "Authentication",
      collapsed: false,
      items: [
        {
          text: "LDAP",
          link: "ldap"
        }
      ]
    },
    {
      text: "Components",
      collapsed: false,
      items: [
        {
          text: "Navigation Bar",
          link: "navigation"
        },
        {
          text: "Info Button",
          link: "info-button",
        },
        {
          text: "Navbar User",
          link: "nav-user",
        }
      ],
    }
  ]
}
