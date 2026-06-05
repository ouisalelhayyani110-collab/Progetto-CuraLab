<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SediSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sedi')->insert([
            [
                'nome'      => 'CuraLab - Sede Principale',
                'indirizzo' => 'Via della Salute 1',
                'citta'     => 'Torino',
                'cap'       => '10140',
                'telefono'  => '011 123456',
                'email'     => 'info@curalab.it',
            ],
            [
                'nome'      => 'CuraLab - Sede Centro',
                'indirizzo' => 'Corso Vittorio Emanuele 34',
                'citta'     => 'Torino',
                'cap'       => '10123',
                'telefono'  => '011 234567',
                'email'     => 'centro@curalab.it',
            ],
            [
                'nome'      => 'CuraLab - Sede Mirafiori',
                'indirizzo' => 'Via Giordano Bruno 12',
                'citta'     => 'Torino',
                'cap'       => '10137',
                'telefono'  => '011 345678',
                'email'     => 'mirafiori@curalab.it',
            ],
            [
                'nome'      => 'CuraLab - Sede Moncalieri',
                'indirizzo' => 'Via Roma 88',
                'citta'     => 'Moncalieri',
                'cap'       => '10024',
                'telefono'  => '011 456789',
                'email'     => 'moncalieri@curalab.it',
            ],
            [
                'nome'      => 'CuraLab - Sede Collegno',
                'indirizzo' => 'Corso Francia 200',
                'citta'     => 'Collegno',
                'cap'       => '10093',
                'telefono'  => '011 567890',
                'email'     => 'collegno@curalab.it',
            ],
        ]);
    }
}