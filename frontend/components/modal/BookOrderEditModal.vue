<script setup lang="ts">
import type { BookOrder } from "~/types/bookorder"

const props = defineProps<{
  bookOrder: BookOrder
}>()

const config = useRuntimeConfig()
const changedBookOrder = reactive(props.bookOrder)

async function onSubmit() {
  return await $fetch("/bookOrders/update/" + props.bookOrder.id, {
    method: "PUT",
    params: {
      data: changedBookOrder,
    },
    baseURL: config.public.baseURL,
  })
}

const model = defineModel<boolean>()
</script>

<template>
  <slot />
  <UModal v-model="model">
    <UCard>
      <template #header>
        <div class="flex items-center justify-between">
          <p
            class="text-base font-semibold leading-6 text-red-600 dark:text-white"
          >
            Editing "{{ bookOrder.bookId }}"
          </p>
          <UButton
            color="gray"
            variant="ghost"
            icon="i-heroicons-x-mark-20-solid"
            class="-my-1"
          />
        </div>
      </template>
      <UForm :state="bookOrder" class="mb-5" @submit="onSubmit">
        <UFormGroup label="Name" name="name">
          <UInput
            :v-model="changedBookOrder.count"
            :value="bookOrder.count"
            size="sm"
            color="primary"
            variant="outline"
            placeholder="count"
          />
          <UInput
            :v-model="changedBookOrder.creationUser"
            :value="bookOrder.creationUser"
            size="sm"
            color="primary"
            variant="outline"
            placeholder="created by"
          />
          <UInput
            :v-model="changedBookOrder.schoolClass"
            :value="bookOrder.schoolClass.grade"
            size="sm"
            color="primary"
            variant="outline"
            placeholder="schoolClass"
          />
        </UFormGroup>
        <UButton class="mt-3 w-full justify-center sm:w-24" type="submit">
          Submit
        </UButton>
      </UForm>
    </UCard>
  </UModal>
</template>

<style scoped></style>
