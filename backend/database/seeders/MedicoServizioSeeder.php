<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicoServizioSeeder extends Seeder
{
    public function run(): void
    {
        // Ogni medico eroga il servizio della propria specializzazione.
        // Gli id di medici e servizi coincidono perché entrambi
        // seguono lo stesso ordine delle specializzazioni.
        DB::table('medico_servizio')->insert([
            ['medico_id' => 1, 'servizio_id' => 1], // Ferretti → Visita cardiologica
            ['medico_id' => 2, 'servizio_id' => 2], // Conti → Visita ginecologica
            ['medico_id' => 3, 'servizio_id' => 3], // Esposito → Visita ortopedica
            ['medico_id' => 4, 'servizio_id' => 4], // Ricci → Visita ostetrica
            ['medico_id' => 5, 'servizio_id' => 5], // Fontana → Visita dermatologica
            ['medico_id' => 6, 'servizio_id' => 6], // De Luca → Visita neurologica
            ['medico_id' => 7, 'servizio_id' => 7], // Ferrara → Visita pediatrica
        ]);
    }
}