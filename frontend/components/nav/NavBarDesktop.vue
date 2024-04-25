<script setup lang="ts">
import NavBarContainer from "~/components/nav/NavBarContainer.vue"
import NavBarLogoLink from "~/components/nav/NavBarLogoLink.vue"
const links = [
  { title: "orderList", link: "/settings" },
  { title: "classManagement", link: "/settings" },
  { title: "budgetOverview", link: "/settings" },
  { title: "import", link: "/settings" },
]
</script>

<template>
  <NavBarContainer>
    <NavBarLeftSection>
      <NavBarLogoLink />
      <NavLink v-for="link in links" :title="link.title" :link="link.link" />
    </NavBarLeftSection>

    <NavBarRightSection>
      <NavBarThemeToggle />
      <NavDivider />
      <NavBarLanguageToggle />
      <NavDivider />
      <NavSettingsButton />
      <NavInfoButton />
      <NavUser />
    </NavBarRightSection>
  </NavBarContainer>
</template>

<style scoped></style>
