<script setup lang="ts">
defineProps<{
  title: string
}>()

const model = defineModel<boolean>()
defineEmits(["create"])
</script>

<template>
  <UModal v-model="model" class="bg-opacity-0">
    <UCard>
      <template #header>
        <ModalHeader
          color="green"
          :title="title"
          icon="i-heroicons-plus-circle"
        />
      </template>
      <slot />
      <template #footer>
        <div class="flex w-full justify-end space-x-2">
          <UButton
            color="green"
            icon="heroicons:plus-20-solid"
            @click="$emit('create')"
          >
            {{ $t("actions.create") }}
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
