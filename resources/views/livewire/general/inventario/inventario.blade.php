<div>
    <h1 class="pt-2">Inventario</h1>
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#tab-inventario" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-inventario-tab"
                    data-tabs-target="#lista-inventario" type="button" role="tab" aria-controls="lista-inventario"
                    aria-selected="false">Listado de inventario</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="transferencia-inventario-tab" data-tabs-target="#transferencia-inventario" type="button"
                    role="tab" aria-controls="transferencia-inventario" aria-selected="false">Transferencia de
                    inventario</button>
            </li>
        </ul>
    </div>

    <div id="tab-inventario">

        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-inventario" role="tabpanel"
            aria-labelledby="lista-inventario-tab">
            <livewire:general.inventario.lista-inventario-table />
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="transferencia-inventario" role="tabpanel"
            aria-labelledby="transferencia-inventario-tab">
            <livewire:administracion.inventario.transferencia-inventario>
        </div>

    </div>

    @script
    <script>
        $wire.on('recargarComponente');
    </script>
    @endscript


</div>