<div>
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
    <div class="flex">
        <span
            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 border-e-0 rounded-s-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
            <i class="{{ $icon }}"></i>
        </span>
        <select id="{{ $id }}" {{ $model ? 'wire:model=' .$model : '' }}
            class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option selected value="">{{$optionTextDefault}}</option>
            @if ($id == 'estado')
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
            @elseif ($id== 'tipo_cuenta')
            <option value="1">Ahorros</option>
            <option value="2">Corriente</option>
            <option value="3">Tarjeta de Crédito</option>
            <option value="4">Cuenta Internacional</option>
            <option value="5">Cuenta de inversión</option>
            <option value="6">Crédito rotativo</option>
            @else
            @foreach ( $empresas as $empresa )
            <option value="{{$empresa->id}}">{{$empresa->nombre_comercial}}</option>
            @endforeach

            @endif
        </select>
    </div>
    <div>@error($model) <div class="text-red-500">{{ $message }}</div> @enderror</div>
    <script>
        document.addEventListener('DOMContentLoaded',function(){
            
        });
    </script>
</div>