import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        hmr: {
            host: 'localhost'
        }
    },// ← Ajoute cette section pour supprimer le warning
  css: {
    preprocessorOptions: {
      scss: {
        api: 'modern-compiler', // ou 'modern' selon ta version de sass
      },
    },
  },
});
