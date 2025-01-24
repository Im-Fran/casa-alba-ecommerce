<div>
    @if(request()->routeIs('home'))
        <x-modal wire:model="openSearch" class="backdrop-blur">
            <input wire:model.live="search" type="text" class="w-full p-2 border border-neutral-200 rounded-lg" placeholder="Buscar productos..."/>
        </x-modal>

        <x-lucide-search wire:click.stop="$toggle('openSearch')" class="hover:text-secondary w-8 h-8 cursor-pointer"/>
    @endif
</div>
