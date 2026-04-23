<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Requests\RendezVous\RendezVousRequestDTO;
use App\Http\Requests\RendezVousRequest;
use DateTimeImmutable;
use Tests\TestCase;

class RendezVousRequestDTOTest extends TestCase
{
    private array $validData = [
        'dateHeureDebut'  => '2026-04-15 10:00:00',
        'motif'           => 'Consultation annuelle',
        'user_id'         => 1,
        'veterinaire_id'  => 2,
        'animal_id'       => 3,
    ];

    public function test_fromArray_maps_all_fields_correctly(): void
    {
        $dto = RendezVousRequestDTO::fromArray($this->validData);

        $this->assertInstanceOf(DateTimeImmutable::class, $dto->dateHeureDebut);
        $this->assertSame('2026-04-15 10:00:00', $dto->dateHeureDebut->format('Y-m-d H:i:s'));
        $this->assertSame('Consultation annuelle', $dto->motif);
        $this->assertSame(1, $dto->user_id);
        $this->assertSame(2, $dto->veterinaire_id);
        $this->assertSame(3, $dto->animal_id);
    }

    public function test_fromArray_parses_date_correctly(): void
    {
        $dto = RendezVousRequestDTO::fromArray($this->validData);

        $this->assertSame('2026-04-15', $dto->dateHeureDebut->format('Y-m-d'));
        $this->assertSame('10:00:00', $dto->dateHeureDebut->format('H:i:s'));
    }

    public function test_fromRequest_delegates_to_fromArray_with_validated_data(): void
    {
        $requestMock = \Mockery::mock(RendezVousRequest::class);
        $requestMock->shouldReceive('validated')->once()->andReturn($this->validData);

        $dto = RendezVousRequestDTO::fromRequest($requestMock);

        $this->assertInstanceOf(RendezVousRequestDTO::class, $dto);
        $this->assertSame('Consultation annuelle', $dto->motif);
    }

    public function test_toArray_returns_correct_keys(): void
    {
        $dto   = RendezVousRequestDTO::fromArray($this->validData);
        $array = $dto->toArray();

        $this->assertArrayHasKey('dateHeureDebut', $array);
        $this->assertArrayHasKey('motif', $array);
        $this->assertArrayHasKey('user_id', $array);
        $this->assertArrayHasKey('veterinaire_id', $array);
        $this->assertArrayHasKey('animal_id', $array);
    }

    public function test_toArray_formats_date_as_string(): void
    {
        $dto   = RendezVousRequestDTO::fromArray($this->validData);
        $array = $dto->toArray();

        $this->assertIsString($array['dateHeureDebut']);
        $this->assertSame('2026-04-15 10:00:00', $array['dateHeureDebut']);
    }

    public function test_toArray_preserves_scalar_values(): void
    {
        $dto   = RendezVousRequestDTO::fromArray($this->validData);
        $array = $dto->toArray();

        $this->assertSame('Consultation annuelle', $array['motif']);
        $this->assertSame(1, $array['user_id']);
        $this->assertSame(2, $array['veterinaire_id']);
        $this->assertSame(3, $array['animal_id']);
    }


}

