<script setup lang="ts">
const config = useRuntimeConfig()

const username = ref<string>("")
const password = ref<string>("")

function createCookie(tokenValue: string) {
  const token = useCookie("AuthToken")
  token.value = tokenValue
}

async function submitData() {
  try {
    const response = await $fetch("/login", {
      method: "POST",
      params: {
        usr: username.value,
        pwd: password.value,
      },
      baseURL: config.public.baseURL,
    })
    // @ts-ignore
    console.log(response)

    // @ts-ignore
    createCookie(response.token)
  } catch (error) {
    console.error("Error submitting data:", error)
  }
}
</script>

<template>
  <div class="sm:flex sm:justify-center">
    <UContainer
      class="w-full p-0 sm:w-[425px] sm:rounded-lg sm:border sm:border-solid sm:border-gray-200 sm:p-8 sm:shadow-md sm:shadow-gray-300 sm:dark:border-gray-700 sm:dark:shadow-none"
    >
      <LoginInput label="Username">
        <template v-slot:input>
          <UInput class="mb-4" v-model="username"></UInput>
        </template>
      </LoginInput>

      <LoginInput label="Password">
        <template v-slot:input>
          <UInput type="Password" class="mb-4" v-model="password"></UInput>
        </template>
      </LoginInput>
      <UButton
        @click="submitData()"
        class="flex w-full justify-center dark:bg-blue-500 dark:text-white"
      >
        Sign in
      </UButton>
    </UContainer>
  </div>
</template>

<style scoped></style>
