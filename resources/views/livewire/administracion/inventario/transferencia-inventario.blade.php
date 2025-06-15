<div>

    <div class="flex justify-end">
        <button type="button" data-modal-target="extralarge-modal" data-modal-toggle="extralarge-modal"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i
                class="fa-solid fa-file-invoice"></i> Historial de transferencias</button>
    </div>
    <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">

        <div
            class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Origen</h2>

            <div>
                <x-select2 label="Sucursal Origen" id="sucursal_origen" icon="fa-solid fa-ruler-horizontal"
                    model="sucursal_origen" optionTextDefault="Seleccione la sucursal de origen"
                    wire="change=cambiarSucursal" disabled="{{ $disabled }}">
                </x-select2>
            </div>


        </div>

        <div
            class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Inventario a transferir</h2>
            <div>
                <x-live-wire-input label="Producto" id="producto_origen" icon="fa-solid fa-location-dot"
                    model="producto_origen" placeholder="Buscar producto" typeInput="text" wire='buscarProductoOrigen'>
                </x-live-wire-input>

                <x-live-wire-input label="" id="id_producto_origen" icon="" model="id_producto_origen" placeholder=""
                    typeInput="hidden">
                </x-live-wire-input>

                @if ($listaProductos)
                <ul class="max-w-md p-2 space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                    @foreach ($listaProductos as $inventario)
                    <li class="cursor-pointer" wire:click='setearNombreProducto("{{$inventario->id}}")'>
                        {{ $inventario->producto->codigo_producto.' - '. $inventario->producto->descripcion . ' -
                        '.$inventario->stock }}
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>

            <x-live-wire-input label="Stock disponible" id="stock_disponible_origen" icon="fa-solid fa-cubes"
                model="stock_disponible_origen" placeholder="Stock Disponible" typeInput="text" disabled='disabled'>
            </x-live-wire-input>

            <x-live-wire-input label="Stock a transferir" id="stock_transferencia" icon="fa-solid fa-cubes"
                model="stock_transferencia" placeholder="Stock a transferir" typeInput="text">
            </x-live-wire-input>
        </div>

        <div
            class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Destino</h2>
                <x-select2 label="Sucursal Destino" id="sucursal_destino" icon="fa-solid fa-ruler-horizontal"
                    model="sucursal_destino" idSucursalOrigen="{{$sucursal_origen}}"
                    optionTextDefault="Seleccione la sucursal de destino"> </x-select2>
            </div>
            <div class="flex justify-end pt-2">
                <button type="button" wire:click='agregarTransferenciaInventario'
                    class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    <i class="fa-solid fa-circle-plus"></i> Agregar
                </button>
            </div>
        </div>
    </div>
    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
    <div>
        <h4 class="pb-6 text-xl font-semibold">Transferencias por enviar</h4>
        <livewire:administracion.inventario.lista-transferencias-inventario :estado="'0'" />
    </div>

    <!-- Extra Large Modal -->
    <div id="extralarge-modal" tabindex="-1" wire:ignore.self data-modal-backdrop="static"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-h-full max-w-7xl">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Historial de transferencia de inventario
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="extralarge-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 space-y-4 md:p-5">
                    <livewire:administracion.inventario.lista-transferencias-inventario-table>
                        <hr>
                        <div class="flex justify-center gap-4">
                            <div>
                                <label for="start_date"
                                    class="block text-sm font-medium text-gray-900 dark:text-gray-300">Fecha
                                    de
                                    inicio</label>
                                <input type="date" id="start_date" name="start_date" aria-label="Fecha de inicio"
                                    wire:model="start_date"
                                    class="mb-2 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                @if ($errors->has('start_date'))
                                <p class="mt-1 text-sm text-red-500">{{ $errors->first('start_date') }}</p>
                                @endif
                            </div>

                            <div>
                                <label for="end_date"
                                    class="block text-sm font-medium text-gray-900 dark:text-gray-300">Fecha
                                    de
                                    finalización</label>
                                <input type="date" id="end_date" name="end_date" aria-label="Fecha de finalización"
                                    wire:model="end_date"
                                    class="mb-2 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @if ($errors->has('end_date'))
                                <p class="mt-1 text-sm text-red-500">{{ $errors->first('end_date') }}</p>
                                @endif
                            </div>
                            <div class="my-auto">
                                <button type="button" wire:click='generarExcelHistorial'
                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    <i class="fa-solid fa-file-excel"></i> Generar Excel
                                </button>
                            </div>
                        </div>
                </div>
                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-4 space-x-3 border-t border-gray-200 rounded-b md:p-5 rtl:space-x-reverse dark:border-gray-600">
                    <button data-modal-hide="extralarge-modal" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('estadoCampos', (e) => {
            const elemento = document.getElementById(''+e.elementId+'');
            if( elemento ){
                elemento.value = "";
            }
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

        $wire.on('estadoActualizacion', (e) => {
                Swal.fire({
                    title: e.title,
                    text: e.message,
                    icon: e.icon,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    /* $wire.dispatch('redirigir'); */
                });
            });

/*             $wire.on('estadoActualizacion_tabla', (e) => {
                Swal.fire({
                    title: e.title,
                    text: e.message,
                    icon: e.icon,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                }).then((result) => {
                   
                });
            }); */

            $wire.dispatch('recargarComponente');
            
    </script>
    @endscript
</div>