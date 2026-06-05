<?php

namespace App\Http\Controllers;

use App\Models\Servizio;
use Illuminate\Http\Request;

class ServizioController extends Controller
{
    // Restituisce tutti i servizi con la loro specializzazione in formato JSON
    public function index()
    {
        $servizi = Servizio::with('specializzazione')->get();

        return response()->json($servizi);
    }
}