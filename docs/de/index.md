---
layout: home

title: Schulbuchaktion
titleTemplate: Der einfachste Weg zur Verwaltung von Schulbüchern

hero:
  name: "Schulbuchaktion"
  text: "Dokumentation"
  tagline: 📚 Schulbücher einfach verwalten
  actions:
    - theme: brand
      text: Schnellstart für Benutzer
      link: /de/users/getting-started
    - theme: alt
      text: Entwicklerreferenz
      link: /de/developers/setup
  image:
    src: /htl-logo.svg
    alt: VitePress

features:
  - icon: 📑
    title: Bestellliste
    details: Einfache Buchbestellung, effiziente Klassenverwaltung.
  - icon: 👩‍👧‍👦
    title: Klassenverwaltung
    details: Effiziente Schüler- und Klassenverwaltung.
  - icon: 💵
    title: Budgetübersicht
    details: Analyse des Budgets für fundierte Entscheidungen.
  - icon: 💡
    title: Importieren
    details: XLSX-Dateien mühelos importieren
  - icon: 🎨
    title: Anpassbar
    details: Personalisierte Farben, Designs und Spracheinstellungen.
  - icon: 🔐
    title: Sicherheit
    details: Datensicherheit durch robuste Maßnahmen.
  - icon: 🚀
    title: Leistungsstark
    details: Erleben Sie schnelle, reaktionsschnelle Leistung für nahtlose Operationen.
---

<script setup>
import {
  VPTeamPage,
  VPTeamPageTitle,
  VPTeamMembers,
  VPTeamPageSection
} from "vitepress/theme"

const members = [
  {
    avatar: "https://github.com/Dino-Kupinic.png",
    name: "Dino Kupinic",
    title: "Full Stack Entwickler + Scrum Master",
    links: [
      { icon: "github", link: "https://github.com/Dino-Kupinic" },
      { icon: "twitter", link: "https://x.com/DinoKupinic" }
    ]
  },
  {
    avatar: "https://github.com/MPloier.png",
    name: "Michael Ploier",
    title: "Backend Entwickler",
    links: [
      { icon: "github", link: "https://github.com/MPloier" },
    ]
  },
  {
    avatar: "https://github.com/PhyToN-xD.png",
    name: "Lukas Bauer",
    title: "Backend Entwickler",
    links: [
      { icon: "github", link: "https://github.com/PhyToN-xD" },
    ]
  },
  {
    avatar: "https://github.com/dsamhabe.png",
    name: "Daniel Samhaber",
    title: "Frontend Entwickler",
    links: [
      { icon: "github", link: "https://github.com/dsamhabe" },
    ]
  },
  {
    avatar: "https://github.com/Neuery17Alt.png",
    name: "Jannick Angerer",
    title: "Frontend Entwickler",
    links: [
      { icon: "github", link: "https://github.com/Neuery17Alt" },
    ]
  },
]

const partners = [
  {
    avatar: "https://github.com/mrohrweck.png",
    name: "Monika Rohrweck",
    title: "Projektinhaber",
    org: "HTL Steyr",
    orgLink: "https://www.htl-steyr.ac.at/",
    links: [
      { icon: "github", link: "https://github.com/mrohrweck" },
    ]
  },
  {
    avatar: "https://github.com/prathgeb.png",
    name: "Peter Rathgeb",
    title: "Technischer Berater",
    org: "HTL Steyr",
    orgLink: "https://www.htl-steyr.ac.at/",
    links: [
      { icon: "github", link: "https://github.com/prathgeb" },
    ]
  },
  {
    avatar: "https://api.dicebear.com/8.x/identicon/svg?seed=SCAN&backgroundColor=ffffff",
    name: "Anja Schneiderbauer",
    org: "HTL Steyr",
    orgLink: "https://www.htl-steyr.ac.at/",
    title: "Externer Auftraggeber",
  },
  {
    avatar: "https://api.dicebear.com/8.x/identicon/svg?seed=RABS&backgroundColor=ffffff",
    name: "Stefan Raberger",
    org: "HTL Steyr",
    orgLink: "https://www.htl-steyr.ac.at/",
    title: "Externer Auftraggeber",
  },
]

</script>

<VPTeamPage>
  <VPTeamPageTitle>
    <template #title>Unser Team</template>
    <template #lead>Ein Team von passionierten Entwicklern</template>
  </VPTeamPageTitle>
  <VPTeamMembers :members="members" />
</VPTeamPage>

<VPTeamPage>
  <VPTeamPageTitle>
    <template #title>Partner</template>
  </VPTeamPageTitle>
  <VPTeamMembers :members="partners" />
</VPTeamPage>


<style>
:root {
  --vp-home-hero-name-color: transparent;
  --vp-home-hero-name-background: -webkit-linear-gradient(120deg, #086dcb 30%, #1dbef3);

  --vp-home-hero-image-background-image: linear-gradient(-45deg, #242a3b 50%, #428faf 50%);
  --vp-home-hero-image-filter: blur(44px);

}

.dark {
  --vp-c-gutter: #28282d;
}

@media (min-width: 640px) {
  :root {
    --vp-home-hero-image-filter: blur(56px);
  }
}

@media (min-width: 960px) {
  :root {
    --vp-home-hero-image-filter: blur(68px);
  }
}
</style>

