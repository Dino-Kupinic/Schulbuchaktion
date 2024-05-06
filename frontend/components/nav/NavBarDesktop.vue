<script setup lang="ts">
import type { NavigationItem } from "~/types/nav"

defineProps<{
  links: NavigationItem[]
}>()
</script>

<template>
  <NavBarContainer>
    <NavBarLeftSection>
      <NavBarLogoLink />
      <NuxtLink
        v-for="link in links"
        :key="link.link"
        :to="link.link"
        class="hover:text-primary px-3"
      >
        {{ link.title }}
      </NuxtLink>
    </NavBarLeftSection>
    <NavBarRightSection />
  </NavBarContainer>
</template>
