<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicoSedeSeeder extends Seeder
{
    public function run(): void
    {
        // Ogni riga associa un medico a una sede.
        // Gli id corrispondono all'ordine di inserimento nei seeder precedenti.
        // Sedi: 1=Principale, 2=Centro, 3=Mirafiori, 4=Moncalieri, 5=Collegno
        DB::table('medico_sede')->insert([
            ['medico_id' => 1, 'sede_id' => 1], // Ferretti → Principale
            ['medico_id' => 1, 'sede_id' => 2], // Ferretti → Centro
            ['medico_id' => 2, 'sede_id' => 1], // Conti → Principale
            ['medico_id' => 2, 'sede_id' => 5], // Conti → Collegno
            ['medico_id' => 3, 'sede_id' => 1], // Esposito → Principale
            ['medico_id' => 3, 'sede_id' => 3], // Esposito → Mirafiori
            ['medico_id' => 4, 'sede_id' => 1], // Ricci → Principale
            ['medico_id' => 5, 'sede_id' => 1], // Fontana → Principale
            ['medico_id' => 5, 'sede_id' => 2], // Fontana → Centro
            ['medico_id' => 6, 'sede_id' => 1], // De Luca → Principale
            ['medico_id' => 6, 'sede_id' => 4], // De Luca → Moncalieri
            ['medico_id' => 7, 'sede_id' => 1], // Ferrara → Principale
            ['medico_id' => 7, 'sede_id' => 3], // Ferrara → Mirafiori
        ]);
    }
}