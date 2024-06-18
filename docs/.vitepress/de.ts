import {DefaultTheme, defineConfig} from "vitepress"

export const de = defineConfig({
  lang: "de-DE",
  description: "Offizielle Schulbuchaktion Dokumentation",
  themeConfig: {
    nav: nav(),
    sidebar: {
      "/de/users/": {
        base: "/de/users/",
        items: sidebarUsers(),
      },
      "/de/developers/": {
        base: "/de/developers/",
        items: sidebarDevelopers(),
      },
    },
    editLink: {
      pattern: 'https://github.com/Dino-Kupinic/Schulbuchaktion/edit/main/docs/:path',
      text: 'Seite auf GitHub bearbeiten'
    },
    lastUpdated: {
      text: 'Aktualisiert am',
    },
    footer: {
      message: "Veröffentlicht unter der MIT Lizenz.",
      copyright: "Copyright © 2024-jetzt Nixx Labs",
    },
    docFooter: {
      prev: "Vorheriges",
      next: "Nächstes",
    },
  },
})

function nav(): DefaultTheme.NavItem[] {
  return [
    {
      text: "Home",
      link: "/de/",
    },
    {
      text: "Nutzer",
      link: "/de/users/getting-started",
    },
    {
      text: "Entwickler",
      link: "/de/developers/setup",
    },
  ]
}

function sidebarUsers(): DefaultTheme.SidebarItem[] {
  return [
    {
      text: "Einführung",
      collapsed: false,
      items: [
        {
          text: "Erste Schritte",
          link: "getting-started",
        },
        {
          text: "Authentifizierung",
          link: "auth",
        },
        {
          text: "Fragen & Antworten",
          link: "q&a",
        },
        {
          text: "Hilfe",
          link: "help",
        },
        {
          text: "Fehler melden",
          link: "report-bug",
        },
      ],
    },
    {
      text: "Anpassung",
      collapsed: false,
      items: [
        {
          text: "Die Farben ändern",
          link: "theme-colors",
        },
        {
          text: "Zwischen Hell und Dunkel wechseln",
          link: "light-dark-mode",
        },
        {
          text: "Sprache",
          link: "language-settings",
        },
      ],
    },
    {
      text: "Benutzer",
      collapsed: false,
      items: [
        {
          text: "Verwenden von Benutzer-Einstellungen",
          link: "nav-user",
        }
      ]
    },
    {
      text: "Navigation",
      collapsed: false,
      items: [
        {
          text: "Durch die Schulbuchaktion navigieren",
          link: "navigation"
        }
      ]
    },
    {
      text: "Klassenverwaltung",
      collapsed: false,
      items: [
        {
          text: "Klassen erstellen",
          link: "create-class"
        },
        {
          text: "Klassen editieren und löschen",
          link: "edit-class"
        },
      ]
    }
  ]
}

function sidebarDevelopers(): DefaultTheme.SidebarItem[] {
  return [
    {
      text: "Einführung",
      collapsed: false,
      items: [
        {
          text: "Einrichten",
          link: "setup",
        },
        {
          text: "Erweitern",
          link: "extending",
        },
        {
          text: "Deployment",
          link: "deployment",
        },
        {
          text: "Dokumentation ändern",
          link: "documentation",
        },
        {
          text: "Protokolle",
          link: "logging",
        },
      ],
    },
    {
      text: "Konventionen",
      collapsed: false,
      items: [
        {
          text: "Code Stil",
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
          text: "Meilensteine",
          link: "milestones",
        },
        {
          text: "API",
          link: "api",
        },
      ],
    },
    {
      text: "Authentifizierung",
      collapsed: false,
      items: [
        {
          text: "LDAP",
          link: "ldap",
        },
        {
          text: "Sicherheit",
          link: "security",
        },
        {
          text: "An-/Abmeldung",
          link: "authentication"
        }
      ],
    },
    {
      text: "Internationalisierung",
      collapsed: false,
      items: [
        {
          text: "i18n",
          link: "internationalization",
        },
      ],
    },
    {
      text: "Datenpersistenz",
      collapsed: false,
      items: [
        {
          text: "Datenbank",
          link: "database",
        },
        {
          text: "XLSX Import",
          link: "import",
        },
        {
          text: "Services",
          link: "services",
        }
      ],
    },
  ]
}

export const search: DefaultTheme.LocalSearchOptions["locales"] = {
  de: {
    translations: {
      button: {
        buttonText: "Suchen",
        buttonAriaLabel: "Suchen",
      },
      modal: {
        displayDetails: "Details anzeigen",
        resetButtonTitle: "Zurücksetzen",
        backButtonTitle: "Zurück",
        noResultsText: "Keine Resultate",
        footer: {
          selectText: "Auswählen",
          navigateText: "Navigieren",
          navigateUpKeyAriaLabel: "Nach oben",
          navigateDownKeyAriaLabel: "Nach unten",
          closeText: "Schließen",
          closeKeyAriaLabel: "Schließen",
        },
      },
    },
  },
}
