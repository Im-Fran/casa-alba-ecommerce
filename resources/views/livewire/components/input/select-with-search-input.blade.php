<div
    x-data="{
        open: false,
        search: '',
        selected: null,
        selectedText: '',
        init() {
            this.selected = $wire.selected;
            this.selectedText = this.selected ? $wire.options.find(o => o.id === this.selected).name : '';

            this.$watch('selected', value => {
                $wire.selected = value;
                this.selectedText = value ? $wire.options.find(o => o.id === value).name : '';
            });
        }
    }"
    class="relative"
>
    <button @click="open = !open" type="button" class="w-full flex items-center justify-between px-4 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <span x-text="selectedText || 'Select an option'"></span>
        <svg x-bind:class="{ 'transform rotate-180': open }" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg"
    >
        <div class="p-2">
            <input
                type="text"
                x-model="search"
                placeholder="Search..."
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <ul class="max-h-60 overflow-auto py-1">
            <template x-for="option in $wire.options.filter(option => option.name.toLowerCase().includes(search.toLowerCase()))" :key="option.id">
                <li>
                    <button
                        @click="selected = option.id; open = false"
                        type="button"
                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100"
                        :class="{ 'bg-blue-50': selected === option.id }"
                        x-text="option.name"
                    ></button>
                </li>
            </template>
        </ul>
    </div>
</div>
