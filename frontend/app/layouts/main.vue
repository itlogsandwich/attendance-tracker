<script setup lang="ts">

const isCollapsed = ref(false)
</script>

<template>
  <main>
    <UDashboardGroup>
      <UDashboardSidebar class="shadow-sm" v-model:collapsed="isCollapsed" resizable collapsible>

        <div class="h-10 flex items-center px-2 mb-2">
          <h1 v-if="!isCollapsed" class="text-xl font-bold truncate">
            SKLoud App
          </h1>
          <h1 v-else class="text-xl font-bold text-center w-full">
            SK
          </h1>
        </div>

        <UDashboardSearchButton leading :collapsed="isCollapsed" :label="isCollapsed ? undefined : 'Search...'" />
        <div v-if="!isCollapsed" class="flex flex-col content-center">
          <ULink to="/dashboard">
            <div class="items-center">
              <UIcon name="i-lucide-layout-dashboard" size="20" />
              <span class="content-center"> Dashboard </span>
            </div>
          </ULink>
          <ULink to="/timesheet">
            <UIcon name="i-lucide-calendar" size="20" />
            Timesheet
          </ULink>
          <ULink to="/project">
            <UIcon name="i-lucide-file-text" size="20" />
            Project
          </ULink>
        </div>
        <div v-else class="flex flex-col items-center">
          <ULink to="/dashboard">
            <div class="items-center">
              <UIcon name="i-lucide-layout-dashboard" size="20" />
            </div>
          </ULink>
          <ULink to="/timesheet">
            <UIcon name="i-lucide-calendar" size="20" />
          </ULink>
          <ULink to="/project">
            <UIcon name="i-lucide-file-text" size="20" />
          </ULink>
        </div>

      </UDashboardSidebar>

      <UDashboardSearch />

      <slot />
    </UDashboardGroup>
  </main>
</template>
