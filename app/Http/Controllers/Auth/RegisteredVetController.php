<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Vet;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'numero' => ['required', 'string'],
            'address' => ['required', 'string'],


            'numeroLicence' => ['required', 'string'],
            'nomClinique'=> ['required', 'string'],
            'NbAnsExperience'=> ['required', 'int'],
            'dateDeNaissance'=> ['required', 'date'],
            'certification'=> ['required', 'string'],
            'licenceExpiration'=> ['required', 'date'],
            'horaires'=> ['required', 'string'],
        ]);

        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'numero' => $request->numero,
            'address' => $request->address,
        ]);


        if ($user) {



            $vet = Vet::create([
                'numeroLicence' => $request->numeroLicence,
                'nomClinique' => $request->nomClinique,
                'NbAnsExperience' => $request->NbAnsExperience,
                'dateDeNaissance' => $request->dateDeNaissance,
                'certification' => $request->certification,
                'licenceExpiration' => $request->licenceExpiration,
                'horaires' => $request->horaires,
                'user_id' => $user->id,

            ]);
            $role = Role::where('role', 'vet')->first();
            $user->roles()->attach($role);
        }



        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
