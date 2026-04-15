<?php

namespace App\DTOs\Requests;

use App\Http\Requests\AnimalRequest;


class AnimalRequestDTO
{
    public function __construct(
        public string  $nom,
        public int    $espece_id,
        public ?string  $race = null,
        public ?string $dateNaissance = null,
        public ?string $poids = null,
        public ?string $sexe_id,
        public string $user_id,
    ) {}

    public static function fromArray(array $data) : self
    {
        return new self(
            $data['nom'],
            $data['espece_id'],
            $data['race'],
            $data['dateNaissance'],
            $data['poids'],
            $data['sexe_id'],
            $data['user_id'],
        );
    }

    public static function fromRequest(AnimalRequest $request): self
    {
        return self::fromArray($request->validated());
    }

    public function toArray(): array
    {
        return [
            'nom' => $this->nom,
            'espece_id' => $this->espece_id,
            'race' => $this->race,
            'dateNaissance' => $this->dateNaissance,
            'poids' => $this->poids,
            'sexe_id' => $this->sexe_id,
            'user_id' => $this->user_id,
        ];
    }



}
