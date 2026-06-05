<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appuntamento extends Model
{
    // Nome esplicito — Laravel pluralizzerebbe "appuntamentos"
    protected $table = 'appuntamenti';

    // Questa tabella ha sia created_at che updated_at
    public $timestamps = true;

    protected $fillable = [
        'paziente_id',
        'medico_id',
        'servizio_id',
        'sede_id',
        'data_ora',
        'durata_minuti',
        'stato',
        'note',
    ];

    protected $casts = [
        'data_ora' => 'datetime', // stringa dal DB: oggetto Carbon (data/ora)
    ];

    // RELAZIONI

    // Un appuntamento appartiene a un paziente
    public function paziente()
    {
        return $this->belongsTo(Paziente::class, 'paziente_id');
    }

    // Un appuntamento appartiene a un medico
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    // Un appuntamento appartiene a un servizio
    public function servizio()
    {
        return $this->belongsTo(Servizio::class, 'servizio_id');
    }

    // Un appuntamento appartiene a una sede
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }
}