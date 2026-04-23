<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Requests\User\RegisterUserDTO;
use App\DTOs\Requests\Veterinaire\VeterinaireCreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\VeterinaireRequest;
use App\Repositories\UserRepository;
use App\Repositories\VeterinaireRepository;
use App\Services\UserService;
use App\Services\VeterinaireService;
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
        RegisterUserRequest   $userRequest,
        VeterinaireRequest    $vetRequest,
        UserService           $userService,
        VeterinaireService    $vetService,
        UserRepository        $userRepository,
        VeterinaireRepository $veterinarianRepository,
    ) {
        $userDTO = RegisterUserDTO::fromRequest($userRequest);
        $vetDTO = VeterinaireCreateDTO::fromRequest($vetRequest);


        $user = $userService->register($userDTO);

        $vetService->createVeterinarian($vetDTO, $user->id,$veterinarianRepository);


        event(new Registered($user));
        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
