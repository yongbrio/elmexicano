<div>
    <h1 class="pt-2">Administrar Egresos</h1>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#tab-egresos" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-egresos-tab"
                    data-tabs-target="#lista-egresos" type="button" role="tab" aria-controls="lista-egresos"
                    aria-selected="false">Listado de egresos</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="registrar-egresos-tab" data-tabs-target="#registrar-egresos" type="button" role="tab"
                    aria-controls="registrar-egresos" aria-selected="false">Registrar egreso</button>
            </li>
        </ul>
    </div>
    <div id="tab-egresos">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-egresos" role="tabpanel"
            aria-labelledby="lista-egresos-tab">
            <livewire:administracion.egresos.lista-egresos-table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="registrar-egresos" role="tabpanel"
            aria-labelledby="registrar-egresos-tab">
            <livewire:administracion.egresos.registrar-egreso>
        </div>
    </div>
</div>