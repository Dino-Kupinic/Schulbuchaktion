<script setup lang="ts">
const revealMenu = ref<boolean>(false)

defineEmits(["roundCorners"])
</script>

<template>
  <UButton
    color="blue"
    class="mx-2"
    trailing-icon="i-heroicons-bars-3-solid"
    variant="soft"
    @click="
      () => {
        revealMenu = !revealMenu
        $emit('roundCorners', revealMenu)
      }
    "
  />
  <UContainer
    v-if="revealMenu"
    class="absolute top-20 z-10 box-border flex h-[97%] w-[97%] flex-col items-start justify-start gap-y-5 overflow-x-hidden rounded-b border border-neutral-300 p-5 dark:border-gray-700 dark:bg-gray-900"
  >
    <PlaceHolder />
    <PlaceHolder />
    <PlaceHolder />
    <PlaceHolder />
  </UContainer>
</template>

<style scoped></style>
