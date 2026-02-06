<script setup lang="ts">

const isCollapsed = ref(false)
</script>

<template>
  <main>
    <UDashboardGroup>
      <UDashboardSidebar v-model:collapsed="isCollapsed" resizable collapsible>

        <div class="h-10 flex items-center px-2 mb-2">
          <h1 v-if="!isCollapsed" class="text-xl font-bold truncate">
            SKLoud App
          </h1>
          <h1 v-else class="text-xl font-bold text-center w-full">
            SK
          </h1>
        </div>

        <UDashboardSearchButton leading :collapsed="isCollapsed" :label="isCollapsed ? undefined : 'Search...'" />
        <div v-if="!isCollapsed" class="flex flex-col">
          <ULink to="/dashboard">
            Dashboard
          </ULink>
          <ULink to="/timesheet">
            Timesheet
          </ULink>
          <ULink to="/project">
            Project
          </ULink>
        </div>

      </UDashboardSidebar>

      <UDashboardSearch />

      <slot />
    </UDashboardGroup>
  </main>
</template>
