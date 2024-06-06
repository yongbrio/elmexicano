<div>

    <div class="grid grid-cols-1">

        <div>
            <ul class="max-w-md space-y-1 text-base text-gray-500 list-disc list-inside dark:text-gray-400">
                <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Permisos generales</h2>
                @foreach ( $modulosArrayGenerales as $key => $value )
                <x-toggle-switch-li nombreModulo='{{$value["nombre_modulo"]}}'
                    wire='cambiarPermiso("{{$value["name_permission"]}}")' activate='{{$value["activate"]}}'
                    id='{{$value["id"]}}'>
                </x-toggle-switch-li>
                @endforeach
                <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-900">
                <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Permisos de administración</h2>
                @foreach ( $modulosArrayAdministracion as $key => $value )
                <x-toggle-switch-li nombreModulo='{{$value["nombre_modulo"]}}'
                    wire='cambiarPermiso("{{$value["name_permission"]}}")' activate='{{$value["activate"]}}'
                    id='{{$value["id"]}}'>
                </x-toggle-switch-li>
                @endforeach
                <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-900">
                <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Permisos de Seguridad</h2>
                @foreach ( $modulosArraySeguridad as $key => $value )
                <x-toggle-switch-li nombreModulo='{{$value["nombre_modulo"]}}'
                    wire='cambiarPermiso("{{$value["name_permission"]}}")' activate='{{$value["activate"]}}'
                    id='{{$value["id"]}}'>
                </x-toggle-switch-li>
                @endforeach
            </ul>
        </div>

    </div>

    @script
    <script>
        $wire.on('estadoActualizacion', (e) => {
                Swal.fire({
                    title: e.title,
                    text: e.message,
                    icon: e.icon,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.dispatch('resetInputs');
                        $wire.dispatch('recargarComponente');
                        const closeModalButton = document.getElementById('close-modal-registrar');
                        closeModalButton.click();
                    }
                });
            });
    </script>
    @endscript