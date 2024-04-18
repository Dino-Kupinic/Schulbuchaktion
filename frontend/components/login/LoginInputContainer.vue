<script setup lang="ts"></script>

<template>
  <div class="sm:flex sm:justify-center">
    <UContainer
      class="w-full p-0 sm:w-[425px] sm:rounded-lg sm:border sm:border-solid sm:border-neutral-200 sm:p-8 sm:shadow-md sm:shadow-neutral-300 sm:dark:border-neutral-700 sm:dark:shadow-none"
    >
      <LoginInput label="Username" margin="mb-4" />
      <LoginInput label="Password" margin="mb-8" />
      <UButton
        class="flex w-full justify-center dark:bg-blue-500 dark:text-white"
      >
        Sign in
      </UButton>
    </UContainer>
  </div>
</template>

<style scoped></style>
