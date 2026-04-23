<?php

namespace App\DTOs\Requests\User;

use Illuminate\Http\Request;

class UserRequestDTO
{
    public function __construct(
        public int $id,
        public string $prenom,
        public string $nom,
        public string $email,
        public string $numero,
        public string $adresse,
        public ?string $deleted_at,
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
            $data['deleted_at']
        );
    }

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromModel(mixed $user): UserRequestDTO
    {
        return new self(
            $user->id,
            $user->prenom,
            $user->nom,
            $user->email,
            $user->numero,
            $user->adresse,
            $user->deleted_at,
        );
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
            'deleted_at' => $this->deleted_at,
        ];
    }


}
