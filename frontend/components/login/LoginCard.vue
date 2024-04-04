<script setup lang="ts"></script>

<template>
  <NavBar />
  <NavBarThemeToggle />
  <div class="flex h-screen flex-wrap justify-center">
    <div class="flex w-full items-center justify-center sm:mb-0">
      <TheLogo />
    </div>
    <UContainer class="ml-6 mr-6 h-auto w-full">
      <h1 class="mb-16 flex justify-center text-[20px] font-medium sm:mb-4">
        Sign in to your account
      </h1>
      <LoginInputContainer />
    </UContainer>
  </div>
</template>

<style scoped></style>
