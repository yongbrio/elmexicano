<div>
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
    <div class="flex">

        <span
            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 border-e-0 rounded-s-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
            <i class="{{ $icon }}"></i>
        </span>
        <select id="{{ $id }}" {{ $model ? 'wire:model=' .$model : '' }} {{ $wire ? 'wire:' .$wire : '' }} {{$disabled ?
            $disabled: '' }}
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
            @elseif ($id == 'categoria')
            @foreach ( $categorias as $categoria )
            <option value="{{$categoria->id}}">{{$categoria->nombre_categoria}}</option>
            @endforeach
            @elseif ($id == 'tipo')
            @foreach ( $tipo_afectacion_impuesto as $tipo_impuesto )
            <option value="{{$tipo_impuesto->id}}">{{$tipo_impuesto->descripcion }}
            </option>
            @endforeach
            @elseif ($id == 'importancia')
            <option value="Alta">Alta</option>
            <option value="Media">Media</option>
            <option value="Baja">Baja</option>
            @elseif ($id == 'unidad_medida')
            @foreach ($unidad_medidas as $unidad_medida)
            <option value="{{$unidad_medida->id}}">{{$unidad_medida->nombre_unidad_medida}}</option>
            @endforeach
            @elseif ($id == 'sucursal' || $id == 'sucursal_origen')
            @foreach ($sucursales as $sucursal)
            <option value="{{$sucursal->id}}">{{$sucursal->nombre_sucursal}}</option>
            @endforeach
            @elseif ($id == 'sucursal_destino')
            @isset($sucursales_destino)
            @foreach ($sucursales_destino as $sucursal)
            <option value="{{$sucursal->id}}">{{$sucursal->nombre_sucursal}}</option>
            @endforeach
            @endisset
            @elseif ($id == 'tipo_producto')
            @foreach ($tipo_productos as $tipo_producto)
            <option value="{{$tipo_producto->id}}">{{$tipo_producto->nombre_tipo_producto}}</option>
            @endforeach
            @elseif ($id == 'perfil')
            @foreach ($perfiles as $perfil)
            <option value="{{$perfil->role_id}}">{{$perfil->role_name}}</option>
            @endforeach
            @elseif ($id == 'tipo_egreso')
            <option value="1">Insumo</option>
            <option value="2">Regular</option>
            @elseif ($id == 'giro_sucursal')
            @foreach ($giro_sucursales as $giro_sucursal)
            <option value="{{$giro_sucursal->id}}">{{$giro_sucursal->descripcion}}</option>
            @endforeach
            @elseif ($id == 'tipo_sucursal')
            @foreach ($tipo_sucursales as $tipo_sucursal)
            <option value="{{$tipo_sucursal->id}}">{{$tipo_sucursal->descripcion}}</option>
            @endforeach
            @elseif ($id == 'lista_categorias_1')
            @foreach ($lista_categorias_1 as $categoria)
            <option value="{{$categoria->id}}">{{$categoria->nombre_categoria}}</option>
            @endforeach
            @elseif ($id == 'lista_categorias_2')
            @foreach ($lista_categorias_2 as $categoria)
            <option value="{{$categoria->id}}">{{$categoria->nombre_categoria}}</option>
            @endforeach
            @else
            @foreach ( $empresas as $empresa )
            <option value="{{$empresa->id}}">{{$empresa->nombre_comercial}}</option>
            @endforeach
            @endif
        </select>
    </div>
    <div>@error($model) <div class="text-sm text-red-500">{{ $message }}</div> @enderror</div>
</div>