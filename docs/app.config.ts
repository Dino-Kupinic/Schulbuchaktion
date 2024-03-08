export default defineAppConfig({
  docus: {
    title: "Schulbuchaktion",
    description: "Official Documentation for Schulbuchaktion",
    socials: {
      github: "Dino-Kupinic/Schulbuchaktion",
      nuxt: {
        label: "HTL Steyr",
        icon: "mdi:school",
        href: "https://htl-steyr.ac.at/",
      },
    },
    aside: {
      level: 0,
      collapsed: false,
      exclude: [],
    },
    main: {
      padded: true,
      fluid: true,
    },
    header: {
      logo: false,
      showLinkIcon: true,
      exclude: [],
      fluid: true,
    },
    footer: {
      credits: {
        icon: "",
        text: "",
        href: "",
      },
    },
  },
})
