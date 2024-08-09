<!-- Editar Perfil modal -->
<div wire:ignore.self id="modal-ordenes" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Creación de Orden
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="modal-ordenes">
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
                <div class="grid grid-cols-1">

                    {{-- Paso 1 --}}
                    @if ($es_corporativo)

                    <h2 class="text-xl font-medium">Sucursal {!! $paso2 ? ' <i
                            class="text-green-600 fa-solid fa-circle-check"></i>':'' !!}</h2>
                    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                    <x-select2 label="Seleccione una sucursal" id="sucursal" icon="fa-solid fa-ruler-horizontal"
                        model="sucursal" optionTextDefault="Seleccione una sucursal"
                        disabled=" {{ $paso2 ? 'disabled' : '' }}" wire='change=cambiar(2)'>
                    </x-select2>
                    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">

                    @endif
                    {{-- Fin Paso 1 --}}

                    {{-- Paso 2 --}}
                    @if($paso2)
                    <h2 class="text-xl font-medium ">Tipo de Orden {!! $paso3 ? ' <i
                            class="text-green-600 fa-solid fa-circle-check"></i>':'' !!} </h2>
                    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                    <div class="flex">
                        <div class="flex items-center p-1 rounded ps-4 dark:border-gray-700">
                            <input {{$paso3 ? 'disabled' : '' }} id="ingreso" type="radio" value="ingreso"
                                name="radio-ingreso-egreso" wire:model='tipo_orden' wire:click='cambiar(3)'
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="ingreso"
                                class="w-full text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">Ingreso
                            </label>
                        </div>
                        <div class="flex items-center p-1 rounded ps-4 dark:border-gray-700">
                            <input {{$paso3 ? 'disabled' : '' }} id="egreso" type="radio" value="egreso"
                                name="radio-ingreso-egreso" wire:model='tipo_orden' wire:click='cambiar(3)'
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="egreso"
                                class="w-full text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">Egreso
                            </label>
                        </div>
                    </div>
                    <div>@error($tipo_orden) <div class="text-sm text-red-500">{{ $message }}</div> @enderror</div>
                    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                    @endif
                    {{-- Fin Paso 2 --}}

                    {{-- Paso 3 --}}
                    @if($paso3)
                    @if($tipo_orden == 'ingreso')
                    <h2 class="text-xl font-medium ">Cliente {!! $paso4 ? ' <i
                            class="text-green-600 fa-solid fa-circle-check"></i>':'' !!}</h2>
                    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                    <x-live-wire-input label="" id="buscar_cliente" icon="fa-solid fa-location-dot"
                        model="buscar_cliente" placeholder="Buscar Cliente" typeInput="text" wire='buscarCliente'
                        :disabled="$paso4">
                    </x-live-wire-input>

                    <x-live-wire-input label="" id="id_cliente" icon="" model="id_cliente" placeholder=""
                        typeInput="hidden">
                    </x-live-wire-input>

                    @if (!empty(trim($listaClientes)) && count($listaClientes) > 0 )
                    <div class="z-50 w-full overflow-auto max-h-40">
                        <ul class="p-2 ml-[35px] -mt-[8px] space-y-1 text-sm text-gray-900 list-inside list-none">
                            @foreach ($listaClientes as $cliente)
                            <li class="p-1 border-2 border-gray-300 cursor-pointer dark:text-gray-400 hover:bg-sky-600 hover:text-white"
                                wire:click='setearNombreCliente("{{$cliente->id}}")'>
                                {{ $cliente->nombre_legal.' - '. $cliente->nit . ' - '.$cliente->telefono }}
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    @endif
                    @elseif ($tipo_orden == 'egreso')

                    <h2 class="text-xl font-medium ">Proveedor{!! $paso4 ? ' <i
                            class="text-green-600 fa-solid fa-circle-check"></i>':'' !!}</h2>
                    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">

                    <x-live-wire-input label="" id="buscar_proveedor" icon="fa-solid fa-location-dot"
                        model="buscar_proveedor" placeholder="Buscar Proveedor" typeInput="text" wire='buscarProveedor'
                        :disabled="$paso4">
                    </x-live-wire-input>

                    <x-live-wire-input label="" id="id_proveedor" icon="" model="id_proveedor" placeholder=""
                        typeInput="hidden">
                    </x-live-wire-input>

                    @if (!empty(trim($listaProveedores)) && count($listaProveedores) >0)
                    <div class="z-50 w-full overflow-auto max-h-40">
                        <ul class="p-2 ml-[35px] -mt-[8px] space-y-1 text-sm text-gray-900 list-inside list-none">
                            @foreach ($listaProveedores as $proveedor)
                            <li class="p-1 border-2 border-gray-300 cursor-pointer dark:text-gray-400 hover:bg-sky-600 hover:text-white"
                                wire:click='setearNombreProveedor("{{$proveedor->id}}")'>
                                {{ $proveedor->nombre_legal.' - '. $proveedor->nit . ' - '.$proveedor->telefono }}
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    @endif

                    @endif
                    @endif
                    {{-- Fin Paso 3 --}}

                    {{-- Paso 4 --}}
                    @if($paso4)
                    @if ($tipo_orden == 'ingreso')
                    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                    @livewire('utilidades.cliente.vista',['id'=>$id_cliente])
                    @elseif ($tipo_orden == 'egreso')
                    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                    @livewire('utilidades.proveedor.vista',['id'=>$id_proveedor])
                    <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">
                    <h2 class="mt-4 mb-5 text-lg font-medium">Datos de empresa {!! $id_empresa ? ' <i
                            class="text-green-600 fa-solid fa-circle-check"></i>':'' !!} </h2>
                    <x-select2 label="Factura con" id="empresaFactura" icon="fa-solid fa-comment" model="id_empresa"
                        optionTextDefault="Seleccione empresa" wire='change=asignarEmpresaProveedor'>
                    </x-select2>
                    @if ($id_empresa)
                    <div class="mt-4">
                        @livewire('utilidades.proveedor.empresa',['id'=>$id_empresa])
                    </div>
                    @endif

                    @endif
                    @endif
                    {{-- Fin Paso 4 --}}
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex justify-end p-4 mt-5 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">

                @if($paso2 === true && $es_corporativo === true)
                <x-buttons-component tipoBoton='default' texto='Regresar' icono='fa-solid fa-circle-chevron-left'
                    wireAction='cambiar(1)'>
                </x-buttons-component>
                @endif

                @if($paso3 === true)
                <x-buttons-component tipoBoton='default' texto='Regresar' icono='fa-solid fa-circle-chevron-left'
                    wireAction='cambiar(2)'>
                </x-buttons-component>
                @endif

                @if($paso4 === true)
                <x-buttons-component tipoBoton='default' texto='Regresar' icono='fa-solid fa-circle-chevron-left'
                    wireAction='cambiar(3)'>
                </x-buttons-component>
                <x-buttons-component tipoBoton='green' texto='Crear Orden' icono='fa-solid fa-floppy-disk'
                    wireAction='cambiar(5)'>
                </x-buttons-component>
                @endif

            </div>
        </div>
    </div>
    @script
    <script>
        $wire.on('alertas', (e) => {
                Swal.fire({
                    title: e.title,
                    text: e.message,
                    icon: e.icon,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                });
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
        });
    </script>

    @endscript
</div>
<!-- Fin Editar Perfil modal -->