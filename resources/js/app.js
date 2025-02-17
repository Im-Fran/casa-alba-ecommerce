import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import ToastComponent from '../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts.js';
import {livewire_hot_reload} from 'virtual:livewire-hot-reload'

Alpine.plugin(ToastComponent);

Livewire.start()
Livewire.hook('request', ({ fail }) => {
    fail(({ status, preventDefault }) => {
        if (status === 419) {
            preventDefault()
            confirm('La página ha expirado. Para continuar debes recargar la página.') && window.location.reload();
        }
    })
})

livewire_hot_reload();
