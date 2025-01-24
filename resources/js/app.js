import './bootstrap';
import '../../vendor/masmerise/livewire-toaster/resources/js';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import {livewire_hot_reload} from 'virtual:livewire-hot-reload'

Livewire.start()
livewire_hot_reload();
