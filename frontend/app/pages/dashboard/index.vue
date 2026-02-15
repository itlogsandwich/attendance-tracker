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

const category_label = ref<string>("Project");

const filter_category = [
  {
    label: 'Project',
    icon: 'i-lucide-file-text',
    value: 'project',
    onSelect: () => { category_label.value = "Project" }
  },
  {
    label: 'Billable',
    icon: 'i-lucide-philippine-peso',
    value: 'billable',
    onSelect: () => { category_label.value = "Billable" }
  },
]

const who_label = ref<string>("Only me");

const filter_who = [
  {
    label: 'Only me',
    icon: 'i-lucide-user',
    value: 'only_me',
    onSelect: () => { who_label.value = "Only me" }
  },
  {
    label: 'Team',
    icon: 'i-lucide-users',
    value: 'team',
    onSelect: () => { who_label.value = "Team" }
  },
]

const project_distribution = computed(() => {
  const map = new Map<number, number>();

  entries.value.forEach(entry => {
    if (entry.project_id) {
      const current = map.get(entry.project_id) || 0;
      map.set(entry.project_id, current + entry.total_seconds);
    }
  });

  return projects.value
    .filter(p => map.has(p.id))
    .map(p => ({
      name: p.title,
      value: Math.round((map.get(p.id) || 0) / 3600 * 10) / 10
    }))
    .sort((a, b) => b.value - a.value);
})

const chart_option = computed(() => ({
  tooltip: {
    trigger: 'item',
    formatter: '{b}: {c} hrs ({d}%)'
  },
  legend: {
    top: '5%',
    left: 'center'
  },
  series: [
    {
      name: 'Time per Project',
      type: 'pie',
      radius: ['40%', '70%'],
      avoidLabelOverlap: false,
      itemStyle: {
        borderRadius: 10,
        borderColor: '#fff',
        borderWidth: 2
      },
      label: {
        show: false,
        position: 'center'
      },
      emphasis: {
        label: {
          show: true,
          fontSize: 20,
          fontWeight: 'bold'
        }
      },
      data: project_distribution.value
    }
  ]
}));
</script>
<template>
  <AppPanel title="Dashboard">
    <div class="flex flex-row w-full justify-between items-center">
      <div>
        <h1 class="text-2xl text-black">Overall Stats</h1>
      </div>
      <div class="flex justify-center gap-10">

        <UDropdownMenu :items="filter_category" arrow :content="{ side: 'bottom', align: 'start' }">
          <UButton trailing-icon="i-lucide-chevron-down" :label="category_label" color="neutral" variant="subtle" />
        </UDropdownMenu>

        <UDropdownMenu :items="filter_who" arrow :content="{ side: 'bottom', align: 'start' }">
          <UButton trailing-icon="i-lucide-chevron-down" :label="who_label" color="neutral" variant="subtle">
          </UButton>
        </UDropdownMenu>

        <UDropdownMenu :items="filter_who" arrow :content="{ side: 'bottom', align: 'start' }">
          <UButton trailing-icon="i-lucide-chevron-down" label="Something" color="neutral" variant="subtle">
          </UButton>
        </UDropdownMenu>
      </div>
    </div>

    <div class=" flex flex-row w-full h-full gap-6 mb-2">

      <div class="w-full h-200 rounded-lg bg-gray-50 shadow-lg">
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
            <div class="w-full h-86 items-center text-center content-center p-4">
              <div v-if="project_distribution.length > 0" class="h-75 w-full">
                <VChart class="h-full w-full" :option="chart_option" autoresize />
              </div>

              <div v-else class="flex flex-col items-center justify-center h-full text-gray-400">
                <UIcon name="i-lucide-bar-chart-2" class="w-12 h-12 mb-2" />
                <p>No data available</p>
              </div>
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

      <div class="w-1/3 h-200 rounded-lg bg-gray-50 shadow-lg">
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
