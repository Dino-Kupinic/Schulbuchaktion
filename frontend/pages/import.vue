<script setup lang="ts">
const file = ref<File>()
const config = useRuntimeConfig()
const response = ref<string>("")

async function submitFile() {
  if (!file.value) {
    throw createError({
      statusMessage: "No file selected",
    })
  }

  const formData = new FormData()
  formData.append("file", file.value)

  try {
    const data = await $fetch("/importXLSX", {
      method: "POST",
      body: formData,
      baseURL: config.public.baseURL,
    })
    response.value = "File uploaded successfully!"
    console.log(data)
  } catch (err: unknown) {
    const error = err as Error
    console.error("Error uploading file:", error)
    throw createError({
      statusMessage: error.message,
    })
  }
}
</script>

<template>
  <div
    class="flex h-full w-full items-center justify-center rounded-lg border p-3 shadow-sm dark:border-gray-700"
  >
    <div>
      <PageTitle>Import XLSX</PageTitle>
      <div class="flex h-auto flex-col space-y-2 rounded-lg border p-4">
        <UInput
          type="file"
          accept=".xlsx"
          icon="i-heroicons-folder"
          @change="file = $event[0]"
        />
        <div>
          <UButton label="Submit" class="px-8" @click="submitFile()" />
        </div>
      </div>
      <p v-if="response">{{ response }}</p>
    </div>
  </div>
</template>
