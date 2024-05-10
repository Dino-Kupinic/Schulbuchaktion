<script setup lang="ts">
defineProps<{
  icon: string
  text: string
}>()
</script>

<template>
  <div class="flex items-center text-sm">
    <Icon :name="icon" class="mr-1 text-blue-500" />
    <p class="text-gray-600 dark:text-gray-400">
      {{ text }}
    </p>
  </div>
</template>
