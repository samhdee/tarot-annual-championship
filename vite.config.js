import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/home.scss',
                'resources/scss/player-profile.scss',
                'resources/js/app.js',
                'resources/js/home.js',
                'resources/js/player-profile.js'
            ],
            refresh: true,
        }),

    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
