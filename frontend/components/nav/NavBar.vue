<script setup lang="ts">
import PlaceHolder from "~/components/nav/PlaceHolder.vue";
import NavBarDesktop from "~/components/nav/NavBarDesktop.vue";

const viewport = useViewport()

watch(viewport.breakpoint, (newBreakpoint, oldBreakpoint) => {
  console.log('Breakpoint updated:', oldBreakpoint, '->', newBreakpoint)
})

</script>

<template>
    <NavBarDesktop v-if="viewport.isGreaterThan('mobile')"/>
    <NavBarMobile v-else/>
</template>

<style scoped>

</style>