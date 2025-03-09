<div>
    <h1 class="pt-2 mb-5">Actualizar datos de Sucursal</h1>
    <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        <x-live-wire-input label="Identificador" id="identificador" icon="fa-solid fa-id-card" model="identificador"
            placeholder="Ingrese el identificador" typeInput="text"></x-live-wire-input>

        <x-live-wire-input label="Nombre de sucursal" id="nombre_sucursal" icon="fa-solid fa-industry"
            model="nombre_sucursal" placeholder="Ingrese el nombre de la sucursal" typeInput="text"></x-live-wire-input>

        <x-live-wire-input label="Dirección" id="direccion" icon="fa-regular fa-map" model="direccion"
            placeholder="XXXXXXXXXXXXX" typeInput="text"></x-live-wire-input>


        <x-live-wire-input label="Barrio/Localidad" id="barrio_localidad" icon="fa-solid fa-location-arrow"
            model="barrio_localidad" placeholder="Barrio/Localidad" typeInput="text"></x-live-wire-input>

        <div>
            <x-live-wire-input label="Ciudad" id="ciudad" icon="fa-solid fa-location-dot" model="ciudad"
                placeholder="Soacha" typeInput="text" wire='buscarCiudad'></x-live-wire-input>

            <x-live-wire-input label="" id="idciudad" icon="" model="idciudad" placeholder="" typeInput="hidden">
            </x-live-wire-input>

            @if ($listaMunicipios)
            <ul class="max-w-md p-2 space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                @foreach ($listaMunicipios as $mun)
                <li class="cursor-pointer" wire:click='setearNombreCiudad("{{$mun->id}}")'>{{ $mun->nombre_municipio }}
                </li>
                @endforeach
            </ul>
            @endif
        </div>

        <div>
            <x-live-wire-input label="Departamento" id="departamento" icon="fa-solid fa-map-location-dot"
                model="departamento" placeholder="Cundinamarca" typeInput="text" disabled='disabled'>
            </x-live-wire-input>
            <x-live-wire-input label="" id="iddepartamento" icon="" model="iddepartamento" placeholder=""
                typeInput="hidden">
            </x-live-wire-input>
        </div>

        <x-select2 label="Giro de sucursal" id="giro_sucursal" icon="fa-solid fa-store" model="giro_sucursal"
            optionTextDefault="Seleccione un giro de sucursal"> </x-select2>

        <x-select2 label="Tipo de sucursal" id="tipo_sucursal" icon="fa-solid fa-shop" model="tipo_sucursal"
            optionTextDefault="Seleccione un tipo de sucursal"> </x-select2>

        <x-select2 label="Estado" id="estado" icon="fa-solid fa-toggle-on" model="estado"
            optionTextDefault="Seleccione un estado"> </x-select2>

    </div>

    <div class="flex justify-end mt-5">

        <button wire:click="cancelarActualizarSucursal" type="button"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                class="fa-solid fa-ban"></i> Cancelar
        </button>

        <button wire:click="actualizarSucursal" type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <div wire:loading.remove wire:target="actualizarSucursal">
                <i class="fa-solid fa-floppy-disk"></i> Actualizar
            </div>
            <div wire:loading wire:target="actualizarSucursal">
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
    </script>
    @endscript

</div>