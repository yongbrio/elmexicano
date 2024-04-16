<div>
    <h1 class="pt-2">Administrar Empresas</h1>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#tab-empresas" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-empresas-tab" data-tabs-target="#lista-empresas"
                    type="button" role="tab" aria-controls="lista-empresas" aria-selected="false">Listado de empresas</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="registrar-empresas-tab" data-tabs-target="#registrar-empresas" type="button" role="tab" aria-controls="registrar-empresas"
                    aria-selected="false">Registrar empresa</button>
            </li>
        </ul>
    </div>
    <div id="tab-empresas">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-empresas" role="tabpanel"
            aria-labelledby="lista-empresas-tab">
           <livewire:administracion.empresas.lista-empresas-table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="registrar-empresas" role="tabpanel"
            aria-labelledby="registrar-empresas-tab">
            <livewire:administracion.empresas.registrar-empresa>
        </div>
    </div>
</div>
