<script setup lang="ts">
const props = defineProps({
  title: { type: String, required: true },
  link: { String, required: true },
})
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
