<script setup lang="ts">
import NavBarContainer from "~/components/nav/NavBarContainer.vue"
import NavBarLogoLink from "~/components/nav/NavBarLogoLink.vue"

const burgerMenuVisible = ref<boolean>(false)
</script>

<template>
  <NavBarContainer
    :class="{ 'rounded-b-none border-b-0 shadow-none': burgerMenuVisible }"
  >
    <NavBarLogoLink />
    <NavBarBurgerMenu
      @burger-menu-visible="(visible: boolean) => (burgerMenuVisible = visible)"
    />
  </NavBarContainer>
</template>

<style scoped></style>
