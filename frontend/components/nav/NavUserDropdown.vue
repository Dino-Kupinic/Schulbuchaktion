<script setup lang="ts">
const config = useRuntimeConfig()
const items = [
  [
    {
      label: "Dino Kupinic",
      link: "#",
      slot: "account",
    },
  ],
  [
    {
      label: "myBooks",
      link: "#",
      icon: "i-heroicons-book-open",
    },
    {
      label: "allTeachers",
      link: "#",
      icon: "i-heroicons-user-group-solid",
    },
  ],
  [
    {
      label: "logout",
      link: "#",
    },
  ],
]

async function logoutUser() {
  const bearerToken = useCookie("BearerToken")
  bearerToken.value = null
  await navigateTo("/login")
}
</script>

<template>
  <UDropdown
    :items="items"
    :ui="{
      item: {
        disabled: 'cursor-text select-text',
      },
    }"
    :popper="{ placement: 'bottom-start' }"
  >
    <slot />
    <template #account="{ item }">
      <div class="text-left">
        <p class="truncate font-medium text-gray-900 dark:text-white">
          {{ item.label }}
        </p>
      </div>
    </template>
    <template #item="{ item }">
      <UIcon
        v-if="item.label != 'logout'"
        :name="item.icon"
        class="h-4 w-4 text-gray-400 dark:text-gray-500"
      />
      <ULink v-if="item.label != 'logout'" class="truncate" :to="item.link">
        {{ $t("avatar." + item.label) }}
      </ULink>
      <UButton v-else variant="outline" @click="logoutUser" color="red">
        {{ $t("avatar." + item.label) }}
      </UButton>
    </template>
  </UDropdown>
</template>
