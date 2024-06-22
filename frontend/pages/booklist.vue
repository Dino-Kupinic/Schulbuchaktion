<script setup lang="ts">
import type { Book } from "~/types/book"
import type { APIResponseArray, APIResponsePaginated } from "~/types/response"
import type { SchoolClass } from "~/types/schoolclass"
import type { BookOrderDTO } from "~/types/bookorder"
import { z } from "zod"
import type { FormSubmitEvent } from "#ui/types"
import type { Year } from "~/types/year"

const { t, locale } = useI18n()

const columns = ref([
  {
    key: "orderNumber",
    label: "BNR",
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
const columnsBackup = ref(columns.value)
const config = useRuntimeConfig()

const options = [5, 10, 15, 20, 30, 40]

const DEFAULT_PAGE = 1
const DEFAULT_PAGE_COUNT = options[2]

const page = ref<number>(DEFAULT_PAGE)
const pageCount = ref<number>(DEFAULT_PAGE_COUNT)

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
const query = ref<string>("")

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
  pageCount.value = DEFAULT_PAGE_COUNT
  query.value = ""
  selectedColumns.value = columnsBackup.value
}

const { data: schoolClasses, pending: schoolClassesPending } =
  await useLazyFetch<APIResponseArray<SchoolClass>>("/schoolClasses", {
    baseURL: config.public.baseURL,
    pick: ["data"],
  })

const isVisible = ref(false)

const schema = z.object({
  schoolClass: z.object({
    id: z.number(),
    name: z.string(),
    grade: z.number(),
    students: z.number(),
    repetents: z.number(),
    budget: z.number(),
    usedBudget: z.number(),
  }),
  repetents: z.string(),
  teacherCopy: z.boolean(),
})

const state = reactive({
  schoolClass: undefined,
  repetents: undefined,
  teacherCopy: undefined,
})

const { data: years } = await useLazyFetch<APIResponseArray<Year>>("/years", {
  baseURL: config.public.baseURL,
})

async function addBookOrder() {
  const result = schema.safeParse(state)

  if (!result.success) {
    displayFailureNotification(
      t("notification.failure"),
      t("classes.updateClass.failureDescription"),
    )
    console.error(result.error.errors)
    return
  }

  const formData = result.data

  if (years.value == null || years.value.data == undefined) {
    return
  }

  const bookOrders: BookOrderDTO[] = []

  selectedRows.value.forEach((row) => {
    let count = 0

    switch (formData.repetents) {
      case "With":
        count = formData.schoolClass.students + formData.schoolClass.repetents
        break
      case "Without":
        count = formData.schoolClass.students
        break
      case "Only":
        count = formData.schoolClass.repetents
        break
    }

    if (formData.teacherCopy) count++

    bookOrders.push({
      count: count,
      teacherCopy: formData.teacherCopy,
      schoolClass: formData.schoolClass.id,
      book: row.id,
      year: row.year.id,
      lastUser: "testuser",
      creationUser: "testuser",
      repetents: formData.repetents,
    })
  })

  try {
    for (const bookOrder of bookOrders) {
      await $fetch("bookOrders/create", {
        method: "POST",
        body: bookOrder,
        baseURL: config.public.baseURL,
      })
    }

    displaySuccessNotification(
      t("bookList.createOrder.title"),
      t("bookList.createOrder.successDescription"),
    )

    isVisible.value = false
  } catch (err: unknown) {
    const error = err as Error

    displayFailureNotification(
      t("bookList.createOrder.title"),
      t("bookList.createOrder.failureDescription"),
    )
    throw createError({
      statusMessage: error.message,
    })
  }
}

let repententOptions: { label: string; value: number }[] = []

watch(
  locale,
  () => {
    repententOptions = [
      { label: t("bookList.createOrder.repetents.with"), value: 1 },
      { label: t("bookList.createOrder.repetents.without"), value: 2 },
      { label: t("bookList.createOrder.repetents.only"), value: 3 },
    ]
  },
  { immediate: true },
)
</script>

<template>
  <div class="h-full">
    <PageHeader
      :title="$t('bookList.title')"
      :subtitle="$t('bookList.subtitle')"
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
          >
            <UButton
              label="Order"
              class="ml-2"
              size="md"
              :disabled="selectedRows.length === 0"
              @click="isVisible = true"
            />
          </TableSearch>

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
            {{ row.grade.replaceAll("=", ",") }}
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
          <UDropdown :items="items(row).value" :ui="{ width: 'w-auto' }">
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
            :total="books?.data?.total || 0"
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
    <GenericCreateModal
      v-model="isVisible"
      :title="$t('bookList.createOrder.title')"
      @create="addBookOrder"
    >
      <UTable
        class="mb-4 rounded-lg border"
        :rows="selectedRows"
        :loading-state="{
          icon: 'i-heroicons-arrow-path-20-solid',
          label: 'Loading...',
        }"
        :loading="pending"
        :progress="{ color: 'primary', animation: 'carousel' }"
        :columns="[
          {
            key: 'title',
          },
        ]"
        :ui="{
          wrapper: 'relative overflow-x-auto h-[150px] overflow-y-auto',
          td: {
            padding: 'py-1',
          },
          th: {
            base: 'hidden',
          },
        }"
      />

      <UForm
        :schema="schema"
        :state="state"
        class="space-y-4"
        @submit="addBookOrder"
      >
        <UFormGroup
          :label="$t('bookList.createOrder.class.title')"
          name="schoolClass"
        >
          <USelectMenu
            v-if="!schoolClassesPending"
            v-model="state.schoolClass"
            :placeholder="$t('bookList.createOrder.class.placeholder')"
            :options="schoolClasses?.data"
            option-attribute="name"
            searchable
          />
        </UFormGroup>

        <UFormGroup
          :label="$t('bookList.createOrder.repetents.title')"
          name="repetents"
        >
          <USelectMenu
            v-model="state.repetents"
            :placeholder="$t('bookList.createOrder.repetents.placeholder')"
            :options="repententOptions"
            option-attribute="label"
            value-attribute="label"
          />
        </UFormGroup>

        <UFormGroup
          :label="$t('bookList.createOrder.teacherCopy')"
          name="teacherCopy"
        >
          <UCheckbox
            v-model="state.teacherCopy"
            class="mt-2"
            color="blue"
            :label="$t('bookList.createOrder.includeTeacherCopy')"
            :help="$t('bookList.createOrder.includeDescription')"
          />
        </UFormGroup>
      </UForm>
    </GenericCreateModal>
  </div>
</template>
