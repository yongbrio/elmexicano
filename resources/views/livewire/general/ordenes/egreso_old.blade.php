<div>
    <div class="mt-5 text-lg">
        <div>

            <div>
                <i class="text-red-600 fa-solid fa-cart-shopping"></i> Orden Egreso No. <span
                    class="font-semibold">{{$orden->id}}</span>
                @if ($misma_sucursal)
                <button type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i
                        class="fa-solid fa-print"></i></button>
                @endif
            </div>

            <hr class="h-[2px] my-4 bg-red-600 border-0">

            <div class="mb-5 text-sm">
                DETALLE DE EGRESO
            </div>
            <div class="pl-4 mb-5">
                <ol
                    class="relative py-2 font-semibold text-gray-900 border-gray-200 shadow-lg border-s dark:border-gray-700 dark:text-gray-400 sm:rounded-lg shadow-gray-900">
                    <li class="mb-5 ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-red-900">
                            <i class="text-red-600 fa-solid fa-users-line"></i>
                        </span>
                        <h3 class="text-sm leading-tight mb-0.5"><span
                                class="bg-red-600 text-white text-sm font-medium me-2 px-2.5 py-0.5 rounded">{{$datos->nit}}</span>-
                            {{strtoupper($datos->nombre_comercial)}}</h3>
                        <p class="text-xs">{{strtoupper($datos->nombre_legal)}} (0)</p>
                    </li>
                    <li class="mb-5 ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <i class="text-red-600 fa-solid fa-paper-plane"></i>
                        </span>
                        <h3 class="text-sm leading-tight"><span class="font-semibold">{{$nombre_sucursal}}</span> -
                            {{strtoupper($datos->barrio_localidad)}} <span
                                class="italic">({{strtoupper($ciudad->nombre_municipio)." -
                                ".strtoupper($departamento->nombre_departamento)}})</span> </h3>
                        <p class="text-xs">{{strtoupper($datos->direccion)}}</p>
                    </li>
                    <li class="mb-8 ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <i class="text-red-600 fa-solid fa-gears"></i>
                        </span>
                        <h3 class="pt-2 text-sm leading-tight"><span class="text-semibold">{{$fecha}}</span> /
                            {{strtoupper($nombre_sucursal)}} / {{strtoupper($nombre_registrado_por)}} / EFECTIVO -
                            CONCILIADO </h3>
                        {{-- <p class="text-sm">Step details here</p> --}}
                    </li>
                    <li class="mb-5 ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <i class="text-red-600 fa-solid fa-comment"></i>
                        </span>
                        {{-- <h3 class="font-medium leading-tight">
                        </h3> --}}
                        <div class="flex pr-5" x-data="{ isDisabled: true }" x-on:click.away="isDisabled = true"
                            x-init="$watch('isDisabled', value => { if (!value) $refs.textarea.focus(); })">
                            <textarea id="comentario" rows="1" x-ref="textarea" :disabled="isDisabled"
                                wire:blur='registrarComentario' wire:model='comentario'
                                class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Registra un comentario..."></textarea>
                            @if ($misma_sucursal)
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
                        {{-- <p class="text-sm">Step details here</p> --}}
                    </li>

                    <li class="pr-2 mb-8 ms-6" x-data="main({{ $fileCount }})">

                        <span
                            class="absolute flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <i class="text-red-600 fa-solid fa-cloud-arrow-up"></i>
                        </span>
                        @if($misma_sucursal)
                        <h3 class="pt-2 text-sm leading-tight">COMPROBANTES</h3>
                        <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                        <div x-ref="fileContainer" wire:ignore>

                            <div class="flex justify-center w-full mb-2" id="containerUploadFile"
                                x-show="fileCount < 5">

                                <label
                                    class="p-2 text-sm text-white bg-green-600 rounded-lg cursor-pointer hover:bg-green-700"
                                    for="file_input1">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> Cargar Comprobante
                                </label>

                                <div id="blockFile1" wire:key="blockFile1">
                                    <div class="hidden" id="subBlockFile1">
                                        <input wire:model='archivos' wire:click='subirArchivo(1)'
                                            accept="image/jpeg, image/png, image/jpg, application/pdf"
                                            x-on:change="previewFile(event, 1)"
                                            class="hidden w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                            id="file_input1" type="file">
                                    </div>
                                </div>
                            </div>

                            <div x-show="fileCount === 5"
                                class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                                role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">¡Atención!</span> La máxima cantidad de archivos es 5.
                                </div>
                            </div>

                        </div>
                        @endif
                        @if(!empty($archivos_orden))
                        <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                        <label class="block mb-2 text-xs">Comprobantes Cargados
                        </label>
                        @foreach($archivos_orden as $archivo_orden)
                        <div id="blockFile{{$archivo_orden->id}}" wire:key="blockFile{{$archivo_orden->id}}">
                            <div class="flex mt-3" id="subBlockFile{{$archivo_orden->id}}">
                                <div class="flex w-full">
                                    <span
                                        class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 rounded-e-0 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                        @if (str_starts_with($archivo_orden->fileType, 'image/'))
                                        <i class="text-blue-600 fa-solid fa-image"></i>
                                        @elseif ( $archivo_orden->fileType === 'application/pdf')
                                        <i class="text-red-600 fa-solid fa-file-pdf"></i>
                                        @endif
                                    </span>
                                    <input disabled type="text" id="showFile{{$archivo_orden->id}}"
                                        value='{{$archivo_orden->nombre_original}}'
                                        class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Nombre Archivo">
                                </div>
                                @if($misma_sucursal)
                                <button type="button" x-on:click='eliminarInputFile("blockFile{{$archivo_orden->id}}")'
                                    wire:click='eliminarArchivo("{{$archivo_orden->id}}")'
                                    class="inline-flex justify-center p-2 text-red-600 rounded-full cursor-pointer hover:bg-red-100 dark:text-red-500 dark:hover:bg-gray-600">
                                    <i class="fa-solid fa-trash"></i>
                                    <span class="sr-only">Eliminar</span>
                                </button>
                                @endif
                                <button id="btnPreview{{$archivo_orden->id}}"
                                    data-file-url="{{ route('admin.storage', ['modulo'=> 'egresos', 'filename' => $archivo_orden->nombre]) }}"
                                    data-file-type="{{$archivo_orden->fileType}}" type="button"
                                    x-on:click='modalPreview("{{$archivo_orden->id}}")'
                                    data-modal-target="modal-preview-soporte" data-modal-toggle="modal-preview-soporte"
                                    class='inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600'>
                                    <i class="fa-solid fa-eye"></i>
                                    <span class="sr-only">Ver</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </li>


                </ol>
            </div>



        </div>

        <div class="grid-cols-1 gap-4 mt-5 text-lg sm:grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2">
            <div>
                <div>
                    <i class="text-red-600 fa-solid fa-bars"></i> Detalle
                </div>
                <hr class="h-[2px] my-4 bg-red-600 border-0">
                <div class="relative overflow-x-auto shadow-lg sm:rounded-lg shadow-gray-900">
                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                        <thead class="text-gray-700 bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-2 py-3 rounded-s-lg">
                                    C1
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    C2
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

                            @if (!empty($listaEgresosAgregados))
                            @foreach ($listaEgresosAgregados as $index => $egreso)
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row"
                                    class="px-2 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $egreso['categoria_1'] }}
                                </th>
                                <td class="px-2 py-1">
                                    {{ $egreso['categoria_2'] }}
                                </td>
                                <td class="px-2 py-1">
                                    {{ $egreso['descripcion'] }}
                                </td>
                                <td class="px-2 py-1">
                                    {{ $egreso['cantidad_egreso'] }}
                                </td>
                                <td class="px-2 py-1">
                                    {{ "$ ".number_format($egreso['precio_unitario_con_iva'], 0, ',', '.') }}
                                </td>
                                <td class="px-2.5 py-1">
                                    {{ "$ ".number_format($egreso['total'], 0, ',', '.') }}
                                </td>
                                <td class="px-2.5 py-1">
                                    @if($misma_sucursal)
                                    <button type="button"
                                        wire:click="eliminarEgresoLista({{ $egreso['id_egreso'] }},{{$index}})"
                                        class="inline-flex justify-center p-2 text-red-600 rounded-full cursor-pointer hover:bg-red-100 dark:text-red-500 dark:hover:bg-gray-600">
                                        <i class="fa-solid fa-trash"></i>
                                        <span class="sr-only">Eliminar</span>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="bg-white dark:bg-gray-800">
                                <td colspan="6" class="px-2 py-1 text-center">
                                    Aún no ha agregado ningún egreso.
                                </td>
                            </tr>
                            @endif


                        </tbody>
                        <tfoot>

                            @php

                            $totalGeneral = 0;
                            $cantidadTotal = 0;

                            if (!empty($listaEgresosAgregados)) {
                            foreach ($listaEgresosAgregados as $egre) {
                            $totalGeneral += $egre['total'];
                            $cantidadTotal += $egre['cantidad_egreso'];
                            }
                            }
                            @endphp

                            @if (!empty($listaEgresosAgregados))
                            <tr class="font-semibold text-gray-900 dark:text-white">
                                <th scope="row" class="px-2 py-3 text-base">Total</th>
                                <td class="px-2 py-3 text-center">-----</td>
                                <td class="px-2 py-3 text-center">-----</td>
                                <td class="px-2 py-3">{{$cantidadTotal}}</td>
                                <td class="px-2 py-3 text-center">-----</td>
                                <td class="px-2 py-3"><span
                                        class="bg-red-600 text-white text-sm font-medium me-2 px-2.5 py-0.5 rounded">{{
                                        "$
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
                    <i class="text-red-600 fa-solid fa-file-invoice-dollar"></i> CATALOGO DE EGRESOS
                </div>
                <hr class="h-[2px] my-4 bg-red-600 border-0">
                <div
                    class="p-4 mb-5 shadow-lg border-s dark:border-gray-700 dark:text-gray-400 sm:rounded-lg shadow-gray-900">
                    @if ($misma_sucursal)
                    <livewire:general.ordenes.lista-egresos>
                        @else
                        <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
                            role="alert">
                            <span class="font-medium">¡Atención!</span> La sucursal de esta orden es diferente a la
                            asignada
                            en tu perfil y no puedes realizar ninguna acción.
                        </div>

                        @endif
                </div>
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
                        {{$egresos ? $egresos->codigo_egreso ." - " .$egresos->descripcion_egreso : ''}}
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

                    <x-live-wire-input label="Categoría 1" id="categoria_1" icon="fa-solid fa-cubes" model="categoria_1"
                        placeholder="Categoría 1" typeInput="text" disabled='disabled'>
                    </x-live-wire-input>

                    <x-live-wire-input label="Categoría 2" id="categoria_2" icon="fa-solid fa-percent"
                        model="categoria_2" placeholder="Categoría 2" typeInput="text" disabled='disabled'>
                    </x-live-wire-input>

                    <x-select2 x-model="tipoSeleccionado" wire="change=asignarPorcentaje" label="Tipo de afectación"
                        id="tipo" icon="fa-solid fa-percent" model="tipo"
                        optionTextDefault="Seleccione Tipo de Impuesto"> </x-select2>

                    <x-live-wire-input label="Impuesto (%)" id="impuesto" icon="fa-solid fa-file-invoice-dollar"
                        model="impuesto" placeholder="0" typeInput="text" disabled="disabled"></x-live-wire-input>

                    <x-live-wire-input label="Precio (con IVA)" id="precio_unitario_con_iva"
                        icon="fa-solid fa-dollar-sign" placeholder="0" typeInput="number" wire="validarTipoAfectacion"
                        model="precio_unitario_con_iva">
                    </x-live-wire-input>

                    <x-live-wire-input label="Precio (sin IVA)" id="precio_unitario_sin_iva"
                        icon="fa-solid fa-dollar-sign" model="precio_unitario_sin_iva" placeholder="0"
                        typeInput="number" disabled="disabled"></x-live-wire-input>
                    {{--
                    <x-live-wire-input label="Precio Unitario + IVA" id="precio_unitario_con_iva"
                        icon="fa-solid fa-dollar-sign" model="precio_unitario_con_iva" placeholder="0" typeInput="text"
                        wire='validarPrecioUnitario' modelblur='validarPrecioUnitario'>
                    </x-live-wire-input> --}}

                    <x-live-wire-input label="Cantidad a agregar" id="stock_transferencia" icon="fa-solid fa-cubes"
                        model="stock_transferencia" placeholder="Cantidad a agregar" typeInput="number"
                        wire='validarCantidadAgregar' modelblur='validarCantidadAgregar'>
                    </x-live-wire-input>

                </div>

                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">

                    <button data-modal-hide="modal-datos-productos" type="button"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancelar</button>

                    <button type="button" wire:click='agregarListaEgresos()'
                        class="ms-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirmar
                        <i class="fa-solid fa-circle-check"></i></button>

                </div>
            </div>
        </div>
    </div>

    <div id="modal-preview-soporte" tabindex="-1" aria-hidden="true" wire:ignore.self
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Vista previa Comprobante
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg cerrarModal hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-preview-soporte">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="flex justify-center" id="bodyPreview">
                </div>
                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                    <button data-modal-hide="modal-preview-soporte" type="button"
                        class="cerrarModal py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:loading wire:target="archivos">
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center w-full h-full overflow-x-hidden overflow-y-auto bg-black bg-opacity-40"
            aria-modal="true" role="dialog">
            <div class="relative w-full max-w-2xl max-h-full p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal content -->
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Subiendo archivo...
                    </h3>
                </div>
                <!-- Modal body -->
                <div class="p-4 space-y-4 md:p-5">
                    <div class="text-center">
                        <i class="text-blue-600 fa-xl fa-solid fa-cloud-arrow-up fa-beat-fade"></i>
                        <h2 class="mt-4 text-zinc-900 dark:text-white">Cargando...</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Función para inicializar el modal
            function initializeModal() {
            const $targetEl2 = document.getElementById('modal-preview-soporte');   
            const instanceOptions2 = {
                    id: 'modal-preview-soporte',
                    override: true
                };
                const modal2 = new Modal($targetEl2, instanceOptions2);
                    
                const closeModalBtns = document.querySelectorAll('.cerrarModal');

                closeModalBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        if (modal2) {
                            modal2.hide();
                            // Esperar un poco para asegurarse de que el modal se ha cerrado
                            setTimeout(() => {
                                const backdrop = document.querySelector('[modal-backdrop]');
                                if (backdrop) {
                                    backdrop.remove();
                                }
                            }, 300);
                        }
                    });
                });
                    
                return modal2;
            }

            // Inicializar el modal
            let modal2 = initializeModal();
        });

        //Alpine JS
        function main(count) {
            return {
                fileCount: count,
                maxFiles: 5,
                eliminarInputFile(id){
                   const input = document.getElementById(id);
                   if(input){
                    input.remove();
                    this.fileCount--;
                   } 
                },
                previewFile(event, id) {
                    if (this.fileCount < this.maxFiles) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            const self = this;  // Guardamos el contexto de `this`
                            reader.onload = function(e) {       
                                const fileInput = document.getElementById(`file_input${id}`);
                                fileInput.value='';
                                self.fileCount++;
                            };
                            reader.readAsDataURL(file);
                        } else {
                            previewDiv.innerHTML = ''; // Clear preview if no file
                        }
                    }
                }
            };
        }
        
        function modalPreview(id){
            
            let button = document.querySelector(`#btnPreview${id}[data-file-url]`);
            const fileURL = button.getAttribute('data-file-url');
            button = document.querySelector(`#btnPreview${id}[data-file-type]`);
            const fileType = button.getAttribute('data-file-type');
            let modal2 = initializeModal();
            const modalBody = document.getElementById('bodyPreview');
            modalBody.innerHTML='';
            if (fileType === 'application/pdf') {
            // Mostrar vista previa del PDF
            modalBody.appendChild(showLoadingIndicator());
            // Crear el iframe
            const iframe = document.createElement('iframe');
            iframe.src = fileURL; // Establecer la URL del archivo
            iframe.width = '100%'; // Ancho del iframe
            iframe.height = '500px'; // Alto del iframe
            iframe.style.border = 'none'; // Opcional: eliminar borde
            // Agregar evento load al iframe
            iframe.addEventListener('load', () => {
                console.log('Iframe has fully loaded.');
                let loader = modalBody.querySelector('#cargaArchivoContainer');
                if(loader){
                    loader.remove();
                }
                
            });
            
            modalBody.appendChild(iframe);
            
            } else if (fileType.startsWith('image/')) {
                
                const img = document.createElement('img');
                img.src = fileURL;
                img.className = 'h-full w-full p-2';
                modalBody.innerHTML = '';
                modalBody.appendChild(img);
                
            }

            modal2.show();

        }
        
        // Función para inicializar el modal
        function initializeModal() {
            const $targetEl2 = document.getElementById('modal-preview-soporte');   
            const instanceOptions2 = {
                id: 'modal-preview-soporte',
                override: true
            };
            const modal2 = new Modal($targetEl2, instanceOptions2);
                
            const closeModalBtns = document.querySelectorAll('.cerrarModal');

            closeModalBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (modal2) {
                        modal2.hide();
                        // Esperar un poco para asegurarse de que el modal se ha cerrado
                        setTimeout(() => {
                            const backdrop = document.querySelector('[modal-backdrop]');
                            if (backdrop) {
                                backdrop.remove();
                            }
                        }, 300);
                    }
                });
            });
                
            return modal2;
        }

        function showLoadingIndicator() {
            // Crear el contenedor principal
            const container = document.createElement('div');
            container.className = 'absolute inset-0 flex items-center justify-center bg-gray-400 bg-opacity-50';
            container.id = 'cargaArchivoContainer';

            // Crear el contenido de carga
            const content = document.createElement('div');
            content.className = 'text-center p-4 space-y-4 md:p-5';

            // Crear el ícono de carga
            const icon = document.createElement('i');
            icon.className = 'text-red-600 fa-xl fa-solid fa-file-pdf fa-bounce';

            // Crear el título
            const title = document.createElement('h2');
            title.className = 'mt-4 text-zinc-50';
            title.textContent = 'Cargando vista del archivo';

            // Añadir el ícono y el título al contenido
            content.appendChild(icon);
            content.appendChild(title);

            // Añadir el contenido al contenedor
            container.appendChild(content);

            // Devolver el contenedor completo
            return container;
        }

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