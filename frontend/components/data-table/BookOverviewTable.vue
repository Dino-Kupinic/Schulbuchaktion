<script setup lang="ts">
import EditTableModal from "~/components/data-table/EditTableModal.vue"

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

const books: Ref<Book[]> = ref([])

const items = (row: Book) =>
  ref([
    [
      {
        label: t("actions.edit"),
        icon: "i-heroicons-pencil-square-20-solid",
        //click: () => edit Book,
      },
    ],
  ])

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

const selectedRows = ref<Book[]>([])

const query = ref("")

const filteredRows = computed(() => {
  if (!query.value) {
    return books.value
  }

  return books.value.filter((book: Book) => {
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

const config = useRuntimeConfig()

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

async function getBooks(): Promise<Book[]> {
  const response = await $fetch("/books", {
    method: "GET",
    baseURL: config.public.baseURL,
  })

  // @ts-expect-error
  return response.data
}

async function deleteBookById(id: number) {
  await $fetch("books/delete/" + id, {
    method: "DELETE",
    baseURL: config.public.baseURL,
  })
}

onMounted(async () => {
  books.value = await getBooks()
})

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
</script>

<template>
  <EditTableModal />
  <UCard
    class="m-auto h-full w-full rounded-lg border border-neutral-300 p-0 underline-offset-1 shadow-lg dark:border-gray-700 dark:bg-gray-900 sm:min-h-28"
    :ui="{ shadow: 'shadow-none', ring: '' }"
  >
    <div class="flex border-b border-gray-200 px-3 py-3.5 dark:border-gray-700">
      <UInput v-model="query" :placeholder="$t('tableSearch.searchForBooks')" />
    </div>
    <!-- Wrap UTable in a div with a specific height and overflow-y auto -->
    <UTable
      v-model="selectedRows"
      v-model:sort="sort"
      :rows="filteredRows"
      :columns="columnsTable"
      :ui="{
        wrapper: 'relative overflow-x-auto max-h-[450px] overflow-y-auto',
        tr: {
          base: 'relative overflow-y-auto whitespace-nowrap',
          padding: 'px-4 py-4',
          color: 'text-gray-500 dark:text-gray-400',
          font: '',
          size: 'text-sm',
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
      <template #ebook-data="{ row }">
        <div class="text-center">
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
        </div>
      </template>
      <template #ebookPlus-data="{ row }">
        <div class="text-center">
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
