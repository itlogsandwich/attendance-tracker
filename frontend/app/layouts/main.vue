<script setup lang="ts">
</script>

<template>
  <main>
    <UDashboardGroup>
      <UDashboardSidebar resizable collapsible>
        <UDashboardSearchButton leading />
      </UDashboardSidebar>

      <UDashboardSearch />

      <slot />
    </UDashboardGroup>
  </main>
</template>
