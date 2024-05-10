<script setup lang="ts"></script>

<template>
  <div
    class="flex h-full w-full flex-col rounded-lg border p-3 shadow-sm dark:border-gray-700"
  >
    <PageTitle>{{ $t("tableTitles.bookOverview") }}</PageTitle>
    <BookOverviewTable />
  </div>
</template>

<style scoped></style>
