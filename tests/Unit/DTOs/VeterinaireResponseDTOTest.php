<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Requests\UserRequestDTO;
use App\DTOs\Response\LangueResponseDTO;
use App\DTOs\Response\VeterinaireResponseDTO;
use App\Models\Langue;
use App\Models\User;
use App\Models\Vet;
use Tests\TestCase;

class VeterinaireResponseDTOTest extends TestCase
{
    private function makeFullVet(array $override = []): Vet
    {
        $user = User::factory()->make([
            'id'      => 1,
            'prenom'  => 'Paul',
            'nom'     => 'Vet',
            'email'   => 'paul@vet.com',
            'numero'  => '0600000000',
            'adresse' => '1 rue',
        ]);

        $vet = Vet::factory()->make(array_merge([
            'id'               => 1,
            'numeroLicence'    => 'LIC-001',
            'nomClinique'      => 'Clinique Test',
            'adresseClinique'  => '10 avenue',
            'NbAnsExperience'  => 8,
            'dateDeNaissance'  => '1980-01-01',
            'licenceExpiration' => '2030-01-01',
            'certification'    => 'CPAV',
            'user_id'          => 1,
        ], $override));

        $vet->setRelation('user', $user);
        $vet->setRelation('langues', collect());

        return $vet;
    }

    public function test_fromModel_maps_all_scalar_fields(): void
    {
        $vet = $this->makeFullVet();

        $dto = VeterinaireResponseDTO::fromModel($vet);

        $this->assertSame(1, $dto->id);
        $this->assertSame('LIC-001', $dto->numeroLicence);
        $this->assertSame('Clinique Test', $dto->nomClinique);
        $this->assertSame('10 avenue', $dto->adresseClinique);
        $this->assertSame(8, $dto->NbAnsExperience);
        $this->assertSame('1980-01-01', $dto->dateDeNaissance);
        $this->assertSame('2030-01-01', $dto->licenceExpiration);
        $this->assertSame('CPAV', $dto->certification);
        $this->assertSame(1, $dto->user_id);
    }

    public function test_fromModel_maps_user_as_UserRequestDTO(): void
    {
        $vet = $this->makeFullVet();

        $dto = VeterinaireResponseDTO::fromModel($vet);

        $this->assertInstanceOf(UserRequestDTO::class, $dto->user);
        $this->assertSame('Paul', $dto->user->prenom);
    }

    public function test_fromModel_maps_empty_langues_collection(): void
    {
        $vet = $this->makeFullVet();

        $dto = VeterinaireResponseDTO::fromModel($vet);

        $this->assertCount(0, $dto->langues);
    }

    public function test_fromModel_maps_langues_as_LangueResponseDTOs(): void
    {
        $vet    = $this->makeFullVet();
        $langue = Langue::factory()->make(['id' => 1, 'libelle' => 'Français']);
        $vet->setRelation('langues', collect([$langue]));

        $dto = VeterinaireResponseDTO::fromModel($vet);

        $this->assertCount(1, $dto->langues);
        $this->assertInstanceOf(LangueResponseDTO::class, $dto->langues->first());
        $this->assertSame('Français', $dto->langues->first()->libelle);
    }
}

