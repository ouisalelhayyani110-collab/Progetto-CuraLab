<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\AppuntamentoController;
use App\Http\Controllers\ContattoController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\ServizioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ─── AUTENTICAZIONE ───────────────────────────────────────────────────────────

// Route pubbliche — non richiedono token
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);

// Route protette — richiedono token Sanctum nell'header
Route::middleware('auth:sanctum')->group(function () {

    // Dati del paziente autenticato
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout — revoca il token corrente
    Route::post('/logout', [LoginController::class, 'destroy']);
});

// ─── PAGINE PUBBLICHE ─────────────────────────────────────────────────────────

Route::get('/medici',  [MedicoController::class,  'index']);
Route::get('/servizi', [ServizioController::class, 'index']);
Route::get('/sedi',    [SedeController::class,    'index']);
Route::post('/contatti', [ContattoController::class, 'store']);

// ─── AREA PAZIENTE ────────────────────────────────────────────────────────────

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/appuntamenti',            [AppuntamentoController::class, 'index']);
    Route::post('/appuntamenti',           [AppuntamentoController::class, 'store']);
    Route::delete('/appuntamenti/{appuntamento}', [AppuntamentoController::class, 'destroy']);
});