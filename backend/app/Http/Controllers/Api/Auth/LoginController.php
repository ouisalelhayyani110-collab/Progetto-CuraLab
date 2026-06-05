<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Paziente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Autentica il paziente e restituisce un token di accesso
    public function store(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cerca il paziente per email
        $paziente = Paziente::where('email', $request->email)->first();

        // Verifica che esista e che la password sia corretta
        if (! $paziente || ! Hash::check($request->password, $paziente->password_hash)) {
            throw ValidationException::withMessages([
                'email' => ['Le credenziali non sono corrette.'],
            ]);
        }

        // Crea e restituisce un nuovo token
        $token = $paziente->createToken('auth_token')->plainTextToken;

        return response()->json([
            'paziente' => $paziente,
            'token'    => $token,
        ]);
    }

    // Revoca il token corrente (logout)
    public function destroy(Request $request)
    {
        // Elimina solo il token usato in questa richiesta,
        // non tutti i token del paziente
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'messaggio' => 'Logout effettuato con successo.',
        ]);
    }
}