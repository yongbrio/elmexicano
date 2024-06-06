<div>
    <h1 class="pt-2">Administrar Usuarios</h1>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#tab-usuarios" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-usuarios-tab"
                    data-tabs-target="#lista-usuarios" type="button" role="tab" aria-controls="lista-usuarios"
                    aria-selected="false">Listado de usuarios</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="registrar-usuarios-tab" data-tabs-target="#registrar-usuarios" type="button" role="tab"
                    aria-controls="registrar-usuarios" aria-selected="false">Registrar usuarios</button>
            </li>
        </ul>
    </div>
    <div id="tab-usuarios">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-usuarios" role="tabpanel"
            aria-labelledby="lista-usuarios-tab">
            <livewire:administracion.usuarios.lista-usuarios-table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="registrar-usuarios" role="tabpanel"
            aria-labelledby="registrar-usuarios-tab">
            <livewire:administracion.usuarios.registrar-usuarios>
        </div>
    </div>


</div>