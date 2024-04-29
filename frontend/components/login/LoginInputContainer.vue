<script setup lang="ts">
const config = useRuntimeConfig()

const username = ref<string>("")
const password = ref<string>("")

function setUsername(inputUsername: string) {
  username.value = inputUsername
}
function setPassword(inputPassword: string) {
  password.value = inputPassword
}
function createCookie() {
  const token = useCookie("AuthToken")
  token.value = "HalloAuthToken"
}

createCookie()
async function submitFile() {
  console.log(username.value)
  console.log(password.value)
  try {
    const data = await $fetch(`http://localhost:8000/login`, {
      method: "POST",
      mode: "no-cors",
      baseURL: config.public.baseURL,
    })
  } catch (error) {
    console.error("Error uploading file:", error)
  }
}
</script>

<template>
  <div class="sm:flex sm:justify-center">
    <UContainer
      class="w-full p-0 sm:w-[425px] sm:rounded-lg sm:border sm:border-solid sm:border-neutral-200 sm:p-8 sm:shadow-md sm:shadow-neutral-300 sm:dark:border-neutral-700 sm:dark:shadow-none"
    >
      <LoginInput
        label="Username"
        margin="mb-4"
        @pass-user-input="setUsername"
      />
      <LoginInput
        label="Password"
        margin="mb-8"
        type="password"
        @pass-user-input="setPassword"
      />
      <UButton
        @click="submitFile()"
        class="flex w-full justify-center dark:bg-blue-500 dark:text-white"
      >
        Sign in
      </UButton>
    </UContainer>
  </div>
</template>

<style scoped></style>
