<script setup lang="ts">
defineProps<{
  placeholder: string
}>()

const query = defineModel<string>()
</script>

<template>
  <div class="flex w-full sm:w-[300px]">
    <UInput
      v-model="query"
      size="md"
      class="w-full"
      icon="i-heroicons-magnifying-glass-20-solid"
      :placeholder
    />
    <slot />
  </div>
</template>
