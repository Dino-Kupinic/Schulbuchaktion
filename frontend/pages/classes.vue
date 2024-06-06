<script setup lang="ts">
import type { SchoolClass } from "~/types/schoolclass"

const { schoolClasses, fetchSchoolClasses } = useSchoolClasses()
await fetchSchoolClasses()

const classes = ref<SchoolClass[]>(schoolClasses.value)
</script>

<template>
  <div class="flex h-full w-full flex-col">
    <PageHeader
      class="grow-0"
      :title="$t('classes.title')"
      :subtitle="$t('classes.subtitle')"
    />
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
      <div class="flex flex-col sm:flex-row">
        <div class="w-96 p-3 dark:border-r-neutral-800 sm:border-r">
          <p class="font-semibold">Create new</p>
          <UFormGroup> </UFormGroup>
        </div>
        <UTable :rows="classes" class="w-full" />
      </div>
    </UCard>
  </div>
</template>
