<script setup lang="ts">
import type { Book } from "~/types/book"
import type { APIResponsePaginated } from "~/types/response"

const columnsBackup = ref([
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
const pageCount = ref(3)
const { data: books, pending } = await useLazyFetch<APIResponsePaginated<Book>>(
  "/books",
  {
    params: {
      perPage: pageCount,
      page: page,
    },
    baseURL: config.public.baseURL,
    watch: [page, pageCount],
  },
)

const pageFrom = computed(() => (page.value - 1) * pageCount.value + 1)
const pageTo = computed(() => {
  if (!books.value?.data?.pages) {
    return 0
  } else {
    return page.value * pageCount.value
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

const selectedColumns = columns
const columnsTable = computed(() =>
  columns.value.filter((column) => selectedColumns.value.includes(column)),
)

const sort = ref({ column: "id", direction: "asc" as const })
const selectedRows = ref<Book[]>([])
const query = ref("")

const filteredRows = computed(() => {
  if (!books.value) {
    return []
  }

  if (!query.value) {
    return books.value.data?.books
  }

  return books.value.data?.books.filter((book: Book) => {
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

function resetFilters() {
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
      <template #grade-data="{ row }">
        <span>
          {{ row.grade.replaceAll("=", ", ") }}
        </span>
      </template>
      <template #ebook-data="{ row }">
        <div class="-ml-2 pr-10 text-center">
          <span v-if="row.ebook">
            <Icon
              class="text-green-500"
              name="material-symbols:check-small"
            ></Icon>
            {{ $t("bool.yes") }}
          </span>
          <span v-else>
            <Icon
              class="text-red-500"
              name="material-symbols:close-small-outline"
            ></Icon>
            {{ $t("bool.no") }}
          </span>
        </div>
      </template>
      <template #ebookPlus-data="{ row }">
        <div class="-ml-2 pr-10 text-center">
          <span v-if="row.ebookPlus">
            <Icon
              class="text-green-500"
              name="material-symbols:check-small"
            ></Icon>
            {{ $t("bool.yes") }}
          </span>
          <span v-else>
            <Icon
              class="text-red-500"
              name="material-symbols:close-small-outline"
            ></Icon>
            {{ $t("bool.no") }}
          </span>
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
          :total="books?.data?.pages || 0"
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
