<script setup lang="ts">

interface Props {
  title: string
}

defineProps<Props>();

</script>

<template>
  <UDashboardPanel>
    <template #header>
      <UDashboardNavbar :title="title" color="primary" :toggle="{
        color: 'primary',
        variant: 'subtle',
        class: 'rounded-full',
      }">
        <template #leading>
          <UDashboardSidebarCollapse />
        </template>
      </UDashboardNavbar>
    </template>

    <template #body>
      <slot />
    </template>
  </UDashboardPanel>

</template>
