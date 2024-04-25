<script setup lang="ts">
const props = defineProps<{
  title: string
  link: string
}>()
</script>

<template>
  <UButton
    class="bg-inherit text-black hover:bg-inherit dark:bg-inherit dark:text-white dark:hover:bg-inherit"
  >
    <NuxtLink :to="props.link">
      {{ $t("navLinks." + props.title) }}
    </NuxtLink>
  </UButton>
</template>

<style scoped></style>
