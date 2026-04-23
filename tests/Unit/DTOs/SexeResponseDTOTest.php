<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Response\Sexe\SexeResponseDTO;
use App\Models\Sexe;
use Tests\TestCase;

class SexeResponseDTOTest extends TestCase
{
    public function test_fromModel_maps_id_and_libelle(): void
    {
        $sexe = Sexe::factory()->make(['id' => 1, 'libelle' => 'Mâle']);

        $dto = SexeResponseDTO::fromModel($sexe);

        $this->assertSame(1, $dto->id);
        $this->assertSame('Mâle', $dto->libelle);
    }

    public function test_fromModel_maps_femelle_value(): void
    {
        $sexe = Sexe::factory()->make(['id' => 2, 'libelle' => 'Femelle']);

        $dto = SexeResponseDTO::fromModel($sexe);

        $this->assertSame(2, $dto->id);
        $this->assertSame('Femelle', $dto->libelle);
    }

    public function test_constructor_sets_properties(): void
    {
        $dto = new SexeResponseDTO(5, 'Autre');

        $this->assertSame(5, $dto->id);
        $this->assertSame('Autre', $dto->libelle);
    }
}

