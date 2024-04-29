<script setup lang="ts">
const userInput = ref<string>("")

watch(userInput, async () => {
  console.log(userInput.value)
})

defineProps<{
  label: string
  margin: string
  type?: string
}>()

defineEmits<{
  passUserInput: [value: string]
}>()
</script>

<template>
  <UContainer class="flex p-0 sm:pl-0">
    <p class="mb-3">{{ label }}</p>
    <slot />
  </UContainer>
  <UInput
    :type="type"
    :class="margin"
    :model-value="userInput"
    @input="$emit('passUserInput', userInput)"
  ></UInput>
</template>

<style scoped></style>
