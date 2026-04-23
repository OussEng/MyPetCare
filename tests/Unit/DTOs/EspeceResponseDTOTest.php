<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Response\Espece\EspeceResponseDTO;
use App\DTOs\Response\Vaccination\VaccinationResponseDTO;
use App\Models\Espece;
use App\Models\Vaccination;
use Tests\TestCase;

class EspeceResponseDTOTest extends TestCase
{
    public function test_fromModel_maps_id_and_libelle(): void
    {
        $espece = Espece::factory()->make(['id' => 1, 'libelle' => 'Chien']);
        $espece->setRelation('vaccinations', collect());

        $dto = EspeceResponseDTO::fromModel($espece);

        $this->assertSame(1, $dto->id);
        $this->assertSame('Chien', $dto->libelle);
    }

    public function test_fromModel_maps_empty_vaccinations_to_empty_collection(): void
    {
        $espece = Espece::factory()->make(['id' => 2, 'libelle' => 'Chat']);
        $espece->setRelation('vaccinations', collect());

        $dto = EspeceResponseDTO::fromModel($espece);

        $this->assertCount(0, $dto->vaccinations);
    }

    public function test_fromModel_maps_vaccinations_as_VaccinationResponseDTOs(): void
    {
        $espece = Espece::factory()->make(['id' => 3, 'libelle' => 'Lapin']);
        $vac1   = Vaccination::factory()->make(['id' => 1, 'nom_vaccine' => 'Myxomatose', 'info' => 'Info', 'espece_id' => 3]);
        $vac2   = Vaccination::factory()->make(['id' => 2, 'nom_vaccine' => 'VHD', 'info' => 'Info', 'espece_id' => 3]);
        $espece->setRelation('vaccinations', collect([$vac1, $vac2]));

        $dto = EspeceResponseDTO::fromModel($espece);

        $this->assertCount(2, $dto->vaccinations);
        $this->assertInstanceOf(VaccinationResponseDTO::class, $dto->vaccinations->first());
        $this->assertSame('Myxomatose', $dto->vaccinations->first()->nom_vaccine);
    }

    public function test_constructor_sets_all_properties(): void
    {
        $dto = new EspeceResponseDTO(4, 'Perroquet', collect());

        $this->assertSame(4, $dto->id);
        $this->assertSame('Perroquet', $dto->libelle);
        $this->assertCount(0, $dto->vaccinations);
    }
}


