<script setup lang="ts">
const props = defineProps<{
  label: string
  margin: string
}>()
</script>

<template>
  <UContainer class="flex p-0 sm:pl-0">
    <p class="mb-3" > {{ label }} </p>
    <slot/>
  </UContainer>
  <UInput :class="margin"></UInput>
</template>

<style scoped>

</style>