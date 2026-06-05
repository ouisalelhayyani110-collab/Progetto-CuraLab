<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    // Restituisce tutte le sedi in formato JSON
    public function index()
    {
        $sedi = Sede::all();

        return response()->json($sedi);
    }
}