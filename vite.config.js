import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/registration-form.js',
                'resources/js/programme-dashboard-graph.js',
                'resources/js/admin-dashboard-registration-trends.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Allow external connections
        port: 5173,
        hmr: {
            host: process.env.VITE_HMR_HOST || 'localhost',
        },
        strictPort: false,
    },
});
