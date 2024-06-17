<script setup lang="ts">
import type {
  APIResponse,
  APIResponseArray,
  APIResponsePaginated,
} from "~/types/response"
import type { BookOrder } from "~/types/bookorder"
import type { Book } from "~/types/book"
import type { Department } from "~/types/department"

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
  ],
  [
    {
      label: t("orderList.deleteOrder.delete"),
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
        key: "bookSubject",
        label: t("book.subject"),
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
        key: "grade",
        label: t("book.grade"),
        sortable: true,
      },
      {
        key: "bookPrice",
        label: t("book.price"),
        sortable: true,
      },
      {
        key: "actions",
      },
    ]
  },
  { immediate: true },
)

async function updateOrder() {
  changedBookOrder.value.year = changedBookOrder.value.year.id
  if (schoolClassId.value) {
    changedBookOrder.value.schoolClass = schoolClassId.value.value
  }
  if (bookId.value) {
    changedBookOrder.value.book = bookId.value
  }
  await $fetch("/bookOrders/update/" + changedBookOrder.value.id, {
    baseURL: config.public.baseURL,
    method: "PUT",
    body: changedBookOrder.value,
  })

  const toast = useToast()

  toast.add({
    title: t("bookList.updateOrder.success"),
    description: t("bookList.updateOrder.successDescription"),
    icon: "i-heroicons-check-circle",
  })

  editModalVisible.value = false
}

async function deleteOrder() {
  await $fetch("/bookOrders/delete/" + changedBookOrder.value.id, {
    baseURL: config.public.baseURL,
    method: "DELETE",
  })
  const toast = useToast()

  toast.add({
    title: t("orderList.deleteOrder.success"),
    description: t("orderList.deleteOrder.successDescription"),
    icon: "i-heroicons-check-circle",
  })

  deleteModalVisible.value = false
}

const { data: books } = await useLazyFetch<APIResponsePaginated<Book>>(
  "/books",
  {
    baseURL: config.public.baseURL,
  },
)

const { data: schoolClasses } = await useLazyFetch<APIResponse<Department[]>>(
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
</script>

<template>
  <UCard
    class="h-auto w-full rounded-lg"
    :ui="{
      body: {
        padding: '',
      },
      header: {
        padding: 'sm:px-4 py-3',
      },
    }"
  >
    <template #header>
      <div
        class="flex w-full flex-col items-center justify-between space-y-2 sm:flex-row"
      >
        <div class="flex w-full sm:w-[300px]">
          <UInput
            v-model="query"
            size="md"
            class="w-full"
            icon="i-heroicons-magnifying-glass-20-solid"
            :placeholder="$t('bookList.searchForBooks')"
          />
        </div>

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
        wrapper: 'relative overflow-x-auto h-[500px] overflow-y-auto',
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
      <template #bookSubject-data="{ row }">
        <span> {{ row.book.subject.name }}</span>
      </template>
      <template #year-data="{ row }">
        <span> {{ row.year.year }}</span>
      </template>
      <template #grade-data="{ row }">
        <span> {{ row.schoolClass.grade }}</span>
      </template>
      <template #bookPrice-data="{ row }">
        <span> {{ row.book.bookPrice / 100 }} €</span>
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

    <UModal v-model="editModalVisible" class="bg-opacity-0">
      <UCard>
        <template #header>
          <div class="flex items-center justify-between">
            <p
              class="text-base font-semibold leading-6 text-red-600 dark:text-white"
            >
              Editing book order for "{{ changedBookOrder.book.title }}"
            </p>
            <UButton
              color="gray"
              variant="ghost"
              icon="i-heroicons-x-mark-20-solid"
              class="-my-1"
              @click="editModalVisible = false"
            />
          </div>
        </template>
        <p>Book</p>
        <USelectMenu
          v-model="bookId"
          :placeholder="changedBookOrder.book.title"
          :options="books?.data?.books"
          option-attribute="title"
          value-attribute="id"
          searchable
        />

        <p class="mt-4">Class</p>
        <USelectMenu
          v-model="schoolClassId"
          :placeholder="changedBookOrder.schoolClass.name"
          :options="
            schoolClasses?.data?.map((schoolClass) => ({
              label: schoolClass.name,
              value: schoolClass.id,
            }))
          "
          searchable
        />

        <UButton class="mt-4" @click="updateOrder">Submit</UButton>
      </UCard>
    </UModal>

    <UModal v-model="deleteModalVisible" class="bg-opacity-0">
      <UCard>
        <template #header>
          <ModalHeader
            :title="$t('orderList.deleteOrder.title')"
            icon="i-heroicons-trash"
          />
        </template>
        <p class="text-base leading-6">
          {{ $t("orderList.deleteOrder.confirmation") }} "{{
            changedBookOrder.book.title
          }}"?
        </p>
        <template #footer>
          <div class="flex w-full justify-end space-x-2">
            <UButton color="red" icon="i-heroicons-trash" @click="deleteOrder">
              {{ $t("orderList.deleteOrder.delete") }}
            </UButton>
            <UButton
              label="Cancel"
              color="gray"
              icon="i-heroicons-x-mark-20-solid"
              @click="deleteModalVisible = false"
            >
              {{ $t("orderList.deleteOrder.cancel") }}
            </UButton>
          </div>
        </template>
      </UCard>
    </UModal>

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
</template>
<style scoped></style>
