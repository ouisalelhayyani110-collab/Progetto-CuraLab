<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nome -->
        <div>
            <x-input-label for="nome" :value="__('Nome')" />
            <x-text-input id="nome" class="block mt-1 w-full" type="text" name="nome"
                :value="old('nome')" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('nome')" class="mt-2" />
        </div>

        <!-- Cognome -->
        <div class="mt-4">
            <x-input-label for="cognome" :value="__('Cognome')" />
            <x-text-input id="cognome" class="block mt-1 w-full" type="text" name="cognome"
                :value="old('cognome')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('cognome')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Conferma Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Conferma Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Consenso Termini -->
        <div class="mt-4">
            <label class="flex items-center">
                <input type="checkbox" name="consenso_termini" class="rounded border-gray-300"
                    {{ old('consenso_termini') ? 'checked' : '' }} />
                <span class="ms-2 text-sm text-gray-600">
                    Accetto i <a href="#" class="underline hover:text-gray-900">Termini e Condizioni</a>
                </span>
            </label>
            <x-input-error :messages="$errors->get('consenso_termini')" class="mt-2" />
        </div>

        <!-- Consenso Privacy -->
        <div class="mt-4">
            <label class="flex items-center">
                <input type="checkbox" name="consenso_privacy" class="rounded border-gray-300"
                    {{ old('consenso_privacy') ? 'checked' : '' }} />
                <span class="ms-2 text-sm text-gray-600">
                    Accetto la <a href="#" class="underline hover:text-gray-900">Informativa Privacy</a>
                </span>
            </label>
            <x-input-error :messages="$errors->get('consenso_privacy')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Hai già un account?') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Registrati') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>