<?php

namespace App\Http\Controllers;

use App\Models\RichiestaContatto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContattoController extends Controller
{
    // Salva il messaggio dal form contatti e restituisce conferma JSON
    public function store(Request $request)
    {
        $request->validate([
            'nome'      => ['required', 'string', 'max:150'],
            'email'     => ['required', 'email', 'max:150'],
            'oggetto'   => ['nullable', 'string', 'max:255'],
            'messaggio' => ['required', 'string'],
        ]);

        $richiesta = RichiestaContatto::create([
            'nome'        => $request->nome,
            'email'       => $request->email,
            'oggetto'     => $request->oggetto,
            'messaggio'   => $request->messaggio,
            // Auth::id() restituisce NULL se l'utente non è autenticato —
            // il form contatti è accessibile anche ai non registrati
            'paziente_id' => Auth::id(),
        ]);

        return response()->json([
            'messaggio' => 'Richiesta inviata con successo.',
            'data'      => $richiesta,
        ], 201);
    }
}