<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    // Restituisce tutti i medici con la loro specializzazione in formato JSON
    public function index()
    {
        $medici = Medico::with('specializzazione')->get();

        return response()->json($medici);
    }
}