<script setup lang="ts">
import type { SchoolClass } from "~/types/schoolclass"
import type { APIResponseArray } from "~/types/response"
import type { Department } from "~/types/department"
import type { Book } from "~/types/book"

// const { schoolClasses, fetchSchoolClasses } = useSchoolClasses()
// await fetchSchoolClasses()
//
// const classes = ref<SchoolClass[]>(schoolClasses.value)

const columns = ref([
  {
    key: "name",
    label: "Name",
    sortable: true,
  },
  {
    key: "grade",
    label: "Grade",
    sortable: true,
  },
  {
    key: "students",
    label: "Students",
    sortable: true,
  },
  {
    key: "repetents",
    label: "Repetents",
    sortable: true,
  },
  {
    key: "budget",
    label: "Budget",
    sortable: true,
  },
  {
    key: "usedBudget",
    label: "Used Budget",
    sortable: true,
  },
  {
    key: "department",
    label: "Department",
    sortable: true,
  },
  {
    key: "year",
    label: "Year",
    sortable: true,
  },
  {
    key: "actions",
  },
])

const config = useRuntimeConfig()
const { data: classes, pending } = await useLazyFetch<
  APIResponseArray<SchoolClass>
>("/schoolClasses", {
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

const { t } = useI18n()
const items = (row: SchoolClass) =>
  ref([
    [
      {
        label: t("actions.info"),
        icon: "i-heroicons-information-circle",
      },
      {
        label: t("actions.edit"),
        icon: "i-heroicons-pencil-square-20-solid",
      },
      {
        label: t("actions.duplicate"),
        icon: "i-heroicons-document-duplicate",
      },
      {
        label: t("actions.delete"),
        icon: "i-heroicons-trash",
      },
    ],
  ])

const name = ref<string>("")
const selectedDepartment = ref<string>("")
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
          <p class="font-semibold">Create new</p>
          <div class="mt-2 flex flex-col gap-3">
            <UFormGroup label="Name" required>
              <UInput v-model="name" placeholder="1AHITN" />
            </UFormGroup>
            <UFormGroup label="Grade" required>
              <UInput placeholder="1" />
            </UFormGroup>
            <UFormGroup label="Students" required>
              <UInput placeholder="30" />
            </UFormGroup>
            <UFormGroup label="Repetents" hint="Optional">
              <UInput placeholder="0" />
            </UFormGroup>
            <UFormGroup label="Budget" required>
              <UInput placeholder="3000" />
            </UFormGroup>
            <UFormGroup label="Department" required>
              <USelect
                v-if="!departmentsPending && departments && departments.data"
                v-model="selectedDepartment"
                :options="
                  departments?.data.map((d) => ({
                    label: d.name,
                    value: d.id,
                  }))
                "
                placeholder="Select a department"
              />
              <USkeleton v-else class="h-8 w-full" />
            </UFormGroup>
            <div>
              <UButton color="primary" type="submit" label="Create"></UButton>
            </div>
          </div>
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
            <template #budget-data="{ row }">
              <span class="pr-16">{{ row.budget }}</span>
            </template>
            <template #year-data="{ row }">
              <span>{{ row.year.year }}</span>
            </template>
            <template #department-data="{ row }">
              <span> {{ row.department.name }}</span>
            </template>
            <template #usedBudget-data="{ row }">
              <span class="pr-24"> {{ row.usedBudget }}</span>
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
