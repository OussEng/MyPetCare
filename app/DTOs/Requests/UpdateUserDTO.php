<?php

namespace App\DTOs\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserDTO
{
    public function __construct(
        public readonly string $prenom,
        public readonly string $nom,
        public readonly string $email,
        public readonly string $numero,
        public readonly string $adresse,
    ) {}

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            prenom:  $request->validated('prenom'),
            nom:     $request->validated('nom'),
            email:   $request->validated('email'),
            numero:  $request->validated('numero'),
            adresse: $request->validated('adresse'),
        );
    }

    public function toArray(): array
    {
        return [
            'prenom'  => $this->prenom,
            'nom'     => $this->nom,
            'email'   => $this->email,
            'numero'  => $this->numero,
            'adresse' => $this->adresse,
        ];
    }
}

