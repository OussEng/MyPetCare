<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('etats')->insert([
            ['libelle' => 'En attente'],
            ['libelle' => 'Confimé'],
            ['libelle' => 'Anullé'],
            ['libelle' => 'Passé'],
        ]);
    }
}
