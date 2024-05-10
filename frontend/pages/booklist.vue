<script setup lang="ts"></script>

<template>
  <div class="flex h-full w-full flex-col">
    <PageHeader
      :title="$t('bookList.title')"
      :subtitle="$t('bookList.subtitle')"
    />
    <BookOverviewTable />
  </div>
</template>

<style scoped></style>
