// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  modules: [
    '@nuxt/eslint',
    '@nuxt/hints',
    '@nuxt/ui',
    'nuxt-auth-utils',
  ],
  devtools: { enabled: true },
  compatibilityDate: '2026-02-06',
  css: ['./app/assets/css/main.css'],

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
