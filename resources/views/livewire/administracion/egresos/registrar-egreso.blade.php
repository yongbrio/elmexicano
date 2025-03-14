<div>

    <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        <x-live-wire-input label="Código del egreso" id="codigo_egreso" icon="fa-solid fa-address-card"
            model="codigo_egreso" placeholder="123" typeInput="number" disabled="disabled">
        </x-live-wire-input>

        <x-select2 label="Tipo de egreso" id="tipo_egreso" icon="fa-solid fa-toggle-on" model="tipo_egreso"
            optionTextDefault="Seleccione un tipo de egreso" wire="change=seleccionarFlujo"> </x-select2>

        @if ($flujo == 1 || $flujo == 2)
        <x-select2 label="Selecciona categoría 1" id="lista_categorias_1" icon="fa-solid fa-list-ol" model="categoria_1"
            optionTextDefault="Selecciona categoría 1" wire='change=traerCategoriasAsociadas'> </x-select2>

        <div>
            <label for="lista_categorias_2"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecciona categoría 2</label>
            <div class="flex">
                <span
                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 border-e-0 rounded-s-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    <i class="fa-solid fa-list-ol"></i>
                </span>
                <select id="lista_categorias_2" wire:model='categoria_2'
                    class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected value="">Selecciona categoría 2</option>
                    @if (!empty($lista_categorias_asociadas))
                    @foreach ($lista_categorias_asociadas as $cat_asoc)
                    <option value="{{ $cat_asoc->id_categoria_2 }}">{{ $cat_asoc->categoria2->nombre_categoria }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div>@error('categoria_2') <div class="text-sm text-red-500">{{ $message }}</div> @enderror</div>
        </div>

        <x-live-wire-input label="Descripción de egreso" id="descripcion_egreso" icon="fa-solid fa-file-signature"
            model="descripcion_egreso" placeholder="Descripción de egreso" typeInput="text"></x-live-wire-input>
        @endif
        @if ($flujo == 1)
        <div>
            <x-live-wire-input label="Código de producto" id="codigo_producto_busqueda" icon="fa-solid fa-location-dot"
                model="codigo_producto_busqueda" placeholder="Buscar producto" typeInput="text" wire='buscarProducto'>
            </x-live-wire-input>

            @if (!empty(trim($listaProductos)) && count($listaProductos) > 0)
            <div class="z-50 w-full overflow-auto max-h-40">
                <ul class="p-2 ml-[35px] -mt-[8px] space-y-1 text-sm text-gray-900 list-inside list-none">
                    @foreach ($listaProductos as $producto)
                    <li class="p-1 border-2 border-gray-300 cursor-pointer dark:text-gray-400 hover:bg-sky-600 hover:text-white"
                        wire:click="setearNombreProducto('{{ $producto->id }}','{{ $producto->codigo_producto }} - {{ $producto->descripcion }}')">
                        {{ $producto->codigo_producto.' - '. $producto->descripcion }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            <x-live-wire-input label="" id="codigo_producto" icon="" model="codigo_producto" placeholder=""
                typeInput="hidden">
            </x-live-wire-input>
        </div>

        <x-select2 label="Unidad de medida" id="unidad_medida" icon="fa-solid fa-toggle-on" model="unidad_medida"
            optionTextDefault="Seleccione unidad de medida"> </x-select2>

        @endif

        @if ($flujo == 1 || $flujo == 2)
        <x-select2 label="Estado" id="estado" icon="fa-solid fa-toggle-on" model="estado"
            optionTextDefault="Seleccione un estado"> </x-select2>
        @endif

    </div>

    @if ($flujo == 1 || $flujo == 2)

    <div class="flex justify-end mt-5">
        <button wire:click="cancelarRegistrarEgreso" type="button"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                class="fa-solid fa-ban"></i> Cancelar
        </button>
        <button wire:click="registrarEgreso" type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <div wire:loading.remove wire:target="registrarEgreso">
                <i class="fa-solid fa-floppy-disk"></i> Guardar
            </div>
            <div wire:loading wire:target="registrarEgreso">
                Cargando...
            </div>
        </button>
    </div>

    @endif

    @script
    <script>
        $wire.on('estadoActualizacion', (e) => {
                Swal.fire({
                    title: e.title,
                    text: e.message,
                    icon: e.icon,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    $wire.dispatch('redirigir');
                });
            });
    </script>
    @endscript

</div>