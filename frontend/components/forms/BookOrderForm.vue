<script setup lang="ts">
import { z } from "zod"

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

const { schoolClasses, fetchSchoolClasses } = useSchoolClasses()
await fetchSchoolClasses()

let repententOptions: { label: string; value: number }[] = []

const { locale, t } = useI18n()
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

const emit = defineEmits<{
  "update:modelValue": [newState: typeof state]
}>()

type BookFormState = {
  schoolClass: undefined
  repetents: undefined
  teacherCopy: undefined
}
const state = defineModel<BookFormState>()

watch(
  state,
  (newState) => {
    const result = schema.safeParse(state)

    if (!result.success) {
      displayFailureNotification(
        t("notification.failure"),
        t("classes.updateClass.failureDescription"),
      )
      console.error(result.error.errors)
      return
    }
    emit("update:modelValue", newState)
  },
  { deep: true },
)
</script>

<template>
  <slot name="header" />
  <UForm :schema="schema" :state="state" class="space-y-4">
    <UFormGroup
      :label="$t('bookList.createOrder.class.title')"
      name="schoolClass"
    >
      <USelectMenu
        v-model="state.schoolClass"
        :placeholder="$t('bookList.createOrder.class.placeholder')"
        :options="schoolClasses"
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
</template>
