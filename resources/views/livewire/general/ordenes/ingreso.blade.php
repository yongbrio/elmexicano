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
            class="grid grid-cols-1 gap-4 text-sm normal-case sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-[35%,65%] mx-4">

            {{-- accordion --}}
            <div wire:ignore.self class="" x-data="{ accordion: Alpine.store('accordion') }">
                <div x-data="accordion(1)" x-init="init()" @destroy.window="destroy()" wire:ignore
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
                        <div class="flex items-center justify-end">
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
                <div x-data="accordion(2)" x-init="init()" @destroy.window="destroy()" wire:ignore.self
                    class="p-4 mt-2 transition-all duration-700 bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-2xl dark:bg-gray-800 dark:border-gray-700 border-s shadow-gray-900">

                    <div class="flex mb-1">
                        <div class="flex w-full">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                <i class="text-green-600 fa-solid fa-gears"></i>
                            </span>
                            <h5 class="content-center font-semibold tracking-tight text-gray-900 dark:text-white">
                                Control - {!!$this->darStatusEnvio($estado_envio)!!}</h5>
                        </div>
                        <div class="flex items-center justify-end" wire:ignore>
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
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Fecha de creación:</strong>
                            {{$fecha}}</p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Sucursal:</strong>
                            {{$nombre_sucursal}}</p>
                        <p class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Usuario de
                                registro:</strong>
                            {{$nombre_registrado_por}}</p>
                        <p class="mb-2 font-normal text-gray-800 dark:text-gray-400"><strong>Factura con:</strong>
                            {{$empresa_factura}}</p>
                        <div class="block">
                            <div class="block">
                                <label for="estado_despacho"
                                    class="mb-1 font-normal text-gray-800 dark:text-gray-400"><strong>Estado de
                                        envío</strong></label>
                                @if (($orden->estado_envio != 2 && empty($orden->adjuntos_envios)))
                                <select id="estado_despacho" wire:change='estadoEnvio()' wire:model='estado_envio'
                                    x-init="updateHeight()"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="0" selected>Por despachar</option>
                                    <option value="1">Despachado</option>
                                    <option value="2">Conciliado</option>
                                </select>
                                @endif
                            </div>

                            @if ($mostrar_adjunto_envio && $orden->estado_envio != 2 && empty($orden->adjuntos_envios)
                            )
                            <div x-init="updateHeight()">
                                <div class="flex justify-center w-full mb-2 align-end" id="containerUploadFile">
                                    <div class="mb-2">
                                        <label for="input_adjunto_envio"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargar
                                            comprobante</label>
                                        <label
                                            class="block p-2 text-sm text-white bg-green-600 rounded-lg cursor-pointer hover:bg-green-700"
                                            for="input_adjunto_envio">
                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                            Cargar comprobante
                                        </label>

                                        <div id="">
                                            <div class="hidden" id="">
                                                <input wire:model='archivos_envio' wire:click='subirArchivo()'
                                                    accept="image/jpeg, image/png, image/jpg, application/pdf"
                                                    class="hidden w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                    id="input_adjunto_envio" type="file">
                                            </div>
                                        </div>
                                        @error('archivos_envio')
                                        <span x-init="updateHeight()" class="text-xs text-red-500">{{ $message
                                            }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @elseif($enviar_conciliar || $orden->estado_envio == 3)
                            <div x-init="updateHeight()" class="mt-2">
                                <div class="relative w-full overflow-auto shadow-md max-h-80 sm:rounded-lg">
                                    <table
                                        class="w-full min-w-full overflow-auto text-sm text-left text-gray-500 border border-gray-200 rtl:text-right dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Fecha Comprobante
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Nombre comprobante
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr x-init="updateHeight()"
                                                class="text-xs border-b odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                                                <td class="px-6 py-4">
                                                    {{$adjuntos_envios->fecha}}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex w-24 truncate"
                                                        title="{{$adjuntos_envios->nombre_original}}">
                                                        @if (str_starts_with($adjuntos_envios->fileType,
                                                        'image/'))
                                                        <i class="text-blue-600 fa-solid fa-image"></i>
                                                        @elseif ( $adjuntos_envios->fileType ===
                                                        'application/pdf')
                                                        <i class="text-red-600 fa-solid fa-file-pdf"></i>
                                                        @endif
                                                        {{$adjuntos_envios->nombre_original}}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="d-flex">
                                                        @if($misma_sucursal)
                                                        @if ($orden->estado_envio == 2)
                                                        <button type="button" wire:click='eliminarArchivoEnvio()'
                                                            class="inline-flex justify-center p-2 text-red-600 rounded-full cursor-pointer hover:bg-red-100 dark:text-red-500 dark:hover:bg-gray-600">
                                                            <i class="fa-solid fa-trash"></i>
                                                            <span class="sr-only">Eliminar</span>
                                                        </button>
                                                        @endif
                                                        @endif
                                                        <button id="btnPreview_envio{{$adjuntos_envios->id}}"
                                                            data-file-url="{{route('admin.storage', ['modulo'=> 'ingresos', 'filename' => $adjuntos_envios->nombre]) }}"
                                                            data-file-type="{{$adjuntos_envios->fileType}}"
                                                            type="button"
                                                            x-on:click='modalPreview("{{$adjuntos_envios->id}}","envio")'
                                                            data-modal-target="modal-preview-soporte"
                                                            data-modal-toggle="modal-preview-soporte"
                                                            class='inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600'>
                                                            <i class="fa-solid fa-eye"></i>
                                                            <span class="sr-only">Ver</span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                @if ($estado_envio != 3)
                                <div class="flex justify-center mt-2" x-init="updateHeight()">
                                    <button type="button" wire:click='conciliarEnvio()'
                                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><i
                                            class="fa-solid fa-check"></i> Conciliar</button>
                                </div>
                                @endif
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div x-data="accordion(3)" x-init="init()" @destroy.window="destroy()" wire:ignore.self
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
                        <div class="flex items-center justify-end">
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
                        <div class="max-h-[140px] overflow-y-auto mt-2 rounded-lg"
                            x-data="{ scrollToBottom() { $el.scrollTop = $el.scrollHeight; } }" x-init="scrollToBottom">
                            @if ($historialComentarios)
                            @foreach ( $historialComentarios as $com )
                            <div class="p-1 mt-1 rounded-lg" x-init="updateHeight()">
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
                <div x-data="accordion(4)" x-init="init()" @destroy.window="destroy()" wire:ignore.self
                    class="p-4 mt-2 transition-all duration-700 bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-2xl dark:bg-gray-800 dark:border-gray-700 border-s shadow-gray-900">
                    <div class="flex mb-1">
                        <div class="flex w-full">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                <i class="text-green-600 fa-solid fa-circle-dollar-to-slot"></i>
                            </span>
                            <h5
                                class="content-center font-semibold tracking-tight text-gray-900 capitalize dark:text-white">
                                Pagos {!! $estadoOrden !!}
                            </h5>
                        </div>
                        <div class="flex items-center justify-end" wire:ignore>
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

                        @if ($listaProductosAgregados)
                        {{-- Mostramos el contenido siempre y cuando existan productos agregados a la lista --}}
                        @if (!empty($orden->forma_pago) && !$aplicar_pago )
                        {{-- Begin:Tabla de pagos registrados --}}
                        <div class="w-full p-2 mx-auto" x-init="updateHeight()">
                            <div class="relative overflow-auto shadow-md max-h-80 sm:rounded-lg">
                                <table
                                    class="w-full min-w-full text-sm text-left text-gray-500 border border-gray-200 rtl:text-right dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Monto
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Medio pago
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Fecha Pago
                                            </th>
                                            @if ($orden->forma_pago !=='efectivo')
                                            <th scope="col" class="px-6 py-3">
                                                Nombre comprobante
                                            </th>
                                            @endif

                                            <th scope="col" class="px-6 py-3">
                                                Usuario registro
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($archivos_orden) && isset($pagoOrdenes) && $orden->forma_pago
                                        !=='efectivo')
                                        @foreach($archivos_orden as $archivo_orden)
                                        @if ($pagoOrdenes->id === $archivo_orden->id_pago_ordenes)
                                        <tr x-init="updateHeight()"
                                            class="text-xs border-b odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                $ {{ number_format($pagoOrdenes->monto, 0, ',', '.') }}
                                            </th>
                                            <td class="px-6 py-4">
                                                @php
                                                $mediosPago = [
                                                "banco"=>"Banco",
                                                "efectivo"=>"Efectivo",
                                                "credito"=>"Crédito"
                                                ];
                                                $medioSeleccionado = $mediosPago[$pagoOrdenes->nombre_forma_pago]
                                                @endphp
                                                {{$medioSeleccionado}}

                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                $fechaFormateada = date('d-m-Y', $pagoOrdenes->fecha);
                                                @endphp
                                                {{$fechaFormateada}}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex w-24 truncate"
                                                    title="{{$archivo_orden->nombre_original}}">
                                                    @if (str_starts_with($archivo_orden->fileType,
                                                    'image/'))
                                                    <i class="text-blue-600 fa-solid fa-image"></i>
                                                    @elseif ( $archivo_orden->fileType ===
                                                    'application/pdf')
                                                    <i class="text-red-600 fa-solid fa-file-pdf"></i>
                                                    @endif
                                                    {{$archivo_orden->nombre_original}}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$nombre_registrado_por}}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex">
                                                    @if($misma_sucursal)
                                                    @if (!$ordenCerrada)
                                                    <button type="button"
                                                        wire:click='eliminarArchivo("{{$archivo_orden->id}}","{{$pagoOrdenes->id}}")'
                                                        class="inline-flex justify-center p-2 text-red-600 rounded-full cursor-pointer hover:bg-red-100 dark:text-red-500 dark:hover:bg-gray-600">
                                                        <i class="fa-solid fa-trash"></i>
                                                        <span class="sr-only">Eliminar</span>
                                                    </button>
                                                    @endif

                                                    @endif
                                                    <button id="btnPreview_pago{{$archivo_orden->id}}"
                                                        data-file-url="{{ route('admin.storage', ['modulo'=> 'ingresos', 'filename' => $archivo_orden->nombre]) }}"
                                                        data-file-type="{{$archivo_orden->fileType}}" type="button"
                                                        x-on:click='modalPreview("{{$archivo_orden->id}}","pago")'
                                                        data-modal-target="modal-preview-soporte"
                                                        data-modal-toggle="modal-preview-soporte"
                                                        class='inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600'>
                                                        <i class="fa-solid fa-eye"></i>
                                                        <span class="sr-only">Ver</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @elseif(isset($pagoOrdenes) && $orden->forma_pago === 'efectivo')
                                        <tr x-init="updateHeight()"
                                            class="text-xs border-b odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                $ {{ number_format($valor_total_orden, 0, ',', '.') }}
                                            </th>
                                            <td class="px-6 py-4">
                                                Efectivo
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                $fechaFormateada = date('d-m-Y', $pagoOrdenes->fecha);
                                                @endphp
                                                {{$fechaFormateada}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$nombre_registrado_por}}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex">
                                                    @if($misma_sucursal)
                                                    @if (!$ordenCerrada)
                                                    <button type="button"
                                                        wire:click='eliminarPagoEfectivo("{{$orden->id}}","{{$pagoOrdenes->id}}")'
                                                        class="inline-flex justify-center p-2 text-red-600 rounded-full cursor-pointer hover:bg-red-100 dark:text-red-500 dark:hover:bg-gray-600">
                                                        <i class="fa-solid fa-trash"></i>
                                                        <span class="sr-only">Eliminar</span>
                                                    </button>
                                                    @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- End:Tabla de pagos registrados --}}
                        @endif
                        @if($orden->forma_pago !== '')
                        {{-- Begin:Mostrar botón de cerrar Orden --}}
                        @if ($orden->estado_orden != 2 && $orden->estado_orden != 3 && $orden->forma_pago !== 'banco')
                        <div class="flex flex-col text-center" x-init="updateHeight()">
                            <div class="flex justify-center">
                                <button type="button" wire:click='cerrarOrden()'
                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    <i class="fa-solid fa-lock"></i> Validar orden
                                </button>
                            </div>
                        </div>
                        @elseif($orden->estado_orden == 3 && !$aplicar_pago)
                        <div class="flex flex-col text-center" x-init="updateHeight()">
                            <div class="flex justify-center">
                                <button type="button" wire:click='aplicarPago()'
                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    <i class="fa-solid fa-sack-dollar"></i> Aplicar pago
                                </button>
                            </div>
                        </div>
                        @endif

                        {{-- End:Mostrar botón de cerrar Orden --}}
                        @endif

                        @if(empty($archivos_orden) || $aplicar_pago)
                        {{-- Begin:Mostrar si existen pagos registrados --}}
                        <div class="flex flex-col text-center">

                            @if (empty($orden->forma_pago))
                            {{-- Begin: Mostramos siempre y cuando no haya ningún pago registrado --}}
                            <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
                                role="alert">
                                <i class="fa-solid fa-circle-info"></i> Al agregar un pago no se podrán agregar más
                                productos.
                            </div>
                            {{-- End: Mostramos siempre y cuando no haya ningún pago registrado --}}
                            @endif

                            <div class="flex justify-center">
                                @if($orden->forma_pago === '')
                                {{-- Begin: Mostramos el botón para agregar un nuevo pago --}}
                                @if(!$opcionesPagoActivado && !$aplicar_pago)
                                {{-- Begin: Ocultamos el botón si se dió clic en este botón --}}
                                <button type="button" wire:click="mostrarOpcionesPago()"
                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    Agregar pago
                                </button>
                                {{-- End: Ocultamos el botón si se dió clic en este botón --}}
                                @endif
                                {{-- End: Mostramos el botón para agregar un nuevo pago --}}
                                @endif
                                @if ($opcionesPagoActivado || $aplicar_pago)
                                {{-- Begin: Mostramos el contenido --}}
                                <div x-init="updateHeight()">
                                    <div class="w-full mx-auto">
                                        @php
                                        $clase = 'sm:grid-cols-2';
                                        if($forma_pago === ''){
                                        $clase = 'sm:grid-cols-1';
                                        }
                                        @endphp
                                        <div class="grid-cols-1 gap-1 mt-5 text-lg sm:grid {{ $clase }}">
                                            @if ($orden->forma_pago !== 'credito' || $aplicar_pago)
                                            {{-- Begin: si el medio de pago es crédito no es necesario mostrar la forma
                                            de pago --}}
                                            <div>
                                                <label for="forma-pago"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Forma
                                                    de pago</label>

                                                <select id="forma-pago" wire:model='forma_pago'
                                                    wire:change='asignarFormaPago($event.target.value)'
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option value="" selected>Forma de pago</option>
                                                    <option value="efectivo">Efectivo</option>
                                                    <option value="banco">Banco</option>
                                                    @if (!$aplicar_pago)
                                                    <option value="credito">Crédito</option>
                                                    @endif

                                                </select>

                                            </div>
                                            {{-- End: si el medio de pago es crédito no es necesario mostrar la forma de
                                            pago --}}
                                            @endif
                                            @if ($forma_pago !== '')
                                            @if ($forma_pago === 'banco')
                                            <div x-init="updateHeight()">
                                                <label for="fecha-pago"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                                                <input type="date" wire:model='fecha_pago' id="fecha-pago"
                                                    aria-label="fecha pago"
                                                    class="mb-2 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    value="{{date('Y-m-d')}}">
                                                @error('fecha_pago')
                                                <span x-init="updateHeight()" class="text-xs text-red-500">{{ $message
                                                    }}</span>
                                                @enderror
                                            </div>

                                            @if ($forma_pago === 'banco')
                                            <div>
                                                <label for="seleccion_banco"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cuenta
                                                    de Banco</label>

                                                <select id="seleccion_banco" wire:model='seleccion_banco'
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option value="" selected>Seleccionar Banco</option>
                                                    @if (isset($datos_cuentas_banco))
                                                    @foreach ($datos_cuentas_banco as $cuenta_banco)
                                                    <option value="{{$cuenta_banco->id}}">{{$cuenta_banco->nombre_banco.
                                                        " - ".$cuenta_banco->numero_cuenta}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>

                                                @error('seleccion_banco')
                                                <span x-init="updateHeight()" class="text-xs text-red-500">{{ $message
                                                    }}</span>
                                                @enderror

                                            </div>
                                            @endif

                                            @elseif ($forma_pago === 'credito')
                                            <div>
                                                <label for="plazo_pago"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plazo
                                                    de pago</label>
                                                <select id="plazo_pago" wire:model='plazo_pago'
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option value="" selected>Elige una opción</option>
                                                    <option value="7">1 semana (7 días)</option>
                                                    <option value="15">2 semanas (15 días)</option>
                                                    <option value="30">4 semanas (30 días)</option>
                                                </select>
                                                @error('plazo_pago')
                                                <span x-init="updateHeight()" class="text-xs text-red-500">{{ $message
                                                    }}</span>
                                                @enderror
                                            </div>
                                            @endif

                                            @if ((empty($archivos_orden) && ($forma_pago !== 'efectivo'))
                                            ||($forma_pago !== 'efectivo' && $aplicar_pago) )
                                            <div x-init="updateHeight()">
                                                <div class="flex justify-center w-full mb-2 align-end"
                                                    id="containerUploadFile">
                                                    <div class="mb-6">
                                                        @php
                                                        $texto_comprobante = "Cargar comprobante";
                                                        if($forma_pago == 'credito'){
                                                        $texto_comprobante = "Cargar comprobante entrega";
                                                        }
                                                        @endphp

                                                        <label for="file_input1"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{$texto_comprobante}}</label>
                                                        <label
                                                            class="block p-2 text-sm text-white bg-green-600 rounded-lg cursor-pointer hover:bg-green-700"
                                                            for="file_input1">
                                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                                            {{$texto_comprobante}}
                                                        </label>

                                                        <div id="blockFile1">
                                                            <div class="hidden" id="subBlockFile1">
                                                                <input wire:model='archivos' wire:click='subirArchivo()'
                                                                    accept="image/jpeg, image/png, image/jpg, application/pdf"
                                                                    class="hidden w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                                    id="file_input1" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @elseif ((empty($archivos_orden) && ($forma_pago === 'efectivo'))
                                            ||($forma_pago === 'efectivo' && $aplicar_pago) )
                                            <div x-init="updateHeight()">
                                                <label for="confirmar_pago_efectivo_btn"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmar
                                                    pago</label>
                                                <button type="button" id="confirmar_pago_efectivo_btn"
                                                    wire:click='confirmarPagoEfectivo()'
                                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                    <i class="fa-solid fa-check"></i> Confirmar pago</button>

                                            </div>
                                            @endif
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                {{-- End: Mostramos el contenido --}}
                                @endif

                            </div>
                        </div>
                        {{-- End:Mostrar si existen pagos registrados --}}
                        @endif

                        @else
                        <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">¡Atención!</span> No hay productos agregados a la orden.
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="">
                @if($inventarioVisible)
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
                @endif
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
                                        @if($inventarioVisible)
                                        <div class="p-1 border rounded-lg ms-2">
                                            <button type="button" @if ($productoLista['cantidad_producto']==1 ) disabled
                                                @else
                                                wire:click='disminuirProductoLista({{ $productoLista["id_producto"] }})'
                                                @endif
                                                class="border-0 px-2.5 py-1.5 text-xs font-medium text-center text-gray-900 bg-white  border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <span>
                                                {{$productoLista['cantidad_producto']}}
                                            </span>
                                            <button type="button"
                                                wire:click='aumentarProductoLista({{$productoLista["id_producto"]}})'
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
                                        @endif

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

    <div wire:loading wire:target="archivos_envio">
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

    <div id="modal-preview-soporte" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" wire:ignore.self
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

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.store("accordion", {
                openTabs: [1, 2, 3, 4]
            });

            Alpine.data("accordion", (idx) => ({
                init() {
                    this.idx = idx;
                    this.updateHeight(); // Llamar a updateHeight directamente
                    window.addEventListener("resize", this.updateHeight.bind(this));
                },
                idx: -1,
                handleClick() {
                    if (Alpine.store("accordion").openTabs.includes(this.idx)) {
                        Alpine.store("accordion").openTabs = Alpine.store("accordion").openTabs.filter(tab => tab !== this.idx);
                    } else {
                        Alpine.store("accordion").openTabs.push(this.idx);
                    }
                    this.updateHeight();
                },
                handleRotate() {
                    return Alpine.store("accordion").openTabs.includes(this.idx) ? "-rotate-180" : "";
                },
                handleToggle() {
                    return Alpine.store("accordion").openTabs.includes(this.idx)
                        ? `max-height: ${this.$refs.tab.scrollHeight}px`
                        : "";
                },
                updateHeight() {
                    if (this.$refs && this.$refs.tab) {
                        if (Alpine.store("accordion").openTabs.includes(this.idx)) {
                            this.$refs.tab.style.maxHeight = this.$refs.tab.scrollHeight + "px";
                        } else {
                            this.$refs.tab.style.maxHeight = null;
                        }
                    }
                },
                destroy() {
                    window.removeEventListener("resize", this.updateHeight.bind(this));
                }
            }));
        });
        
        function modalPreview(id,tipo){
            
            let button = document.querySelector(`#btnPreview_${tipo}${id}[data-file-url]`);
            const fileURL = button.getAttribute('data-file-url');
            button = document.querySelector(`#btnPreview_${tipo}${id}[data-file-type]`);
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
        document.addEventListener('livewire:load', function () {
            Livewire.hook('component.init', ({ component, cleanup }) => {
                
                // Verifica si el componente y el evento son los correctos
                if (component.el.querySelector('#forma-pago')) {
                    alert("Hola mundo");
                    // Ejecuta el método de Alpine después del evento de Livewire
                    document.querySelector('#forma-pago').dispatchEvent(new Event('change'));
                }
            });
            });

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