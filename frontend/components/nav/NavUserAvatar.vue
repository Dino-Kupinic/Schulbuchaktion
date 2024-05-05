<script setup lang="ts">
defineProps<{
  username: string
}>()
</script>

<template>
  <UAvatar
    class="from-primary-700 to-primary-400 bg-gradient-to-r text-white"
    size="lg"
  >
    {{ username }}
  </UAvatar>
</template>
