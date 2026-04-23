<?php

namespace App\Services;

use App\DTOs\Response\Langue\LangueResponseDTO;
use App\Repositories\LangueRepository;

class LangueService
{
    private LangueRepository $langueRepository;

    /**
     * @param LangueRepository $langueRepository
     */
    public function __construct(LangueRepository $langueRepository)
    {
        $this->langueRepository = $langueRepository;
    }


    public function getLangues(){

        $langues = $this->langueRepository->findAll();

        return $langues->map(fn($langue) => LangueResponseDTO::fromModel($langue));

    }


}
