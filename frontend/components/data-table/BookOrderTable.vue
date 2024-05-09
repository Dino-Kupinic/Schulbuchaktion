<script setup lang="ts">
import BookOrderTable from "~/components/data-table/BookOrderTable.vue"

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

const id = ref(0)

const bookOrders = useLazyFetch<BookOrder>("bookOrders")

const items = (row: BookOrder) => [
  [
    {
      label: "Edit",
      icon: "i-heroicons-pencil-square-20-solid",
      click: () => console.log("Edit", row.id),
    },
  ],
  [
    {
      label: "Delete",
      icon: "i-heroicons-trash-20-solid",
      click: () => console.log("Edit", row.id),
    },
  ],
]

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

// Selected Rows
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
    return bookOrders.value
  }

  return bookOrders.value.filter((bookOrder) => {
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
</script>

<template>
  <PageTitle>{{ $t("tableTitles.orderTable") }}</PageTitle>
  <UCard
    class="m-auto h-full w-full rounded-lg border border-neutral-300 p-0 underline-offset-1 shadow-lg dark:border-gray-700 dark:bg-gray-900 sm:h-auto sm:min-h-28"
    :ui="{ shadow: 'shadow-none', ring: '', body: 'p-0' }"
  >
    <div class="flex border-b border-gray-200 px-3 py-3.5 dark:border-gray-700">
      <UInput
        v-model="query"
        :placeholder="$t('tableSearch.searchForOrders')"
      />
    </div>
    <UTable
      v-model="selectedRows"
      v-model:sort="sort"
      :rows="filteredRows"
      :columns="columnsTable"
      class="m-0 w-full"
      @select="select"
    >
      <template #subject-data="{ row }">
        <span> {{ row.subject.name }}</span>
      </template>
      <template #publisher-data="{ row }">
        <span> {{ row.publisher.name }}</span>
      </template>
      <template #bookPrice-data="{ row }">
        <span> {{ row.bookPrice / 100 }} €</span>
      </template>
      <template #actions-data="{ row }">
        <UDropdown :items="items(row)">
          <UButton
            color="gray"
            variant="ghost"
            icon="i-heroicons-ellipsis-horizontal-20-solid"
          />
        </UDropdown>
      </template>
    </UTable>

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
