<div>
    <h1 class="pt-2">Administrar Clientes</h1>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#tab-clientes" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-clientes-tab" data-tabs-target="#lista-clientes"
                    type="button" role="tab" aria-controls="lista-clientes" aria-selected="false">Listado de clientes</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="registrar-clientes-tab" data-tabs-target="#registrar-clientes" type="button" role="tab" aria-controls="registrar-clientes"
                    aria-selected="false">Registrar clientes</button>
            </li>
        </ul>
    </div>
    <div id="tab-clientes">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-clientes" role="tabpanel"
            aria-labelledby="lista-clientes-tab">
           <livewire:lista-clientes-table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="registrar-clientes" role="tabpanel"
            aria-labelledby="registrar-clientes-tab">
            <livewire:administracion.registrar-clientes>
        </div>
    </div>


</div>