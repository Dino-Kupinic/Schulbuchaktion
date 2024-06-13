<script setup lang="ts">
import decodeAuthCookie from "~/utils/decodeAuthCookie"

const username = decodeAuthCookie()?.username
const shorthand = username.substring(0, 2).toUpperCase()
</script>

<template>
  <NavUserDropdown>
    <NavUserAvatar :username="shorthand" />
  </NavUserDropdown>
</template>
