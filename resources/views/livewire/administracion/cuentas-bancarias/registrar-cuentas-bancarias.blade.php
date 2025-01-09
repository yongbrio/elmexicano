<div>

    <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        <x-select2 label="Tipo de cuenta" id="tipo_cuenta" icon="fa-solid fa-money-check-dollar" model="tipo_cuenta"
            optionTextDefault="Seleccione una cuenta"> </x-select2>

        <x-live-wire-input label="Número de cuenta" id="numero_cuenta" icon="fa-solid fa-money-check-dollar"
            model="numero_cuenta" placeholder="900000000" typeInput="number"></x-live-wire-input>

        <x-live-wire-input label="Banco" id="nombre_banco" icon="fa-solid fa-building-columns" model="nombre_banco"
            placeholder="Nombre del banco" typeInput="text"></x-live-wire-input>

        <x-select2 label="Empresa" id="empresa" icon="fa-solid fa-comment" model="empresa"
            optionTextDefault="Seleccione Empresa"> </x-select2>

            <x-live-wire-input label="Fecha de apertura" id="fecha_apertura" icon="fa-solid fa-calendar-days" model="fecha_apertura"
            placeholder="Fecha de apertura" typeInput="date"></x-live-wire-input>

        {{-- <x-date-picker-input label="Fecha de apertura" id="fecha_apertura" model="fecha_apertura"
            placeholder="Seleccione una fecha"> </x-date-picker-input> --}}

        <x-select2 label="Estado" id="estado" icon="fa-solid fa-toggle-on" model="estado"
            optionTextDefault="Seleccione un estado"> </x-select2>

    </div>

    <div class="flex justify-end mt-5">

        <button wire:click="cancelarRegistrarCuentaBancaria" type="button"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                class="fa-solid fa-ban"></i> Cancelar
        </button>

        <button wire:click="registrarCuentaBancaria" type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <div wire:loading.remove wire:target="registrarCuentaBancaria">
                <i class="fa-solid fa-floppy-disk"></i> Guardar
            </div>
            <div wire:loading wire:target="registrarCuentaBancaria">
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