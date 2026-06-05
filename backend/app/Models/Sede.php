<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    // Nome esplicito della tabella — Laravel pluralizzerebbe "sedes"
    protected $table = 'sedi';

    // Questa tabella non ha created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'indirizzo',
        'citta',
        'cap',
        'telefono',
        'email'
    ];

    // RELAZIONI

    // Una sede è collegata a molti medici tramite la tabella ponte medico_sede.
    // belongsToMany gestisce automaticamente le tabelle N:M —
    // non serve un Model separato per medico_sede.
    public function medici()
    {
        return $this->belongsToMany(Medico::class, 'medico_sede');
    }

    // Una sede ha molte disponibilità (i turni dei medici in quella sede)
    public function disponibilita()
    {
        return $this->hasMany(Disponibilita::class, 'sede_id');
    }

    // Una sede ha molti appuntamenti
    public function appuntamenti()
    {
        return $this->hasMany(Appuntamento::class, 'sede_id');
    }
}