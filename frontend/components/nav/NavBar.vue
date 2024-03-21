<script setup lang="ts">

import PlaceHolder from "~/components/nav/PlaceHolder.vue";
</script>

<template>
  <UContainer
      class="mt-2 flex underline-offset-1 w-[97%] h-11/12 border border-neutral-300 dark:bg-gray-900
      dark:border-gray-700 items-center box-border rounded-lg shadow-lg justify-between"
  >
    <ULink to="/">
      <Logo class="h-12"></Logo>
    </ULink>

    <NavBarLeftSection class="max-md:hidden">
      <PlaceHolder></PlaceHolder>
      <PlaceHolder></PlaceHolder>
      <PlaceHolder></PlaceHolder>
      <PlaceHolder></PlaceHolder>
    </NavBarLeftSection>

    <NavBarRightSection class="max-lg:hidden">
      <PlaceHolder></PlaceHolder>
      <PlaceHolder></PlaceHolder>
      <PlaceHolder></PlaceHolder>
    </NavBarRightSection>

    <NavBarBurgerMenu class="lg:hidden"/>
  </UContainer>
</template>

<style scoped>

</style>