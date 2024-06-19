<script setup lang="ts">
const props = defineProps<{
  title: string
  icon: string
  color: "green" | "red" | "yellow"
}>()

const colors = computed(() => {
  switch (props.color) {
    case "red":
      return "text-red-500 dark:text-red-400"
    case "yellow":
      return "text-yellow-500 dark:text-yellow-400"
    case "green":
      return "text-green-500 dark:text-green-400"
    default:
      return "text-neutral-500"
  }
})
</script>

<template>
  <div class="flex items-center">
    <Icon :name="icon" class="mr-2" :class="[colors]" />
    <p class="font-semibold">{{ title }}</p>
  </div>
</template>
