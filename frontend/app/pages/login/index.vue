<script setup lang="ts">
definePageMeta({
  layout: "landing",
})
const onSubmit = console.log("Logged in")

</script>
<template>
  <div class="flex min-h-svh w-full items-center justify-center p-6 md:p-10">
    <div class="w-full max-w-sm">
      <Form @submit="onSubmit" />
    </div>
  </div>
</template>
