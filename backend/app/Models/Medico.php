<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    // Nome esplicito — Laravel pluralizzerebbe "medicos"
    protected $table = 'medici';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'cognome',
        'specializzazione_id',
        'email',
        'telefono',
        'foto',
        'biografia'
    ];

    // RELAZIONI

    // Un medico appartiene a una specializzazione
    public function specializzazione()
    {
        return $this->belongsTo(Specializzazione::class, 'specializzazione_id');
    }

    // Un medico opera in molte sedi (N:M tramite medico_sede)
    public function sedi()
    {
        return $this->belongsToMany(Sede::class, 'medico_sede');
    }

    // Un medico eroga molti servizi (N:M tramite medico_servizio)
    public function servizi()
    {
        return $this->belongsToMany(Servizio::class, 'medico_servizio');
    }

    // Un medico ha molte fasce di disponibilità settimanale
    public function disponibilita()
    {
        return $this->hasMany(Disponibilita::class, 'medico_id');
    }

    // Un medico ha molti appuntamenti
    public function appuntamenti()
    {
        return $this->hasMany(Appuntamento::class, 'medico_id');
    }
}