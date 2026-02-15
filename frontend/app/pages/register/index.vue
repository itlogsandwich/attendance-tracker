<script setup lang="ts">
definePageMeta({
  layout: "landing",
})
const toast = useToast();
const config = useRuntimeConfig();


async function handleRegister(formData: any) {
  try {

    await $fetch('http://localhost:8000/sanctum/csrf-cookie', {
      method: 'GET',
      credentials: 'include',
    });

    const xsrfToken = useCookie('XSRF-TOKEN').value;

    await $fetch(`${config.public.apiBase}/register`, {
      method: 'POST',
      body: formData,
      credentials: 'include',
      headers: {
        'Accept': 'application/json',
        'X-XSRF-TOKEN': xsrfToken || '',
      },
    });

    toast.add({ title: "Registered!", color: "success" })
    navigateTo("/")
  }
  catch (err: any) {
    const message = err.response?._data?.message || "An error has occured"
    toast.add({ title: 'Register Failed', description: message, color: 'error' })
    console.error("Failed to register", err);
  }
}

</script>

<template>
  <main>
    <div class="flex flex-row min-h-svh h-screen w-screen">
      <div class="flex-1 h-full items-center justify-center content-center text-center bg-gray-50">
        <UContainer class="max-w-lg">
          <RegisterForm @submit="handleRegister" />
        </UContainer>
      </div>
    </div>
  </main>
</template>
