<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disponibilita extends Model
{
    // Nome esplicito — Laravel pluralizzerebbe "disponibilitas"
    protected $table = 'disponibilita';

    public $timestamps = false;

    protected $fillable = [
        'medico_id',
        'sede_id',
        'giorno_settimana',
        'ora_inizio',
        'ora_fine',
        'durata_slot_minuti'
    ];

    // RELAZIONI

    // Una fascia di disponibilità appartiene a un medico
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    // Una fascia di disponibilità appartiene a una sede
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }
}