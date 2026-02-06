<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Requests\RegisterUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(
        RegisterUserRequest $request,
        UserRepository $userRepository,
        UserService $userService,
    ): RedirectResponse
    {
        $userDTO = RegisterUserDTO::fromRequest($request);
        $user = $userService->register($userDTO, 'user', $userRepository);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
