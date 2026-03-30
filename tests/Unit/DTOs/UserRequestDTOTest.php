<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Requests\UserRequestDTO;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserRequestDTOTest extends TestCase
{
    private array $validData = [
        'id'      => 42,
        'prenom'  => 'Marie',
        'nom'     => 'Martin',
        'email'   => 'marie@example.com',
        'numero'  => '0698765432',
        'adresse' => '5 avenue des Fleurs',
    ];

    public function test_fromArray_maps_all_fields_correctly(): void
    {
        $dto = UserRequestDTO::fromArray($this->validData);

        $this->assertSame(42, $dto->id);
        $this->assertSame('Marie', $dto->prenom);
        $this->assertSame('Martin', $dto->nom);
        $this->assertSame('marie@example.com', $dto->email);
        $this->assertSame('0698765432', $dto->numero);
        $this->assertSame('5 avenue des Fleurs', $dto->adresse);
    }

    public function test_fromRequest_calls_validated_and_maps(): void
    {
        $requestMock = \Mockery::mock(Request::class);
        $requestMock->shouldReceive('validated')->once()->andReturn($this->validData);

        $dto = UserRequestDTO::fromRequest($requestMock);

        $this->assertInstanceOf(UserRequestDTO::class, $dto);
        $this->assertSame(42, $dto->id);
    }

    public function test_fromModel_maps_model_attributes_correctly(): void
    {
        $user = User::factory()->make([
            'id'      => 10,
            'prenom'  => 'Paul',
            'nom'     => 'Bernard',
            'email'   => 'paul@example.com',
            'numero'  => '0611111111',
            'adresse' => '2 rue des Lilas',
        ]);

        $dto = UserRequestDTO::fromModel($user);

        $this->assertSame(10, $dto->id);
        $this->assertSame('Paul', $dto->prenom);
        $this->assertSame('Bernard', $dto->nom);
        $this->assertSame('paul@example.com', $dto->email);
        $this->assertSame('0611111111', $dto->numero);
        $this->assertSame('2 rue des Lilas', $dto->adresse);
    }

    public function test_toArray_returns_all_expected_keys(): void
    {
        $dto   = UserRequestDTO::fromArray($this->validData);
        $array = $dto->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('prenom', $array);
        $this->assertArrayHasKey('nom', $array);
        $this->assertArrayHasKey('email', $array);
        $this->assertArrayHasKey('numero', $array);
        $this->assertArrayHasKey('adresse', $array);
    }

    public function test_toArray_values_match_constructor_values(): void
    {
        $dto   = UserRequestDTO::fromArray($this->validData);
        $array = $dto->toArray();

        $this->assertSame(42, $array['id']);
        $this->assertSame('Marie', $array['prenom']);
        $this->assertSame('marie@example.com', $array['email']);
    }

}


