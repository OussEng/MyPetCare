<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Requests\User\UserRequestDTO;
use App\DTOs\Response\Animal\AnimalResponseDTO;
use App\DTOs\Response\RendezVous\RendezVousResponseDTO;
use App\DTOs\Response\User\UserSimpleDTO;
use App\DTOs\Response\Veterinaire\VeterinaireResponseDTO;
use App\Enums\Etat;
use App\Models\Animal;
use App\Models\Espece;
use App\Models\RendezVous;
use App\Models\Sexe;
use App\Models\User;
use App\Models\Vet;
use DateTimeImmutable;
use Tests\TestCase;

class RendezVousResponseDTOTest extends TestCase
{
    private function makeFullRendezVous(): RendezVous
    {

        $user = User::factory()->make(['id' => 1, 'prenom' => 'Jean', 'nom' => 'Client',
            'email' => 'jean@test.com', 'numero' => '0600', 'adresse' => '1 rue']);


        $vetUser = User::factory()->make(['id' => 2, 'prenom' => 'Paul', 'nom' => 'VetDoc',
            'email' => 'paul@vet.com', 'numero' => '0611', 'adresse' => '2 av']);
        $vet = Vet::factory()->make([
            'id' => 1, 'user_id' => 2,
            'numeroLicence' => 'LIC-001', 'nomClinique' => 'Clin', 'adresseClinique' => '2 av',
            'NbAnsExperience' => 5, 'dateDeNaissance' => '1980-01-01',
            'licenceExpiration' => '2030-01-01', 'certification' => 'CPAV',
        ]);
        $vet->setRelation('user', $vetUser);
        $vet->setRelation('langues', collect());

        // Build animal
        $espece = Espece::factory()->make(['id' => 1, 'libelle' => 'Chien']);
        $espece->setRelation('vaccinations', collect());
        $sexe = Sexe::factory()->make(['id' => 1, 'libelle' => 'Mâle']);
        $animal = Animal::factory()->make([
            'id'        => 1,
            'nom'       => 'Rex',
            'sexe_id'   => 1,
            'espece_id' => 1,
            'user_id'   => 1,
        ]);
        $animal->setRelation('espece', $espece);
        $animal->setRelation('sexe', $sexe);
        $animal->setRelation('user', $user);
        $animal->setRelation('vaccinations', collect());

        // Build rendez-vous
        $rv = RendezVous::factory()->make([
            'id'             => 10,
            'dateHeureDebut' => '2026-05-01 09:00:00',
            'motif'          => 'Visite annuelle',
            'etat'           => Etat::CONFIRMER,
            'user_id'        => 1,
            'animal_id'      => 1,
            'veterinaire_id' => 1,
        ]);
        $rv->setRelation('user', $user);
        $rv->setRelation('veterinaire', $vet);
        $rv->setRelation('animal', $animal);

        return $rv;
    }

    public function test_fromModel_maps_id_and_motif(): void
    {
        $rv  = $this->makeFullRendezVous();
        $dto = RendezVousResponseDTO::fromModel($rv);

        $this->assertSame(10, $dto->id);
        $this->assertSame('Visite annuelle', $dto->motif);
    }

    public function test_fromModel_maps_dateHeureDebut_as_DateTimeImmutable(): void
    {
        $rv  = $this->makeFullRendezVous();
        $dto = RendezVousResponseDTO::fromModel($rv);

        $this->assertInstanceOf(DateTimeImmutable::class, $dto->dateHeureDebut);
        $this->assertSame('2026-05-01', $dto->dateHeureDebut->format('Y-m-d'));
    }

    public function test_fromModel_maps_etat_as_Etat_enum(): void
    {
        $rv  = $this->makeFullRendezVous();
        $dto = RendezVousResponseDTO::fromModel($rv);

        $this->assertInstanceOf(Etat::class, $dto->etat);
        $this->assertSame(Etat::CONFIRMER, $dto->etat);
    }

    public function test_fromModel_maps_user_as_UserSimpleDTO(): void
    {
        $rv  = $this->makeFullRendezVous();
        $dto = RendezVousResponseDTO::fromModel($rv);

        $this->assertInstanceOf(UserSimpleDTO::class, $dto->user);
        $this->assertSame(1, $dto->user->id);
    }

    public function test_fromModel_maps_veterinaire_as_VeterinaireResponseDTO(): void
    {
        $rv  = $this->makeFullRendezVous();
        $dto = RendezVousResponseDTO::fromModel($rv);

        $this->assertInstanceOf(VeterinaireResponseDTO::class, $dto->veterinaire);
        $this->assertSame('LIC-001', $dto->veterinaire->numeroLicence);
    }

    public function test_fromModel_maps_animal_as_AnimalResponseDTO(): void
    {
        $rv  = $this->makeFullRendezVous();
        $dto = RendezVousResponseDTO::fromModel($rv);

        $this->assertInstanceOf(AnimalResponseDTO::class, $dto->animal);
        $this->assertSame('Rex', $dto->animal->nom);
    }
}



