import {DefaultTheme, defineConfig} from "vitepress"
import {FooterTranslations} from "vitepress/types/local-search"

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
          text: "Hilfe",
          link: "help",
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