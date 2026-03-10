<script setup lang="ts">
import * as z from 'zod'
import type { FormSubmitEvent } from '@nuxt/ui'

const schema = z.object({
  name: z.string('Name is required').min(2, 'Must be at least 2 characters'),
  email: z.email('Invalid email'),
  password: z.string('Password is required').min(8, 'Must be at least 8 characters'),
  password_confirmation: z.string('Password is required').min(8, 'Must be at least 8 characters')
}).refine((data) => data.password === data.password_confirmation, {
  message: "Passwords do not match",
  path: ["password_confirmation"],
})

type Schema = z.output<typeof schema>

const state = reactive<Partial<Schema>>({
  name: undefined,
  email: undefined,
  password: undefined,
  password_confirmation: undefined,
})

const emit = defineEmits<{
  (e: 'submit', data: Schema): void
}>()

async function onSubmit(event: FormSubmitEvent<Schema>) {
  emit('submit', event.data)
}

</script>

<template>
  <UContainer>
    <UCard class="bg-gray-400" variant="soft">
      <UForm :schema="schema" :state="state" class="space-y-4" @submit="onSubmit">
        <UFormField label="Name" name="name">
          <UInput v-model="state.name" />
        </UFormField>

        <UFormField label="Email" name="email">
          <UInput v-model="state.email" />
        </UFormField>

        <UFormField label="Password" name="password">
          <UInput v-model="state.password" type="password" />
        </UFormField>

        <UFormField label="Confirm Password" name="confirm_password">
          <UInput v-model="state.password_confirmation" type="password" />
        </UFormField>
        <UButton type="submit">
          Submit
        </UButton>
        <ULink to="/" class="flex items-center text-center justify-center gap-2">
          <span class="content-center text-center text-white underline hover:text-blue-900"> Already have an
            account?</span>
        </ULink>
      </UForm>
    </UCard>
  </UContainer>
</template>
