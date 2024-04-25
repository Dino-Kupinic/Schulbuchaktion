<script setup lang="ts">
const emit = defineEmits(["burgerMenuVisible"])

const icon = ref<string>("i-heroicons-bars-3-solid")
const revealMenu = ref<boolean>(false)
const links = [
  { title: "orderList", link: "/settings" },
  { title: "classManagement", link: "/settings" },
  { title: "budgetOverview", link: "/settings" },
  { title: "import", link: "/settings" },
]
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
    class="mx-2"
    :trailing-icon="icon"
    variant="soft"
    @click="openMenu()"
  />
  <template v-if="revealMenu">
    <UContainer
      class="absolute top-20 z-10 mr-px flex h-full w-[97%] flex-col items-start justify-start gap-y-5 space-y-3 overflow-x-hidden rounded-b border border-t-0 border-neutral-300 bg-white p-5 opacity-100 dark:border-gray-700 dark:bg-[#171717]"
    >
      <UContainer class="w-full space-y-1">
        <NavUser />
        <NavBurgerMenuDivider />
      </UContainer>

      <UContainer class="w-full border-inherit" v-for="link in links">
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
    </UContainer>
  </template>
</template>

<style scoped></style>
