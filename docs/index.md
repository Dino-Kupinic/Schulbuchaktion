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
    src: assets/htl-logo.svg
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

