<script setup lang="ts">
const links = [
  { title: "orderList", link: "/orderlist" },
  { title: "classManagement", link: "/classes" },
  { title: "budgetOverview", link: "/budget" },
  { title: "import", link: "/import" },
]
</script>

<template>
  <NavBarContainer>
    <NavBarLeftSection>
      <NavBarLogoLink />
      <NavLink
        v-for="link in links"
        :key="link.link"
        :title="link.title"
        :link="link.link"
      />
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
