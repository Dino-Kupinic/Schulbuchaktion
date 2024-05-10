<script setup lang="ts">
type Info = {
  icon: string
  text: string
}

const { t, locale } = useI18n()
const infoList = ref<Info[]>([])

watch(
  locale,
  () => {
    infoList.value = [
      {
        icon: "i-heroicons-check-16-solid",
        text: t("import.info.infos[0]"),
      },
      {
        icon: "i-heroicons-check-16-solid",
        text: t("import.info.infos[1]"),
      },
      {
        icon: "i-heroicons-check-16-solid",
        text: t("import.info.infos[2]"),
      },
    ]
  },
  { immediate: true },
)
</script>

<template>
  <p>{{ $t("import.info.title") }}</p>
  <div class="my-2">
    <div class="flex flex-col gap-2">
      <InfoItem
        v-for="item in infoList"
        :key="item.text"
        :icon="item.icon"
        :text="item.text"
      />
    </div>
  </div>
</template>
