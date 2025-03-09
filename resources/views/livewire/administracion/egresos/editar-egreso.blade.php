<div>
    <h1 class="pt-2 mb-5">Actualizar datos de Egreso</h1>

    <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        <x-live-wire-input label="Código del egreso" id="codigo_egreso" icon="fa-solid fa-address-card"
            model="codigo_egreso" placeholder="1234" typeInput="number" disabled="disabled"></x-live-wire-input>

        <x-live-wire-input label="Categoría 1" id="categoria_1" icon="fa-solid fa-file-signature" model="categoria_1"
            placeholder="Categoría 1" typeInput="text"></x-live-wire-input>

        <x-live-wire-input label="Categoría 2" id="categoria_2" icon="fa-solid fa-file-signature" model="categoria_2"
            placeholder="Categoría 2" typeInput="text"></x-live-wire-input>

        <x-select2 label="Tipo de egreso" id="tipo_egreso" icon="fa-solid fa-toggle-on" model="tipo_egreso"
            optionTextDefault="Seleccione un tipo de egreso"> </x-select2>

        <x-live-wire-input label="Descripción de egreso" id="descripcion_egreso" icon="fa-solid fa-file-signature"
            model="descripcion_egreso" placeholder="Descripción de egreso" typeInput="text"></x-live-wire-input>

        <x-live-wire-input label="Código de producto" id="codigo_producto" icon="fa-solid fa-address-card"
            model="codigo_producto" placeholder="1234" typeInput="number"></x-live-wire-input>

        <x-select2 label="Unidad de medida" id="unidad_medida" icon="fa-solid fa-toggle-on" model="unidad_medida"
            optionTextDefault="Seleccione unidad de medida"> </x-select2>

        <x-select2 label="Estado" id="estado" icon="fa-solid fa-toggle-on" model="estado"
            optionTextDefault="Seleccione un estado"> </x-select2>

    </div>

    <div class="flex justify-end mt-5">

        <button wire:click="cancelarActualizarEgreso" type="button"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                class="fa-solid fa-ban"></i> Cancelar
        </button>

        <button wire:click="actualizarEgreso" type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <div wire:loading.remove wire:target="actualizarEgreso">
                <i class="fa-solid fa-floppy-disk"></i> Guardar
            </div>
            <div wire:loading wire:target="actualizarEgreso">
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