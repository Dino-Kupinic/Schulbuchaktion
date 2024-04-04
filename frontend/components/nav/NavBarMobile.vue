<script setup lang="ts">
import NavBarContainer from "~/components/nav/NavBarContainer.vue"
import NavBarLogoLink from "~/components/nav/NavBarLogoLink.vue"

const rounded = ref<boolean>(false)

watch(rounded, async () => {})
</script>

<template>
  <NavBarContainer class="rounded-t">
    <NavBarLogoLink />
    <NavBarBurgerMenuLarge
      @round-corners="(condition) => (rounded = condition)"
      class="justify-content-center"
    />
  </NavBarContainer>
</template>

<style scoped></style>
