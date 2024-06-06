<script setup lang="ts">
defineProps<{
  label: string
}>()
</script>

<template>
  <UContainer class="flex p-0 sm:pl-0">
    <p class="mb-3">{{ label }}</p>
    <slot />
  </UContainer>
  <slot name="input"></slot>
</template>

<style scoped></style>
