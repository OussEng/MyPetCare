<?php

namespace App\DTOs\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class RegisterUserDTO
{
    public function __construct(
        public string $prenom,
        public string $nom,
        public string $email,
        public string $password,
        public int $numero,
        public string $adresse,
    ) {}

    public static function fromArray(array $data): self
    {

        return new self(
            $data['prenom'],
            $data['nom'],
            $data['email'],
            $data['password'],
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
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'email' => $this->email,
            'password' =>$this->password,
            'numero' => $this->numero,
            'adresse' => $this->adresse,
        ];
    }



}


