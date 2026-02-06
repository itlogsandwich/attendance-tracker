<script setup lang="ts">

const isCollapsed = ref(false)
</script>

<template>
  <main>
    <UDashboardGroup>
      <UDashboardSidebar class="shadow-sm" v-model:collapsed="isCollapsed" resizable collapsible>

        <div class="h-10 flex items-center content-center px-1 mb-2">
          <h1 v-if="!isCollapsed" class="text-xl font-bold truncate">
            SKLoud App
          </h1>
          <h1 v-else class="text-xl font-bold text-center w-full">
            SK
          </h1>
        </div>

        <UDashboardSearchButton leading :collapsed="isCollapsed" :label="isCollapsed ? undefined : 'Search...'" />
        <div v-if="!isCollapsed" class="flex flex-col content-center pb-2 gap-2">
          <USeparator />
          <ULink to="/dashboard" class="flex items-center gap-2">
            <UIcon name="i-lucide-layout-dashboard" size="20" />
            <span> Dashboard </span>
          </ULink>
          <ULink to="/timesheet" class="flex items-center gap-2">
            <UIcon name="i-lucide-calendar" size="20" />
            <span class="content-center"> Timesheet </span>
          </ULink>
          <ULink to="/project" class="flex items-center gap-2">
            <UIcon name="i-lucide-file-text" size="20" />
            <span class="content-center"> Project </span>
          </ULink>
        </div>
        <div v-else class="flex flex-col items-center gap-2">
          <USeparator />
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
