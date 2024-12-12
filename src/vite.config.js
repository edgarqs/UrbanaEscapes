import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/main.scss'],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
          scss: {
            api: 'modern-compiler'
          }
        }
      }
});
