<script setup lang="ts"></script>

<template>
  <div class="flex h-full w-full flex-col">
    <PageHeader
      class="grow-0"
      :title="$t('bookList.title')"
      :subtitle="$t('bookList.subtitle')"
    />
    <BookOverviewTable class="grow" />
  </div>
</template>

<style scoped></style>
