<script setup lang="ts">
import PageTitle from "~/components/typography/PageTitle.vue"
import PageContainer from "~/components/util/PageContainer.vue"

const file = ref(null)
const config = useRuntimeConfig()
const response = ref<string>("")

async function submitFile() {
  if (!file.value) return

  const formData = new FormData()
  // @ts-expect-error
  formData.append("file", file.value.files[0])
  // @ts-expect-error
  formData.append("name", file.value.files[0].name)

  try {
    const data = await $fetch(`/importXLSX`, {
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
      fatal: true,
    })
  }
}
</script>

<template>
  <PageContainer>
    <PageTitle>Import XLSX</PageTitle>
    <div class="flex h-auto flex-col space-y-2 rounded-lg border p-4">
      <input ref="file" type="file" accept=".xlsx" />
      <div>
        <UButton label="Submit" @click="submitFile()" />
      </div>
    </div>
    <p v-if="response">{{ response }}</p>
  </PageContainer>
</template>
