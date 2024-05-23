<script setup lang="ts">
import { jwtDecode } from "jwt-decode"
import type { JwtAuthPayload, LoginResponse } from "~/types/auth"

const config = useRuntimeConfig()
const toast = useToast()
const { t } = useI18n()

const username = ref<string>("")
const password = ref<string>("")

function createCookie(tokenValue: string) {
  const token = useCookie("BearerToken")
  token.value = tokenValue
}

async function submitData() {
  try {
    const response = await $fetch<LoginResponse>("/login", {
      method: "POST",
      params: {
        usr: username.value,
        pwd: password.value,
      },
      baseURL: config.public.baseURL,
    })

    createCookie(response.token)
    const decodedToken = jwtDecode<JwtAuthPayload>(response.token)
    if (!decodedToken.authenticated) {
      toast.add({
        title: t("login.failure"),
        description: t("login.notAuthenticated"),
        color: "red",
        icon: "i-material-symbols-error-circle-rounded-outline-sharp",
      })
    }
    await navigateTo("/")
  } catch (error) {
    const err = error as Error
    throw createError({
      statusMessage: err.message,
    })
  }
}
</script>

<template>
  <div class="sm:flex sm:justify-center">
    <UContainer
      class="w-full p-0 sm:w-[425px] sm:rounded-lg sm:border sm:border-solid sm:border-gray-200 sm:p-8 sm:shadow-md sm:shadow-gray-300 sm:dark:border-gray-700 sm:dark:shadow-none"
    >
      <LoginInput label="Username">
        <template #input>
          <UInput v-model="username" class="mb-4"></UInput>
        </template>
      </LoginInput>

      <LoginInput label="Password">
        <template #input>
          <UInput v-model="password" type="Password" class="mb-4"></UInput>
        </template>
      </LoginInput>
      <UButton
        class="flex w-full justify-center dark:bg-blue-500 dark:text-white"
        @click="submitData()"
      >
        {{ $t("login.signIn") }}
      </UButton>
    </UContainer>
  </div>
</template>
