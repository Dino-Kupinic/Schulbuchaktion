<script setup lang="ts">
import LoginInputContainer from "~/components/login/LoginInputContainer.vue"
</script>

<template>
  <NavBarThemeToggle/>
  <div class="flex flex-wrap justify-center h-screen">
    <div class="w-full flex justify-center items-center sm:mb-0">
      <Logo/>
    </div>
    <UContainer class="w-full h-auto mr-6 ml-6">
      <h1 class="flex justify-center font-medium text-[20px] mb-16  sm:mb-4">Sign in to your account</h1>
      <LoginInputContainer/>
    </UContainer>
  </div>
</template>

<style scoped>

</style>