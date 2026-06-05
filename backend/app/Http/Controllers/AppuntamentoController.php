<?php

namespace App\Http\Controllers;

use App\Models\Appuntamento;
use App\Models\Servizio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppuntamentoController extends Controller
{
    // Lista appuntamenti del paziente autenticato
    public function index()
    {
        $appuntamenti = Appuntamento::with(['medico', 'servizio', 'sede'])
            ->where('paziente_id', Auth::id())
            ->orderBy('data_ora', 'desc')
            ->get();

        return response()->json($appuntamenti);
    }

    // Prenota un nuovo appuntamento
    public function store(Request $request)
    {
        $request->validate([
            'medico_id'   => ['required', 'exists:medici,id'],
            'servizio_id' => ['required', 'exists:servizi,id'],
            'sede_id'     => ['required', 'exists:sedi,id'],
            'data_ora'    => ['required', 'date', 'after:now'],
        ]);

        // Copia la durata dal servizio nell'appuntamento
        // per preservare lo storico anche se la durata cambia in futuro
        $servizio = Servizio::find($request->servizio_id);

        $appuntamento = Appuntamento::create([
            'paziente_id'   => Auth::id(),
            'medico_id'     => $request->medico_id,
            'servizio_id'   => $request->servizio_id,
            'sede_id'       => $request->sede_id,
            'data_ora'      => $request->data_ora,
            'durata_minuti' => $servizio->durata_default_min,
            'stato'         => 'confermato',
        ]);

        return response()->json([
            'messaggio'    => 'Appuntamento prenotato con successo.',
            'appuntamento' => $appuntamento->load(['medico', 'servizio', 'sede']),
        ], 201);
    }

    // Cancella un appuntamento (con regola delle 24 ore)
    public function destroy(Appuntamento $appuntamento)
    {
        // Verifica che l'appuntamento appartenga al paziente autenticato
        if ($appuntamento->paziente_id !== Auth::id()) {
            return response()->json([
                'messaggio' => 'Non autorizzato.',
            ], 403);
        }

        // Regola delle 24 ore: non si può cancellare se mancano
        // meno di 24 ore all'appuntamento
        if (now()->diffInHours($appuntamento->data_ora, false) < 24) {
            return response()->json([
                'messaggio' => 'Non è possibile cancellare un appuntamento nelle 24 ore precedenti.',
            ], 422);
        }

        $appuntamento->update(['stato' => 'annullato']);

        return response()->json([
            'messaggio' => 'Appuntamento cancellato con successo.',
        ]);
    }
}