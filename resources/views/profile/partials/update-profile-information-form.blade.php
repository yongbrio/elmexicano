<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Información del perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Actualiza tu información personal.") }}
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
                <x-input-label for="numero_identificacion" :value="__('Número de identificación')" />
                <x-text-input id="numero_identificacion" name="numero_identificacion" type="number"
                    class="mt-1 block w-full" {{-- :value="old('numero_identificacion', $user->name)" --}} required
                    autofocus autocomplete="numero_identificacion" />
                <x-input-error class="mt-2" :messages="$errors->get('numero_identificacion')" />
            </div>

            <div>
                <x-input-label for="name" :value="__('Nombres')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="lastname" :value="__('Apellidos')" />
                <x-text-input id="lastname" name="lastname" type="number" class="mt-1 block w-full" {{--
                    :value="old('numero_identificacion', $user->name)" --}} required autofocus
                    autocomplete="lastname" />
                <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
            </div>

            <div>
                <x-input-label for="fecha_nacimiento" :value="__('Fecha de nacimiento')" />
                <x-date-input id="fecha_nacimiento" name="fecha_nacimiento" type="number" class="mt-1 block w-full" {{--
                    :value="old('numero_identificacion', $user->name)" --}} required autofocus
                    autocomplete="fecha_nacimiento" />
                <x-input-error class="mt-2" :messages="$errors->get('fecha_nacimiento')" />
            </div>

            <div>
                <x-input-label for="username" :value="__('Usuario del sistema')" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                    :value="old('username', $user->username)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>
        </div>
        <div class="flex items-center justify-end gap-4">
            <x-primary-button>{{ __('Actualizar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>