<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = DB::table('users')->insertGetId([
            'prenom' => 'Admin',
            'nom' => 'Admin',
            'email' => 'admin@mypet.com',
            'password' => bcrypt('Pa$$w0rd'),
            'numero' => '0700000000',
            'adresse' => '1 rue du france',
        ]);


        $roleId = DB::table('roles')->where('role','admin')->value('id');


        DB::table('role_user')->insert([
            'user_id' => $userId,
            'role_id' => $roleId,
        ]);
    }
}
