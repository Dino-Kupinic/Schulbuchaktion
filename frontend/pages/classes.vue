<script setup lang="ts">
import type { SchoolClass } from "~/types/schoolclass"
import type { APIResponseArray, APIResponseObject } from "~/types/response"
import type { Department } from "~/types/department"
import type { FormSubmitEvent } from "#ui/types"
import { z } from "zod"

const { t, locale } = useI18n()

const columns = ref()
watch(
  locale,
  () => {
    columns.value = [
      { label: t("classes.table.name"), key: "name", sortable: true },
      { label: t("classes.table.grade"), key: "grade", sortable: true },
      { label: t("classes.table.students"), key: "students", sortable: true },
      { label: t("classes.table.repetents"), key: "repetents", sortable: true },
      { label: t("classes.table.budget"), key: "budget", sortable: true },
      {
        label: t("classes.table.usedBudget"),
        key: "usedBudget",
        sortable: true,
      },
      {
        label: t("classes.table.department"),
        key: "department",
        sortable: true,
      },
      { label: t("classes.table.year"), key: "year", sortable: true },
      { key: "actions" },
    ]
  },
  { immediate: true },
)

const items = (row: SchoolClass) =>
  ref([
    [
      { label: t("actions.info"), icon: "i-heroicons-information-circle" },
      { label: t("actions.edit"), icon: "i-heroicons-pencil-square-20-solid" },
      { label: t("actions.duplicate"), icon: "i-heroicons-document-duplicate" },
      { label: t("actions.delete"), icon: "i-heroicons-trash" },
    ],
  ])

const config = useRuntimeConfig()
const {
  data: classes,
  pending,
  refresh: refreshClasses,
} = await useLazyFetch<APIResponseArray<SchoolClass>>("/schoolClasses", {
  baseURL: config.public.baseURL,
  pick: ["data"],
})

const { data: departments, pending: departmentsPending } = await useLazyFetch<
  APIResponseArray<Department>
>("/departments", {
  baseURL: config.public.baseURL,
  pick: ["data"],
})

const filteredRows = computed(() => {
  if (!classes.value) {
    return []
  }

  return classes.value.data
})

const schema = z.object({
  name: z
    .string()
    .min(1, "Must be atleast 1 characters")
    .max(255, "Must be at most 255 characters"),
  grade: z.number().int().min(1, "Must be at least 1"),
  students: z.number().int().min(1, "Must be at least 1"),
  repetents: z.number().int().min(0, "Must be at least 0").default(0),
  budget: z.number().int().min(1, "Must be at least 1"),
  usedBudget: z.number().optional(),
  year: z.number().optional(),
  department: z.any(),
})

type Schema = z.output<typeof schema>
const state = reactive({
  name: undefined,
  grade: undefined,
  students: undefined,
  repetents: undefined,
  budget: undefined,
  department: undefined,
})

const toast = useToast()
const { currentYear, fetchCurrentYear } = useCurrentYear()
await fetchCurrentYear()

async function onSubmit(event: FormSubmitEvent<Schema>) {
  const formData = event.data

  try {
    formData.department = parseInt(formData.department)
    formData.usedBudget = 0
    formData.year = currentYear.value?.id

    const response = await $fetch<APIResponseObject<SchoolClass>>(
      "/schoolClasses/create",
      {
        method: "POST",
        body: JSON.stringify(formData),
        baseURL: config.public.baseURL,
      },
    )
    if (response.success) {
      toast.add({
        title: t("classes.success"),
        description: t("classes.successDescription"),
        icon: "i-heroicons-check-circle",
      })
      refreshClasses()
    } else {
      toast.add({
        title: t("classes.failure"),
        description: t("classes.failureDescription"),
        color: "red",
        icon: "i-material-symbols-error-circle-rounded-outline-sharp",
      })
    }
  } catch (err: unknown) {
    const error = err as Error
    throw createError({
      statusMessage: error.message,
    })
  }
}

const getUsedBudgetColor = (usedBudget: number, budget: number): string => {
  const percentage = (usedBudget / budget) * 100
  if (percentage < 65) return "text-green-500"
  if (percentage < 85) return "text-yellow-500"
  if (percentage <= 100) return "text-red-500"
  return "text-neutral-500"
}
</script>

<template>
  <div class="h-full">
    <PageHeader
      :title="$t('classes.title')"
      :subtitle="$t('classes.subtitle')"
    />
    <UCard
      :ui="{
        base: 'h-full',
        body: {
          base: 'h-full',
          padding: '',
        },
        header: {
          padding: 'sm:px-4 py-3',
        },
      }"
    >
      <div class="flex h-full flex-col sm:flex-row">
        <div class="w-72 p-4 dark:border-r-neutral-800 sm:border-r">
          <p class="mb-3 font-semibold">{{ $t("classes.create") }}</p>
          <UForm
            :schema="schema"
            :state="state"
            class="space-y-2"
            @submit="onSubmit"
          >
            <UFormGroup :label="$t('classes.form.name')" name="name" required>
              <UInput v-model="state.name" placeholder="1AHITN" />
            </UFormGroup>
            <UFormGroup :label="$t('classes.form.grade')" name="grade" required>
              <UInput v-model="state.grade" type="number" placeholder="1" />
            </UFormGroup>
            <UFormGroup
              :label="$t('classes.form.students')"
              name="students"
              required
            >
              <UInput v-model="state.students" type="number" placeholder="30" />
            </UFormGroup>
            <UFormGroup
              :label="$t('classes.form.repetents')"
              name="repetents"
              hint="Optional"
            >
              <UInput v-model="state.repetents" type="number" placeholder="0" />
            </UFormGroup>
            <UFormGroup
              :label="$t('classes.form.budget')"
              name="budget"
              required
            >
              <UInput v-model="state.budget" type="number" placeholder="3000" />
            </UFormGroup>
            <UFormGroup
              :label="$t('classes.form.department')"
              name="department"
              required
            >
              <USelect
                v-if="!departmentsPending && departments && departments.data"
                v-model="state.department"
                :options="departments.data"
                option-attribute="name"
                value-attribute="id"
                :placeholder="$t('classes.form.departmentPlaceholder')"
              />
              <USkeleton v-else class="h-8 w-full" />
            </UFormGroup>
            <UButton
              color="primary"
              type="submit"
              :label="$t('classes.form.submit')"
            />
          </UForm>
        </div>
        <div class="flex h-full flex-col overflow-x-scroll">
          <UTable
            :rows="filteredRows"
            :loading="pending"
            :columns="columns"
            :loading-state="{
              icon: 'i-heroicons-arrow-path-20-solid',
              label: 'Loading...',
            }"
            :ui="{
              wrapper: 'overflow-y-scroll overflow-x-scroll',
              td: {
                padding: 'py-1',
              },
            }"
            :progress="{ color: 'primary', animation: 'carousel' }"
          >
            <template #name-data="{ row }">
              <span class="pr-8">{{ row.name }}</span>
            </template>
            <template #year-data="{ row }">
              <span>{{ row.year.year }}</span>
            </template>
            <template #department-data="{ row }">
              <span> {{ row.department.name }}</span>
            </template>
            <template #budget-data="{ row }">
              <span class="pr-16">{{ row.budget }}€</span>
            </template>
            <template #usedBudget-data="{ row }">
              <span
                :class="getUsedBudgetColor(row.usedBudget, row.budget)"
                class="pr-24"
              >
                {{ row.usedBudget }}€
              </span>
            </template>
            <template #actions-data="{ row }">
              <UDropdown :items="items(row).value" :ui="{ width: 'w-auto' }">
                <UButton
                  color="gray"
                  variant="ghost"
                  icon="i-heroicons-ellipsis-horizontal-20-solid"
                />
              </UDropdown>
            </template>
          </UTable>
        </div>
      </div>
    </UCard>
  </div>
</template>
