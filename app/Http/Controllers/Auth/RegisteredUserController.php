<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Requests\User\RegisterUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{

    private UserService $userService;


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


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
     * @throws \Throwable
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $dto = RegisterUserDTO::fromRequest($request);
        $user = $this->userService->register($dto);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('home', absolute: false))->with("success" , "Vous étes inscrit avec success");
    }
}
