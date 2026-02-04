<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class UserDTO
{
    public function __construct(
        public int $id,
        public string $prenom,
        public string $nom,
        public string $email,
        public string $numero,
        public string $adresse,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['prenom'],
            $data['nom'],
            $data['email'],
            $data['numero'],
            $data['adresse'],
        );
    }

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'email' => $this->email,
            'numero' => $this->numero,
            'adresse' => $this->adresse,
        ];
    }


}
