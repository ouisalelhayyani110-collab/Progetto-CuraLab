<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // L'ordine è fondamentale: le tabelle con FK devono essere
        // popolate dopo le tabelle a cui fanno riferimento.
        $this->call([
            SpecializzazioniSeeder::class, // nessuna FK
            SediSeeder::class,             // nessuna FK
            ServiziSeeder::class,          // FK → specializzazioni
            MediciSeeder::class,           // FK → specializzazioni
            MedicoSedeSeeder::class,       // FK → medici, sedi
            MedicoServizioSeeder::class,   // FK → medici, servizi
            DisponibilitaSeeder::class,    // FK → medici, sedi
            PazientiSeeder::class,         // nessuna FK
            AppuntamentiSeeder::class,     // FK → pazienti, medici, servizi, sedi
        ]);
    }
}