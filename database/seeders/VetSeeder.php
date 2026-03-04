<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = DB::table('users')->insertGetId([
            'prenom' => 'Vet',
            'nom' => 'Vet',
            'email' => 'vet@mypet.com',
            'password' => bcrypt('Pa$$w0rd'),
            'numero' => '0700000000',
            'adresse' => '1 rue du france',
        ]);

        DB::table('veterinaires')->insert([
            'numeroLicence' => 'ORDRE-75001',
            'nomClinique' => 'Pole veterinaire',
            'NbAnsExperience' => 5,
            'certification' => 'DESC Chirurgie',
            'dateDeNaissance' => '1990-01-01',
            'licenceExpiration' => '2030-01-01',
            'adresseClinique' => '1 rue du france',
            'created_at' => now(),
            'user_id' => $userId,
        ]);


        $roleId = DB::table('roles')->where('role','veterinarian')->value('id');


        DB::table('role_user')->insert([
            'user_id' => $userId,
            'role_id' => $roleId,
        ]);
    }
}
