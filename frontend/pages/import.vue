<script setup lang="ts">
import type { APIResponseArray } from "~/types/response"
import type { Year } from "~/types/year"

const toast = useToast()
const config = useRuntimeConfig()
const { t } = useI18n()

const { data: years, pending } = await useLazyFetch<APIResponseArray<Year>>(
  "/years",
  {
    baseURL: config.public.baseURL,
    pick: ["data"],
  },
)

const file = ref<File>()
const year = ref<number>()

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
    const data = await $fetch("/importXLSX", {
      method: "POST",
      body: formData,
      baseURL: config.public.baseURL,
    })
    console.log(data)
    toast.add({
      title: t("import.success"),
      description: t("import.successDescription"),
      icon: "i-heroicons-check-circle",
    })
  } catch (err: unknown) {
    const error = err as Error
    toast.add({
      title: t("import.failure"),
      description: t("import.failureDescription"),
      color: "red",
      icon: "i-material-symbols-error-circle-rounded-outline-sharp",
    })
    throw createError({
      statusMessage: error.message,
    })
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
          @click="submitFile()"
        />
      </template>
    </UCard>
  </div>
</template>
