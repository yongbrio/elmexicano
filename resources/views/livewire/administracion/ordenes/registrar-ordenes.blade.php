<div class="">

    {{-- Inicio Productos --}}
    <div
        class="{{ $habilitarProducto ? 'block' : 'hidden' }} border-solid border-2 rounded border-gray-50 p-4 shadow-xl shadow-gray-400">
        <h1 class="py-1 text-xl font-medium"><i class="fa-solid fa-cart-plus"></i> Productos</h1>
        <div>
            <x-info-alert-component texto="Agrega los productos para iniciar el proceso de generación de la orden.">
            </x-info-alert-component>
        </div>

        <div>
            <div class="{{ !empty($listaProductosAgregados) ? 'flex' : 'hidden' }}  justify-end">
                <button type="button" data-modal-target="modal-lista-productos-agregados"
                    data-modal-toggle="modal-lista-productos-agregados"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <i class="fa-solid fa-eye"></i> Ver Productos Agregados</button>
            </div>

            <div>
                <x-select2 label="Sucursal Origen" id="sucursal_origen" icon="fa-solid fa-ruler-horizontal"
                    model="sucursal_origen" optionTextDefault="Seleccione la sucursal de origen"
                    wire="change=cambiarSucursal">
                </x-select2>
            </div>

            <x-live-wire-input label="Producto" id="producto_buscar" icon="fa-solid fa-location-dot"
                model="producto_buscar" placeholder="Buscar producto" typeInput="text" wire='buscarProducto'>
            </x-live-wire-input>

            <x-live-wire-input label="" id="id_producto" icon="" model="id_producto" placeholder="" typeInput="hidden">
            </x-live-wire-input>

            @if ($listaProductos)

            <ul class="max-w-md p-2 space-y-1 text-sm text-gray-500 list-disc list-inside dark:text-gray-400">
                @foreach ($listaProductos as $prod)
                <li class="cursor-pointer" wire:click='setearNombreProducto("{{$prod->id}}")'>
                    {{ $prod->codigo_producto.' - '. $prod->descripcion . ' - '.$prod->stock }}
                </li>
                @endforeach
            </ul>
            @endif

            @if ($id_producto)
            <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">

                <x-live-wire-input label="Precio + IVA" id="precio_unitario_con_iva" icon="fa-solid fa-cubes"
                    model="precio_unitario_con_iva" placeholder="Precio + IVA" typeInput="text" disabled='disabled'>
                </x-live-wire-input>

                <x-live-wire-input label="Stock disponible" id="stock_disponible_origen" icon="fa-solid fa-cubes"
                    model="stock_disponible_origen" placeholder="Stock Disponible" typeInput="text" disabled='disabled'>
                </x-live-wire-input>

                <x-live-wire-input label="Cantidad a agregar" id="stock_transferencia" icon="fa-solid fa-cubes"
                    model="stock_transferencia" placeholder="Cantidad a agregar" typeInput="text" wire='validarStock'
                    modelblur='validarStock'>
                </x-live-wire-input>
            </div>
            @endif
        </div>

        <div class="flex justify-end p-2">

            @if (!empty($listaProductosAgregados))
            <x-buttons-component tipoBoton='default' texto='Siguiente' icono='fa-solid fa-forward-step'
                wireAction='cambiar(2)'>
            </x-buttons-component>
            @endif

            @if (!empty(trim($stock_transferencia)))

            <x-buttons-component tipoBoton='green' texto='Agregar' icono='fa-solid fa-cart-plus'
                wireAction='agregarListaProductos'>
            </x-buttons-component>

            @endif

        </div>

    </div>
    {{-- Fin Productos --}}

    {{-- Inicio Cliente --}}
    <div
        class="{{ $habilitarCliente ? 'block' : 'hidden' }}  border-solid border-2 rounded border-gray-50 p-4 shadow-xl shadow-gray-400">
        <h1 class="py-1 text-xl font-medium"><i class="fa-solid fa-user-check"></i> Cliente</h1>
        <div>
            <x-info-alert-component texto="Diligencia y valida los datos del cliente.">
            </x-info-alert-component>
        </div>

        <x-live-wire-input label="Cliente" id="buscar_cliente" icon="fa-solid fa-location-dot" model="buscar_cliente"
            placeholder="Buscar Cliente" typeInput="text" wire='buscarCliente'>
        </x-live-wire-input>

        <x-live-wire-input label="" id="id_cliente" icon="" model="id_cliente" placeholder="" typeInput="hidden">
        </x-live-wire-input>

        @if ($listaClientes)
        <ul class="max-w-md p-2 space-y-1 text-sm text-gray-500 list-disc list-inside dark:text-gray-400">
            @foreach ($listaClientes as $cliente)
            <li class="cursor-pointer" wire:click='setearNombreCliente("{{$cliente->id}}")'>
                {{ $cliente->nombre_legal.' - '. $cliente->nit . ' - '.$cliente->telefono }}
            </li>
            @endforeach
        </ul>
        @endif

        <div class="flex justify-end p-2">

            <x-buttons-component tipoBoton='default' texto='Atrás' icono='fa-solid fa-backward-step'
                wireAction='cambiar(1)'>
            </x-buttons-component>
            @if ($id_cliente)
            <x-buttons-component tipoBoton='default' texto='Siguiente' icono='fa-solid fa-forward-step'
                wireAction='cambiar(3)'>
            </x-buttons-component>
            @endif
        </div>
    </div>
    {{-- Fin Cliente --}}

    <div
        class="{{ $habilitarInfoPago ? 'block' : 'hidden' }}  border-solid border-2 rounded border-gray-50 p-4 shadow-xl shadow-gray-400">
        <h1 class="py-1 text-xl font-medium"><i class="fa-solid fa-hand-holding-dollar"></i> Medio y forma de pago</h1>
        <div>
            <x-info-alert-component texto="Selecciona el método y la forma de pago.">
            </x-info-alert-component>
        </div>

        <div class="flex justify-end py-1 text-lg">
            <div>
                <div>
                    Valor total: $ {{number_format($valorTotalProductos, 0, ',', '.');}}
                </div>
                @if($forma_pago == 'pcont' )
                <div>
                    Valor pagado: $ {{number_format($valorTotalProductos, 0, ',', '.');}}
                </div>
                @endif

                @if($forma_pago == 'pcred' && $valorParcial)
                <div>
                    Valor parcial pagado: $ {{number_format($valorParcial, 0, ',', '.');}}
                </div>
                <div>
                    Valor restante: $ {{number_format($valorRestante, 0, ',', '.');}}
                </div>
                @endif
            </div>

        </div>

        <label for="medio_pago" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Medio de
            pago</label>
        <select id="medio_pago" wire:model='medio_pago' wire:change='medioPago'
            class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="" selected>Selecciona un medio de pago</option>
            <option value="ef">Efectivo</option>
            <option value="tc">Tarjeta de crédito</option>
            <option value="td">Tarjeta débito</option>
            <option value="tb">Transferencia bancaria</option>
        </select>

        <label for="forma_pago" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Forma de
            pago</label>
        <select id="forma_pago" wire:model='forma_pago' wire:change='formaPago'
            class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option selected>Selecciona una forma de pago</option>
            <option value="pcred">Pago a crédito</option>
            <option value="pcont">Pago de contado</option>
        </select>

        @if( $forma_pago == 'pcred')

        <x-live-wire-input label="Valor parcial pagado" id="valorParcial" icon="fa-solid fa-location-dot"
            model="valorParcial" wire='actualizarPagoTotal' placeholder="Valor parcial pagado" typeInput="text">
        </x-live-wire-input>

        @endif

        <div class="flex justify-end p-2">
            <x-buttons-component tipoBoton='default' texto='Atrás' icono='fa-solid fa-backward-step'
                wireAction='cambiar(2)'>
            </x-buttons-component>

            @if( !empty($medio_pago) && $medio_pago && $forma_pago )
            @if ($forma_pago == 'pcred' && $valorParcial )
            <x-buttons-component tipoBoton='green' texto='Generar Orden' icono='fa-solid fa-file-arrow-up'
                wireAction='guardarOrden'>
            </x-buttons-component>
            @elseif ($forma_pago =='pcont')
            <x-buttons-component tipoBoton='green' texto='Generar Orden' icono='fa-solid fa-file-arrow-up'
                wireAction='guardarOrden'>
            </x-buttons-component>
            @else

            @endif
            @endif
        </div>
    </div>
    <!-- Lista Productos Agregados modal -->
    <div id="modal-lista-productos-agregados" wire:ignore.self tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Lista Productos Agregados
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-lista-productos-agregados">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 space-y-4 text-sm md:p-5">

                    @if(!empty($listaProductosAgregados))

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Sucursal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Precio Unitario + IVA
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Acción</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($listaProductosAgregados as $index => $productos)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        {{$index+1}}
                                    </td>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$productos['producto_nombre']}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$productos['nombre_sucursal']}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$productos['precio_unitario_con_iva']}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$productos['cantidad_producto']}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$productos['total']}}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline"
                                            wire:click='eliminarProductoLista({{$index}})'>
                                            <i class="fa-solid fa-trash"></i> </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="flex justify-center">No hay productos agregados</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Lista Productos Agregados modal -->

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
        });





    </script>
    @endscript

</div>