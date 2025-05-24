<div>
    <h1 class="pt-2">Administrar Productos</h1>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#tab-producto" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-producto-tab"
                    data-tabs-target="#lista-producto" type="button" role="tab" aria-controls="lista-producto"
                    aria-selected="false">Listado de productos</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="registrar-producto-tab" data-tabs-target="#registrar-producto" type="button" role="tab"
                    aria-controls="registrar-producto" aria-selected="false">Registrar producto</button>
            </li>
        </ul>
    </div>

    <div id="tab-producto">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-producto" role="tabpanel"
            aria-labelledby="lista-producto-tab">
            <livewire:administracion.productos.lista-producto-table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="registrar-producto" role="tabpanel"
            aria-labelledby="registrar-producto-tab">
            <livewire:administracion.productos.registrar-producto>
        </div>
    </div>

</div>