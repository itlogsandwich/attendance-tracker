<script setup lang="ts">
definePageMeta({
  layout: "landing",
})

async function onSubmit() {
  navigateTo("/dashboard")
}

</script>

<template>
  <main>
    <div class="flex flex-row min-h-svh h-screen w-screen">
      <div class="flex-1 h-full items-center justify-center content-center text-center bg-gray-200">
        <h1> Keep track of your time, and never miss a task. </h1>
      </div>
      <div class="flex-1 h-full items-center justify-center content-center text-center bg-gray-50">
        <UContainer class="max-w-lg">
          <Form @submit="onSubmit" />
        </UContainer>
      </div>
    </div>
  </main>
</template>
