<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LangueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('langues')->insert([
            ['libelle' => 'Francais'],
            ['libelle' => 'Anglais'],
            ['libelle' => 'Arab'],
            ['libelle' => 'Chinois'],
            ['libelle' => 'Allemand'],
        ]);
    }
}
