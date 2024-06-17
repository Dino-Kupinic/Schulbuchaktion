<script setup lang="ts"></script>

<template>
  <div class="flex h-full w-full flex-col">
    <PageHeader
      class="grow-0"
      :title="$t('orderList.title')"
      :subtitle="$t('orderList.subtitle')"
    />
    <BookOrderTable class="grow" />
  </div>
</template>

<style scoped></style>
