<!--<script setup lang="ts"></script>-->
<!--<template>-->
<!--  <UModal :model-value="isVisible" class="bg-opacity-0">-->
<!--    <UCard>-->
<!--      <template #header>-->
<!--        <div class="flex items-center justify-between">-->
<!--          <p-->
<!--            class="text-base font-semibold leading-6 text-red-600 dark:text-white"-->
<!--          >-->
<!--            Editing book order for "{{ changedBookOrder.book.title }}"-->
<!--          </p>-->
<!--          <UButton-->
<!--            color="gray"-->
<!--            variant="ghost"-->
<!--            icon="i-heroicons-x-mark-20-solid"-->
<!--            class="-my-1"-->
<!--            @click="editModalVisible = false"-->
<!--          />-->
<!--        </div>-->
<!--      </template>-->
<!--      <p>Book</p>-->
<!--      <USelectMenu-->
<!--        v-model="bookId"-->
<!--        :placeholder="changedBookOrder.book.title"-->
<!--        :options="-->
<!--          books?.data?.books.map((book) => ({-->
<!--            label: book.title,-->
<!--            value: book.id,-->
<!--          }))-->
<!--        "-->
<!--        searchable-->
<!--      />-->

<!--      <p class="mt-4">Class</p>-->
<!--      <USelectMenu-->
<!--        v-model="schoolClassId"-->
<!--        :placeholder="changedBookOrder.schoolClass.name"-->
<!--        :options="-->
<!--          schoolClasses?.data?.map((schoolClass) => ({-->
<!--            label: schoolClass.name,-->
<!--            value: schoolClass.id,-->
<!--          }))-->
<!--        "-->
<!--        searchable-->
<!--      />-->

<!--      <UButton class="mt-4" @click="updateOrder">Submit</UButton>-->
<!--    </UCard>-->
<!--  </UModal>-->
<!--</template>-->

<!--<style scoped></style>-->
