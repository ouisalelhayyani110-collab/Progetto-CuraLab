<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specializzazione extends Model
{
    protected $table = 'specializzazioni';

    public $timestamps = false;

    // $fillable definisce le colonne che possono essere salvate tramite
    // mass assignment, cioè passando un array a create() o update().
    // Esempio: Specializzazione::create(['nome' => '...', 'descrizione' => '...'])
    // È una protezione di sicurezza: se un utente invia campi extra
    // (es. 'id' o altri campi sensibili), Laravel li ignora automaticamente.
    // Qualsiasi colonna NON elencata qui non potrà essere salvata via array.
    protected $fillable = ['nome', 'descrizione'];

    // RELAZIONI

    // Una specializzazione ha molti servizi (hasMany)
    // Equivale al FK specializzazione_id nella tabella servizi
    public function servizi()
    {
        return $this->hasMany(Servizio::class, 'specializzazione_id');
    }

    // Una specializzazione ha molti medici (hasMany)
    // Equivale al FK specializzazione_id nella tabella medici
    public function medici()
    {
        return $this->hasMany(Medico::class, 'specializzazione_id');
    }
}