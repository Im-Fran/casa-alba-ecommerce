import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import livewire from '@defstudio/vite-livewire-plugin';

export default ({ mode }) => {

    process.env = {
        ...process.env,
        ...loadEnv(mode, process.cwd())
    }

    return defineConfig({
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: false,
            }),
            livewire({
                refresh: ['resources/css/app.css'],
            })
        ],
        server: {
            hmr: {
                host: process.env.VITE_DEVELOPMENT_SERVER,
            }
        }
    });
};
