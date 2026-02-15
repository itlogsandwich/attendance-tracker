<script setup lang="ts">
import type { TimeEntry } from "#shared/types/time-entry";
import { formatDuration } from "~/composables/formatDuration";
definePageMeta({
  layout: "main"
});

const config = useRuntimeConfig();

const { user } = useUserSession();

const { data: projects } = await useFetch<Project[]>(`${config.public.apiBase}/projects`);

const selected_project = ref<string>("Project");
const selected_id = ref<number | null>(null);

const filter_project_dropdown = computed(() => {
  if (!projects.value) return [];


  return [
    projects.value.map((project) => ({
      label: project.title,
      icon: "i-lucide-file-text",
      onSelect: () => {
        selected_project.value = project.title;
        selected_id.value = project.id;
      },

    }))
  ]

});

const { data: entries, refresh } = await useFetch<TimeEntry[]>(`${config.public.apiBase}/time-entries`);

const search_task = ref<string>("");

const current_entry = ref<TimeEntry | null>(null);

const formatted_time = ref<string>("0:00:00");

let timer_interval: ReturnType<typeof setInterval> | null = null;

async function startTimer() {
  if (current_entry.value) return;
  if (!selected_project.value) return;

  const now = new Date();
  try {
    await $fetch('http://localhost:8000/sanctum/csrf-cookie', {
      method: 'GET',
      credentials: 'include',
    });
    const xsrfToken = useCookie('XSRF-TOKEN').value;

    const response = await $fetch<TimeEntry>(`${config.public.apiBase}/time-entries`, {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Accept': 'application/json',
        'X-XSRF-TOKEN': xsrfToken || '',
      },
      body: {
        title: search_task.value.trim(),
        project_id: selected_id.value,
        user_id: 1,
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
  catch (err: any) {
    if (err.response?._data?.errors) {
      console.error("Validation Errors:", err.response._data.errors);
    } else {
      console.error("General Error:", err);
    }
  }
}

async function stopTimer() {
  if (!current_entry.value) return;

  const end_time = new Date().toISOString();

  try {

    const xsrfToken = useCookie('XSRF-TOKEN').value;
    await $fetch(`${config.public.apiBase}/time-entries/${current_entry.value.id}`, {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-XSRF-TOKEN': xsrfToken || '',
      },
      body: {
        _method: 'PATCH',
        end_time: end_time,
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
        <UDropdownMenu :items="filter_project_dropdown" arrow :content="{ side: 'bottom', align: 'start' }">
          <UButton trailing-icon="i-lucide-chevron-down" :label="selected_project" color="neutral" variant="subtle" />
        </UDropdownMenu>
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
        <UInput v-bind:placeholder="entry.title" :ui="{ base: 'text-md' }" />

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
