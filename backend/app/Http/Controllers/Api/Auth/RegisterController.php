<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Paziente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    // Registra un nuovo paziente e restituisce un token di accesso
    public function store(Request $request)
    {
        $request->validate([
            'nome'             => ['required', 'string', 'max:100'],
            'cognome'          => ['required', 'string', 'max:100'],
            'email'            => ['required', 'string', 'email', 'max:150', 'unique:pazienti'],
            'password'         => ['required', 'confirmed', Rules\Password::defaults()],
            'consenso_termini' => ['required', 'accepted'],
            'consenso_privacy' => ['required', 'accepted'],
        ]);

        $paziente = Paziente::create([
            'nome'             => $request->nome,
            'cognome'          => $request->cognome,
            'email'            => $request->email,
            'password_hash'    => Hash::make($request->password),
            'consenso_termini' => true,
            'consenso_privacy' => true,
        ]);

        // Crea un token Sanctum per il paziente appena registrato.
        // Il frontend lo salverà e lo invierà in ogni richiesta
        // nell'header: Authorization: Bearer {token}
        $token = $paziente->createToken('auth_token')->plainTextToken;

        return response()->json([
            'paziente' => $paziente,
            'token'    => $token,
        ], 201); // 201 = Created
    }
}