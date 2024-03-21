<script setup lang="ts">

import PlaceHolder from "~/components/nav/PlaceHolder.vue";
import NavBarContainer from "~/components/nav/NavBarContainer.vue";
import NavBarLogoLink from "~/components/nav/NavBarLogoLink.vue";
</script>

<template>
  <NavBarContainer>
    <NavBarLeftSection>
      <NavBarLogoLink/>
      <PlaceHolder/>
      <PlaceHolder/>
      <PlaceHolder/>
      <PlaceHolder/>
    </NavBarLeftSection>

    <NavBarRightSection>
      <PlaceHolder/>
      <PlaceHolder/>
      <PlaceHolder/>
    </NavBarRightSection>
  </NavBarContainer>
</template>

<style scoped>

</style>