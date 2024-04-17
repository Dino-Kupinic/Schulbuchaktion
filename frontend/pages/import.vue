<script setup lang="ts">
const file = ref(null)
const config = useRuntimeConfig()

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
    console.log("File uploaded successfully!")
    console.log(data)
  } catch (error) {
    console.error("Error uploading file:", error)
  }
}
</script>

<template>
  <div>
    <input ref="file" type="file" accept=".xlsx" />
    <UButton label="Submit" @click="submitFile()" />
  </div>
</template>
