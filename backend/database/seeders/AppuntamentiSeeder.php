<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppuntamentiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('appuntamenti')->insert([
            [
                'paziente_id'   => 1, // Luca Bianchi
                'medico_id'     => 1, // Marco Ferretti (cardiologo)
                'servizio_id'   => 1, // Visita cardiologica
                'sede_id'       => 1, // Sede Principale
                'data_ora'      => '2026-06-10 09:00:00',
                'durata_minuti' => 30,
                'stato'         => 'confermato',
                'note'          => null,
            ],
            [
                'paziente_id'   => 2, // Sofia Greco
                'medico_id'     => 2, // Alessia Conti (ginecologa)
                'servizio_id'   => 2, // Visita ginecologica
                'sede_id'       => 1, // Sede Principale
                'data_ora'      => '2026-06-11 09:00:00',
                'durata_minuti' => 30,
                'stato'         => 'confermato',
                'note'          => 'Prima visita',
            ],
            [
                'paziente_id'   => 3, // Marco Ferrari
                'medico_id'     => 7, // Giuseppe Ferrara (pediatra)
                'servizio_id'   => 7, // Visita pediatrica
                'sede_id'       => 1, // Sede Principale
                'data_ora'      => '2026-06-12 14:00:00',
                'durata_minuti' => 30,
                'stato'         => 'confermato',
                'note'          => null,
            ],
            [
                'paziente_id'   => 1, // Luca Bianchi
                'medico_id'     => 6, // Paolo De Luca (neurologo)
                'servizio_id'   => 6, // Visita neurologica
                'sede_id'       => 1, // Sede Principale
                'data_ora'      => '2026-05-10 14:00:00',
                'durata_minuti' => 45,
                'stato'         => 'completato', // visita già svolta
                'note'          => null,
            ],
        ]);
    }
}