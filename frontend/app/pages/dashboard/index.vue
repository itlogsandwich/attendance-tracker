<script setup lang="ts">
definePageMeta({
  layout: 'main',
});
</script>

<template>

  <UDashboardPanel resizable :min-size="22" :default-size="35" :max-size="40">
    <template #header>
      <UDashboardNavbar title="Attendance Tracker" :toggle="{
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
      <div class=" flex flex-row h-full w-full bg-red-500">

        <div class="w-full bg-green-500">
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

        <div class="w-full bg-blue-500">

          02
        </div>

        <div class="w-full bg-yellow-500">

          03
        </div>

      </div>
    </template>
  </UDashboardPanel>

</template>
