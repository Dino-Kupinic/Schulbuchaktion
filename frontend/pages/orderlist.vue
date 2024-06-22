<script setup lang="ts">
import type {
  APIResponse,
  APIResponseArray,
  APIResponsePaginated,
} from "~/types/response"
import type { BookOrder } from "~/types/bookorder"
import type { Book } from "~/types/book"
import type { SchoolClass } from "~/types/schoolclass"
import { z } from "zod"

const columns = ref([
  {
    key: "bookTitle",
    label: "Title",
    sortable: true,
  },
  {
    key: "bookSubject",
    label: "Subject",
    sortable: true,
  },
  {
    key: "department",
    label: "Department",
    sortable: true,
  },
  {
    key: "year",
    label: "School year",
    sortable: true,
  },
  {
    key: "grade",
    label: "Grade",
    sortable: true,
  },
  {
    key: "bookPrice",
    label: "Price",
    sortable: true,
  },
  {
    key: "actions",
  },
])

const config = useRuntimeConfig()
const editModalVisible = ref<boolean>(false)
const deleteModalVisible = ref<boolean>(false)
const { data: bookOrders, pending } = await useLazyFetch<
  APIResponseArray<BookOrder[]>
>("/bookOrders", {
  baseURL: config.public.baseURL,
  pick: ["data"],
  watch: [editModalVisible, deleteModalVisible],
})

const changedBookOrder = ref()

const items = (row: BookOrder) => [
  [
    {
      label: "Edit",
      slot: "edit",
      icon: "i-heroicons-pencil-square-20-solid",
      click: () => {
        changedBookOrder.value = row
        editModalVisible.value = true
      },
    },
    {
      label: t("actions.delete"),
      slot: "delete",
      icon: "i-heroicons-trash-20-solid",
      click: () => {
        changedBookOrder.value = row
        deleteModalVisible.value = true
      },
    },
  ],
]

const options = [5, 10, 15, 20, 30, 40]

const DEFAULT_PAGE_COUNT = options[2]

const page = ref(1)
const pageCount = ref(5)
const pageTotal = ref(10) // This value should be dynamic coming from the API
const pageFrom = computed(() => (page.value - 1) * pageCount.value + 1)
const pageTo = computed(() =>
  Math.min(page.value * pageCount.value, pageTotal.value),
)

const selectedColumns = ref(columns)
const columnsTable = computed(() =>
  columns.value.filter((column) => selectedColumns.value.includes(column)),
)

const sort = ref({ column: "id", direction: "asc" as const })
const selectedRows = ref<BookOrder[]>([])

function select(row: BookOrder) {
  const index = selectedRows.value.findIndex((item) => item.id === row.id)
  if (index === -1) {
    selectedRows.value.push(row)
  } else {
    selectedRows.value.splice(index, 1)
  }
}

const query = ref("")

const filteredRows = computed(() => {
  if (!query.value) {
    return bookOrders.value?.data
  }

  return bookOrders.value?.data?.filter((bookOrder) => {
    return Object.values(bookOrder).some((value) => {
      return String(value).toLowerCase().includes(query.value.toLowerCase())
    })
  })
})

const { t, locale } = useI18n()

watch(
  locale,
  () => {
    columns.value = [
      {
        key: "bookTitle",
        label: t("book.title"),
        sortable: true,
      },
      {
        key: "count",
        label: t("bookOrder.count"),
        sortable: true,
      },
      {
        key: "repetents",
        label: t("bookOrder.repetents"),
        sortable: true,
      },
      {
        key: "lastUser",
        label: t("bookOrder.lastUser"),
        sortable: true,
      },
      {
        key: "department",
        label: t("book.department"),
        sortable: true,
      },
      {
        key: "year",
        label: t("book.schoolYear"),
        sortable: true,
      },
      {
        key: "bookPrice",
        label: t("book.price"),
        sortable: true,
      },
      {
        key: "totalBookPrice",
        label: t("bookOrder.totalPrice"),
        sortable: true,
      },
      {
        key: "actions",
      },
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

const state = reactive({
  name: undefined,
  grade: undefined,
  students: undefined,
  repetents: undefined,
  budget: undefined,
  department: undefined,
})

async function updateOrder() {
  if (schoolClassId.value) {
    changedBookOrder.value.schoolClass = getSchoolClassById(
      schoolClassId.value.value,
    )
  }

  if (bookId.value) {
    changedBookOrder.value.book = getBookById(bookId.value.value)
  }

  await $fetch("/bookOrders/update/" + changedBookOrder.value.id, {
    baseURL: config.public.baseURL,
    method: "PUT",
    body: changedBookOrder.value,
  })

  displaySuccessNotification(
    t("orderList.updateOrder.success"),
    t("orderList.updateOrder.successDescription"),
  )

  editModalVisible.value = false
}

async function deleteOrder() {
  await $fetch("/bookOrders/delete/" + changedBookOrder.value.id, {
    baseURL: config.public.baseURL,
    method: "DELETE",
  })

  displaySuccessNotification(
    t("orderList.deleteOrder.success"),
    t("orderList.deleteOrder.successDescription"),
  )

  deleteModalVisible.value = false
}

const { data: books } = await useLazyFetch<APIResponsePaginated<Book>>(
  "/books",
  {
    baseURL: config.public.baseURL,
  },
)

const { data: schoolClasses } = await useLazyFetch<APIResponse<SchoolClass[]>>(
  "/schoolClasses",
  {
    baseURL: config.public.baseURL,
    watch: [page, pageCount],
  },
)

function getSchoolClassById(id: number) {
  return schoolClasses?.value?.data?.find(
    (schoolClass) => schoolClass.id === id,
  )
}

function getBookById(id: number) {
  return books?.value?.data?.books.find((book) => book.id === id)
}

const bookId = ref()
const schoolClassId = ref()

const columnsBackup = ref(columns.value)

function resetFilters() {
  pageCount.value = DEFAULT_PAGE_COUNT
  query.value = ""
  selectedColumns.value = columnsBackup.value
}

const calculatedPrice = (row: BookOrder) => {
  return (row.count * row.book.bookPrice) / 100
}
</script>

<template>
  <div class="h-full">
    <PageHeader
      :title="$t('orderList.title')"
      :subtitle="$t('orderList.subtitle')"
    />
    <UCard
      :ui="{
        base: 'h-full flex flex-col',
        body: {
          base: 'h-full overflow-y-auto',
          padding: '',
        },
        header: {
          padding: 'sm:px-4 py-3',
        },
        footer: {
          base: '',
          padding: 'sm:px-4 py-3',
        },
      }"
    >
      <template #header>
        <div
          class="flex w-full flex-col items-center justify-between space-y-2 sm:flex-row"
        >
          <TableSearch
            v-model="query"
            :placeholder="$t('bookList.searchForBooks')"
          />

          <div class="flex items-center gap-2">
            <USelect
              v-model="pageCount"
              size="md"
              :options="options"
              @update:model-value="(value) => (pageCount = Number(value))"
            />

            <USelectMenu
              v-model="selectedColumns"
              :options="columns.slice(0, columns.length - 1)"
              multiple
              :ui-menu="{ base: 'w-40' }"
            >
              <UButton icon="i-heroicons-view-columns" color="gray" size="md">
                Columns
              </UButton>
            </USelectMenu>

            <UButton
              icon="i-heroicons-funnel"
              color="gray"
              size="md"
              @click="resetFilters()"
            >
              Reset
            </UButton>
          </div>
        </div>
      </template>
      <UTable
        v-model="selectedRows"
        v-model:sort="sort"
        :rows="filteredRows"
        :loading-state="{
          icon: 'i-heroicons-arrow-path-20-solid',
          label: 'Loading...',
        }"
        :loading="pending"
        :progress="{ color: 'primary', animation: 'carousel' }"
        :columns="columnsTable"
        :ui="{
          td: {
            padding: 'py-1',
          },
        }"
        @select="select"
      >
        <template #bookTitle-data="{ row }">
          <span> {{ row.book.title }}</span>
        </template>
        <template #department-data="{ row }">
          <span> {{ row.schoolClass.department.name }}</span>
        </template>
        <template #count-data="{ row }">
          <span> {{ row.schoolClass.students }}</span>
        </template>
        <template #bookSubject-data="{ row }">
          <span> {{ row.book.subject.name }}</span>
        </template>
        <template #year-data="{ row }">
          <span class="pr-24"> {{ row.year.year }}</span>
        </template>
        <template #bookPrice-data="{ row }">
          <span> {{ row.book.bookPrice / 100 }} €</span>
        </template>
        <template #totalBookPrice-data="{ row }">
          <span> {{ calculatedPrice(row) }} €</span>
        </template>
        <template #actions-data="{ row }">
          <UDropdown :items="items(row)" :ui="{ width: 'w-auto' }">
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
        :title="$t('orderList.updateOrder.title')"
        :item-title="changedBookOrder?.book.title ?? null"
        @update="updateOrder"
      >
        <UForm :schema="schema" :state="state" class="space-y-3"> </UForm>
      </GenericEditModal>

      <GenericDeleteModal
        v-model="deleteModalVisible"
        :title="$t('orderList.deleteOrder.title')"
        :item-title="changedBookOrder?.book.title ?? null"
        @delete="deleteOrder"
      />

      <template #footer>
        <div class="flex flex-wrap items-center justify-between">
          <div>
            <span class="text-sm leading-5">
              {{ $t("pagination.showing") }}
              <span class="font-medium">{{ pageFrom }}</span>
              {{ $t("pagination.to") }}
              <span class="font-medium">{{ pageTo }}</span>
              {{ $t("pagination.of") }}
              <span class="font-medium">{{ pageTotal }}</span>
              {{ $t("pagination.results") }}
            </span>
          </div>

          <UPagination
            v-model="page"
            :page-count="pageCount"
            :total="pageTotal"
            :ui="{
              wrapper: 'flex items-center',
              default: {
                activeButton: {
                  variant: 'outline',
                },
              },
            }"
          />
        </div>
      </template>
    </UCard>
  </div>
</template>
