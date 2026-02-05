<script lang="ts" setup>
import type { ToasterProps } from "vue-sonner"

const props = defineProps<ToasterProps>()
const colorMode = useColorMode()

const colorTheme = computed(() => {
  return colorMode.value as "dark" | "light"
})

</script>
<template>
  <LazyToaster v-bind="props" position="top-right" :theme="colorTheme" close-button expand hydrate-on-idle
    rich-colors />
</template>
