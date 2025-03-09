<div>

    <div class="p-4 mb-4 text-sm text-blue-600 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
        Crea categorías de egresos y luego asocialas.
    </div>

    <div id="accordion-open" data-accordion="open" class="text-base" wire:ignore.self
        data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">

        <h4 id="accordion-open-heading-1" wire:ignore.self>
            <button type="button"
                class="flex items-center justify-between w-full gap-3 p-5 font-medium text-gray-500 border border-b-0 border-gray-200 rtl:text-right rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-600 hover:text-white dark:hover:bg-gray-800"
                data-accordion-target="#accordion-open-body-1" aria-expanded="true"
                aria-controls="accordion-open-body-1">
                <span class="flex items-center">
                    Registrar categorías
                </span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h4>

        <div id="accordion-open-body-1" class="hidden" aria-labelledby="accordion-open-heading-1" wire:ignore.self>
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                <div
                    class="content-center grid-cols-2 gap-4 mt-5 text-lg text-center sm:grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2">

                    {{-- Inicio Categorías 1 --}}
                    <div class="p-1">
                        <h4 class="p-2 font-medium text-white bg-blue-600 rounded-t-lg">
                            Categoría 1
                        </h4>
                        <div class="p-2 border border-blue-500 border-solid">
                            <div class="pt-5">
                                <x-live-wire-input label="Nombre de categoría" id="categoria_1"
                                    icon="fa-solid fa-file-signature" model="categoria_1"
                                    placeholder="Nombre de categoría" typeInput="text">
                                </x-live-wire-input>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="button" wire:click="RegistrarCategoria1"
                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    <i class="fa-solid fa-floppy-disk"></i> Registrar
                                </button>
                            </div>
                        </div>
                        <div class="pt-5">
                            <h4 class="font-medium">
                                Categorías registradas
                            </h4>
                            <hr class="h-[2px] bg-blue-500 mt-1 mb-5">
                            <div class="max-h-[300px] overflow-y-auto">
                                <livewire:administracion.categorias-egresos.lista-categorias-egresos1>
                            </div>
                        </div>
                    </div>
                    {{-- Fin Categorías 1 --}}

                    {{-- Inicio Categorías 2 --}}
                    <div class="p-1">
                        <h4 class="p-2 font-medium text-white bg-blue-600 rounded-t-lg">
                            Categoría 2
                        </h4>
                        <div class="p-2 border border-blue-500 border-solid">
                            <div class="pt-5">
                                <x-live-wire-input label="Nombre de categoría" id="categoria_2"
                                    icon="fa-solid fa-file-signature" model="categoria_2"
                                    placeholder="Nombre de categoría" typeInput="text">
                                </x-live-wire-input>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="button" wire:click='RegistrarCategoria2'
                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    <i class="fa-solid fa-floppy-disk"></i> Registrar
                                </button>
                            </div>
                        </div>
                        <div class="pt-5">
                            <h4 class="font-medium">
                                Categorías registradas
                            </h4>
                            <hr class="h-[2px] bg-blue-500 mt-1 mb-5">
                            <div class="max-h-[300px] overflow-y-auto">
                                <livewire:administracion.categorias-egresos.lista-categorias-egresos2>
                            </div>
                        </div>
                    </div>
                    {{-- Fin Categorías 2 --}}

                </div>
            </div>
        </div>

        <h4 id="accordion-open-heading-2" wire:ignore.self>
            <button type="button"
                class="flex items-center justify-between w-full gap-3 p-5 font-medium text-gray-500 border border-b-0 border-gray-200 rtl:text-right focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-600 hover:text-white dark:hover:bg-gray-800"
                data-accordion-target="#accordion-open-body-2" aria-expanded="false"
                aria-controls="accordion-open-body-2">
                <span class="flex items-center">
                    Asociar categorías</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h4>

        <div id="accordion-open-body-2" class="hidden" aria-labelledby="accordion-open-heading-2" wire:ignore.self>
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                <div
                    class="content-center grid-cols-2 gap-4 mt-5 text-lg text-center sm:grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2">
                    <div>
                        <x-select2 label="Selecciona categoría 1" id="lista_categorias_1" icon="fa-solid fa-toggle-on"
                            model="lista_categorias_1" optionTextDefault="Selecciona categoría 1"> </x-select2>
                    </div>
                    <div>
                        <x-select2 label="Selecciona categoría 2" id="lista_categorias_2" icon="fa-solid fa-toggle-on"
                            model="lista_categorias_2" optionTextDefault="Selecciona categoría 2"> </x-select2>
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <button type="button" wire:click='asociarCategorias'
                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        <i class="fa-solid fa-link"></i> Asociar categorías
                    </button>
                </div>
            </div>
        </div>
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
                });
            });
    </script>
    @endscript

</div>