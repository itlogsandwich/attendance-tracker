<script setup lang="ts">
import type { TimeEntry } from "#shared/types/time-entry";
definePageMeta({
  layout: "main"
});

const config = useRuntimeConfig();

const { data: entries, refresh } = await useFetch<TimeEntry[]>(`${config.public.apiBase}/time-entries`);

const search_task = ref<string>("");

const current_entry = ref<TimeEntry | null>(null);

const formatted_time = ref<string>("0:00:00");

let timer_interval: ReturnType<typeof setInterval> | null = null;

function formatDuration(seconds: number): string {
  const h = Math.floor(seconds / 3600).toString().padStart(2, '0');
  const m = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
  const s = Math.floor(seconds % 60).toString().padStart(2, '0');
  return `${h}:${m}:${s}`;
}

async function startTimer() {
  if (current_entry.value) return;

  const now = new Date();
  try {
    const response_cookie = await $fetch('http://localhost:8000/sanctum/csrf-cookie', {
      method: 'GET',
      credentials: 'include',
    });
    console.log("CSRF Cookie Response:", response_cookie);

    const response = await $fetch<TimeEntry>(`${config.public.apiBase}/time-entries`, {
      method: 'POST',
      credentials: 'include',
      body: {
        title: search_task.value.trim(),
        project_id: null,
        start_time: now.toISOString(),
      }
    });

    current_entry.value = response;

    timer_interval = setInterval(() => {
      if (!current_entry.value) return;

      const start_time = new Date(current_entry.value.start_time);
      const elapsed_seconds = Math.floor((Date.now() - start_time.getTime()) / 1000);
      current_entry.value.total_seconds = elapsed_seconds;
      formatted_time.value = formatDuration(elapsed_seconds);
    }, 1000);

  }
  catch (err) {
    console.error("Failed to POST time entry:", err);
  }
}

async function stopTimer() {
  if (!current_entry.value) return;

  const end_time = new Date().toISOString();

  try {

    await $fetch(`${config.public.apiBase}/time-entries/${current_entry.value.id}`, {
      method: 'PATCH',
      body: {
        end_time,
      }
    });

    current_entry.value = null;
    formatted_time.value = "00:00:00";

    await refresh();
  }
  catch (err) {
    console.error("Failed to PATCH time entry:", err);
  }
}

</script>

<template>
  <AppPanel title="Timesheet">

    <div id="add-entry"
      class="flex w-full h-16 bg-white shadow-md rounded-md border border-gray-100 items-center px-4 gap-4 mb-10">
      <UInput v-model="search_task" placeholder="What project are you working on?" class="flex-1"
        :ui="{ base: 'text-md' }" />

      <div class="items-center text-center">
        <span class="self-end text-center"> PROJECT NAME </span>
      </div>
      <div class="flex items-center h-8 gap-4 flex-none">
        <USeparator orientation="vertical" />

        <UIcon name="i-lucide-tag" class="size-5" />

        <USeparator orientation="vertical" />
        <UIcon name="i-lucide-philippine-peso" class="size-5" />

        <USeparator orientation="vertical" />

        <div class="items-center text-center">
          <span class="self-end text-center"> {{ formatted_time }}</span>
        </div>

        <USeparator orientation="vertical" />

        <UButton v-if="current_entry" trailing-icon="i-lucide-square" label="STOP" @click="stopTimer"
          class="px-8 font-bold rounded-none h-10 hover:bg-red-600 bg-red-500">
        </UButton>
        <UButton v-else trailing-icon="i-lucide-play" color="primary" label="START" @click="startTimer"
          class="px-8 font-bold rounded-none h-10">
        </UButton>
      </div>
    </div>

    <div v-for="entry in entries" id="list-entries"
      class="flex flex-col w-full bg-white shadow-md  rounded-md border border-gray-100">

      <div class="flex h-8 px-2 rounded-t-md justify-between bg-gray-200">
        <span class="self-end"> Today </span>
      </div>

      <div class="flex flex-row items-center p-1 gap-4">
        <UInput v-model="search_task" class="flex-none" :ui="{ base: 'text-md' }" />

        <div class="flex-1 items-center">
          <span class="text-l"> {{ entry.project?.title || "No Project" }}</span>
        </div>
        <div class="flex items-center h-8 gap-4 flex-none">

          <USeparator orientation="vertical" />
          <UIcon name="i-lucide-tag" class="size-5" />

          <USeparator orientation="vertical" />
          <UIcon name="i-lucide-philippine-peso" class="size-5" />

          <USeparator orientation="vertical" />
          <div class="flex items-center text-center gap-2 ">
            <span class="self-end text-center"> {{ entry.start_time }} - {{ entry.end_time }} </span>
            <UIcon name="i-lucide-calendar" class="size-5" />
          </div>

          <USeparator orientation="vertical" />

          <UButton v-if="current_entry" trailing-icon="i-lucide-square" color="neutral" variant="ghost"
            @click="stopTimer" class="px-8 font-bold rounded-none h-10">
          </UButton>
          <UButton v-else trailing-icon="i-lucide-play" color="neutral" variant="ghost" @click="startTimer"
            class="px-8 font-bold rounded-none h-10">
          </UButton>
        </div>
      </div>
    </div>
  </AppPanel>
</template>
