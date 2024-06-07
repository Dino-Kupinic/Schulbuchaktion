<script setup lang="ts">
defineProps<{
  title: string
  icon: string
}>()
</script>

<template>
  <div class="flex items-center">
    <Icon :name="icon" class="mr-2 text-red-500 dark:text-red-200" />
    <p class="font-semibold">{{ title }}</p>
  </div>
</template>
