<script setup lang="ts">
import decodeAuthCookie from "~/utils/decodeAuthCookie"

const username = decodeAuthCookie()?.username as string
const shorthand = username?.substring(0, 2).toUpperCase()
</script>

<template>
  <NavUserDropdown>
    <NavUserAvatar :username="shorthand" />
  </NavUserDropdown>
</template>
