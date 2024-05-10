<script setup lang="ts">
defineProps<{
  title: string
  subtitle: string
}>()
</script>

<template>
  <div class="mb-2">
    <PageTitle>{{ title }}</PageTitle>
    <PageSubtitle>{{ subtitle }}</PageSubtitle>
    <slot />
  </div>
</template>
