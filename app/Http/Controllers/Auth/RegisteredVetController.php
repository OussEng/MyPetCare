<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Requests\User\RegisterUserDTO;
use App\DTOs\Requests\Veterinaire\VeterinaireCreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\RegisterVeterinaireRequest;
use App\Http\Requests\VeterinaireRequest;
use App\Repositories\UserRepository;
use App\Repositories\VeterinaireRepository;
use App\Services\UserService;
use App\Services\VeterinaireService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RegisteredVetController extends Controller
{

    private UserService $userService;
    private VeterinaireService $veterinaireService;

    public function __construct(UserService $userService, VeterinaireService $veterinaireService){
        $this->userService = $userService;
        $this->veterinaireService = $veterinaireService;
    }



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
     * @throws \Throwable
     */
    public function store(
        RegisterVeterinaireRequest $request,
    ) {
        $userDTO = RegisterUserDTO::fromRequest($request);
        $vetDTO = VeterinaireCreateDTO::fromRequest($request);

        $user = DB::transaction(function () use ($userDTO, $vetDTO) {
            $user = $this->userService->register($userDTO);
            $this->veterinaireService->createVeterinarian($vetDTO, $user->id);

            return $user;
        });



        event(new Registered($user));
        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
