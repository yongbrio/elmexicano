<div>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <div class="grid-cols-1 gap-4 mt-5 text-lg sm:grid sm:grid-cols-1">
        <div>
            <i class="text-green-600 fa-solid fa-cart-shopping"></i> Orden Ingreso No. <span
                class="font-semibold">{{$orden->id}}</span>
        </div>
        <hr class="h-[2px] my-2 bg-green-600 border-0">
        {{-- Nuevoooo --}}
        <div
            class="grid-cols-[1fr,2fr] gap-4 text-sm normal-case sm:grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-[1fr,2fr] ">
            {{-- accordion --}}
            <div wire:ignore.self class="" x-data="{ accordion: Alpine.store('accordion') }">
                <div x-data="accordion(1)" wire:ignore
                    class="p-4 mt-2 transition-all duration-700 bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-2xl dark:bg-gray-800 dark:border-gray-700 border-s shadow-gray-900">

                    <div class="flex mb-1">
                        <div class="flex w-full">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                <i class="text-green-600 fa-solid fa-users-line"></i>
                            </span>
                            <h5
                                class="content-center font-semibold tracking-tight text-gray-900 capitalize dark:text-white">
                                Cliente No.

                                <button type="button"
                                    class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{$datos->telefono}}</button>


                            </h5>
                        </div>
                        <div class="flex items-center justify-end w-full">
                            <span :class="handleRotate()" @click="handleClick()"
                                class="transition-transform duration-500 transform cursor-pointer fill-current">
                                <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <hr class="h-[2px] mt-0 mb-2 bg-green-600 border-0">
                    <div class="overflow-hidden transition-all duration-700 max-h-0" x-ref="tab"
                        :style="handleToggle()">
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Grupo:</strong>
                            {{$datos->grupo}}
                        </p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Nombre comercial:</strong>
                            {{($datos->nombre_comercial)}}</p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Nombre legal:</strong>
                            {{$datos->nombre_legal}}</p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>NIT:</strong>
                            {{$datos->nit}}</p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Sucursal:</strong>
                            {{$datos->sucursal}}
                        </p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Encargado:</strong>
                            {{$datos->nombre_encargado}}
                        </p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Correo:</strong>
                            {{$datos->correo}}
                        </p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Descripción:</strong>
                            {{$datos->descripcion}}
                        </p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Dirección:</strong>
                            {{$datos->direccion}}</p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Barrio/Localidad:</strong>
                            {{$datos->barrio_localidad}}</p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Ciudad:</strong>
                            {{$ciudad->nombre_municipio}}</p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Departamento:</strong>
                            {{$departamento->nombre_departamento}}
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Importancia:</strong>
                            {{$datos->importancia}}

                    </div>
                </div>
                <div x-data="accordion(2)" wire:ignore
                    class="p-4 mt-2 transition-all duration-700 bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-2xl dark:bg-gray-800 dark:border-gray-700 border-s shadow-gray-900">

                    <div class="flex mb-1">
                        <div class="flex w-full">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                <i class="text-green-600 fa-solid fa-gears"></i>
                            </span>
                            <h5
                                class="content-center font-semibold tracking-tight text-gray-900 capitalize dark:text-white">
                                Control</h5>
                        </div>
                        <div class="flex items-center justify-end w-full">
                            <span :class="handleRotate()" @click="handleClick()"
                                class="transition-transform duration-500 transform cursor-pointer fill-current">
                                <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <hr class="h-[2px] mt-0 mb-2 bg-green-600 border-0">
                    <div class="overflow-hidden transition-all duration-700 max-h-0" x-ref="tab"
                        :style="handleToggle()">
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Fecha de creación:</strong>
                            {{$fecha}}</p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Sucursal:</strong>
                            {{$nombre_sucursal}}</p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Usuario de
                                registro:</strong>
                            {{$nombre_registrado_por}}</p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Factura con:</strong>
                            {{$empresa_factura}}</p>
                    </div>
                </div>
                <div x-data="accordion(3)" wire:ignore.self
                    class="p-4 mt-2 transition-all duration-700 bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-2xl dark:bg-gray-800 dark:border-gray-700 border-s shadow-gray-900">
                    <div class="flex mb-1" wire:ignore>
                        <div class="flex w-full">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                <i class="text-green-600 fa-solid fa-comment"></i>
                            </span>
                            <h5
                                class="content-center font-semibold tracking-tight text-gray-900 capitalize dark:text-white">
                                Comentarios</h5>
                        </div>
                        <div class="flex items-center justify-end w-full">
                            <span :class="handleRotate()" @click="handleClick()"
                                class="transition-transform duration-500 transform cursor-pointer fill-current">
                                <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <hr class="h-[2px] mt-0 mb-2 bg-green-600 border-0">
                    <div class="overflow-hidden transition-all duration-700 max-h-0" x-ref="tab" :style="handleToggle()"
                        wire:ignore.self>
                        <div class="h-[140px] overflow-y-auto mt-2 rounded-lg"
                            x-data="{ scrollToBottom() { $el.scrollTop = $el.scrollHeight; } }" x-init="scrollToBottom">
                            @if ($historialComentarios)
                            @foreach ( $historialComentarios as $com )
                            <div class="p-1 mt-1 rounded-lg">
                                <div class="bg-gray-200 rounded-lg">
                                    <div class="flex justify-start ps-1">
                                        <span class="p-1 text-xs font-semibold text-blue-500 rounded-lg">
                                            {{$com->nombre}}
                                        </span>
                                    </div>
                                    <div class="pb-2 ps-1">
                                        {{$com->comentario}}
                                    </div>
                                </div>

                                <div class="flex justify-end mt-[-10px]">
                                    <span class="p-[2px] font-semibold text-white bg-blue-500 rounded-lg text-[12px]">
                                        {{$com->fecha}}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="flex items-end mt-5" x-data="{ isDisabled: true }"
                            x-on:click.away="isDisabled = true"
                            x-init="$watch('isDisabled', value => { if (!value) $refs.textarea.focus(); })">
                            <textarea id="comentario" rows="1" x-ref="textarea" :disabled="isDisabled"
                                wire:blur='registrarComentario' wire:model='comentario'
                                class="h-28 max-h-28 block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Registra un comentario...">
                            </textarea>
                            @if($misma_sucursal)
                            <button type="submit" @click="isDisabled = !isDisabled"
                                class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                                <i class="fa-solid fa-pen-to-square" wire:loading.remove></i>
                                <div wire:loading wire:target="registrarComentario">
                                    <i class="fa-solid fa-spinner fa-spin"></i>
                                </div>
                                <span class="sr-only">Editar</span>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div x-data="accordion(4)" wire:ignore
                    class="p-4 mt-2 transition-all duration-700 bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-2xl dark:bg-gray-800 dark:border-gray-700 border-s shadow-gray-900">
                    <div class="flex mb-1">
                        <div class="flex w-full">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                <i class="text-green-600 fa-solid fa-circle-dollar-to-slot"></i>
                            </span>
                            <h5
                                class="content-center font-semibold tracking-tight text-gray-900 capitalize dark:text-white">
                                Pagos</h5>
                        </div>
                        <div class="flex items-center justify-end w-full">
                            <span :class="handleRotate()" @click="handleClick()"
                                class="transition-transform duration-500 transform cursor-pointer fill-current">
                                <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <hr class="h-[2px] mt-0 mb-2 bg-green-600 border-0">
                    <div class="overflow-hidden transition-all duration-700 max-h-0" x-ref="tab"
                        :style="handleToggle()">
                        Hola soy los pagos
                    </div>
                </div>
            </div>

            <div>

                <div
                    class=" max-h-[392px] p-4 mt-2 mb-2 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 border-s shadow-gray-900">

                    <div class="flex mb-1">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                            <i class="text-green-600 fa-solid fa-truck-moving"></i>
                        </span>
                        <h5 class="content-center font-semibold tracking-tight text-gray-900 dark:text-white">
                            Inventario</h5>
                    </div>

                    <hr class="h-[2px] mt-0 mb-2 bg-green-600 border-0">

                    @if($misma_sucursal)

                    <div class="overflow-y-auto max-h-[312px] p-3">
                        <livewire:general.ordenes.lista-inventario>
                    </div>

                    @else
                    <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
                        role="alert">
                        <span class="font-medium">¡Atención!</span> La sucursal de esta orden es diferente a la
                        asignada
                        en tu perfil y no puedes realizar ninguna acción.
                    </div>
                    @endif


                </div>
                {{-- Items de la orden --}}
                <div
                    class="p-4 mt-2 mb-2 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 border-s shadow-gray-900">
                    <div class="flex justify-between">
                        <div class="flex mb-1">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                <i class="text-green-600 fa-solid fa-cart-arrow-down"></i>
                            </span>
                            <h5 class="content-center font-semibold tracking-tight text-gray-900 dark:text-white">
                                Items de la orden ({{count($listaProductosAgregados)}})</h5>
                        </div>
                    </div>

                    <hr class="h-[2px] mt-0 mb-2 bg-green-600 border-0">

                    @if ($listaProductosAgregados)

                    @foreach ($listaProductosAgregados as $productoLista )

                    <div class="flex justify-between">

                        <div class="flex items-center">

                            @if(!empty($productoLista['imagen']))

                            <img src='{{ route("admin.storage", ["modulo" => "productos", "filename" => basename($productoLista["imagen"])]) }}'
                                alt="Producto"
                                class="h-[60px] w-[60px] max-h-[60px] max-w-[60px] rounded object-contain">
                            @else
                            <img src="{{asset('images/imagen-defecto-producto.jpg')}}" alt="Producto"
                                class="h-[60px] w-[60px] max-h-[60px] max-w-[60px] rounded object-contain">
                            @endif

                            <div class="grid ml-4 place-content-start">
                                <p class="text-base font-semibold text-gray-800">{{$productoLista['descripcion']}}
                                    ({{$productoLista['cantidad_producto']}})</p>
                                <div class="flex flex-col capitalize place-items-start">
                                    <div class="flex items-center">
                                        <p class="text-gray-600">$ {{
                                            number_format($productoLista['precio_unitario_con_iva'], 0, ',', '.') }}</p>
                                        <p class="ml-2 text-gray-600">SKU: {{$productoLista['codigo_producto']}}</p>
                                        <div class="p-1 border rounded-lg ms-2">
                                            <button type="button" @if ($productoLista['cantidad_producto'] == 1 ) disabled @else wire:click='disminuirProductoLista({{ $productoLista["id_producto"] }})' @endif
                                                class="border-0 px-2.5 py-1.5 text-xs font-medium text-center text-gray-900 bg-white  border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <span>
                                                {{$productoLista['cantidad_producto']}}
                                            </span>
                                            <button type="button" wire:click='aumentarProductoLista({{$productoLista["id_producto"]}})'
                                                class="border-0 px-2.5 py-1.5 text-xs font-medium text-center text-gray-900 bg-white  border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="ms-2">
                                            <button type="button" title="Eliminar"
                                                wire:click="eliminarProductoLista({{ $productoLista['id_producto'] }})"
                                                class="inline-flex justify-center text-base text-red-600 rounded-full cursor-pointer hover:bg-red-100 dark:text-red-500 dark:hover:bg-gray-600">
                                                <i class="fa-solid fa-trash"></i>
                                                <span class="sr-only">Eliminar</span>
                                            </button>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="grid place-content-end text-end">
                                <p class="flex items-center justify-end text-base font-semibold text-gray-800">
                                    $ {{ number_format(($productoLista['precio_unitario_con_iva'] *
                                    $productoLista['cantidad_producto']),0,',','.')}}
                                </p>
                                <div class="flex {{-- flex-col --}} items-end capitalize place-items-start">
                                    <p class="text-gray-600">IVA (19%) - $ {{
                                        number_format((($productoLista['precio_unitario_con_iva'] -
                                        $productoLista['precio_unitario_sin_iva']) *
                                        $productoLista['cantidad_producto']),0,',','.')}}</p>
                                    <p class="ml-2 text-gray-600">Subtotal - $ {{
                                        number_format(($productoLista['precio_unitario_sin_iva'] *
                                        $productoLista['cantidad_producto']),0,',','.')}}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr class="h-[2px] my-2 bg-gray-200 border-0">
                    @endforeach


                    <div class="flex justify-end">
                        <div class="flex">

                            @php
                            $total = 0;
                            $ivaTotal = 0;
                            $subtotal = 0;
                            foreach ($listaProductosAgregados as $productoLista ){
                            $total += $productoLista['total'];
                            $ivaTotal += ($productoLista['precio_unitario_con_iva'] -
                            $productoLista['precio_unitario_sin_iva']) * $productoLista['cantidad_producto'];
                            $subtotal += $productoLista['precio_unitario_sin_iva'] *
                            $productoLista['cantidad_producto'];
                            }
                            @endphp

                            <div class="grid place-content-end text-end">
                                <p class="flex items-center justify-end text-base font-semibold text-gray-800">Total:
                                    $ {{ number_format($total,0,',','.')}}
                                </p>
                                <div class="flex items-end capitalize place-items-start">
                                    <p class="text-gray-600">IVA - $ {{number_format($ivaTotal,0,',','.')}}</p>
                                    <p class="ml-2 text-gray-600">Subtotal - $ {{number_format($subtotal,0,',','.')}}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif
                </div>


            </div>

        </div>
    </div>

    <!-- Main modal -->
    <div id="modal-datos-productos" tabindex="-1" aria-hidden="true" wire:ignore.self
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full z-[2000]">
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

                    <x-live-wire-input label="Precio Sin IVA" id="precio_unitario_sin_iva"
                        icon="fa-solid fa-dollar-sign" model="precio_unitario_sin_iva" placeholder="0" typeInput="text"
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
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Cancelar
                    </button>

                    <button type="button" wire:click='agregarListaProductos()'
                        class="ms-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirmar
                        <i class="fa-solid fa-circle-check"></i>
                    </button>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.store("accordion", {
                // Lista de índices abiertos. Aquí están todos abiertos por defecto (por ejemplo, del 1 al 3)
                openTabs: [1, 2, 3, 4] 
            });
        
            Alpine.data("accordion", (idx) => ({
                init() {
                    this.idx = idx;
                },
                idx: -1,
                handleClick() {
                    // Si el índice ya está abierto, lo eliminamos. Si no, lo añadimos al array.
                    if (this.$store.accordion.openTabs.includes(this.idx)) {
                        this.$store.accordion.openTabs = this.$store.accordion.openTabs.filter(tab => tab !== this.idx);
                    } else {
                        this.$store.accordion.openTabs.push(this.idx);
                    }
                },
                handleRotate() {
                    return this.$store.accordion.openTabs.includes(this.idx) ? "-rotate-180" : "";
                },
                handleToggle() {
                    return this.$store.accordion.openTabs.includes(this.idx)
                        ? `max-height: ${this.$refs.tab.scrollHeight}px`
                        : "";
                }
            }));

        });

    </script>

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