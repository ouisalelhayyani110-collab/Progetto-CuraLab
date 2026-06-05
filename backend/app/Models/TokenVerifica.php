<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenVerifica extends Model
{
    protected $table = 'token_verifica';

    // Questa tabella ha solo created_at, non updated_at.
    // Disabilitiamo la gestione automatica dei timestamp e
    // lasciamo che il database imposti created_at da solo
    // tramite il DEFAULT CURRENT_TIMESTAMP definito nella migration.
    public $timestamps = false;

    protected $fillable = [
        'paziente_id',
        'token',
        'tipo',
        'scadenza',
        'usato',
    ];

    // $casts converte automaticamente i valori dal DB al tipo PHP corretto
    protected $casts = [
        'scadenza' => 'datetime', // stringa dal DB → oggetto Carbon (data/ora)
        'usato'    => 'boolean',  // 0/1 dal DB → true/false in PHP
    ];

    // RELAZIONI

    // Un token appartiene a un paziente
    public function paziente()
    {
        return $this->belongsTo(Paziente::class, 'paziente_id');
    }
}