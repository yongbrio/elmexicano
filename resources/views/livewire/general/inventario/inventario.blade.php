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
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="lista-transferencias-transito-inventario-tab"
                    data-tabs-target="#lista-transferencias-transito-inventario" type="button" role="tab"
                    aria-controls="lista-transferencias-transito-inventario" aria-selected="false">Transferencias en
                    tránsito</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="lista-transferencias-confirmadas-inventario-tab"
                    data-tabs-target="#lista-transferencias-confirmadas-inventario" type="button" role="tab"
                    aria-controls="lista-transferencias-confirmadas-inventario" aria-selected="false">Transferencias
                    confirmadas</button>
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
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-transferencias-transito-inventario"
            role="tabpanel" aria-labelledby="lista-transferencias-transito-inventario-tab">
            <livewire:administracion.inventario.lista-transferencias-inventario :estado="'1'" />
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-transferencias-confirmadas-inventario"
            role="tabpanel" aria-labelledby="lista-transferencias-confirmadas-inventario-tab">
            <livewire:administracion.inventario.lista-transferencias-inventario :estado="'2'" />
        </div>

    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Listen for estadoActualizacion event
            Livewire.on('estadoActualizacion_tabla', (data) => {
                Swal.fire({
                    title: data.title,
                    text: data.message,
                    icon: data.icon,
                    confirmButtonText: 'Ok'
                });
            });
        
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('[data-tabs-target]');
    
            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Crear nueva URL sin ningún parámetro
                    const url = new URL(window.location.origin + window.location.pathname);
                    window.history.replaceState({}, '', url);
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('extralarge-modal');
    
            // Escuchar el evento de cierre del modal de Flowbite
            modal.addEventListener('hidden.tw.modal', function () {
                const url = new URL(window.location.origin + window.location.pathname);
                window.history.replaceState({}, '', url);
            });
    
            // También aplicar cuando se hace clic en cualquier botón que cierra el modal manualmente
            const botonesCerrar = modal.querySelectorAll('[data-modal-hide="extralarge-modal"]');
            botonesCerrar.forEach(boton => {
                boton.addEventListener('click', function () {
                    const url = new URL(window.location.origin + window.location.pathname);
                    window.history.replaceState({}, '', url);
                });
            });
        });
    </script>

    @script
    <script>
        $wire.on('recargarComponente');
    </script>
    @endscript


</div>