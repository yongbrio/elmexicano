<div>
    <div
        class="flex flex-col-reverse grid-cols-1 gap-4 mt-5 text-lg sm:grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">
        <div>

            <div>
                <i class="text-green-600 fa-solid fa-cart-shopping"></i> Orden Ingreso No. <span
                    class="font-semibold">{{$orden->id}}</span>
            </div>

            <hr class="h-[2px] my-4 bg-green-600 border-0">

            <div class="mb-5 text-sm">
                DETALLE DE INGRESO
            </div>
            <div class="pl-4 mb-5">
                <ol
                    class="relative py-2 text-gray-500 border-gray-200 shadow-lg border-s dark:border-gray-700 dark:text-gray-400 sm:rounded-lg shadow-gray-900">
                    <li class="mb-5 ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                            <i class="text-green-600 fa-solid fa-users-line"></i>
                        </span>
                        <h3 class="text-sm leading-tight mb-0.5"><span
                                class="bg-green-600 text-white text-sm font-medium me-2 px-2.5 py-0.5 rounded">{{$datos->nit}}</span>-
                            VENTA PUBLICO</h3>
                        <p class="text-xs">Venta público (0)</p>
                    </li>
                    <li class="mb-5 ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <i class="text-green-600 fa-solid fa-paper-plane"></i>
                        </span>
                        <h3 class="text-sm leading-tight"><span class="font-semibold">VENTA PUBLICO</span> - VENTA
                            PUBLICO <span class="italic">(VENTA PUBLICO)</span> </h3>
                        <p class="text-xs">VENTA PUBLICO</p>
                    </li>
                    <li class="mb-8 ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <i class="text-green-600 fa-solid fa-gears"></i>
                        </span>
                        <h3 class="pt-2 text-sm leading-tight"><span class="text-semibold">{{$this->fecha}}</span> /
                            {{$this->nombre_sucursal}} / {{$orden->id_sucursal}} / EFECTIVO - CONCILIADO </h3>
                        {{-- <p class="text-sm">Step details here</p> --}}
                    </li>
                    <li class="ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <i class="text-green-600 fa-solid fa-comment"></i>
                        </span>
                        {{-- <h3 class="font-medium leading-tight">
                        </h3> --}}
                        <div class="flex pr-5" x-data="{ isDisabled: true }" x-on:click.away="isDisabled = true"
                            x-init="$watch('isDisabled', value => { if (!value) $refs.textarea.focus(); })">
                            <textarea id="comentario" rows="1" x-ref="textarea" :disabled="isDisabled"
                                wire:blur='registrarComentario' wire:model='comentario'
                                class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Registra un comentario..."></textarea>

                            <button type="submit" @click="isDisabled = !isDisabled"
                                class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                                <i class="fa-solid fa-pen-to-square" wire:loading.remove></i>
                                <div wire:loading wire:target="registrarComentario">
                                    <i class="fa-solid fa-spinner fa-spin"></i>
                                </div>
                                <span class="sr-only">Editar</span>
                            </button>

                        </div>
                        {{-- <p class="text-sm">Step details here</p> --}}
                    </li>
                </ol>
            </div>

            <div class="relative overflow-x-auto shadow-lg sm:rounded-lg shadow-gray-900">
                <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                    <thead class="text-gray-700 bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-2 py-3 rounded-s-lg">
                                Código
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Detalle
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Q
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Unitario
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Subtotal
                            </th>
                            <th scope="col" class="px-2 py-3 sr-only rounded-e-lg">
                                Eliminar
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!empty($listaProductosAgregados))
                        @foreach ($listaProductosAgregados as $prod)
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row"
                                class="px-2 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $prod['codigo_producto'] }}
                            </th>
                            <td class="px-2 py-1">
                                {{ $prod['descripcion'] }}
                            </td>
                            <td class="px-2 py-1">
                                {{ $prod['cantidad_producto'] }}
                            </td>
                            <td class="px-2 py-1">
                                {{ "$ ".number_format($prod['precio_unitario_con_iva'], 0, ',', '.') }}
                            </td>
                            <td class="px-2.5 py-1">
                                {{ "$ ".number_format($prod['total'], 0, ',', '.') }}
                            </td>
                            <td class="px-2.5 py-1">
                                <button type="button" wire:click="eliminarProductoLista({{ $prod['id_producto'] }})"
                                    class="inline-flex justify-center p-2 text-red-600 rounded-full cursor-pointer hover:bg-red-100 dark:text-red-500 dark:hover:bg-gray-600">
                                    <i class="fa-solid fa-trash"></i>
                                    <span class="sr-only">Eliminar</span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="bg-white dark:bg-gray-800">
                            <td colspan="6" class="px-2 py-1 text-center">
                                Aún no ha agregado ningún producto.
                            </td>
                        </tr>
                        @endif


                    </tbody>
                    <tfoot>

                        @php

                        $totalGeneral = 0;
                        $cantidadTotal = 0;

                        if (!empty($listaProductosAgregados)) {
                        foreach ($listaProductosAgregados as $prod) {
                        $totalGeneral += $prod['total'];
                        $cantidadTotal += $prod['cantidad_producto'];
                        }
                        }
                        @endphp

                        @if (!empty($listaProductosAgregados))
                        <tr class="font-semibold text-gray-900 dark:text-white">
                            <th scope="row" class="px-2 py-3 text-base">Total</th>
                            <td class="px-2 py-3">-----</td>
                            <td class="px-2 py-3">{{$cantidadTotal}}</td>
                            <td class="px-2 py-3">-----</td>
                            <td class="px-2 py-3"><span
                                    class="bg-green-600 text-white text-sm font-medium me-2 px-2.5 py-0.5 rounded">{{ "$
                                    ".number_format($totalGeneral, 0, ',', '.') }}</span>
                            </td>
                        </tr>

                        @endif
                    </tfoot>
                </table>
            </div>

        </div>
        <div>
            <div>
                <i class="text-green-600 fa-solid fa-truck-moving"></i> Inventario
            </div>
            <hr class="h-[2px] my-4 bg-green-600 border-0">
            <div class="mb-5 text-sm">
                INVENTARIO DISPONIBLE
            </div>

            <div
                class="p-4 mb-5 shadow-lg border-s dark:border-gray-700 dark:text-gray-400 sm:rounded-lg shadow-gray-900">
                <livewire:general.ordenes.lista-inventario>
            </div>
        </div>
    </div>

    <!-- Main modal -->
    <div id="modal-datos-productos" tabindex="-1" aria-hidden="true" wire:ignore.self
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{$producto ? $producto->descripcion : ''}}
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-datos-productos">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div
                    class="grid-cols-1 gap-4 p-4 mt-5 text-lg md:p-5 sm:grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">

                    <x-live-wire-input label="Precio Unitario + IVA" id="precio_unitario_con_iva"
                        icon="fa-solid fa-dollar-sign" model="precio_unitario_con_iva" placeholder="0" typeInput="text"
                        disabled='disabled'></x-live-wire-input>

                    <x-live-wire-input label="Stock disponible" id="stock_disponible" icon="fa-solid fa-cubes"
                        model="stock_disponible" placeholder="0" typeInput="text" disabled='disabled'>
                    </x-live-wire-input>

                    <x-live-wire-input label="Comisión" id="comision" icon="fa-solid fa-percent" model="comision"
                        placeholder="Comisión" typeInput="text" disabled>
                    </x-live-wire-input>

                    <x-live-wire-input label="Cantidad a agregar" id="stock_transferencia" icon="fa-solid fa-cubes"
                        model="stock_transferencia" placeholder="Cantidad a agregar" typeInput="number"
                        wire='validarStock' modelblur='validarStock'>
                    </x-live-wire-input>


                </div>

                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">

                    <button data-modal-hide="modal-datos-productos" type="button"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancelar</button>

                    <button type="button" wire:click='agregarListaProductos()'
                        class="ms-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirmar
                        <i class="fa-solid fa-circle-check"></i></button>

                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        const $targetEl = document.getElementById('modal-datos-productos');
            // instance options object
            const instanceOptions = {
            id: 'modal-datos-productos',
            override: true
            };
            const modal = new Modal($targetEl, instanceOptions);
            
        $wire.on('agregar', (e) => {
            
            $wire.dispatch('agregarProducto',{ id: e.id });

            modal.show();

        });

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
        
        $wire.on('mensajes', (e) => {
            
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
            icon: e.icon,
            title: e.message
            });

            if(e.state){
                modal.hide();
            }
        });

    </script>
    @endscript
</div>