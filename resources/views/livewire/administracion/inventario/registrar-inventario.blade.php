<div>
    <h4 class="mb-4 text-lg font-bold">Datos del inventario</h4>
    <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <x-select2 label="Sucursal" id="sucursal" icon="fa-solid fa-building" model="sucursal"
            wire="change=validarCodigoProducto" optionTextDefault="Seleccione una sucursal"> </x-select2>

        <div>
            <x-live-wire-input label="Producto" id="codigo_producto" icon="fa-solid fa-location-dot"
                model="codigo_producto" placeholder="Buscar producto" typeInput="text" wire='buscarProducto'>
            </x-live-wire-input>

            <x-live-wire-input label="" id="id_producto" icon="" model="id_producto" placeholder="" typeInput="hidden">
            </x-live-wire-input>

            @if ($listaProductos)
            <ul class="max-w-md p-2 space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                @foreach ($listaProductos as $prod)
                <li class="cursor-pointer" wire:click='setearNombreProducto("{{$prod->id}}")'>
                    {{ $prod->codigo_producto.' - '. $prod->descripcion }}
                </li>
                @endforeach
            </ul>
            @endif
        </div>

        <x-live-wire-input label="Nombre del producto" id="descripcion" icon="fa-solid fa-list" model="descripcion"
            placeholder="" typeInput="text" disabled="disabled"></x-live-wire-input>

        <x-live-wire-input label="Stock" id="stock" icon="fa-solid fa-boxes-stacked" model="stock" placeholder="0"
            typeInput="number"></x-live-wire-input>

        <x-live-wire-input label="Stock Mínimo" id="stock_minimo" icon="fa-solid fa-cubes-stacked" model="stock_minimo"
            placeholder="0" typeInput="number"></x-live-wire-input>

        <x-select2 label="Comisiona" id="comisiona" icon="fa-solid fa-percent" model="comisiona"
            optionTextDefault="Seleccione una opción"> </x-select2>

        <x-select2 label="Estado" id="estado" icon="fa-solid fa-toggle-on" model="estado"
            optionTextDefault="Seleccione un estado"> </x-select2>
    </div>
    <hr class="my-4">
    <h4 class="mb-4 text-lg font-bold">Datos del producto</h4>
    <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        <x-select2 label="Categoría" id="categoria" icon="fa-solid fa-layer-group" model="categoria"
            optionTextDefault="" disabled="disabled"> </x-select2>

        <x-select2 label="Tipo de producto" id="tipo_producto" icon="fa-solid fa-layer-group" model="tipo_producto"
            optionTextDefault="" disabled="disabled"> </x-select2>

        <x-select2 x-model="tipoSeleccionado" label="Tipo de afectación" id="tipo" icon="fa-solid fa-percent"
            model="tipo" optionTextDefault="" disabled="disabled">
        </x-select2>

        <x-live-wire-input label="Impuesto (%)" id="impuesto" icon="fa-solid fa-file-invoice-dollar" model="impuesto"
            placeholder="" typeInput="text" disabled="disabled" disabled="disabled"></x-live-wire-input>

        <x-select2 label="Unidad/medida" id="unidad_medida" icon="fa-solid fa-ruler-horizontal" model="unidad_medida"
            optionTextDefault="" disabled="disabled"> </x-select2>

        <x-live-wire-input label="Costo Unitario" id="costo_unitario" icon="fa-solid fa-dollar-sign" placeholder=""
            typeInput="number" model="costo_unitario" disabled="disabled"></x-live-wire-input>

        <x-live-wire-input label="Precio (con IVA)" id="precio_unitario_con_iva" icon="fa-solid fa-dollar-sign"
            placeholder="" typeInput="number" model="precio_unitario_con_iva" disabled="disabled">
        </x-live-wire-input>

        <x-live-wire-input label="Precio (sin IVA)" id="precio_unitario_sin_iva" icon="fa-solid fa-dollar-sign"
            model="precio_unitario_sin_iva" placeholder="" typeInput="number" disabled="disabled"></x-live-wire-input>

        <x-live-wire-input label="Comisión" id="comision" icon="fa-solid fa-dollar-sign" model="comision" placeholder=""
            typeInput="number" disabled="disabled"></x-live-wire-input>

    </div>

    <div class="grid grid-cols-1 gap-4 mt-5 text-sm sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2">

        <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1">

            <div class="flex justify-start">

                <figure class="flex justify-center max-w-lg h-[250px] w-[250px] " wire:loading.remove
                    wire:target="imagen">

                    <div class="flex flex-col items-center">
                        @if ($imagen_db)
                        @php
                        $path = $imagen_db;
                        $moduleName = 'productos'; // Nombre del módulo
                        $imageName = basename($path);
                        @endphp
                        <img class="h-[250px] w-[250px] rounded-lg border-black border-[1px]"
                            src="{{ route('admin.storage', ['modulo'=> $moduleName, 'filename' => $imageName]) }}"
                            alt="Imagen producto" />
                        @else
                        <img class="rounded-lg h-[250px] w-[250px] border-black border-2"
                            src="{{asset('images/imagen-defecto-producto.jpg') }}" alt="Imagen producto" />
                        @endif
                        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Imagen del
                            producto
                        </figcaption>
                    </div>
                </figure>
            </div>
        </div>
    </div>

    <div class="flex justify-end mt-5">
        <button wire:click="cancelarRegistrarInventario" type="button"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                class="fa-solid fa-ban"></i> Cancelar
        </button>

        <button wire:click="registrarInventario" type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <div wire:loading.remove wire:target="registrarInventario">
                <i class="fa-solid fa-floppy-disk"></i> Guardar
            </div>
            <div wire:loading wire:target="registrarInventario">
                Cargando...
            </div>
        </button>
    </div>

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
            
            $wire.on('estadoCampos', (e) => {
                const precio_unitario = document.getElementById(''+e.elementId+'');
                precio_unitario.value = "";
                const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
                });
                Toast.fire({
                icon: "warning",
                title: e.message
                });
            });
            
            $wire.on('resetFileInput', (e) => {
                document.getElementById('imagen').value = null;
            });
            
    </script>
    @endscript

</div>