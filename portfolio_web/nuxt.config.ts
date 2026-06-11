// nuxt.config.ts
export default defineNuxtConfig({
  modules: ['@nuxtjs/tailwindcss',
    '@nuxt/icon'],

  css: ['~/assets/css/main.css'],

  app: {
    head: {
      title: 'Romi Lama | Software Engineer',
      htmlAttrs: {
        lang: 'en',
        class: 'scroll-smooth'
      },
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' }
      ],
      link: [
        { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
        { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: '' },
        { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css2?family=Inter:wght=300;400;500;600;700&family=JetBrains+Mono:wght=400;500&display=swap' }
      ]
    }
  }
})  