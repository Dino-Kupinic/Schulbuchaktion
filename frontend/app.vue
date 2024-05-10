<script setup lang="ts">
const { locale } = useI18n()
const localeCookie = useCookie("locale")

const setLocale = () => {
  if (!localeCookie.value) {
    localeCookie.value = "en-US"
  }
  locale.value = localeCookie.value
}

onMounted(() => {
  setLocale()
})
</script>

<template>
  <NuxtLayout>
    <NuxtPage />
    <UNotifications />
  </NuxtLayout>
</template>
