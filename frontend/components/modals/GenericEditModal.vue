<script setup lang="ts">
defineProps<{
  title: string
}>()

const model = defineModel<boolean>()
defineEmits(["update"])
</script>

<template>
  <UModal v-model="model" class="bg-opacity-0">
    <UCard>
      <template #header>
        <ModalHeader
          color="yellow"
          :title="title"
          icon="i-heroicons-pencil-square-20-solid"
        />
      </template>
      <slot />
      <template #footer>
        <div class="flex w-full justify-end space-x-2">
          <UButton
            color="yellow"
            icon="i-heroicons-pencil-square-20-solid"
            @click="$emit('update')"
          >
            {{ $t("actions.update") }}
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
