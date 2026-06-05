<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servizio extends Model
{
    // Nome esplicito — Laravel pluralizzerebbe "servizios"
    protected $table = 'servizi';

    public $timestamps = false;

    protected $fillable = [
        'specializzazione_id',
        'nome',
        'descrizione',
        'durata_default_min'
    ];

    // RELAZIONI

    // Un servizio appartiene a una specializzazione (belongsTo).
    // È il lato "figlio" della relazione — contiene la FK specializzazione_id.
    // Opposto di hasMany: se Specializzazione hasMany Servizio,
    // allora Servizio belongsTo Specializzazione.
    public function specializzazione()
    {
        return $this->belongsTo(Specializzazione::class, 'specializzazione_id');
    }

    // Un servizio è erogato da molti medici tramite la tabella ponte medico_servizio
    public function medici()
    {
        return $this->belongsToMany(Medico::class, 'medico_servizio');
    }

    // Un servizio ha molti appuntamenti
    public function appuntamenti()
    {
        return $this->hasMany(Appuntamento::class, 'servizio_id');
    }
}