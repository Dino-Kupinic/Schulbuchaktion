<script setup lang="ts"></script>

<template>
  <div
    class="flex h-full items-center justify-end space-x-3 border-inherit pr-5"
  >
    <NavBarThemeToggle />
    <NavDivider />
    <NavBarLanguageToggle />
    <NavDivider />
    <NavSettingsButton :styling="true" />
    <NavInfoButton />
    <NavUser />
  </div>
</template>
