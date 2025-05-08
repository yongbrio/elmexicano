<div>
    <h1 class="pt-2 mb-4">Administrar Categorías</h1>

    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-categorias"
        aria-labelledby="lista-categorias-tab">
        <div class="flex justify-end">
            <button type="button" data-modal-target="modal-agregar-categoria"
                data-modal-toggle="modal-agregar-categoria"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><i
                    class="fa-solid fa-circle-plus"></i> Agregar</button>
        </div>
        <div>
            <livewire:administracion.categorias.lista-categorias-table>
        </div>
    </div>

    <!-- Editar Categoría modal -->
    <div wire:ignore.self id="modal-editar-categoria" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Editar Categoría
                    </h3>
                    <button type="button" wire:click='cerrarModalEditarCategoria'
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-editar-categoria">
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

                        <x-live-wire-input label="Nombre de la categoría" id="nombre_categoria_edit"
                            icon="fa-solid fa-money-check-dollar" model="nombre_categoria_edit"
                            placeholder="Nombre de la categoría" typeInput="text"></x-live-wire-input>

                        <x-select2 label="Estado" id="estado" icon="fa-solid fa-toggle-on" model="estado_edit"
                            optionTextDefault="Seleccione un estado"> </x-select2>

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex justify-end p-4 mt-5 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">

                    <button wire:click='cerrarModalEditarCategoria' data-modal-hide="modal-editar-categoria"
                        type="button" id="close-modal-editar"
                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                            class="fa-solid fa-ban"></i> Cancelar
                    </button>
                    <button wire:click="editarCategoria" type="button"
                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        <div wire:loading.remove wire:target="editarCategoria">
                            <i class="fa-solid fa-floppy-disk"></i> Actualizar
                        </div>
                        <div wire:loading wire:target="editarCategoria">
                            Actualizando...
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Editar Categoría modal -->

    <!-- Agregar Categoría modal -->
    <div id="modal-agregar-categoria" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Agregar Categoría
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-agregar-categoria">
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
                    <livewire:administracion.categorias.registrar-categorias>
                </div>

            </div>
        </div>
    </div>
    <!-- Fin Agregar Categoría modal -->

    @script
    <script>
        $wire.on('traerCategoria', (e) => {
            $wire.dispatch('setearCategoria',{
                id:e.id
            });
        });

        $wire.on('estadoActualizacionCategoria', (e) => {
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
                      $wire.dispatch('recargarComponente');
                  }
              });
          });
          
    </script>
    @endscript

</div>