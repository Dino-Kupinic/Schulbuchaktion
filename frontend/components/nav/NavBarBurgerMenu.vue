<script setup lang="ts">
const emit = defineEmits(["burgerMenuVisible"])
const colorMode = useColorMode()

const backgroundColor = ref<string>("")
backgroundColor.value = isLightMode() ? "bg-white" : "bg-[#171717]"

const icon = ref<string>("i-heroicons-bars-3-solid")
const revealMenu = ref<boolean>(false)

function openMenu() {
  revealMenu.value = !revealMenu.value
  emit("burgerMenuVisible", revealMenu.value)
}

function isLightMode() {
  return colorMode.value.toLowerCase() === "light"
}

watch(colorMode, () => {
  if (isLightMode()) backgroundColor.value = "bg-white"
  else backgroundColor.value = "bg-[#171717]"
})

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
    @click="openMenu()"
  />
  <NavBarThemeToggle />
  <template v-if="revealMenu">
    <UContainer
      :class="backgroundColor"
      class="absolute top-20 z-10 mb-5 box-border flex h-[95%] w-[97%] flex-col items-start justify-start gap-y-5 overflow-x-hidden rounded-b border border-t-0 border-neutral-300 p-5 opacity-100 dark:border-gray-700"
    >
      <PlaceHolder />
      <PlaceHolder />
      <PlaceHolder />
      <PlaceHolder />
    </UContainer>
  </template>
</template>

<style scoped></style>
