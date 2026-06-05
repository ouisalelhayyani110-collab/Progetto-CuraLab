<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiziSeeder extends Seeder
{
    public function run(): void
    {
        // specializzazione_id corrisponde all'ordine di inserimento
        // in SpecializzazioniSeeder: 1=Cardiologia, 2=Ginecologia, ecc.
        DB::table('servizi')->insert([
            [
                'specializzazione_id' => 1,
                'nome'                => 'Visita cardiologica',
                'descrizione'         => 'Valutazione della salute del cuore e del sistema cardiovascolare',
                'durata_default_min'  => 30,
            ],
            [
                'specializzazione_id' => 2,
                'nome'                => 'Visita ginecologica',
                'descrizione'         => 'Controllo della salute e prevenzione dell\'apparato femminile',
                'durata_default_min'  => 30,
            ],
            [
                'specializzazione_id' => 3,
                'nome'                => 'Visita ortopedica',
                'descrizione'         => 'Valutazione di ossa, articolazioni e apparato muscolo-scheletrico',
                'durata_default_min'  => 30,
            ],
            [
                'specializzazione_id' => 4,
                'nome'                => 'Visita ostetrica',
                'descrizione'         => 'Controllo e assistenza medica in gravidanza e puerperio',
                'durata_default_min'  => 30,
            ],
            [
                'specializzazione_id' => 5,
                'nome'                => 'Visita dermatologica',
                'descrizione'         => 'Diagnosi e trattamento delle malattie della pelle',
                'durata_default_min'  => 30,
            ],
            [
                'specializzazione_id' => 6,
                'nome'                => 'Visita neurologica',
                'descrizione'         => 'Valutazione del sistema nervoso centrale e periferico',
                'durata_default_min'  => 45,
            ],
            [
                'specializzazione_id' => 7,
                'nome'                => 'Visita pediatrica',
                'descrizione'         => 'Controllo della salute e dello sviluppo di neonati e bambini',
                'durata_default_min'  => 30,
            ],
        ]);
    }
}