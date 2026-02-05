<script setup lang="ts">
definePageMeta({
  layout: "landing",
})

async function onSubmit() {
  navigateTo("/dashboard")
}

</script>
<template>
  <div class="flex flex-row min-h-svh w-full items-center justify-center p-6 md:p-10">
    <div class="w-full max-w-sm">
      <Form @submit="onSubmit" />
    </div>
  </div>
</template>
