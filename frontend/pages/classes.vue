<script setup lang="ts">
import type { SchoolClass } from "~/types/schoolclass"
import type { APIResponseArray, APIResponseObject } from "~/types/response"
import type { Department } from "~/types/department"
import type { FormSubmitEvent } from "#ui/types"
import { z } from "zod"
import TableSearch from "~/components/table/TableSearch.vue"

const { t, locale } = useI18n()

const columns = ref()

// prettier-ignore
watch(
  locale,
  () => {
    columns.value = [
      { label: t("classes.table.name"), key: "name", sortable: true },
      { label: t("classes.table.grade"), key: "grade", sortable: true },
      { label: t("classes.table.students"), key: "students", sortable: true },
      { label: t("classes.table.repetents"), key: "repetents", sortable: true },
      { label: t("classes.table.budget"), key: "budget", sortable: true },
      { label: t("classes.table.usedBudget"), key: "usedBudget", sortable: true },
      { label: t("classes.table.department"), key: "department", sortable: true },
      { label: t("classes.table.year"), key: "year", sortable: true },
      { key: "actions" },
    ]
  },
  { immediate: true },
)

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

const editState = reactive({
  name: "",
  grade: 1,
  students: 1,
  repetents: 0,
  budget: 1,
  department: {},
})

const editModalVisible = ref<boolean>(false)
const deleteModalVisible = ref<boolean>(false)
const changedSchoolClass = ref<SchoolClass | null>(null)
const items = (row: SchoolClass) =>
  ref([
    [
      { label: t("actions.info"), icon: "i-heroicons-information-circle" },
      {
        label: t("actions.edit"),
        icon: "i-heroicons-pencil-square-20-solid",
        click: () => {
          changedSchoolClass.value = row

          editState.name = changedSchoolClass.value.name
          editState.grade = changedSchoolClass.value.grade
          editState.students = changedSchoolClass.value.students
          editState.repetents = changedSchoolClass.value.repetents
          editState.budget = changedSchoolClass.value.budget
          editState.department = changedSchoolClass.value.department.id

          editModalVisible.value = true
        },
      },
      { label: t("actions.duplicate"), icon: "i-heroicons-document-duplicate" },
      {
        label: t("actions.delete"),
        icon: "i-heroicons-trash",
        click: () => {
          changedSchoolClass.value = row
          deleteModalVisible.value = true
        },
      },
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
  credentials: "include",
  watch: [deleteModalVisible, editModalVisible],
})

const { data: departments, pending: departmentsPending } = await useLazyFetch<
  APIResponseArray<Department>
>("/departments", {
  baseURL: config.public.baseURL,
  credentials: "include",
  pick: ["data"],
})

const { currentYear, fetchCurrentYear } = useCurrentYear()
await fetchCurrentYear()

async function onCreateSubmit(event: FormSubmitEvent<Schema>) {
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
      displaySuccessNotification(
        t("notification.success"),
        t("classes.successDescription"),
      )
      refreshClasses()
    } else {
      displayFailureNotification(
        t("notification.failure"),
        t("classes.failureDescription"),
      )
    }
  } catch (err: unknown) {
    const error = err as Error
    throw createError({
      statusMessage: error.message,
    })
  }
}

// TODO: dont delete but set valid date, only show valid classes in view
async function deleteClass() {
  await $fetch(`/schoolClasses/delete/${changedSchoolClass.value?.id}`, {
    method: "DELETE",
    baseURL: config.public.baseURL,
    credentials: "include",
  })

  displaySuccessNotification(
    t("notification.success"),
    t("classes.deleteClass.successDescription"),
  )

  deleteModalVisible.value = false
}

async function updateClass() {
  const result = schema.safeParse(editState)

  if (!result.success) {
    displayFailureNotification(
      t("notification.failure"),
      t("classes.updateClass.failureDescription"),
    )
    console.error(result.error.errors)
    return
  }

  const formData = result.data
  formData.usedBudget = 0
  formData.year = currentYear.value?.id
  formData.department = parseInt(formData.department)

  const response = await $fetch<APIResponseObject<SchoolClass>>(
    `/schoolClasses/update/${changedSchoolClass.value?.id}`,
    {
      method: "PUT",
      body: JSON.stringify(formData),
      baseURL: config.public.baseURL,
      credentials: "include",
    },
  )

  if (response.success) {
    displaySuccessNotification(
      t("notification.success"),
      t("classes.updateClass.successDescription"),
    )
    refreshClasses()
  } else {
    displayFailureNotification(
      t("notification.failure"),
      t("classes.updateClass.failureDescription"),
    )
  }

  editModalVisible.value = false
}

const getUsedBudgetColor = (usedBudget: number, budget: number): string => {
  const percentage = (usedBudget / budget) * 100
  if (percentage < 65) return "text-neutral-500 dark:text-neutral-400"
  if (percentage < 85) return "text-yellow-500"
  if (percentage <= 100) return "text-red-500"
  return "text-neutral-500"
}

const query = ref<string>("")
const filteredRows = computed(() => {
  if (!classes.value || !classes.value.data) {
    return []
  }

  if (!query.value) {
    return classes.value.data
  }

  return classes.value.data.filter((schoolClass: SchoolClass) => {
    return Object.values(schoolClass).some((value) => {
      return (
        value.toString().toLowerCase().includes(query.value.toLowerCase()) ||
        schoolClass.year.year.toString().includes(query.value) ||
        schoolClass.department.name
          .toLowerCase()
          .includes(query.value.toLowerCase())
      )
    })
  })
})
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
            @submit="onCreateSubmit"
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
              :label="$t('actions.submit')"
            />
          </UForm>
        </div>
        <div class="flex h-full w-full flex-col overflow-x-auto">
          <div
            class="w-full border-b border-neutral-300 p-4 dark:border-neutral-700"
          >
            <TableSearch
              v-model="query"
              :placeholder="$t('classes.searchForClasses')"
            />
          </div>
          <UTable
            :rows="filteredRows"
            :loading="pending"
            :columns="columns"
            :loading-state="{
              icon: 'i-heroicons-arrow-path-20-solid',
              label: 'Loading...',
            }"
            :ui="{
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

          <GenericEditModal
            v-model="editModalVisible"
            :title="$t('classes.updateClass.title')"
            @update="updateClass"
          >
            <UForm :schema="schema" :state="editState" class="space-y-3">
              <UFormGroup :label="$t('classes.form.name')" name="name" required>
                <UInput v-model="editState.name" />
              </UFormGroup>
              <UFormGroup
                :label="$t('classes.form.grade')"
                name="grade"
                required
              >
                <UInput v-model="editState.grade" type="number" />
              </UFormGroup>
              <UFormGroup
                :label="$t('classes.form.students')"
                name="students"
                required
              >
                <UInput v-model="editState.students" type="number" />
              </UFormGroup>
              <UFormGroup
                :label="$t('classes.form.repetents')"
                name="repetents"
                hint="Optional"
              >
                <UInput v-model="editState.repetents" type="number" />
              </UFormGroup>
              <UFormGroup
                :label="$t('classes.form.budget')"
                name="budget"
                required
              >
                <UInput v-model="editState.budget" type="number" />
              </UFormGroup>
              <UFormGroup
                :label="$t('classes.form.department')"
                name="department"
                required
              >
                <USelect
                  v-if="!departmentsPending && departments && departments.data"
                  v-model="editState.department"
                  :options="departments.data"
                  option-attribute="name"
                  value-attribute="id"
                  :placeholder="$t('classes.form.departmentPlaceholder')"
                />
                <USkeleton v-else class="h-8 w-full" />
              </UFormGroup>
            </UForm>
          </GenericEditModal>

          <GenericDeleteModal
            v-model="deleteModalVisible"
            :title="$t('classes.deleteClass.title')"
            :item-title="changedSchoolClass?.name ?? null"
            @delete="deleteClass"
          />
        </div>
      </div>
    </UCard>
  </div>
</template>
