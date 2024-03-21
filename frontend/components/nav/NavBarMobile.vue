<script setup lang="ts">

import NavBarContainer from "~/components/nav/NavBarContainer.vue";
</script>

<template>
  <NavBarContainer>
    <ULink to="/">
      <Logo class="h-12"></Logo>
    </ULink>
    <NavBarBurgerMenuLarge/>
  </NavBarContainer>
</template>

<style scoped>

</style>