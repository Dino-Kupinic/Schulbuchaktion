<script setup lang="ts">
const revealMenu = ref<boolean>(false)

defineEmits(["roundCorners"])
</script>

<template>
  <!-- This section is for the small size BurgerMenu -->
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
    class="absolute top-20 z-10 flex h-[97%] w-[97%] flex-row items-center justify-center gap-5 overflow-x-hidden rounded-b bg-black"
  >
  </UContainer>
</template>

<style scoped></style>
