<script setup lang="ts">
const people = [
  {
    id: 1,
    name: "Lindsay Walton",
    title: "Front-end Developer",
    email: "lindsay.walton@example.com",
    role: "Member",
  },
  {
    id: 2,
    name: "Courtney Henry",
    title: "Designer",
    email: "courtney.henry@example.com",
    role: "Admin",
  },
  {
    id: 3,
    name: "Tom Cook",
    title: "Director of Product",
    email: "tom.cook@example.com",
    role: "Member",
  },
  {
    id: 4,
    name: "Whitney Francis",
    title: "Copywriter",
    email: "whitney.francis@example.com",
    role: "Admin",
  },
  {
    id: 5,
    name: "Leonard Krasner",
    title: "Senior Designer",
    email: "leonard.krasner@example.com",
    role: "Owner",
  },
  {
    id: 6,
    name: "Vincent Green",
    title: "Senior Designer",
    email: "",
  },
  {
    id: 7,
    name: "Charlene Reed",
    title: "Front-end Developer",
    email: "",
  },
]
</script>

<template>
  <div class="flex h-full w-full flex-col">
    <PageHeader
      class="grow-0"
      :title="$t('classes.title')"
      :subtitle="$t('classes.subtitle')"
    />
    <UCard
      class="h-auto w-full rounded-lg"
      :ui="{
        body: {
          padding: '',
        },
        header: {
          padding: 'sm:px-4 py-3',
        },
      }"
    >
      <div class="flex flex-col sm:flex-row">
        <div class="w-96 p-3 dark:border-r-neutral-800 sm:border-r">
          <p class="font-semibold">Create new</p>
          <UFormGroup> </UFormGroup>
        </div>
        <UTable :rows="people" class="w-full" />
      </div>
    </UCard>
  </div>
</template>
