<div>
    <h1 class="pt-2">Administrar Sucursales</h1>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#tab-sucursales" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-sucursales-tab"
                    data-tabs-target="#lista-sucursales" type="button" role="tab" aria-controls="lista-sucursales"
                    aria-selected="false">Listado de sucursales</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="registrar-sucursales-tab" data-tabs-target="#registrar-sucursales" type="button" role="tab"
                    aria-controls="registrar-sucursales" aria-selected="false">Registrar sucursal</button>
            </li>
        </ul>
    </div>
    <div id="tab-sucursales">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-sucursales" role="tabpanel"
            aria-labelledby="lista-sucursales-tab">
            <livewire:administracion.sucursales.lista-sucursales-table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="registrar-sucursales" role="tabpanel"
            aria-labelledby="registrar-sucursales-tab">
            <livewire:administracion.sucursales.registrar-sucursal>
        </div>
    </div>
</div>