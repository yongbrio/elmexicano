<div>
    <h1 class="pt-2">Categorías Egresos</h1>
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#tab-egresos" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="lista-egresos-tab"
                    data-tabs-target="#lista-egresos" type="button" role="tab" aria-controls="lista-egresos"
                    aria-selected="true">Listado de categorías</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="registrar-egresos-tab" data-tabs-target="#registrar-egresos" type="button" role="tab"
                    aria-controls="registrar-egresos" aria-selected="false">Registrar categorías de egreso</button>
            </li>
        </ul>
    </div>
    <div id="tab-egresos">
        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="lista-egresos" role="tabpanel"
            aria-labelledby="lista-egresos-tab">
            <livewire:administracion.categorias-egresos.lista-categorias-asociadas>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="registrar-egresos" role="tabpanel"
            aria-labelledby="registrar-egresos-tab">
            <livewire:administracion.categorias-egresos.registrar-categorias-egresos>
        </div>
    </div>

    @script
    <script>
        $wire.on('eliminarCategoria', (e) => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará la categoría asociada. ¡No se puede deshacer!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
             if (result.isConfirmed) {
                $wire.dispatch('eliminarCategoriaAsociada', {
                    id: e.id
                });
            } 
        });
    });

    $wire.on('estadoActualizacionCategoriaAsociada', (e) => {
          Swal.fire({
              title: e.title,
              text: e.message,
              icon: e.icon,
              confirmButtonColor: "#3085d6",
              confirmButtonText: "Ok"
          }).then((result) => {
              if (result.isConfirmed) {
                if(e.icon == "success"){
                    $wire.dispatch('recargarComponenteListaCategoriasAsociadas');
                } 
              }
          });
      });
      
    </script>
    @endscript
</div>