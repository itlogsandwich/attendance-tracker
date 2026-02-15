<script setup lang="ts">
import * as z from 'zod'
import type { FormSubmitEvent } from '@nuxt/ui'

const schema = z.object({
  email: z.email('Invalid email'),
  password: z.string('Password is required').min(8, 'Must be at least 8 characters')
})

type Schema = z.output<typeof schema>

const state = reactive<Partial<Schema>>({
  email: undefined,
  password: undefined
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
        <UFormField label="Email" name="email">
          <UInput v-model="state.email" />
        </UFormField>

        <UFormField label="Password" name="password">
          <UInput v-model="state.password" type="password" />
        </UFormField>

        <UButton type="submit">
          Submit
        </UButton>
        <ULink to="/register" class="flex items-center text-center justify-center gap-2">
          <span class="content-center text-center text-white underline hover:text-blue-900"> Don't have an
            account?</span>
        </ULink>
      </UForm>

    </UCard>
  </UContainer>
</template>
