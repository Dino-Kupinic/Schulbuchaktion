<script setup lang="ts">
import { version as versionVue } from "vue"
import { version as versionNuxt } from "nuxt/package.json"

const runtime = useRuntimeConfig()
const appVersion = useAppVersion()

const buildTime = new Date(runtime.public.buildTime as number)
const timeSinceBuild = useTimeAgo(buildTime)

const gitSha = runtime.public.gitHeadSha as string
const gitShaFormatted = gitSha.slice(0, 10)
const vueVersion = versionVue
const nuxtVersion = versionNuxt
</script>

<template>
  <VDropdown :distance="10" :triggers="['click']">
    <UButton
      class="dark:bg-primary-800 text-primary-500 bg-primary-100/75 max-w-xs transition duration-300 ease-in-out hover:scale-110 hover:text-white dark:text-white"
      >Info
    </UButton>
    <template #popper>
      <div
        class="grid grid-cols-[max-content_1fr] items-center gap-x-2 gap-y-3 p-3"
      >
        <UIcon class="h-5 w-5" name="i-heroicons-cube-20-solid"></UIcon>
        <time
          :datetime="buildTime.toISOString()"
          :title="buildTime.toLocaleString()"
        >
          built {{ timeSinceBuild }} (<code>{{ gitShaFormatted }}</code
          >)
        </time>

        <UIcon class="h-5 w-5" name="i-heroicons-calendar-days-solid" />
        <p v-if="appVersion">
          Schulbuchaktion
          <span
            ><code>{{ appVersion }}</code></span
          >
        </p>
        <div v-else>{{ $t("NavCouldntFetchVersion") }}</div>

        <UIcon class="h-5 w-5" name="i-heroicons-calendar-days-solid" />
        <code v-if="vueVersion">Vue {{ vueVersion }}</code>
        <div v-else>{{ $t("NavCouldntFetchVersion") }}</div>

        <UIcon class="h-5 w-5" name="i-heroicons-calendar-days-solid" />
        <code v-if="nuxtVersion">Nuxt {{ nuxtVersion }}</code>
        <div v-else>{{ $t("NavCouldntFetchVersion") }}</div>
      </div>
      <div class="w-full p-2 text-center">
        <NuxtLink
          class="text-primary hover:text-green-300"
          to="https://github.com/Dino-Kupinic/UntisPlanner/issues"
          target="_blank"
          title="Head to Issues"
        >
          {{ $t("NavInfoBugReport") }}
        </NuxtLink>
      </div>
    </template>
  </VDropdown>
</template>
