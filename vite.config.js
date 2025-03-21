import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import livewire from '@defstudio/vite-livewire-plugin';
import basicSsl from '@vitejs/plugin-basic-ssl'

export default ({ mode }) => {

    process.env = {
        ...process.env,
        ...loadEnv(mode, process.cwd())
    }

    const host = process.env.VITE_DEVELOPMENT_SERVER

    return defineConfig({
        plugins: [
            process.env.APP_ENV === 'local' && basicSsl({
                domains: [host]
            }),
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: false,
            }),
            livewire({
                refresh: ['resources/css/app.css'],
            }),
        ],
        server: {
            https: true,
            host,
            hmr: {
                host,
            }
        }
    });
};
