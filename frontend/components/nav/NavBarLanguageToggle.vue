<script setup lang="ts">
import type { DropdownItem } from "#ui/types"

const { locale, locales } = useI18n()
const localeCookie = useCookie("locale")

const updateLocale = (code: string) => {
  locale.value = code
}

const icons = ["us", "de"]
const items: DropdownItem[][] = [
  locales.value.map((loc, index) => ({
    label: loc.name as string,
    icon: `i-flag-${icons[index]}-4x3`,
    click: () => updateLocale(loc.code),
  })),
]

watch(locale, () => {
  localeCookie.value = locale.value
})
</script>

<template>
  <UDropdown
    :items="items"
    :ui="{ width: 'w-auto' }"
    :popper="{ placement: 'bottom-start' }"
  >
    <UButton
      color="white"
      variant="ghost"
      trailing-icon="i-heroicons-language-solid"
    />
  </UDropdown>
</template>
