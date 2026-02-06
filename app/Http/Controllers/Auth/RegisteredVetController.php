<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Requests\RegisterUserDTO;
use App\DTOs\Requests\VeterinarianCreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\VeterinarianRequest;
use App\Repositories\UserRepository;
use App\Repositories\VeterinarianRepository;
use App\Services\UserService;
use App\Services\VeterinarianService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredVetController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register-vet');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(
        RegisterUserRequest $userRequest,
        VeterinarianRequest $vetRequest,
        UserService $userService,
        VeterinarianService $vetService,
        UserRepository $userRepository,
        VeterinarianRepository $veterinarianRepository,
    ) {
        $userDTO = RegisterUserDTO::fromRequest($userRequest);
        $vetDTO = VeterinarianCreateDTO::fromRequest($vetRequest);


        $user = $userService->register($userDTO, 'veterinarian', $userRepository);

        $vetService->createVeterinarian($vetDTO, $user->id,$veterinarianRepository);


        event(new Registered($user));
        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
