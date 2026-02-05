<script setup lang="ts">
</script>

<template>
  <UDashboardNavbar title="Attendance Tracker" :toggle="{
    color: 'primary',
    variant: 'subtle',
    class: 'rounded-full',
  }">
    <slot />
  </UDashboardNavbar>
</template>
