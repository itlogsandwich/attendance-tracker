<script setup lang="ts">
definePageMeta({
  layout: "landing",
})
const toast = useToast();
const config = useRuntimeConfig();


async function handleLogin(formData: any) {
  try {

    await $fetch('http://localhost:8000/sanctum/csrf-cookie', {
      method: 'GET',
      credentials: 'include',
    });

    const xsrfToken = useCookie('XSRF-TOKEN').value;

    await $fetch(`${config.public.apiBase}/login`, {
      method: 'POST',
      body: formData,
      credentials: 'include',
      headers: {
        'Accept': 'application/json',
        'X-XSRF-TOKEN': xsrfToken || '',
      },
    });

    toast.add({ title: "Welcome back!", color: "success" })
    navigateTo("/dashboard")
  }
  catch (err: any) {
    const message = err.response?._data?.message || "Invalid credentials"
    toast.add({ title: 'Login Failed', description: message, color: 'error' })
    console.error("Failed to login", err);
  }
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
          <Form @submit="handleLogin" />
        </UContainer>
      </div>
    </div>
  </main>
</template>
