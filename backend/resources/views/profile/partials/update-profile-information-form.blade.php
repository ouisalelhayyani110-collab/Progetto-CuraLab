<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informazioni Profilo') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Aggiorna il tuo nome, cognome e indirizzo email.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Nome -->
        <div>
            <x-input-label for="nome" :value="__('Nome')" />
            <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full"
                :value="old('nome', $user->nome)" required autofocus autocomplete="given-name" />
            <x-input-error class="mt-2" :messages="$errors->get('nome')" />
        </div>

        <!-- Cognome -->
        <div>
            <x-input-label for="cognome" :value="__('Cognome')" />
            <x-text-input id="cognome" name="cognome" type="text" class="mt-1 block w-full"
                :value="old('cognome', $user->cognome)" required autocomplete="family-name" />
            <x-input-error class="mt-2" :messages="$errors->get('cognome')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- Se il paziente ha cambiato email, mostra un avviso --}}
            @if (! $user->email_confermata)
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('La tua email non è ancora verificata.') }}
                </p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Salva') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">
                    {{ __('Salvato.') }}
                </p>
            @endif
        </div>
    </form>
</section>