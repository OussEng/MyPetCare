<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Response\VaccinationResponseDTO;
use App\Models\Vaccination;
use Tests\TestCase;

class VaccinationResponseDTOTest extends TestCase
{
    public function test_fromModel_maps_all_fields(): void
    {
        $vac = Vaccination::factory()->make([
            'id'          => 10,
            'nom_vaccine' => 'Rabies',
            'info'        => 'Vaccin contre la rage',
            'espece_id'   => 1,  // override FK
        ]);

        $dto = VaccinationResponseDTO::fromModel($vac);

        $this->assertSame(10, $dto->id);
        $this->assertSame('Rabies', $dto->nom_vaccine);
        $this->assertSame('Vaccin contre la rage', $dto->info);
    }

    public function test_fromModel_maps_different_vaccine(): void
    {
        $vac = Vaccination::factory()->make([
            'id'          => 20,
            'nom_vaccine' => 'Parvovirus',
            'info'        => 'Protection contre le parvovirus',
            'espece_id'   => 1,  // override FK
        ]);

        $dto = VaccinationResponseDTO::fromModel($vac);

        $this->assertSame(20, $dto->id);
        $this->assertSame('Parvovirus', $dto->nom_vaccine);
    }

    public function test_constructor_sets_all_properties(): void
    {
        $dto = new VaccinationResponseDTO(5, 'Leptospirose', 'Info vaccin');

        $this->assertSame(5, $dto->id);
        $this->assertSame('Leptospirose', $dto->nom_vaccine);
        $this->assertSame('Info vaccin', $dto->info);
    }
}


