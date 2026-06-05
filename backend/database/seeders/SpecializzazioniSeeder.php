<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecializzazioniSeeder extends Seeder
{
    // run() viene eseguito quando si lancia "php artisan db:seed"
    public function run(): void
    {
        // DB::table()->insert() inserisce più righe in una sola query.
        // È più efficiente di chiamare Model::create() per ogni riga.
        DB::table('specializzazioni')->insert([
            ['nome' => 'Cardiologia',  'descrizione' => 'Diagnosi e cura delle malattie del cuore e del sistema cardiovascolare'],
            ['nome' => 'Ginecologia',  'descrizione' => 'Salute e prevenzione dell\'apparato riproduttivo femminile'],
            ['nome' => 'Ortopedia',    'descrizione' => 'Diagnosi e trattamento di ossa, muscoli, articolazioni e tendini'],
            ['nome' => 'Ostetricia',   'descrizione' => 'Assistenza medica in gravidanza, parto e puerperio'],
            ['nome' => 'Dermatologia', 'descrizione' => 'Diagnosi e cura delle malattie della pelle, capelli e unghie'],
            ['nome' => 'Neurologia',   'descrizione' => 'Diagnosi e cura delle malattie del sistema nervoso'],
            ['nome' => 'Pediatria',    'descrizione' => 'Salute, crescita e sviluppo di neonati e bambini'],
        ]);
    }
}