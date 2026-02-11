<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspeceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('especes')->insert([
            ['libelle' => 'Chat'],
            ['libelle' => 'Cheval'],
            ['libelle' => 'Chien'],
            ['libelle' => 'Lapin'],
            ['libelle' => 'Oiseau'],
            ['libelle' => 'Hamster'],
            ['libelle' => 'Cochon d’Inde'],
            ['libelle' => 'Furet'],
            ['libelle' => 'Reptile'],
            ['libelle' => 'Poisson'],
            ['libelle' => 'Bovin'],
            ['libelle' => 'Caprin'],
            ['libelle' => 'Ovin'],
        ]);
    }
}
