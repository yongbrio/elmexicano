<div>

    <h1 class="pt-2 mb-5">Editar datos de Usuario</h1>

    <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2">

        <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1">
            @if (!$imagen_db)
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="imagen">Cargar
                    imagen
                    del usuario</label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    id="imagen" type="file" wire:model="imagen" wire:click='cambioImagen'
                    accept="image/jpeg, image/png, image/jpg">

                @error('imagen') <span class="text-red-500 error">{{ $message }}</span> @enderror
            </div>
            @endif

            <div wire:loading wire:target="imagen" style="display: none !important;" wire:loading.attr="style"
                wire:loading.style="display: flex !important;"
                class="loading-overlay flex justify-center w-[250px] h-[250px]">

                <div role="status"
                    class="max-w-sm p-4 border border-gray-200 rounded shadow animate-pulse md:p-6 dark:border-gray-700">
                    <div
                        class="flex items-center justify-center h-[150px] w-[150px] mb-4 bg-gray-300 rounded dark:bg-gray-700">
                        <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                            <path
                                d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z" />
                            <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z" />
                        </svg>
                    </div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                    <span class="sr-only">Loading...</span>
                </div>

            </div>

            <div class="flex justify-center">

                <figure class="flex justify-center max-w-lg w-[250px] " wire:loading.remove wire:target="imagen">

                    <div class="flex flex-col items-center">
                        @if ($imagen_db)
                        @php
                        $path = $imagen_db;
                        $moduleName = 'usuarios'; // Nombre del módulo
                        $imageName = basename($path);
                        @endphp
                        <img class="h-[250px] w-[250px] rounded-lg border-black border-[1px]"
                            src="{{ route('admin.storage', ['modulo'=> $moduleName, 'filename' => $imageName]) }}"
                            alt="Imagen usuario" />
                        @elseif (!$imagen_db && $imagen)
                        <div class="flex flex-col items-center">
                            @if ($imagen && in_array($imagen->getClientOriginalExtension(), ['jpg', 'jpeg', 'png']))
                            <img class="h-[250px] w-[250px] rounded-lg border-black border-[1px]"
                                src="{{ $imagen->temporaryUrl() }}" alt="Imagen usuario" />
                            @else

                            <img class="rounded-lg h-[250px] w-[250px] border-black border-2"
                                src="{{asset('images/imagen-defecto-usuario.jpg') }}" alt="Imagen usuario" />
                            @endif
                        </div>
                        @else
                        <img class="rounded-lg h-[250px] w-[250px] border-black border-2"
                            src="{{asset('images/imagen-defecto-usuario.jpg') }}" alt="Imagen usuario" />
                        @endif
                        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Vista previa
                        </figcaption>
                        @if($imagen_db)
                        <button type="button" wire:click="eliminarImagen"
                            class="mt-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                            <i class="fa-solid fa-trash"></i> Eliminar Imagen</button>
                        @endif
                    </div>
                </figure>
            </div>
        </div>
    </div>



    <div class="grid grid-cols-1 gap-4 mt-16 text-sm sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        <x-live-wire-input label="Cédula de ciudadanía" id="cedula" icon="fa-regular fa-id-card" model="cedula"
            placeholder="Ingrese la cédula del usuario" modelblur="validarCedulaUsuario" typeInput="number">
        </x-live-wire-input>

        <x-live-wire-input label="Nombres" id="name" icon="fa-solid fa-user" model="name"
            placeholder="Ingrese los nombres del usuario" typeInput="text">
        </x-live-wire-input>

        <x-live-wire-input label="Apellidos" id="apellidos" icon="fa-solid fa-user" model="apellidos"
            placeholder="Ingrese los apellidos del usuario" typeInput="text">
        </x-live-wire-input>

        <x-live-wire-input label="Fecha de nacimiento" id="fecha_nacimiento" icon="fa-solid fa-cake-candles"
            model="fecha_nacimiento" placeholder="Fecha de nacimiento" typeInput="date"></x-live-wire-input>

        <x-live-wire-input label="Dirección" id="direccion" icon="fa-solid fa-location-dot" model="direccion"
            placeholder="Ingrese la dirección" typeInput="text">
        </x-live-wire-input>

        <x-live-wire-input label="Teléfono" id="telefono" icon="fa-solid fa-phone" model="telefono"
            placeholder="Ingrese el télefono" typeInput="text">
        </x-live-wire-input>

        <x-live-wire-input label="Correo" id="correo" icon="fa-solid fa-envelope" model="correo"
            placeholder="correo@correo.com" typeInput="email"></x-live-wire-input>

        <x-live-wire-input label="Fecha de inicio" id="fecha_inicio" icon="fa-solid fa-calendar-days"
            model="fecha_inicio" placeholder="Fecha de inicio" typeInput="date"></x-live-wire-input>

        <x-live-wire-input label="Referencia 1" id="referencia_1" icon="fa-solid fa-house-user" model="referencia_1"
            placeholder="Nombre-Teléfono-Dirección" typeInput="text"></x-live-wire-input>

        <x-live-wire-input label="Referencia 2" id="referencia_2" icon="fa-solid fa-house-user" model="referencia_2"
            placeholder="Nombre-Teléfono-Dirección" typeInput="text"></x-live-wire-input>

        <x-live-wire-input label="Usuario del Sistema" id="username" icon="fa-solid fa-circle-user" model="username"
            placeholder="Ingrese el usuario del sistema" typeInput="text" modelblur="validarUserName">
        </x-live-wire-input>

        <x-live-wire-input label="Horario" id="horario" icon="fa-solid fa-circle-user" model="horario"
            placeholder="Ingrese el horario" typeInput="text">
        </x-live-wire-input>

        <x-live-wire-input label="EPS" id="eps" icon="fa-solid fa-hospital-user" model="eps"
            placeholder="Ingrese la EPS" typeInput="text">
        </x-live-wire-input>

        <x-live-wire-input label="Pensión" id="pension" icon="fa-solid fa-hand-holding-dollar" model="pension"
            placeholder="Ingrese el fondo de pensión" typeInput="text">
        </x-live-wire-input>

        <x-live-wire-input label="Banco" id="banco" icon="fa-solid fa-landmark" model="banco"
            placeholder="Ingrese el nombre del banco" typeInput="text">
        </x-live-wire-input>

        <x-live-wire-input label="Nro. Cuenta" id="numero_cuenta" icon="fa-solid fa-credit-card" model="numero_cuenta"
            placeholder="Ingrese el número de cuenta" typeInput="text">
        </x-live-wire-input>

        <x-live-wire-input label="Cargo" id="cargo" icon="fa-solid fa-clipboard-user" model="cargo"
            placeholder="Ingrese el cargo" typeInput="text">
        </x-live-wire-input>

        <x-live-wire-input label="Constraseña" id="password" icon="fa-solid fa-lock" model="password"
            placeholder="Ingrese la constraseña" typeInput="password">
        </x-live-wire-input>

        <x-live-wire-input label="Confirmar Constraseña" id="password_confirmation" icon="fa-solid fa-lock"
            model="password_confirmation" placeholder="Confirme la constraseña" typeInput="password">
        </x-live-wire-input>

        <x-select2 label="Perfil" id="perfil" icon="fa-solid fa-id-badge" model="perfil"
            optionTextDefault="Seleccione un perfil"> </x-select2>

        <x-select2 label="Sucursal" id="sucursal" icon="fa-solid fa-ruler-horizontal" model="sucursal"
            optionTextDefault="Seleccione la sucursal asociada">
        </x-select2>

        <x-select2 label="Estado" id="estado" icon="fa-solid fa-toggle-on" model="estado"
            optionTextDefault="Seleccione un estado"> </x-select2>

    </div>


    <div class="flex justify-end mt-5">
        <button wire:click="cancelarActualizarUsuario" type="button"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                class="fa-solid fa-ban"></i> Cancelar
        </button>

        <button wire:click="actualizarUsuario" type="button"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <div wire:loading.remove wire:target="actualizarUsuario">
                <i class="fa-solid fa-floppy-disk"></i> Guardar
            </div>
            <div wire:loading wire:target="actualizarUsuario">
                Cargando...
            </div>
        </button>
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
                    $wire.dispatch('redirigir');
                });
            });
            
            $wire.on('estadoCampos', (e) => {
                const campo = document.getElementById(''+e.elementId+'');
                campo.value = "";
                const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
                });
                Toast.fire({
                icon: "warning",
                title: e.message
                });
            });
            
            $wire.on('resetFileInput', (e) => {
                document.getElementById('imagen').value = null;
            });
            
    </script>
    @endscript

</div>