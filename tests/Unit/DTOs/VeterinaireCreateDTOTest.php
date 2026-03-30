<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Requests\VeterinaireCreateDTO;
use Illuminate\Http\Request;
use Tests\TestCase;

class VeterinaireCreateDTOTest extends TestCase
{
    private array $validData = [
        'numeroLicence'    => 'LIC-1234',
        'nomClinique'      => 'Clinique du Soleil',
        'adresseClinique'  => '10 rue du Vétérinaire',
        'NbAnsExperience'  => 5,
        'dateDeNaissance'  => '1985-06-15',
        'licenceExpiration' => '2028-12-31',
        'certification'    => 'CPAV',
    ];

    public function test_fromArray_maps_all_fields_correctly(): void
    {
        $dto = VeterinaireCreateDTO::fromArray($this->validData);

        $this->assertSame('LIC-1234', $dto->numeroLicence);
        $this->assertSame('Clinique du Soleil', $dto->nomClinique);
        $this->assertSame('10 rue du Vétérinaire', $dto->adresseClinique);
        $this->assertSame(5, $dto->NbAnsExperience);
        $this->assertSame('1985-06-15', $dto->dateDeNaissance);
        $this->assertSame('2028-12-31', $dto->licenceExpiration);
        $this->assertSame('CPAV', $dto->certification);
    }

    public function test_fromArray_allows_null_certification(): void
    {
        $data = array_merge($this->validData, ['certification' => null]);

        $dto = VeterinaireCreateDTO::fromArray($data);

        $this->assertNull($dto->certification);
    }

    public function test_fromRequest_calls_validated_and_maps(): void
    {
        $requestMock = \Mockery::mock(Request::class);
        $requestMock->shouldReceive('validated')->once()->andReturn($this->validData);

        $dto = VeterinaireCreateDTO::fromRequest($requestMock);

        $this->assertInstanceOf(VeterinaireCreateDTO::class, $dto);
        $this->assertSame('LIC-1234', $dto->numeroLicence);
    }

    public function test_toArray_contains_all_expected_keys(): void
    {
        $dto   = VeterinaireCreateDTO::fromArray($this->validData);
        $array = $dto->toArray();

        $this->assertArrayHasKey('numeroLicence', $array);
        $this->assertArrayHasKey('nomClinique', $array);
        $this->assertArrayHasKey('adresseClinique', $array);
        $this->assertArrayHasKey('NbAnsExperience', $array);
        $this->assertArrayHasKey('dateDeNaissance', $array);
        $this->assertArrayHasKey('licenceExpiration', $array);
        $this->assertArrayHasKey('certification', $array);
    }

    public function test_toArray_values_match_input(): void
    {
        $dto   = VeterinaireCreateDTO::fromArray($this->validData);
        $array = $dto->toArray();

        $this->assertSame('LIC-1234', $array['numeroLicence']);
        $this->assertSame(5, $array['NbAnsExperience']);
        $this->assertSame('CPAV', $array['certification']);
    }

}

