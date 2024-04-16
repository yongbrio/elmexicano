<div>
    <h1 class="pt-2">Administrar Proveedores</h1>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#tab-proveedores" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-proveedores-tab" data-tabs-target="#lista-proveedores"
                    type="button" role="tab" aria-controls="lista-proveedores" aria-selected="false">Listado de proveedores</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="registrar-proveedores-tab" data-tabs-target="#registrar-proveedores" type="button" role="tab" aria-controls="registrar-proveedores"
                    aria-selected="false">Registrar proveedores</button>
            </li>
        </ul>
    </div>
    <div id="tab-proveedores">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-proveedores" role="tabpanel"
            aria-labelledby="lista-proveedores-tab">
            <livewire:administracion.proveedores.lista-proveedores-table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="registrar-proveedores" role="tabpanel"
            aria-labelledby="registrar-proveedores-tab">
            <livewire:administracion.proveedores.registrar-proveedores>
        </div>
    </div>


</div>
