<script setup lang="ts">
import type { NavigationItem } from "~/types/nav"

const viewport = useViewport()
const { t, locale } = useI18n()
const links = ref<NavigationItem[]>([])

watch(
  locale,
  () => {
    links.value = [
      {
        title: t("nav.orderList"),
        link: "/orderlist",
      },
      {
        title: t("nav.classManagement"),
        link: "/classes",
      },
      {
        title: t("nav.budgetOverview"),
        link: "/budget",
      },
      {
        title: t("nav.import"),
        link: "/import",
      },
    ]
  },
  { immediate: true },
)
</script>

<template>
  <UContainer class="flex h-[72px] w-full justify-center">
    <NavBarDesktop v-if="viewport.isGreaterThan('tablet')" :links />
    <NavBarMobile v-else :links />
  </UContainer>
</template>
