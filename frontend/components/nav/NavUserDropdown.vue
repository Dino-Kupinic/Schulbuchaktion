<script setup lang="ts">
const items = [
  [
    {
      label: "Dino Kupinic",
      slot: "account",
      disabled: true,
    },
  ],
  [
    {
      label: "My Books",
      icon: "i-heroicons-book-open",
    },
    {
      label: "My Teachers",
      icon: "i-heroicons-user-group-solid",
    },
  ],
  [
    {
      label: "Sign out",
    },
  ],
]
</script>

<template>
  <UDropdown
    :items="items"
    :ui="{ item: { disabled: 'cursor-text select-text' } }"
    :popper="{ placement: 'bottom-start' }"
  >
    <slot></slot>

    <template #account="{ item }">
      <div class="text-left">
        <p class="truncate font-medium text-gray-900 dark:text-white">
          {{ item.label }}
        </p>
      </div>
    </template>

    <template #item="{ item }">
      <UIcon
        v-if="item.label != 'Sign out'"
        :name="item.icon"
        class="h-4 w-4 text-gray-400 dark:text-gray-500"
      />
      <ULink v-if="item.label != 'Sign out'" class="truncate">{{
        item.label
      }}</ULink>
      <UButton v-else variant="outline" color="red">{{ item.label }}</UButton>
    </template>
  </UDropdown>
</template>
