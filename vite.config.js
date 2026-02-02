import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/home.scss',
                'resources/scss/player-profile.scss',
                // 'node_modules/jquery/dist/jquery.min.js',
                'resources/js/app.js',
                'resources/js/home.js',
                'resources/js/player-profile.js',
                'resources/js/admin.js',
            ],
            refresh: true,
        }),

    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    manualChunks: {
        jquery: ['jquery'],
        // bootstrap: ['bootstrap'],
    },
    resolve: {
        alias: {
            '$': 'jQuery',
        }
    }
});
