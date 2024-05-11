<script setup lang="ts">
import type { Book } from "~/types/book"
import type { APIResponsePaginated } from "~/types/response"

const columns = ref([
  {
    key: "orderNumber",
    label: "Order Number",
    sortable: true,
  },
  {
    key: "title",
    label: "Title",
    sortable: true,
  },
  {
    key: "publisher",
    label: "Publisher",
  },
  {
    key: "subject",
    label: "Subject",
  },
  {
    key: "grade",
    label: "Grade",
  },
  {
    key: "ebook",
    label: "E-book",
  },
  {
    key: "ebookPlus",
    label: "E-book plus",
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

const page = ref(1)
const pageCount = ref(5)
const { data: books, pending } = await useLazyFetch<APIResponsePaginated<Book>>(
  "/books",
  {
    params: {
      perPage: pageCount.value,
      page: page.value,
    },
    baseURL: config.public.baseURL,
  },
)

const pageFrom = computed(() => (page.value - 1) * pageCount.value + 1)
const pageTo = computed(() => {
  if (!books.value?.data?.pages) {
    return 0
  } else {
    return Math.min(page.value * pageCount.value, books.value?.data?.pages)
  }
})

const items = (row: Book) =>
  ref([
    [
      {
        label: t("actions.edit"),
        icon: "i-heroicons-pencil-square-20-solid",
      },
      {
        label: t("actions.info"),
        icon: "i-heroicons-information-circle",
      },
    ],
  ])

const selectedColumns = ref(columns)
const columnsTable = computed(() =>
  columns.value.filter((column) => selectedColumns.value.includes(column)),
)

const sort = ref({ column: "id", direction: "asc" as const })
const selectedRows = ref<Book[]>([])
const query = ref("")

const selectedStatus = ref([])

const resetFilters = () => {
  query.value = ""
  selectedStatus.value = []
}

const filteredRows = computed(() => {
  if (!query.value) {
    return books.value
  }

  if (!books.value) {
    return []
  }

  return books.value?.data?.books.filter((book: Book) => {
    return Object.values(book).some((value) => {
      return (
        String(value).toLowerCase().includes(query.value.toLowerCase()) ||
        book.publisher?.name
          ?.toLowerCase()
          .includes(query.value.toLowerCase()) ||
        book.subject?.name?.toLowerCase().includes(query.value.toLowerCase())
      )
    })
  })
})

const { t, locale } = useI18n()

watch(
  locale,
  () => {
    columns.value = [
      {
        key: "orderNumber",
        label: t("book.orderNumber"),
        sortable: true,
      },
      {
        key: "title",
        label: t("book.title"),
        sortable: true,
      },
      {
        key: "publisher",
        label: t("book.publisher"),
        sortable: true,
      },
      {
        key: "subject",
        label: t("book.subject"),
        sortable: true,
      },
      {
        key: "grade",
        label: t("book.grade"),
        sortable: true,
      },
      {
        key: "ebook",
        label: t("book.ebook"),
        sortable: true,
      },
      {
        key: "ebookPlus",
        label: t("book.ebookPlus"),
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

function select(row: Book) {
  const index = selectedRows.value.findIndex(
    (item) => item.orderNumber === row.orderNumber,
  )
  if (index === -1) {
    selectedRows.value.push(row)
  } else {
    selectedRows.value.splice(index, 1)
  }
}

// :ui="{
// wrapper: 'relative overflow-x-auto max-h-[450px] overflow-y-auto',
//   tr: {
//   base: 'relative overflow-y-auto whitespace-nowrap',
//     padding: 'px-4 py-4',
//     color: 'text-gray-500 dark:text-gray-400',
//     font: '',
//     size: 'text-sm',
// },
// }"
</script>

<template>
  <UCard
    class="m-auto h-full w-full rounded-lg border border-neutral-300 p-0 underline-offset-1 shadow-lg dark:border-gray-700 dark:bg-gray-900 sm:min-h-28"
    :ui="{
      shadow: 'shadow-none',
      ring: '',
      body: {
        padding: '',
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
          <USelectMenu
            v-model="pageCount"
            :options="['3', '5', '10', '20', '30', '40']"
          >
            <UButton icon="i-mingcute-rows-4-line" color="gray" size="md">
              Rows
            </UButton>
          </USelectMenu>

          <USelectMenu
            v-model="selectedColumns"
            :options="columns"
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
            :disabled="query === '' && selectedStatus.length === 0"
            @click="resetFilters"
          >
            Reset
          </UButton>
        </div>
      </div>
    </template>

    <UTable
      v-model="selectedRows"
      v-model:sort="sort"
      :rows="books?.data?.books"
      :loading-state="{
        icon: 'i-heroicons-arrow-path-20-solid',
        label: 'Loading...',
      }"
      :loading="pending"
      :progress="{ color: 'primary', animation: 'carousel' }"
      :columns="columnsTable"
      @select="select"
    >
      <template #name-data="{ row }">
        <span
          :class="[
            selectedRows.find((book) => book.orderNumber === row.id) &&
              'text-primary-500 dark:text-primary-400',
          ]"
          >{{ row.name }}</span
        >
      </template>
      <template #subject-data="{ row }">
        <span>{{ row.subject.name }}</span>
      </template>
      <template #publisher-data="{ row }">
        <span> {{ row.publisher.name }}</span>
      </template>
      <template #bookPrice-data="{ row }">
        <span>
          {{
            Intl.NumberFormat("de-DE", {
              style: "currency",
              currency: "EUR",
            }).format(row.bookPrice / 100)
          }}
        </span>
      </template>
      <template #ebook-data="{ row }">
        <div class="-ml-2 pr-10 text-center">
          <Icon
            v-if="row.ebook"
            class="text-green-500"
            name="material-symbols:check-small"
          ></Icon>
          <Icon
            v-else
            class="text-red-500"
            name="material-symbols:close-small-outline"
          ></Icon>
          Yes
        </div>
      </template>
      <template #ebookPlus-data="{ row }">
        <div class="-ml-2 pr-10 text-center">
          <Icon
            v-if="row.ebookPlus"
            class="text-green-500"
            name="material-symbols:check-small"
          ></Icon>
          <Icon
            v-else
            class="text-red-500"
            name="material-symbols:close-small-outline"
          ></Icon>
          Yes
        </div>
      </template>
      <template #actions-data="{ row }">
        <UDropdown :items="items(row).value">
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
            <span class="font-medium">{{ books?.data?.total }}</span>
            {{ $t("pagination.results") }}
          </span>
        </div>

        <UPagination
          v-model="page"
          :page-count="pageCount"
          :total="books?.data?.pages"
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
