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

const state = reactive({
  schoolClass: undefined,
  repetents: undefined,
  teacherCopy: undefined,
})

defineEmits(["submit"])
</script>

<template>
  <slot name="header" />
  <UForm
    :schema="schema"
    :state="state"
    class="space-y-4"
    @submit="$emit('submit', state)"
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
</template>
