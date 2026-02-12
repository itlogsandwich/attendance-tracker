<script setup lang="ts">
import type { Project } from "#shared/types/project";
import type { TimeEntry } from "#shared/types/time-entry";
definePageMeta({
  layout: 'main',
});

const config = useRuntimeConfig();

const { data: entries } = await useFetch<TimeEntry[]>(`${config.public.apiBase}/time-entries`, {
  default: () => [],
});

const { data: projects } = await useFetch<Project[]>(`${config.public.apiBase}/projects`, {
  default: () => [],
});

const total_time = computed(() => {
  const entries_data = entries.value;
  const projects_data = projects.value;

  if (!entries_data || !projects_data) return "0:00:0";

  return totalTime(entries_data, projects_data)
});

</script>
<template>
  <AppPanel title="Dashboard">
    <div class="flex flex-row w-full justify-between items-center">
      <div>
        <h1 class="text-2xl text-black">Overall Stats</h1>
      </div>
      <div class="flex justify-center gap-10">
        <UButton trailing-icon="i-lucide-arrow-down" label="Project" color="neutral" variant="subtle">
        </UButton>
        <UButton trailing-icon="i-lucide-arrow-down" color="primary" variant="subtle">
          Project
        </UButton>
        <UButton trailing-icon="i-lucide-arrow-down" color="primary" variant="subtle">
          Project
        </UButton>
      </div>
    </div>

    <div class=" flex flex-row w-full h-full gap-6 mb-2">

      <div class="w-full h-[800px] rounded-lg bg-gray-50 shadow-lg">
        <div class="flex flex-col items-center">
          <div class="grid grid-cols-3 rounded-t-md items-center text-center w-full h-30 bg-gray-200">
            <div>
              <h1 class="text-2xl"> Total Time</h1>
              <h2 class="text-lg"> {{ total_time }} </h2>
            </div>
            <div>
              <h1 class="text-2xl"> Top Project </h1>
              <h2 class="text-lg"> Locking In </h2>
            </div>
            <div>
              <h1 class="text-2xl"> Top Client </h1>
              <h2 class="text-lg"> Myself </h2>
            </div>
          </div>
          <div class="w-full h-86 items-center text-center content-center">
            <div>
              <h1>SOME SORT OF GRAPH AND CHARTS </h1>
            </div>
          </div>

          <div class="grid grid-cols-2 items-center text-center  w-full h-86">
            <div>
              <h1>
                Some Sort of Chart
              </h1>
            </div>
            <div>
              <h1>
                Some Sort of Chart
              </h1>
            </div>
          </div>

        </div>
      </div>

      <div class="w-1/3 h-[800px] rounded-lg bg-gray-50 shadow-lg">
        <div class="flex flex-col m-20 justify-items-center justify-center align-center text-center">
          <div class="w-full my-4 p-20 bg-red-400">
            01
          </div>
          <div class="w-full my-4 p-20 bg-red-300">
            02
          </div>
          <div class="w-full my-4 p-20 bg-red-200">
            03
          </div>
        </div>
      </div>

    </div>
  </AppPanel>
</template>
