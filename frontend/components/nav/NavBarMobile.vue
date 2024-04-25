<script setup lang="ts">
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
