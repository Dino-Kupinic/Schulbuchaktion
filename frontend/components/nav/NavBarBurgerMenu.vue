<script setup lang="ts">
import type { NavigationItem } from "~/types/nav"

defineProps<{
  links: NavigationItem[]
}>()
const emit = defineEmits(["burgerMenuVisible"])

const icon = ref<string>("i-heroicons-bars-3-solid")
const revealMenu = ref<boolean>(false)

function openMenu() {
  revealMenu.value = !revealMenu.value
  emit("burgerMenuVisible", revealMenu.value)
}

watch(revealMenu, () => {
  if (revealMenu.value) icon.value = "i-heroicons-x-mark"
  else icon.value = "i-heroicons-bars-3-solid"
})
</script>

<template>
  <UButton
    color="blue"
    class="mr-4"
    :trailing-icon="icon"
    size="lg"
    variant="soft"
    @click="openMenu()"
  />
  <template v-if="revealMenu">
    <div
      class="absolute top-[72px] z-10 flex h-[calc(100%-72px)] w-full flex-col items-start justify-start gap-y-5 space-y-3 overflow-x-hidden bg-white p-5 opacity-100 dark:border-gray-700 dark:bg-gray-900"
    >
      <UContainer class="w-full space-y-1">
        <NavUser />
        <NavBurgerMenuDivider />
      </UContainer>

      <UContainer
        v-for="link in links"
        :key="link.link"
        class="w-full border-inherit"
      >
        <NavLink :title="link.title" :link="link.link" />
        <NavBurgerMenuDivider />
      </UContainer>

      <UContainer class="h-20" />
      <UContainer class="w-full">
        <NavSettingsButton :styling="false" />
        <NavBurgerMenuDivider />
      </UContainer>

      <UContainer class="flex w-full justify-between">
        <NavBarLanguageToggle />
        <NavBarThemeToggle />
      </UContainer>
    </div>
  </template>
</template>
