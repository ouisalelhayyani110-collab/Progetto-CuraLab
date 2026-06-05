<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RichiestaContatto extends Model
{
    protected $table = 'richieste_contatto';

    // Questa tabella ha solo data_invio, impostata automaticamente
    // dal database tramite DEFAULT CURRENT_TIMESTAMP nella migration.
    // Non usiamo created_at/updated_at di Laravel.
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'email',
        'oggetto',
        'messaggio',
        'paziente_id',
        'presa_in_carico',
    ];

    protected $casts = [
        'presa_in_carico' => 'boolean',  // 0/1 dal DB: true/false in PHP
        'data_invio'      => 'datetime', // stringa dal DB: oggetto Carbon
    ];

    // RELAZIONI

    // Una richiesta può appartenere a un paziente registrato,
    // oppure essere NULL se inviata da un visitatore non registrato
    public function paziente()
    {
        return $this->belongsTo(Paziente::class, 'paziente_id');
    }
}