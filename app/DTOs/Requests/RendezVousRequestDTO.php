<?php

namespace App\DTOs\Requests;

use App\Http\Requests\RendezVousRequest;
use DateTimeImmutable;

class RendezVousRequestDTO
{


    public function __construct(
        public DateTimeImmutable $dateHeureDebut,
        public string $motif,
        public int $user_id,
        public int $veterinaire_id,
        public int $animal_id,
    )
    {}

    /**
     * @throws \Exception
     */
    public static function fromArray(array $data): self
    {
        return new self(
            new DateTimeImmutable($data['dateHeureDebut']),
            $data['motif'],
            $data['user_id'],
            $data['veterinaire_id'],
            $data['animal_id'],
        );
    }


    public static function fromRequest(RendezVousRequest $request): self
    {
        return self::fromArray($request->validated());
    }

    public function toArray(): array
    {
        return [
            'dateHeureDebut' => $this->dateHeureDebut->format('Y-m-d H:i:s'),
            'motif' => $this->motif,
            'user_id' => $this->user_id,
            'veterinaire_id' => $this->veterinaire_id,
            'animal_id' => $this->animal_id,
        ];

    }



}
