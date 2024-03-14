<script setup lang="ts">
</script>

<template>


  <div class="flex flex-wrap justify-center h-screen">
    <div class="w-full flex justify-center items-center">
       <Logo />
    </div>
    <UContainer class="w-full h-auto mr-6 ml-6">
      <h1 class="flex justify-center font-medium text-[20px] mb-16">Sign in to your account</h1>
      <UContainer class="w-full p-0">
        <LoginInput label="Username" margin="mb-4"/>
        <LoginInput label="Password" margin="mb-8"/>
        <UButton class="dark:bg-blue-500 flex justify-center w-full dark:text-white">Sign in
        </UButton>
      </UContainer>
    </UContainer>

  </div>


</template>

<style scoped>

</style>