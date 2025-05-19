import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  build: {
    // outDir: 'dist',
    // To prevent rgb() to be converted to # (hex)
    cssTarget: "chrome61"
  },
  // If using CSS modules (app.module.styl)
  // TODO: What's the difference between 'camelCase' and 'camelCaseOnly'?
  css: {
    modules: {
      localsConvention: 'camelCaseOnly',
    },
  },
  plugins: [
    laravel({
      input: ['resources/css/app.styl', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  server: {
    // hmr: false,
    // host: 'localhost', // 0.0.0.0 for all interfaces
    port: 5001,
    // allowedHosts: ['127.0.0.1', '192.168.32.2', 'grunge', 'grungecorp', 'grunge.dev', 'grungecorp.dev'],
    watch: {
      ignored: ['**/api-data/*.*', './TODO.txt'],
    },
  },
})
