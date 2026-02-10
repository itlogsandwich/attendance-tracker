<script setup lang="ts">
import { h, resolveComponent } from 'vue'
import type { TableColumn } from '@nuxt/ui'
import type { Project } from '#shared/types/project'

const UButton = resolveComponent('UButton')
const UCheckbox = resolveComponent('UCheckbox')
const UBadge = resolveComponent('UBadge')
const UDropdownMenu = resolveComponent('UDropdownMenu')

const search_project = ref<string>("");

const filtered_projects: any = computed(() => {
  if (!sample_projects.value) return [];

  if (!search_project.value) return sample_projects.value;

  const search_term = search_project.value.toLowerCase();

  return sample_projects.value.filter((project: Project) => {
    return (
      project.title.toLowerCase().includes(search_term) ||
      project.client.toLowerCase().includes(search_term) ||
      project.access.toLowerCase().includes(search_term)
    )
  })
})

definePageMeta({
  layout: "main"
})

const sample_projects = ref<Project[]>([{
  id: 1,
  title: "SKLoud App",
  client: "The People",
  is_tracked: true,
  progress: 50,
  access: "Public",
}, {
  id: 2,
  title: "Marketing",
  client: "The People",
  is_tracked: false,
  progress: 90,
  access: "Public",
}, {
  id: 3,
  title: "Attendance Tracker",
  client: "SKLoud",
  is_tracked: true,
  progress: 20,
  access: "Private",

}])

const columns: TableColumn<Project>[] = [
  {
    id: 'select',
    header: ({ table }) => h(UCheckbox, {
      'modelValue': table.getIsSomePageRowsSelected() ? 'indeterminate' : table.getIsAllPageRowsSelected(),
      'onUpdate:modelValue': (value: boolean | 'indeterminate') => table.toggleAllPageRowsSelected(!!value),
      'aria-label': 'Select all'
    }),
    cell: ({ row }) => h(UCheckbox, {
      'modelValue': row.getIsSelected(),
      'onUpdate:modelValue': (value: boolean | 'indeterminate') => row.toggleSelected(!!value),
      'aria-label': 'Select row'
    }),
    enableSorting: false,
    enableHiding: false
  },
  {
    accessorKey: 'title',
    header: ({ column }) => {
      const is_sorted = column.getIsSorted()
      return h(UButton, {
        color: 'neutral',
        variant: 'ghost',
        label: 'Project Name',
        icon: is_sorted ? (is_sorted === 'asc' ? 'i-lucide-arrow-up-narrow-wide' : 'i-lucide-arrow-down-wide-narrow') : 'i-lucide-arrow-up-down',
        class: '-mx-2.5',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc')
      })
    }
  },
  {
    accessorKey: 'client',
    header: 'Client',
    cell: ({ row }) => row.getValue('client')
  },
  {
    accessorKey: 'tracked',
    header: 'Status',
    cell: ({ row }) => {
      // Logic: Map boolean true/false to Success/Neutral colors
      const is_tracked = row.getValue('tracked') as boolean

      return h(UBadge, {
        class: 'capitalize',
        variant: 'subtle',
        color: is_tracked ? 'success' : 'error'
      }, () => is_tracked ? 'Active' : 'Inactive')
    }
  },
  {
    accessorKey: 'progress',
    header: 'Progress',
    cell: ({ row }) => {
      // Logic: Append '%' sign to the number
      return `${row.getValue('progress')}%`
    }
  },
  {
    accessorKey: 'access',
    header: 'Access',
    cell: ({ row }) => {
      // Logic: specific styling for access types if needed
      const access = row.getValue('access') as string
      return h(UBadge, {
        variant: 'outline',
        color: access === 'Private' ? 'warning' : 'primary'
      }, () => access)
    }
  },
  {
    id: 'actions',
    enableHiding: false,
    cell: ({ row }) => {
      const items = [{
        label: 'Edit Project',
        icon: 'i-lucide-pencil',
        onSelect() {
          console.log('Edit', row.original.title)
        }
      }, {
        label: 'Copy Project Name',
        icon: 'i-lucide-copy',
        onSelect() {
          // Assuming 'copy' and 'toast' are available in scope
          navigator.clipboard.writeText(row.original.title)
        }
      }]

      return h(UDropdownMenu, {
        content: { align: 'end' },
        items,
        'aria-label': 'Actions'
      }, () => h(UButton, {
        icon: 'i-lucide-ellipsis-vertical',
        color: 'neutral',
        variant: 'ghost',
        'aria-label': 'Actions'
      }))
    }
  }
]
</script>

<template>
  <AppPanel title="Project">
    <div class="flex flex-row h-12 px-2 shadow-md gap-2 items-center rounded-lg bg-gray-50">

      <h1 class="flex-1 text-black text-center"> Filter </h1>

      <USeparator orientation="vertical" />
      <UButton trailing-icon="i-lucide-arrow-down" label="Active" class="flex-1 bg-gray-50 text-black justify-center ">
      </UButton>

      <USeparator orientation="vertical" />
      <UButton trailing-icon="i-lucide-arrow-down" label="Client" class="flex-1 bg-gray-50 text-black justify-center">
      </UButton>

      <USeparator orientation="vertical" />
      <UButton trailing-icon="i-lucide-arrow-down" label="Access" class="flex-1 bg-gray-50 text-black justify-center">
      </UButton>

      <USeparator orientation="vertical" />
      <UButton trailing-icon="i-lucide-arrow-down" label="Billing" class="flex-1 bg-gray-50 text-black justify-center">

      </UButton>

      <USeparator orientation="vertical" />
      <div class="flex-none">
        <UInput v-model="search_project" leading-icon="i-lucide-search" class="w-full" placeholder="Apply filters..." />
      </div>

      <UButton label="Apply" variant="outline">

      </UButton>
    </div>

    <div>
      <h1 class="text-center text-lg text-black font-bold rounded-t-lg bg-gray-200">Projects</h1>
      <UTable ref="table" :data="filtered_projects" :columns="columns" sticky class="flex-1 shadow-lg rounded-b-md">
        <template #expanded="{ row }">
          <div class="p-4 bg-gray-50/50">
            <h3 class="text-sm font-bold mb-2">Detailed Project Metadata</h3>
            <ul class="text-xs space-y-1">
              <li><strong>Client ID:</strong> {{ row.original.client.toLowerCase().replace(' ', '-') }}</li>
              <li><strong>Internal Access Level:</strong> {{ row.original.access }}</li>
              <li><strong>Current Completion:</strong> {{ row.original.progress }}%</li>
            </ul>
          </div>
        </template>
      </UTable>
    </div>

  </AppPanel>
</template>
