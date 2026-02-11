<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especes = DB::table('especes')
            ->pluck('id', 'libelle');

        DB::table('vaccinations')->insert([


            [
                'nom_vaccine' => 'Typhus',
                'info' => 'Protection contre la panleucopénie féline',
                'espece_id' => $especes['Chat'],
            ],
            [
                'nom_vaccine' => 'Coryza',
                'info' => 'Protection contre les infections respiratoires félines',
                'espece_id' => $especes['Chat'],
            ],
            [
                'nom_vaccine' => 'Leucose',
                'info' => 'Protection contre le virus de la leucose féline',
                'espece_id' => $especes['Chat'],
            ],


            [
                'nom_vaccine' => 'CHPPi',
                'info' => 'Maladie de Carré, Hépatite, Parvovirose, Parainfluenza',
                'espece_id' => $especes['Chien'],
            ],
            [
                'nom_vaccine' => 'Rage',
                'info' => 'Vaccination antirabique obligatoire dans certains cas',
                'espece_id' => $especes['Chien'],
            ],
            [
                'nom_vaccine' => 'Leptospirose',
                'info' => 'Protection contre les bactéries leptospira',
                'espece_id' => $especes['Chien'],
            ],


            [
                'nom_vaccine' => 'Myxomatose',
                'info' => 'Maladie virale grave chez le lapin',
                'espece_id' => $especes['Lapin'],
            ],
            [
                'nom_vaccine' => 'VHD',
                'info' => 'Maladie hémorragique virale',
                'espece_id' => $especes['Lapin'],
            ],


            [
                'nom_vaccine' => 'Tétanos',
                'info' => 'Protection contre le tétanos équin',
                'espece_id' => $especes['Cheval'],
            ],
            [
                'nom_vaccine' => 'Grippe équine',
                'info' => 'Protection contre la grippe chez le cheval',
                'espece_id' => $especes['Cheval'],
            ],

            [
                'nom_vaccine' => 'Rage bovine',
                'info' => 'Protection contre la rage chez les bovins',
                'espece_id' => $especes['Bovin'],
            ],
            [
                'nom_vaccine' => 'Brucellose',
                'info' => 'Prévention de la brucellose bovine',
                'espece_id' => $especes['Bovin'],
            ],
            [
                'nom_vaccine' => 'Clostridies',
                'info' => 'Vaccination contre les maladies clostridiennes',
                'espece_id' => $especes['Bovin'],
            ],


            [
                'nom_vaccine' => 'Clostridies',
                'info' => 'Vaccination contre les maladies clostridiennes',
                'espece_id' => $especes['Caprin'],
            ],
            [
                'nom_vaccine' => 'Chlamydiose',
                'info' => 'Protection contre la chlamydiose chez les chèvres',
                'espece_id' => $especes['Caprin'],
            ],
            [
                'nom_vaccine' => 'Peste des petits ruminants (PPR)',
                'info' => 'Maladie virale grave chez les caprins',
                'espece_id' => $especes['Caprin'],
            ],

            [
                'nom_vaccine' => 'Clostridies',
                'info' => 'Vaccination contre les maladies clostridiennes',
                'espece_id' => $especes['Ovin'],
            ],
            [
                'nom_vaccine' => 'Fièvre catarrhale ovine',
                'info' => 'Protection contre la fièvre catarrhale des moutons',
                'espece_id' => $especes['Ovin'],
            ],
            [
                'nom_vaccine' => 'Chlamydiose',
                'info' => 'Protection contre la chlamydiose ovine',
                'espece_id' => $especes['Ovin'],
            ],
            [
                'nom_vaccine' => 'Polyomavirus aviaire',
                'info' => 'Protection contre le polyomavirus chez les psittacidés',
                'espece_id' => $especes['Oiseau'],
            ],
            [
                'nom_vaccine' => 'Maladie de Newcastle',
                'info' => 'Vaccination contre la maladie de Newcastle chez les oiseaux',
                'espece_id' => $especes['Oiseau'],
            ],

            [
                'nom_vaccine' => 'Maladie de Carré',
                'info' => 'Vaccination contre la maladie de Carré chez les furets',
                'espece_id' => $especes['Furet'],
            ],
            [
                'nom_vaccine' => 'Rage',
                'info' => 'Vaccination antirabique si obligatoire selon la réglementation',
                'espece_id' => $especes['Furet'],
            ],




        ]);
    }
}
