<div>
    <h1 class="pt-2">Log de Registros</h1>
    <div class="pt-5 mt-6">
        <livewire:administracion.log.lista-log-table>
    </div>

    <div id="modal-datos-log" tabindex="-1" aria-hidden="true" wire:ignore.self
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">

                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-datos-log">
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

                </div>

                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">

                    <button data-modal-hide="modal-datos-log" type="button"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    @script
    <script>
        const $targetEl = document.getElementById('modal-datos-log');
            // instance options object
            const instanceOptions = {
            id: 'modal-datos-log',
            override: true
            };
            const modal = new Modal($targetEl, instanceOptions);
            
        $wire.on('verLog', (e) => {
            
            /* $wire.dispatch('agregarProducto',{ id: e.id }); */

            modal.show();

        });

    </script>
    @endscript
</div>