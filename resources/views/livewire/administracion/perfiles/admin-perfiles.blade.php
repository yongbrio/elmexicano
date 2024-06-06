<div>
    <h1 class="pt-2 mb-4">Administrar Perfiles de Usuario</h1>

    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-perfiles" aria-labelledby="lista-periles-tab">
        <div class="flex justify-end">
            <button type="button" data-modal-target="modal-agregar-perfil" data-modal-toggle="modal-agregar-perfil"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><i
                    class="fa-solid fa-circle-plus"></i> Agregar</button>
        </div>
        <div>
            <livewire:administracion.perfiles.lista-perfiles-table>
        </div>
    </div>


    <!-- Editar Perfil modal -->
    <div wire:ignore.self id="modal-editar-perfil" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Editar Perfil
                    </h3>
                    <button type="button" wire:click='cerrarModalEditarPerfil'
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-editar-perfil">
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

                        <x-live-wire-input label="Nombre del Perfil" id="nombre_perfil_edit"
                            icon="fa-solid fa-money-check-dollar" model="nombre_perfil_edit"
                            placeholder="Nombre del perfil" typeInput="text"></x-live-wire-input>

                        <x-select2 label="Estado" id="estado" icon="fa-solid fa-toggle-on" model="estado_edit"
                            optionTextDefault="Seleccione un estado"> </x-select2>

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex justify-end p-4 mt-5 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">

                    <button wire:click='cerrarModalEditarPerfil' data-modal-hide="modal-editar-perfil" type="button"
                        id="close-modal-editar"
                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                            class="fa-solid fa-ban"></i> Cancelar
                    </button>
                    <button wire:click="editarPerfil" type="button"
                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        <div wire:loading.remove wire:target="editarPerfil">
                            <i class="fa-solid fa-floppy-disk"></i> Actualizar
                        </div>
                        <div wire:loading wire:target="editarPerfil">
                            Actualizando...
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Editar Perfil modal -->

    <!-- Agregar Perfil modal -->
    <div wire:ignore.self id="modal-agregar-perfil" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Agregar Perfil
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-agregar-perfil">
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
                    <livewire:administracion.perfiles.registrar-perfiles>
                </div>

            </div>
        </div>
    </div>
    <!-- Fin Agregar Perfil modal -->

    <!-- Asignar Permisos modal -->
    <div wire:ignore.self id="modal-asignar-permiso" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Asignar permisos a perfil
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-asignar-permiso">
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
                    <livewire:administracion.perfiles.asignar-permisos>
                </div>

            </div>
        </div>
    </div>
    <!-- Fin Asignar Permisos modal  -->

    @script
    <script>
        $wire.on('traerPerfil', (e) => {
            $wire.dispatch('setearPerfil',{
                id:e.id
            });
    });

        $wire.on('estadoActualizacionPerfil', (e) => {
              Swal.fire({
                  title: e.title,
                  text: e.message,
                  icon: e.icon,
                  confirmButtonColor: "#3085d6",
                  confirmButtonText: "Ok"
              }).then((result) => {
                  if (result.isConfirmed) {
                      const closeModalButton = document.getElementById('close-modal-editar');
                      closeModalButton.click();
                  }
              });
          });

    </script>
    @endscript

</div>