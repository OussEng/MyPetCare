<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Response\LangueResponseDTO;
use App\Models\Langue;
use Tests\TestCase;

class LangueResponseDTOTest extends TestCase
{
    public function test_fromModel_maps_id_and_libelle(): void
    {
        $langue = Langue::factory()->make(['id' => 3, 'libelle' => 'Français']);

        $dto = LangueResponseDTO::fromModel($langue);

        $this->assertSame(3, $dto->id);
        $this->assertSame('Français', $dto->libelle);
    }

    public function test_fromModel_with_different_language(): void
    {
        $langue = Langue::factory()->make(['id' => 7, 'libelle' => 'Anglais']);

        $dto = LangueResponseDTO::fromModel($langue);

        $this->assertSame(7, $dto->id);
        $this->assertSame('Anglais', $dto->libelle);
    }

    public function test_constructor_sets_properties(): void
    {
        $dto = new LangueResponseDTO(1, 'Arabe');

        $this->assertSame(1, $dto->id);
        $this->assertSame('Arabe', $dto->libelle);
    }
}

