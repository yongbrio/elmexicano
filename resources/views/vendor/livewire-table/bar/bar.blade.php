<div class="flex flex-col gap-3">
    <div class="flex flex-col gap-3 lg:flex-row">
        <input type="search"
               placeholder="@lang('Buscar')"
               class="px-3 py-2 text-black transition ease-in-out bg-white border rounded-md shadow-sm outline-none border-neutral-200 focus:border-blue-300 dark:bg-neutral-800 dark:border-neutral-700 dark:focus:border-blue-600 dark:text-white"
               wire:model.live.debounce.500ms="globalSearch">
        <div class="items-center justify-center w-full border-transparent border-y" wire:loading.flex>
            <span class="inline-block p-2 my-2 border border-4 border-blue-500 rounded-full border-r-transparent motion-safe:animate-spin"></span>
        </div>
        @include('livewire-table::bar.selection')
        <div class="flex gap-3 ml-auto">
            @includeWhen($this->useReordering, 'livewire-table::bar.buttons.reordering')
            @include('livewire-table::bar.dropdowns.polling')
            @include('livewire-table::bar.dropdowns.columns')
            @include('livewire-table::bar.dropdowns.filters')
            @include('livewire-table::bar.dropdowns.actions')
            @include('livewire-table::bar.dropdowns.trashed')
            <select wire:model.live="perPage"
                    class="px-3 py-2 text-black transition ease-in-out bg-white border rounded-md shadow-sm outline-none border-neutral-200 focus:border-blue-300 dark:bg-neutral-800 dark:border-neutral-700 dark:focus:border-blue-600 dark:text-white">
                @foreach($perPageOptions as $perPage)
                    <option value="{{ $perPage }}">{{ $perPage }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
