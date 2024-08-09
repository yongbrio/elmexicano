<div>
    <h1 class="pt-2">Administrar Ordenes</h1>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#tab-orden"
            role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-orden-tab"
                    data-tabs-target="#lista-orden" type="button" role="tab" aria-controls="lista-orden"
                    aria-selected="false">Listado de ordenes</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="registrar-orden-tab" data-tabs-target="#registrar-orden" type="button" role="tab"
                    aria-controls="registrar-orden" aria-selected="false">Registrar orden</button>
            </li>
        </ul>
    </div>
    <div id="tab-orden">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-orden" role="tabpanel"
            aria-labelledby="lista-orden-tab">
            <livewire:administracion.ordenes.lista-orden-table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="registrar-orden" role="tabpanel"
            aria-labelledby="registrar-orden-tab">
            <livewire:administracion.ordenes.registrar-ordenes>
        </div>
    </div>

    @script
    <script>
        $wire.on('recargarComponente');
    </script>
    @endscript

</div>