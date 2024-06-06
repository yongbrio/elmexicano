<div>

    <div class="grid grid-cols-1">

        <x-live-wire-input label="Nombre del perfil" id="nombre_perfil" icon="fa-solid fa-money-check-dollar"
            model="nombre_perfil" placeholder="Nombre del perfil" typeInput="text"></x-live-wire-input>

        <x-select2 label="Estado" id="estado" icon="fa-solid fa-toggle-on" model="estado"
            optionTextDefault="Seleccione un estado"> </x-select2>

    </div>

    <div class="flex justify-end mt-5">

        <button data-modal-hide="modal-agregar-perfil" type="button" id="close-modal-registrar"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                class="fa-solid fa-ban"></i> Cancelar
        </button>

        <button wire:click="registrarPerfil" wire:click="$refresh" type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <div wire:loading.remove wire:target="registrarPerfil">
                <i class="fa-solid fa-floppy-disk"></i> Guardar
            </div>
            <div wire:loading wire:target="registrarPerfil">
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
                    if (result.isConfirmed) {
                        $wire.dispatch('resetInputs');
                        $wire.dispatch('recargarComponente');
                        const closeModalButton = document.getElementById('close-modal-registrar');
                        closeModalButton.click();
                    }
                });
            });
    </script>
    @endscript

</div>