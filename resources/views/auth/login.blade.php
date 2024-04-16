<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="text-center mb-7">
            <x-input-label class="!text-2xl text-white font-semibold" :value="__('Iniciar Sesión')" />
        </div>
        <!-- Email Address -->
        <div>
            <x-input-label class="text-white font-semibold" for="Nombre de usuario" :value="__('Nombre de usuario')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" class="text-white font-semibold" :value="__('Constraseña')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3 !bg-[#E6A930] !border-white !border-2">
                {{ __('Iniciar sesión') }}&nbsp;<i class="fa-solid fa-right-to-bracket"></i>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>