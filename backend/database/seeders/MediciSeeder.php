<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediciSeeder extends Seeder
{
    public function run(): void
    {
        // specializzazione_id segue l'ordine di SpecializzazioniSeeder:
        // 1=Cardiologia, 2=Ginecologia, 3=Ortopedia, 4=Ostetricia,
        // 5=Dermatologia, 6=Neurologia, 7=Pediatria
        DB::table('medici')->insert([
            [
                'nome'                => 'Marco',
                'cognome'             => 'Ferretti',
                'specializzazione_id' => 1,
                'email'               => 'm.ferretti@curalab.it',
                'telefono'            => '011 111001',
                'foto'                => null,
                'biografia'           => 'Cardiologo con 15 anni di esperienza in cardiologia interventistica e prevenzione cardiovascolare.',
            ],
            [
                'nome'                => 'Alessia',
                'cognome'             => 'Conti',
                'specializzazione_id' => 2,
                'email'               => 'a.conti@curalab.it',
                'telefono'            => '011 111002',
                'foto'                => null,
                'biografia'           => 'Ginecologa con esperienza in ginecologia oncologica e medicina della riproduzione.',
            ],
            [
                'nome'                => 'Roberto',
                'cognome'             => 'Esposito',
                'specializzazione_id' => 3,
                'email'               => 'r.esposito@curalab.it',
                'telefono'            => '011 111003',
                'foto'                => null,
                'biografia'           => 'Ortopedico specializzato in patologie del ginocchio e della spalla, esperto in medicina dello sport.',
            ],
            [
                'nome'                => 'Francesca',
                'cognome'             => 'Ricci',
                'specializzazione_id' => 4,
                'email'               => 'f.ricci@curalab.it',
                'telefono'            => '011 111004',
                'foto'                => null,
                'biografia'           => 'Ostetrica con esperienza in assistenza alla gravidanza fisiologica e preparazione al parto.',
            ],
            [
                'nome'                => 'Andrea',
                'cognome'             => 'Fontana',
                'specializzazione_id' => 5,
                'email'               => 'a.fontana@curalab.it',
                'telefono'            => '011 111005',
                'foto'                => null,
                'biografia'           => 'Dermatologo esperto in dermatologia estetica, mappatura nei e trattamento dell\'acne.',
            ],
            [
                'nome'                => 'Paolo',
                'cognome'             => 'De Luca',
                'specializzazione_id' => 6,
                'email'               => 'p.deluca@curalab.it',
                'telefono'            => '011 111006',
                'foto'                => null,
                'biografia'           => 'Neurologo con esperienza nella diagnosi e trattamento delle malattie del sistema nervoso centrale e periferico.',
            ],
            [
                'nome'                => 'Giuseppe',
                'cognome'             => 'Ferrara',
                'specializzazione_id' => 7,
                'email'               => 'g.ferrara@curalab.it',
                'telefono'            => '011 111007',
                'foto'                => null,
                'biografia'           => 'Pediatra con esperienza nella cura e nel monitoraggio della salute e dello sviluppo di neonati e bambini.',
            ],
        ]);
    }
}