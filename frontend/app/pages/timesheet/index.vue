<script setup lang="ts">
import type { TimeEntry } from "#shared/types/time-entry";

definePageMeta({
  layout: "main"
});

const entries = ref<TimeEntry[]>([]);

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

function startTimer() {
  if (current_entry.value) return;

  const now = new Date();

  current_entry.value = {
    title: search_task.value,
    project: "Project Name",
    start_time: now.toISOString(),
    end_time: null,
    total_seconds: 0
  };

  timer_interval = setInterval(() => {
    if (!current_entry.value) return;

    const start_time = new Date(current_entry.value.start_time);
    const elapsed_seconds = Math.floor((Date.now() - start_time.getTime()) / 1000);
    current_entry.value.total_seconds = elapsed_seconds;
    formatted_time.value = formatDuration(elapsed_seconds);
  }, 1000);
}

function stopTimer() {
  if (!current_entry.value) return;

  if (timer_interval) {
    clearInterval(timer_interval);
    timer_interval = null;
  }

  current_entry.value.end_time = new Date().toISOString();
  entries.value.push(current_entry.value);

  current_entry.value = null;
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
          <span class="text-l"> {{ entry.project }}</span>
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
