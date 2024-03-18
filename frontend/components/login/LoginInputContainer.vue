<script setup lang="ts">

</script>

<template>
  <div class="sm:flex sm:justify-center">
    <UContainer
      class="w-full p-0 sm:w-[425px] sm:pl-0 sm:border sm:border-solid sm:dark:shadow-none sm:dark:border-neutral-700 sm:border-neutral-200 sm:p-8 sm:rounded-md sm:shadow-md sm:shadow-neutral-300">
      <LoginInput label="Username" margin="mb-4"/>
      <LoginInput label="Password" margin="mb-8"/>
      <UButton class="dark:bg-blue-500 flex justify-center w-full dark:text-white">Sign in
      </UButton>
    </UContainer>
  </div>
</template>

<style scoped>

</style>