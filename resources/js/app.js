import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import ToastComponent from '../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts.js';
import {livewire_hot_reload} from 'virtual:livewire-hot-reload'

Alpine.plugin(ToastComponent);

Livewire.start()
livewire_hot_reload();
