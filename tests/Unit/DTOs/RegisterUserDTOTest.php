<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Requests\User\RegisterUserDTO;
use Illuminate\Http\Request;
use Tests\TestCase;

class RegisterUserDTOTest extends TestCase
{
    private array $validData = [
        'prenom'  => 'Jean',
        'nom'     => 'Dupont',
        'email'   => 'jean@example.com',
        'password' => 'Secret123!',
        'numero'  => 612345678,
        'adresse' => '1 rue de la Paix',
    ];

    public function test_fromArray_maps_all_fields_correctly(): void
    {
        $dto = RegisterUserDTO::fromArray($this->validData);

        $this->assertSame('Jean', $dto->prenom);
        $this->assertSame('Dupont', $dto->nom);
        $this->assertSame('jean@example.com', $dto->email);
        $this->assertSame('Secret123!', $dto->password);
        $this->assertSame(612345678, $dto->numero);
        $this->assertSame('1 rue de la Paix', $dto->adresse);
    }

    public function test_fromRequest_calls_validated_and_maps_correctly(): void
    {
        $requestMock = \Mockery::mock(Request::class);
        $requestMock->shouldReceive('validated')->once()->andReturn($this->validData);

        $dto = RegisterUserDTO::fromRequest($requestMock);

        $this->assertInstanceOf(RegisterUserDTO::class, $dto);
        $this->assertSame('Jean', $dto->prenom);
        $this->assertSame('jean@example.com', $dto->email);
    }

    public function test_toArray_returns_all_expected_keys(): void
    {
        $dto = RegisterUserDTO::fromArray($this->validData);

        $array = $dto->toArray();

        $this->assertArrayHasKey('prenom', $array);
        $this->assertArrayHasKey('nom', $array);
        $this->assertArrayHasKey('email', $array);
        $this->assertArrayHasKey('password', $array);
        $this->assertArrayHasKey('numero', $array);
        $this->assertArrayHasKey('adresse', $array);
    }

    public function test_toArray_values_match_constructor_values(): void
    {
        $dto   = RegisterUserDTO::fromArray($this->validData);
        $array = $dto->toArray();

        $this->assertSame('Jean', $array['prenom']);
        $this->assertSame('Dupont', $array['nom']);
        $this->assertSame('jean@example.com', $array['email']);
        $this->assertSame('Secret123!', $array['password']);
        $this->assertSame(612345678, $array['numero']);
        $this->assertSame('1 rue de la Paix', $array['adresse']);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}

