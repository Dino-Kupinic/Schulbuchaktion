<script setup lang="ts">

import PlaceHolder from "~/components/nav/PlaceHolder.vue";
import NavBarContainer from "~/components/nav/NavBarContainer.vue";
</script>

<template>
  <NavBarContainer>
    <NavBarLeftSection>
      <ULink to="/">
        <Logo class="h-12"></Logo>
      </ULink>

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