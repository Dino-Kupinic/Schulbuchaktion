<script setup lang="ts">
const props = defineProps<{
  title: string
  link: string
}>()
</script>

<template>
  <NuxtLink :to="props.link">
    <span>
      {{ props.title }}
    </span>
  </NuxtLink>
</template>
