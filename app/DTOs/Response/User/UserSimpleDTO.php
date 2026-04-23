<?php

namespace App\DTOs\Response\User;

use App\Models\User;


class UserSimpleDTO
{
    public function __construct(
        public int $id,
        public string $prenom,
        public string $nom,
        public string $email,
        public string $password,
        public string $numero,
        public string $adresse,
        public ?string    $deleted_at,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            $user->id,
            $user->prenom,
            $user->nom,
            $user->email,
            $user->password,
            $user->numero,
            $user->adresse,
            $user->deleted_at,
        );

    }



}


