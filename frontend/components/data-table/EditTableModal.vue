<script setup lang="ts"></script>

<template>
  <div>
    <UModal>
      <UCard>
        <template #header>
          <div class="flex items-center justify-between">
            <p
              class="text-base font-semibold leading-6 text-red-600 dark:text-white"
            ></p>
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
  </div>
</template>

<style scoped></style>
