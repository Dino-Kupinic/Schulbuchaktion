<script setup lang="ts">
const props = defineProps({ styling: { type: Boolean, default: true } })
</script>

<template>
  <UButton
    v-if="props.styling"
    class="dark:bg-primary-800 text-primary-500 bg-primary-100/75 transition hover:text-white dark:text-white"
  >
    <NuxtLink to="/settings">{{ $t("settings.settingName") }}</NuxtLink>
  </UButton>
  <UButton
    v-else
    class="bg-inherit text-black hover:bg-inherit dark:bg-inherit dark:text-white dark:hover:bg-inherit"
  >
    <NuxtLink to="/settings">
      {{ $t("settings.settingName") }}
    </NuxtLink>
  </UButton>
</template>

<style scoped></style>
