<script setup lang="ts">
const props = defineProps<{
  title: string
  link: string
}>()
</script>

<template>
  <NuxtLink :to="props.link">
    {{ props.title }}
  </NuxtLink>
</template>
