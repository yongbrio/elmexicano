<div>
    <h1 class="pt-2">Administrar Cuentas Bancarias</h1>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#tab-cuentas-bancarias" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-cuentas-bancarias-tab"
                    data-tabs-target="#lista-cuentas-bancarias" type="button" role="tab"
                    aria-controls="lista-cuentas-bancarias" aria-selected="false">Listado de bancos</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="registrar-cuentas-bancarias-tab" data-tabs-target="#registrar-cuentas-bancarias" type="button"
                    role="tab" aria-controls="registrar-cuentas-bancarias" aria-selected="false">Registrar cuenta
                    bancaria</button>
            </li>
        </ul>
    </div>
    <div id="tab-cuentas-bancarias">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-cuentas-bancarias" role="tabpanel"
            aria-labelledby="lista-cuentas-bancarias-tab">
            <livewire:administracion.cuentas-bancarias.lista-cuentas-bancarias-table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="registrar-cuentas-bancarias" role="tabpanel"
            aria-labelledby="registrar-cuentas-bancarias-tab">
            <livewire:administracion.cuentas-bancarias.registrar-cuentas-bancarias>
        </div>
    </div>
</div>