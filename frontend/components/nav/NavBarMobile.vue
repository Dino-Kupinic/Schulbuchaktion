<script setup lang="ts">
import type { NavigationItem } from "~/types/nav"

defineProps<{
  links: NavigationItem[]
}>()
const burgerMenuVisible = ref<boolean>(false)
</script>

<template>
  <NavBarContainer>
    <NavBarLogoLink />
    <NavBarBurgerMenu
      :links
      @burger-menu-visible="(visible: boolean) => (burgerMenuVisible = visible)"
    />
  </NavBarContainer>
</template>

<style scoped></style>
