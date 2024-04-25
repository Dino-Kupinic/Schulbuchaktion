<script setup lang="ts">
const viewport = useViewport()
</script>

<template>
  <NavBarDesktop v-if="viewport.isGreaterThan('tablet')" />
  <NavBarMobile v-else />
</template>

<style scoped></style>
