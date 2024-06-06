<li class="flex justify-start align-middle">
    <div class="w-48"><span class="">{{$nombreModulo}}</span></div>
    <label class="inline-flex items-center mb-1 cursor-pointer ps-2">
        <input type="checkbox" wire:click='{{$wire}}' class="sr-only peer" id="{{$id}}" {{$activate ? 'checked' : '' }}>
        <div
            class="relative w-11 h-6 bg-red-500 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
        </div>
    </label>
</li>