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
});
