<?php

namespace App\Services;

use App\DTOs\Response\SexeResponseDTO;
use App\Repositories\SexeRepository;
use Illuminate\Support\Collection;

class SexeServices
{

    private SexeRepository $sexeRepository;

    public function __construct(SexeRepository $sexeRepository)
    {
        $this->sexeRepository = $sexeRepository;
    }

    public function getSexes() : Collection
    {

      $sexes =  $this->sexeRepository->findSexes();

      return $sexes->map(fn($sexe) => SexeResponseDTO::fromModel($sexe));

    }

}
