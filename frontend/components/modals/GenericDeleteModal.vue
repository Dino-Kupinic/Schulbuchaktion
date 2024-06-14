<script setup lang="ts">
const props = defineProps<{
  title: string
  itemTitle: string | null
}>()

const model = defineModel<boolean>()
defineEmits(["delete"])

const { t } = useI18n()
const modalTitle = computed(() => {
  return props.title ? props.title : t("actions.delete")
})
</script>

<template>
  <UModal v-model="model" class="bg-opacity-0">
    <UCard>
      <template #header>
        <ModalHeader :title="title" icon="i-heroicons-trash" />
      </template>
      <p class="text-base leading-6">
        {{ $t("actions.confirmation") }} "{{ modalTitle }}"?
      </p>
      <template #footer>
        <div class="flex w-full justify-end space-x-2">
          <UButton
            color="red"
            icon="i-heroicons-trash"
            @click="$emit('delete')"
          >
            {{ $t("actions.delete") }}
          </UButton>
          <UButton
            color="gray"
            icon="i-heroicons-x-mark-20-solid"
            @click="model = false"
          >
            {{ $t("actions.cancel") }}
          </UButton>
        </div>
      </template>
    </UCard>
  </UModal>
</template>
