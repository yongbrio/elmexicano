<div>
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
    <div class="flex">
        <span
            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 rounded-s-lg border-e-0 dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
            <i class="{{ $icon }}"></i>
        </span>
        <input type="{{$typeInput}}" id="{{ $id }}" {{ $model ? 'wire:model=' .$model : '' }}
            class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="{{$placeholder}}">
    </div>
    <div>@error($model) <div class="text-red-500">{{ $message }}</div> @enderror</div>
</div>