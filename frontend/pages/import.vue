<script setup lang="ts">
import type { APIResponseArray } from "~/types/response"
import type { Year } from "~/types/year"

const config = useRuntimeConfig()
const { t } = useI18n()

const { data: years, pending } = await useLazyFetch<APIResponseArray<Year>>(
  "/years/import",
  {
    baseURL: config.public.baseURL,
    pick: ["data"],
  },
)

watch(pending, async () => {
  if (pending) {
    if (years.value !== null) {
      const currentDate = new Date()
      const currentYearExisting = (year: Year) =>
        year.year === currentDate.getFullYear()
      const nextYearExisting = (year: Year) =>
        year.year === currentDate.getFullYear() + 1

      if (!years.value.data?.some(currentYearExisting)) {
        await $fetch("/years/create", {
          method: "POST",
          body: { year: new Date().getFullYear() },
          baseURL: config.public.baseURL,
        })
      }

      if (!years.value.data?.some(nextYearExisting)) {
        await $fetch("/years/create", {
          method: "POST",
          body: { year: new Date().getFullYear() + 1 },
          baseURL: config.public.baseURL,
        })
      }
    }
  }
})

const file = ref<File>()
const year = ref<number>()
const isLoading = ref<boolean>(false)

async function submitFile() {
  if (!file.value) {
    throw createError({
      statusMessage: "No file selected",
    })
  }

  const formData = new FormData()
  formData.append("file", file.value)
  formData.append("year", year.value?.toString() ?? "")

  try {
    isLoading.value = true
    await $fetch("/importXLSX", {
      method: "POST",
      body: formData,
      credentials: "include",
      baseURL: config.public.baseURL,
    })
    displaySuccessNotification(
      t("notification.success"),
      t("import.successDescription"),
    )
  } catch (err: unknown) {
    const error = err as Error
    displayFailureNotification(
      t("notification.failure"),
      t("import.failureDescription"),
    )
    throw createError({
      statusMessage: error.message,
    })
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <div class="flex h-full w-full flex-col">
    <PageHeader :title="$t('import.title')" :subtitle="$t('import.subtitle')" />
    <UCard>
      <template #header>
        <InfoList />
      </template>
      <div class="space-y-3">
        <UAlert
          icon="i-jam-triangle-danger"
          color="red"
          variant="subtle"
          :title="$t('import.alert')"
          :description="$t('import.alertDescription')"
        />
        <UFormGroup :label="$t('import.yearLabel')" required>
          <div v-if="pending">
            <USkeleton class="h-8 w-full" />
          </div>
          <div v-else>
            <USelect
              v-model="year"
              :options="years?.data"
              size="md"
              :placeholder="$t('import.yearSelect')"
              value-attribute="id"
              option-attribute="year"
            />
          </div>
        </UFormGroup>
        <UFormGroup :label="$t('import.fileLabel')" required>
          <UInput
            type="file"
            accept=".xlsx"
            size="md"
            icon="i-heroicons-folder"
            @change="file = $event[0]"
          />
        </UFormGroup>
      </div>
      <template #footer>
        <UButton
          :label="$t('import.submit')"
          class="px-8"
          :loading="isLoading"
          @click="submitFile()"
        />
      </template>
    </UCard>
  </div>
</template>
