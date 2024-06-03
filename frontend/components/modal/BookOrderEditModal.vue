<script setup lang="ts">
import type { BookOrder } from "~/types/bookorder"

const props = defineProps<{
  bookOrder: BookOrder
  isVisible: boolean
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

const isVisible = props.isVisible
</script>

<template>
  <UModal v-model="isVisible">
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
    </UCard>
  </UModal>
</template>

<style scoped></style>
