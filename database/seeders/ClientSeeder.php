<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //client
        $clientId = DB::table('users')->insertGetId([
            'prenom' => 'Client',
            'nom' => 'Client',
            'email' => 'client@mypet.com',
            'password' => bcrypt('Pa$$w0rd'),
            'numero' => '0700000000',
            'adresse' => '1 rue du france',
        ]);

        $roleId = DB::table('roles')->where('role','user')->value('id');

        DB::table('role_user')->insert([
            'user_id' => $clientId,
            'role_id' => $roleId,
        ]);
    }
}
