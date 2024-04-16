<div>
    <h1 class="pt-2 mb-5">Actualizar datos de Empresa</h1>
    <div class="grid grid-cols-1 gap-4 mt-5 text-sm sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        <x-live-wire-input label="NIT" id="nit" icon="fa-solid fa-address-card" model="nit" placeholder="900000000"
            typeInput="number"></x-live-wire-input>

        <x-live-wire-input label="Nombre Legal" id="nombreLegal" icon="fa-solid fa-file-signature" model="nombreLegal"
            placeholder="Nombre Legal" typeInput="text"></x-live-wire-input>

        <x-live-wire-input label="Nombre Comercial" id="nombreComercial" icon="fa-solid fa-industry"
            model="nombreComercial" placeholder="Nombre Comercial" typeInput="text">
        </x-live-wire-input>

        <x-live-wire-input label="Dirección" id="direccion" icon="fa-regular fa-map" model="direccion"
            placeholder="XXXXXXXXXXXXX" typeInput="text"></x-live-wire-input>

        <x-live-wire-input label="Departamento" id="departamento" icon="fa-solid fa-map-location-dot"
            model="departamento" placeholder="Cundinamarca" typeInput="text"></x-live-wire-input>

        <x-live-wire-input label="Ciudad" id="ciudad" icon="fa-solid fa-location-dot" model="ciudad"
            placeholder="Soacha" typeInput="text"></x-live-wire-input>

        <x-live-wire-input label="Matrícula" id="matricula" icon="fa-regular fa-id-card" model="matricula"
            placeholder="Matrícula" typeInput="text"></x-live-wire-input>

        <x-select2 label="Estado" id="estado" icon="fa-solid fa-toggle-on" model="estado"
            optionTextDefault="Seleccione un estado"> </x-select2>

    </div>

    <div class="flex justify-end mt-5">

        <button wire:click="cancelarActualizarEmpresa" type="button"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                class="fa-solid fa-ban"></i> Cancelar
        </button>

        <button wire:click="actualizarEmpresa" type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <div wire:loading.remove wire:target="actualizarEmpresa">
                <i class="fa-solid fa-floppy-disk"></i> Actualizar
            </div>
            <div wire:loading wire:target="actualizarEmpresa">
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