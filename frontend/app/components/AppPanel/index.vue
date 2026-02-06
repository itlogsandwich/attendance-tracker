<script setup lang="ts">

interface Props {
  title: string
}

defineProps<Props>();

</script>

<template>
  <UDashboardPanel>
    <template #header>
      <UDashboardNavbar class="shadow-sm" :title="title" :toggle="{
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
