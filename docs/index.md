---
layout: home

title: Schulbuchaktion
titleTemplate: The easiest way of managing school books

hero:
  name: "Schulbuchaktion"
  text: "Documentation"
  tagline: 📚 Easily manage school books
  actions:
    - theme: brand
      text: Quickstart for Users
      link: /users/getting-started
    - theme: alt
      text: Developer Reference
      link: /developers/setup
  image:
    src: /htl-logo.svg
    alt: VitePress


features:
  - icon: 📑
    title: Order List
    details: Simple book ordering, manage classes efficiently.
  - icon: 👩‍👧‍👦
    title: Class Management
    details: Streamlined student and class administration.
  - icon: 💵
    title: Budget Overview
    details: Analyze budget effectively for informed decisions.
  - icon: 💡
    title: Import
    details: Import XLSX files effortlessly for accurate data.
  - icon: 🎨
    title: Customizable
    details: Personalize colors, themes, and language settings.
  - icon: 🔐
    title: Secure
    details: We ensure data security with robust measures.
  - icon: 🚀
    title: Performant
    details: Experience fast, responsive performance for seamless operations.
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
    title: "Full Stack Developer + Scrum Master",
    links: [
      { icon: "github", link: "https://github.com/Dino-Kupinic" },
      { icon: "twitter", link: "https://x.com/DinoKupinic" }
    ]
  },
  {
    avatar: "https://github.com/MPloier.png",
    name: "Michael Ploier",
    title: "Backend Developer",
    links: [
      { icon: "github", link: "https://github.com/MPloier" },
    ]
  },
  {
    avatar: "https://github.com/PhyToN-xD.png",
    name: "Lukas Bauer",
    title: "Backend Developer",
    links: [
      { icon: "github", link: "https://github.com/PhyToN-xD" },
    ]
  },
  {
    avatar: "https://github.com/dsamhabe.png",
    name: "Daniel Samhaber",
    title: "Frontend Developer",
    links: [
      { icon: "github", link: "https://github.com/dsamhabe" },
    ]
  },
  {
    avatar: "https://github.com/Neuery17Alt.png",
    name: "Jannick Angerer",
    title: "Frontend Developer",
    links: [
      { icon: "github", link: "https://github.com/Neuery17Alt" },
    ]
  },
]

const partners = [
  {
    avatar: "https://github.com/mrohrweck.png",
    name: "Monika Rohrweck",
    title: "Project Owner",
    links: [
      { icon: "github", link: "https://github.com/mrohrweck" },
    ]
  },
  {
    avatar: "https://api.dicebear.com/8.x/identicon/svg?seed=SCAN&backgroundColor=ffffff",
    name: "Anja Schneiderbauer",
    title: "External Client",
  },
  {
    avatar: "https://api.dicebear.com/8.x/identicon/svg?seed=RABS&backgroundColor=ffffff",
    name: "Stefan Raberger",
    title: "External Client",
  },
]

</script>

<VPTeamPage>
  <VPTeamPageTitle>
    <template #title>Our Team</template>
    <template #lead>A team of passionate developers</template>
  </VPTeamPageTitle>
  <VPTeamMembers :members="members" />
</VPTeamPage>

<VPTeamPage>
  <VPTeamPageTitle>
    <template #title>Partners</template>
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

