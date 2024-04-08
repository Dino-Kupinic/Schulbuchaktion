<script setup lang="ts">
const revealMenu = ref<boolean>(false)

defineEmits(["burgerMenuVisible"])
const icon = ref<String>("i-heroicons-bars-3-solid")

watch(revealMenu, () => {
  if (revealMenu.value) icon.value = "i-heroicons-x-mark"
  else icon.value = "i-heroicons-bars-3-solid"
})
</script>

<template>
  <UButton
    color="blue"
    class="mx-2"
    :trailing-icon="icon"
    variant="soft"
    @click="
      () => {
        revealMenu = !revealMenu
        $emit('burgerMenuVisible', revealMenu)
      }
    "
  />
  <UContainer
    v-if="revealMenu"
    class="absolute top-20 z-10 box-border flex h-[97%] w-[97%] flex-col items-start justify-start gap-y-5 overflow-x-hidden rounded-b border border-t-0 border-neutral-300 p-5 opacity-100 dark:border-gray-700"
  >
    <PlaceHolder />
    <PlaceHolder />
    <PlaceHolder />
    <PlaceHolder />
  </UContainer>
</template>

<style scoped></style>
