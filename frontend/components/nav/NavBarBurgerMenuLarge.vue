<script setup lang="ts">
const revealMenu = ref<boolean>(false)
let screenWidth = screen.width
onMounted(() => {
  console.log(screenWidth)
})

const items = [
  [{
    label: 'Profile',
    avatar: {
      src: 'https://avatars.githubusercontent.com/u/739984?v=4'
    }
  }], [{
    label: 'Edit',
    icon: 'i-heroicons-pencil-square-20-solid',
    shortcuts: ['E'],
    click: () => {
      console.log('Edit')
    }
  }, {
    label: 'Duplicate',
    icon: 'i-heroicons-document-duplicate-20-solid',
    shortcuts: ['D'],
    disabled: true
  }], [{
    label: 'Archive',
    icon: 'i-heroicons-archive-box-20-solid'
  }, {
    label: 'Move',
    icon: 'i-heroicons-arrow-right-circle-20-solid'
  }], [{
    label: 'Delete',
    icon: 'i-heroicons-trash-20-solid',
    shortcuts: ['⌘', 'D']
  }]
]
</script>

<template>
  <!-- This section is for the small size BurgerMenu -->
  <UButton color="blue" class="mx-2 md:hidden" trailing-icon="i-heroicons-bars-3-solid" variant="soft"
           @click="revealMenu = !revealMenu"/>
  <UContainer v-if="revealMenu" class="h-screen w-screen bg-dark"></UContainer>
</template>

<style scoped>

</style>