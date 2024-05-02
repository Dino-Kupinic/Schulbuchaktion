<script setup lang="ts">
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
    key: "bookPrice",
    label: "Price",
    sortable: true,
  },
  {
    key: "actions",
  },
])

// @TODO fetch content from DB
const id = ref(0)

const publisher: Partial<Publisher> = {
  id: 1,
  publisherNumber: 48,
  name: "jannick",
}

const publisher2: Partial<Publisher> = {
  id: 1,
  publisherNumber: 48,
  name: "Thomas",
}

const subject: Partial<Subject> = {
  id: 1,
  name: "Deutsch",
}

const subject2: Partial<Subject> = {
  id: 1,
  name: "Englisch",
}

const books: Ref<Partial<Book>[]> = ref([
  {
    orderNumber: id.value++,
    title: "Lord of the Rings",
    bookPrice: 1000,
    ebook: false,
    ebookPlus: true,
    publisher: publisher,
    subject: subject,
  },
  {
    orderNumber: id.value++,
    title: "Lord of the Rings",
    bookPrice: 10000,
    ebook: false,
    ebookPlus: true,
    publisher: publisher2,
    subject: subject2,
  },
  {
    orderNumber: id.value++,
    title: "Lord of the Rings",
    bookPrice: 10000,
    ebook: false,
    ebookPlus: true,
    publisher: publisher,
    subject: subject,
  },
  {
    orderNumber: id.value++,
    title: "Lord of the Rings",
    bookPrice: 10000,
    ebook: false,
    ebookPlus: true,
    publisher: publisher,
    subject: subject,
  },
  {
    orderNumber: id.value++,
    title: "Lord of the Rings",
    bookPrice: 10000,
    ebook: false,
    ebookPlus: true,
    publisher: publisher,
    subject: subject,
  },
  {
    orderNumber: id.value++,
    title: "Lord of the Rings",
    bookPrice: 10000,
    ebook: false,
    ebookPlus: true,
    publisher: publisher,
    subject: subject,
  },
  {
    orderNumber: id.value++,
    title: "Lord of the Rings",
    bookPrice: 10000,
    ebook: false,
    ebookPlus: true,
    publisher: publisher,
    subject: subject,
  },
  {
    orderNumber: id.value++,
    title: "Lord of the Rings",
    bookPrice: 10000,
    ebook: false,
    ebookPlus: true,
    publisher: publisher,
    subject: subject,
  },
  {
    orderNumber: id.value++,
    title: "Lord of the Rings",
    bookPrice: 10000,
    ebook: false,
    ebookPlus: true,
    publisher: publisher,
    subject: subject,
  },
  {
    orderNumber: id.value++,
    title: "Lord of the Rings",
    bookPrice: 10000,
    ebook: false,
    ebookPlus: true,
    publisher: publisher,
    subject: subject,
  },
])

const items = (row: Book) => [
  [
    {
      label: "Edit",
      icon: "i-heroicons-pencil-square-20-solid",
      click: () => console.log("Edit", row.orderNumber),
    },
  ],
  [
    {
      label: "Delete",
      icon: "i-heroicons-trash-20-solid",
      click: () => console.log("Edit", row.orderNumber),
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

const selectedRows = ref<Book[]>([])

const query = ref("")

const filteredRows = computed(() => {
  if (!query.value) {
    return books.value
  }

  return books.value.filter((book) => {
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
  <UCard
    class="m-auto flex h-auto w-full flex-col border border-neutral-300 p-1 dark:border-gray-700 dark:bg-gray-900 sm:h-auto sm:min-h-28 sm:w-[520px] sm:rounded-lg md:w-[775px] lg:w-[1034px]"
  >
    <div class="flex border-b border-gray-200 px-3 py-3.5 dark:border-gray-700">
      <UInput v-model="query" placeholder="Search for books..." />
    </div>
    <UTable
      v-model="selectedRows"
      v-model:sort="sort"
      :rows="filteredRows"
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
            Showing
            <span class="font-medium">{{ pageFrom }}</span>
            to
            <span class="font-medium">{{ pageTo }}</span>
            of
            <span class="font-medium">{{ pageTotal }}</span>
            results
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
