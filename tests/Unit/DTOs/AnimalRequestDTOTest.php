<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Requests\Animal\AnimalRequestDTO;
use App\Http\Requests\AnimalRequest;
use Tests\TestCase;

class AnimalRequestDTOTest extends TestCase
{
    private array $validData = [
        'nom'           => 'Rex',
        'espece_id'     => 1,
        'race'          => 'Labrador',
        'dateNaissance' => '2020-01-01',
        'poids'         => '10.5',
        'sexe_id'       => 2,
        'user_id'       => 3,
    ];

    public function test_fromArray_maps_all_fields_correctly(): void
    {
        $dto = AnimalRequestDTO::fromArray($this->validData);

        $this->assertSame('Rex', $dto->nom);
        $this->assertSame(1, $dto->espece_id);
        $this->assertSame('Labrador', $dto->race);
        $this->assertSame('2020-01-01', $dto->dateNaissance);
        $this->assertSame('10.5', $dto->poids);
        // sexe_id and user_id are typed as ?string / string in the DTO
        $this->assertSame('2', (string) $dto->sexe_id);
        $this->assertSame('3', (string) $dto->user_id);
    }

    public function test_fromArray_handles_nullable_fields_as_null(): void
    {
        $data = array_merge($this->validData, [
            'race'          => null,
            'dateNaissance' => null,
            'poids'         => null,
        ]);

        $dto = AnimalRequestDTO::fromArray($data);

        $this->assertNull($dto->race);
        $this->assertNull($dto->dateNaissance);
        $this->assertNull($dto->poids);
    }

    public function test_fromRequest_delegates_to_fromArray_with_validated_data(): void
    {
        $requestMock = \Mockery::mock(AnimalRequest::class);
        $requestMock->shouldReceive('validated')->once()->andReturn($this->validData);

        $dto = AnimalRequestDTO::fromRequest($requestMock);

        $this->assertInstanceOf(AnimalRequestDTO::class, $dto);
        $this->assertSame('Rex', $dto->nom);
    }

    public function test_toArray_returns_correct_keys_and_values(): void
    {
        $dto = AnimalRequestDTO::fromArray($this->validData);

        $array = $dto->toArray();

        $this->assertArrayHasKey('nom', $array);
        $this->assertArrayHasKey('espece_id', $array);
        $this->assertArrayHasKey('race', $array);
        $this->assertArrayHasKey('dateNaissance', $array);
        $this->assertArrayHasKey('poids', $array);
        $this->assertArrayHasKey('sexe_id', $array);
        $this->assertArrayHasKey('user_id', $array);
        $this->assertSame('Rex', $array['nom']);
        $this->assertSame(1, $array['espece_id']);
    }

    public function test_toArray_preserves_null_nullable_fields(): void
    {
        $data = array_merge($this->validData, ['race' => null, 'poids' => null, 'dateNaissance' => null]);
        $dto  = AnimalRequestDTO::fromArray($data);

        $array = $dto->toArray();

        $this->assertNull($array['race']);
        $this->assertNull($array['poids']);
        $this->assertNull($array['dateNaissance']);
    }

}


