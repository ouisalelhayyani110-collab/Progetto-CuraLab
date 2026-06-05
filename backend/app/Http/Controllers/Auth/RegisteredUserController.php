<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Paziente; // Usiamo Paziente al posto di User
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // Mostra la pagina di registrazione
    public function create(): View
    {
        return view('auth.register');
    }

    // Gestisce l'invio del form di registrazione
    public function store(Request $request): RedirectResponse
    {
        // Validazione dei campi inviati dal form.
        // Se un campo non passa la validazione, Laravel torna
        // automaticamente alla pagina precedente con i messaggi di errore.
        $request->validate([
            'nome'             => ['required', 'string', 'max:100'],
            'cognome'          => ['required', 'string', 'max:100'],
            'email'            => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:pazienti'],
            'password'         => ['required', 'confirmed', Rules\Password::defaults()],
            // 'accepted' verifica che la checkbox sia stata spuntata
            'consenso_termini' => ['required', 'accepted'],
            'consenso_privacy' => ['required', 'accepted'],
        ]);

        // Crea il nuovo paziente nel database.
        // Hash::make() genera l'hash bcrypt della password.
        $paziente = Paziente::create([
            'nome'             => $request->nome,
            'cognome'          => $request->cognome,
            'email'            => $request->email,
            'password_hash'    => Hash::make($request->password),
            'consenso_termini' => true,
            'consenso_privacy' => true,
        ]);

        // Lancia l'evento Registered — necessario per l'invio
        // dell'email di verifica
        event(new Registered($paziente));

        // Effettua il login automatico dopo la registrazione
        Auth::login($paziente);

        return redirect(route('dashboard', absolute: false));
    }
}