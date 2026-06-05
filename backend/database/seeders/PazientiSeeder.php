<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PazientiSeeder extends Seeder
{
    public function run(): void
    {
        // Hash::make() genera un hash bcrypt sicuro della password.
        // Tutti i pazienti di test hanno password 'password' —
        // comodo per i test, da non usare mai in produzione.
        DB::table('pazienti')->insert([
            [
                'nome'              => 'Luca',
                'cognome'           => 'Bianchi',
                'email'             => 'luca.bianchi@email.it',
                'password_hash'     => Hash::make('password'),
                'telefono'          => '333 1111111',
                'data_nascita'      => '1990-05-15',
                'codice_fiscale'    => 'BNCLCU90E15L219X',
                'email_confermata'  => true,
                'consenso_termini'  => true,
                'consenso_privacy'  => true,
            ],
            [
                'nome'              => 'Sofia',
                'cognome'           => 'Greco',
                'email'             => 'sofia.greco@email.it',
                'password_hash'     => Hash::make('password'),
                'telefono'          => '333 2222222',
                'data_nascita'      => '1985-09-22',
                'codice_fiscale'    => 'GRCSFO85P62L219K',
                'email_confermata'  => true,
                'consenso_termini'  => true,
                'consenso_privacy'  => true,
            ],
            [
                'nome'              => 'Marco',
                'cognome'           => 'Ferrari',
                'email'             => 'marco.ferrari@email.it',
                'password_hash'     => Hash::make('password'),
                'telefono'          => '333 3333333',
                'data_nascita'      => '1978-03-08',
                'codice_fiscale'    => 'FRRMRC78C08L219W',
                'email_confermata'  => true,
                'consenso_termini'  => true,
                'consenso_privacy'  => true,
            ],
        ]);
    }
}