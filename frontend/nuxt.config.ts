// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  modules: ['@nuxt/eslint', '@nuxt/hints', '@nuxt/ui', 'nuxt-auth-utils', 'nuxt-echarts'],
  devtools: { enabled: true },
  compatibilityDate: '2026-02-06',
  css: ['./app/assets/css/main.css'],

  echarts: {
    renderer: ['svg'],
    charts: ['BarChart', 'PieChart'],
    components: ['DatasetComponent', 'GridComponent', 'TooltipComponent', 'LegendComponent'],
  },

  imports: {
    dirs: [
      'app/composables/**',
      '~/utils'
    ],
  },

  runtimeConfig: {
    public:
    {
      apiBase: process.env.NUXT_PUBLIC_API_BASE_URL || 'http://localhost:8000/api/v1',
    }
  },
  vite: {
    build: {
      sourcemap: false,
    },
  },

  eslint: {
    config: {
      stylistic: true,
    },
  },
});
