<script setup lang="ts">
import type { NuxtError } from "#app"

defineProps<{ error: NuxtError }>()
</script>

<template>
  <div class="flex h-screen items-center justify-center">
    <div class="m-3 flex flex-col space-y-3">
      <div class="bg-background rounded-lg border p-3">
        <PageTitle class="text-center">
          {{ $t("error.title") }}
        </PageTitle>
      </div>
      <div class="bg-background rounded-lg border p-3">
        <pre class="overflow-hidden">{{ error }}</pre>
      </div>
      <NuxtLink to="/">
        <div class="flex w-full">
          <UButton class="m-auto">{{ $t("error.home") }}</UButton>
        </div>
      </NuxtLink>
    </div>
  </div>
</template>
