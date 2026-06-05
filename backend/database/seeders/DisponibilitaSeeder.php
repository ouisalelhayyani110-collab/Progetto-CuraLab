<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisponibilitaSeeder extends Seeder
{
    public function run(): void
    {
        // giorno_settimana: 0=lunedì, 1=martedì, 2=mercoledì, 3=giovedì, 4=venerdì, 5=sabato, 6=domenica
        DB::table('disponibilita')->insert([

            // Marco Ferretti (cardiologo) — sedi 1 e 2
            ['medico_id' => 1, 'sede_id' => 1, 'giorno_settimana' => 0, 'ora_inizio' => '09:00', 'ora_fine' => '13:00', 'durata_slot_minuti' => 30], // lun mattina, Principale
            ['medico_id' => 1, 'sede_id' => 1, 'giorno_settimana' => 2, 'ora_inizio' => '14:00', 'ora_fine' => '18:00', 'durata_slot_minuti' => 30], // mer pomeriggio, Principale
            ['medico_id' => 1, 'sede_id' => 2, 'giorno_settimana' => 4, 'ora_inizio' => '09:00', 'ora_fine' => '13:00', 'durata_slot_minuti' => 30], // ven mattina, Centro

            // Alessia Conti (ginecologa) — sedi 1 e 5
            ['medico_id' => 2, 'sede_id' => 1, 'giorno_settimana' => 1, 'ora_inizio' => '09:00', 'ora_fine' => '13:00', 'durata_slot_minuti' => 30], // mar mattina, Principale
            ['medico_id' => 2, 'sede_id' => 1, 'giorno_settimana' => 4, 'ora_inizio' => '14:00', 'ora_fine' => '18:00', 'durata_slot_minuti' => 30], // ven pomeriggio, Principale
            ['medico_id' => 2, 'sede_id' => 5, 'giorno_settimana' => 3, 'ora_inizio' => '09:00', 'ora_fine' => '13:00', 'durata_slot_minuti' => 30], // gio mattina, Collegno

            // Roberto Esposito (ortopedico) — sedi 1 e 3
            ['medico_id' => 3, 'sede_id' => 1, 'giorno_settimana' => 0, 'ora_inizio' => '09:00', 'ora_fine' => '13:00', 'durata_slot_minuti' => 30], // lun mattina, Principale
            ['medico_id' => 3, 'sede_id' => 1, 'giorno_settimana' => 3, 'ora_inizio' => '09:00', 'ora_fine' => '13:00', 'durata_slot_minuti' => 30], // gio mattina, Principale
            ['medico_id' => 3, 'sede_id' => 3, 'giorno_settimana' => 5, 'ora_inizio' => '09:00', 'ora_fine' => '12:00', 'durata_slot_minuti' => 30], // sab mattina, Mirafiori

            // Francesca Ricci (ostetrica) — sede 1
            ['medico_id' => 4, 'sede_id' => 1, 'giorno_settimana' => 1, 'ora_inizio' => '09:00', 'ora_fine' => '13:00', 'durata_slot_minuti' => 30], // mar mattina, Principale
            ['medico_id' => 4, 'sede_id' => 1, 'giorno_settimana' => 4, 'ora_inizio' => '09:00', 'ora_fine' => '13:00', 'durata_slot_minuti' => 30], // ven mattina, Principale

            // Andrea Fontana (dermatologo) — sedi 1 e 2
            ['medico_id' => 5, 'sede_id' => 1, 'giorno_settimana' => 2, 'ora_inizio' => '09:00', 'ora_fine' => '13:00', 'durata_slot_minuti' => 30], // mer mattina, Principale
            ['medico_id' => 5, 'sede_id' => 2, 'giorno_settimana' => 0, 'ora_inizio' => '14:00', 'ora_fine' => '18:00', 'durata_slot_minuti' => 30], // lun pomeriggio, Centro
            ['medico_id' => 5, 'sede_id' => 2, 'giorno_settimana' => 5, 'ora_inizio' => '09:00', 'ora_fine' => '12:00', 'durata_slot_minuti' => 30], // sab mattina, Centro

            // Paolo De Luca (neurologo) — sedi 1 e 4, slot da 45 min
            ['medico_id' => 6, 'sede_id' => 1, 'giorno_settimana' => 0, 'ora_inizio' => '14:00', 'ora_fine' => '18:00', 'durata_slot_minuti' => 45], // lun pomeriggio, Principale
            ['medico_id' => 6, 'sede_id' => 4, 'giorno_settimana' => 3, 'ora_inizio' => '09:00', 'ora_fine' => '13:00', 'durata_slot_minuti' => 45], // gio mattina, Moncalieri

            // Giuseppe Ferrara (pediatra) — sedi 1 e 3
            ['medico_id' => 7, 'sede_id' => 1, 'giorno_settimana' => 2, 'ora_inizio' => '14:00', 'ora_fine' => '18:00', 'durata_slot_minuti' => 30], // mer pomeriggio, Principale
            ['medico_id' => 7, 'sede_id' => 3, 'giorno_settimana' => 5, 'ora_inizio' => '09:00', 'ora_fine' => '12:00', 'durata_slot_minuti' => 30], // sab mattina, Mirafiori
        ]);
    }
}