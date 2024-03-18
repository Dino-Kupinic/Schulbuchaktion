<script setup lang="ts">
</script>

<template>
  <NavBarThemeToggle/>
  <div class="flex flex-wrap justify  -center h-screen">
    <div class="w-full flex justify-center items-center sm:mb-0">
      <Logo/>
    </div>
    <UContainer class="w-full h-auto mr-6 ml-6">
      <h1 class="flex justify-center font-medium text-[20px] mb-16  sm:mb-4">Sign in to your account</h1>
      <div class="sm:flex sm:justify-center">
        <UContainer
          class="w-full p-0 sm:w-[30%] sm:pl-0 sm:border sm:border-solid sm:border-neutral-200 sm:p-8 sm:rounded-md sm:shadow-md sm:shadow-neutral-300">
          <LoginInput label="Username" margin="mb-4" />
          <LoginInput label="Password" margin="mb-8" />
          <UButton class="dark:bg-blue-500 flex justify-center w-full dark:text-white">Sign in
          </UButton>
        </UContainer>
      </div>
    </UContainer>

  </div>


</template>

<style scoped>

</style>