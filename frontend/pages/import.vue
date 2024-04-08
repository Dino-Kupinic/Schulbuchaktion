<script setup lang="ts">
const fileInputRef = ref<HTMLInputElement | null>(null)

const uploadFile = async () => {
  const file = fileInputRef.value?.files?.[0]
  console.log(file)

  const formData = new FormData()
  formData.append("file", file)
  console.log(formData)

  try {
    const { data } = useBackendFetch(`/importXLSX`, {
      method: "POST",
      body: formData,
    })
    console.log(data.value)
    console.log("File uploaded successfully!")
  } catch (error) {
    console.error("Error uploading file:", error)
  }
}
</script>

<template>
  <div>
    <UInput ref="fileInput" type="file" size="md" accept=".xlsx" />
    <UButton label="Submit" @click="uploadFile()" />
  </div>
</template>
