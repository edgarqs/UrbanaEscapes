import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/style.scss'],
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
