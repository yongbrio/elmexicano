<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Información del perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Visualiza tu información personal.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('patch')
        <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 ">
            <div>
                <x-input-label for="cedula" :value="__('Número de identificación')" />
                <x-text-input id="cedula" name="cedula" type="number" class="block w-full mt-1" disabled
                    :value="old('cedula', $user->cedula)" autocomplete="cedula" />
            </div>

            <div>
                <x-input-label for="name" :value="__('Nombres')" />
                <x-text-input id="name" name="name" type="text" class="block w-full mt-1"
                    :value="old('name', $user->name)" disabled autocomplete="name" />
            </div>

            <div>
                <x-input-label for="apellidos" :value="__('Apellidos')" />
                <x-text-input id="apellidos" name="apellidos" type="text" class="block w-full mt-1"
                    :value="old('apellidos', $user->apellidos)" disabled autocomplete="apellidos" />
            </div>

            <div>
                <x-input-label for="fecha_nacimiento" :value="__('Fecha de nacimiento')" />
                <x-date-input id="fecha_nacimiento" name="fecha_nacimiento" type="number" class="block w-full mt-1"
                    :value="old('fecha_nacimiento', $user->fecha_nacimiento)" autocomplete="fecha_nacimiento"
                    disabled />
            </div>

            <div>
                <x-input-label for="username" :value="__('Usuario del sistema')" />
                <x-text-input id="username" name="username" type="text" class="block w-full mt-1"
                    :value="old('username', $user->username)" disabled autocomplete="username" />
            </div>

            <div>
                <x-input-label for="direccion" :value="__('Dirección')" />
                <x-text-input id="direccion" name="direccion" type="text" class="block w-full mt-1"
                    :value="old('direccion', $user->direccion)" disabled autocomplete="direccion" />
            </div>

            <div>
                <x-input-label for="telefono" :value="__('Télefono')" />
                <x-text-input id="telefono" name="telefono" type="text" class="block w-full mt-1"
                    :value="old('telefono', $user->telefono)" disabled autocomplete="telefono" />
            </div>

            <div>
                <x-input-label for="correo" :value="__('Correo')" />
                <x-text-input id="correo" name="correo" type="text" class="block w-full mt-1"
                    :value="old('correo', $user->correo)" disabled autocomplete="correo" />
            </div>

            <div>
                <x-input-label for="fecha_inicio" :value="__('Fecha de inicio')" />
                <x-date-input id="fecha_inicio" name="fecha_inicio" type="number" class="block w-full mt-1"
                    :value="old('fecha_inicio', $user->fecha_inicio)" autocomplete="fecha_inicio" disabled />
            </div>

            <div>
                <x-input-label for="referencia_1" :value="__('Referencia 1')" />
                <x-text-input id="referencia_1" name="referencia_1" type="text" class="block w-full mt-1"
                    :value="old('referencia_1', $user->referencia_1)" disabled autocomplete="referencia_1" />
            </div>

            <div>
                <x-input-label for="referencia_2" :value="__('Referencia 2')" />
                <x-text-input id="referencia_2" name="referencia_2" type="text" class="block w-full mt-1"
                    :value="old('referencia_2', $user->referencia_2)" disabled autocomplete="referencia_2" />
            </div>

            <div>
                <x-input-label for="nombre_contacto_emergencia" :value="__('Nombre contacto emergencia')" />
                <x-text-input id="nombre_contacto_emergencia" name="nombre_contacto_emergencia" type="text"
                    class="block w-full mt-1"
                    :value="old('nombre_contacto_emergencia', $user->nombre_contacto_emergencia)" disabled
                    autocomplete="nombre_contacto_emergencia" />
            </div>

            <div>
                <x-input-label for="numero_contacto_emergencia" :value="__('Número contacto emergencia')" />
                <x-text-input id="numero_contacto_emergencia" name="numero_contacto_emergencia" type="text"
                    class="block w-full mt-1"
                    :value="old('numero_contacto_emergencia', $user->numero_contacto_emergencia)" disabled
                    autocomplete="numero_contacto_emergencia" />
            </div>

            <div>
                <x-input-label for="horario" :value="__('Horario')" />
                <x-text-input id="horario" name="horario" type="text" class="block w-full mt-1"
                    :value="old('horario', $user->horario)" disabled autocomplete="horario" />
            </div>

            <div>
                <x-input-label for="eps" :value="__('EPS')" />
                <x-text-input id="eps" name="eps" type="text" class="block w-full mt-1" :value="old('eps', $user->eps)"
                    disabled autocomplete="eps" />
            </div>

            <div>
                <x-input-label for="pension" :value="__('Pensión')" />
                <x-text-input id="pension" name="pension" type="text" class="block w-full mt-1"
                    :value="old('pension', $user->pension)" disabled autocomplete="pension" />
            </div>

            <div>
                <x-input-label for="banco" :value="__('Banco')" />
                <x-text-input id="banco" name="banco" type="text" class="block w-full mt-1"
                    :value="old('banco', $user->banco)" disabled autocomplete="banco" />
            </div>

            <div>
                <x-input-label for="numero_cuenta" :value="__('Número de cuenta')" />
                <x-text-input id="numero_cuenta" name="numero_cuenta" type="text" class="block w-full mt-1"
                    :value="old('numero_cuenta', $user->numero_cuenta)" disabled autocomplete="numero_cuenta" />
            </div>

            <div>
                <x-input-label for="sucursal" :value="__('Sucursal')" />
                <x-text-input id="sucursal" name="sucursal" type="text" class="block w-full mt-1"
                    :value="old('sucursal', $user->sucursal->nombre_sucursal)" disabled autocomplete="sucursal" />
            </div>

            <div>
                <x-input-label for="cargo" :value="__('Cargo')" />
                <x-text-input id="cargo" name="cargo" type="text" class="block w-full mt-1"
                    :value="old('cargo', $user->cargo)" disabled autocomplete="cargo" />
            </div>


        </div>
    </form>
</section>