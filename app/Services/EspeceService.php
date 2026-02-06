<?php

namespace App\Services;

use App\DTOs\Response\EspeceResponseDTO;
use App\Models\Espece;
use App\Repositories\EspeceRepository;
use Illuminate\Support\Collection;

class EspeceService
{
    private EspeceRepository $especeRepository;

    public function __construct(EspeceRepository $especeRepository){
        $this->especeRepository = $especeRepository;
    }



    public function getEspeces() : Collection
    {

        $especes = $this->especeRepository->findAll();


        return $especes->map(fn(Espece $animal) => EspeceResponseDTO::fromModel($animal));
    }



    public function getEspeceByname(string $name) : EspeceResponseDTO
    {
        $espece = $this->especeRepository->findByname($name);

        return EspeceResponseDTO::fromModel($espece);
    }

}
