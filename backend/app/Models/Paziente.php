<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

// Authenticatable invece di Model: aggiunge tutto il necessario
// per l'autenticazione (login, sessioni, remember me...)
// SoftDeletes: aggiunge la logica del soft delete tramite deleted_at
class Paziente extends Authenticatable
{
    use HasApiTokens, SoftDeletes;

    // Nome esplicito — Laravel pluralizzerebbe "pazientes"
    protected $table = 'pazienti';

    protected $fillable = [
        'nome',
        'cognome',
        'email',
        'password_hash',
        'telefono',
        'data_nascita',
        'codice_fiscale',
        'email_confermata',
        'consenso_termini',
        'consenso_privacy',
    ];

    // Campi esclusi quando il Model viene convertito in JSON (es. nelle API).
    // La password e il codice fiscale non devono mai essere esposti
    protected $hidden = [
        'password_hash',
        'codice_fiscale',
    ];

    // $casts dice a Laravel come convertire automaticamente i valori
    // dal database al tipo PHP corretto quando li leggi dal Model.
    // Esempio: 'email_confermata' arriva dal DB come 0/1 ma lo leggi come true/false
    protected $casts = [
        'data_nascita'      => 'date',
        'email_confermata'  => 'boolean',
        'consenso_termini'  => 'boolean',
        'consenso_privacy'  => 'boolean',
        'deleted_at'        => 'datetime',
    ];

    // Laravel si aspetta che il campo password si chiami "password".
    // Nel DB si chiama "password_hash", questo metodo dice al sistema
    // di autenticazione quale colonna usare per verificare la password
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    // RELAZIONI

    // Un paziente ha molti appuntamenti
    public function appuntamenti()
    {
        return $this->hasMany(Appuntamento::class, 'paziente_id');
    }

    // Un paziente ha molti token (conferma email, reset password)
    public function tokenVerifica()
    {
        return $this->hasMany(TokenVerifica::class, 'paziente_id');
    }

    // Un paziente può aver inviato molte richieste di contatto
    public function richiesteContatto()
    {
        return $this->hasMany(RichiestaContatto::class, 'paziente_id');
    }
}