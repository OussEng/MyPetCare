<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\RendezVous;
use App\Models\User;
use App\Models\Vet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{

    public function index(Request $request, $id)
    {

        $vet = Vet::find($id);
        $rendez_vouss = RendezVous::where('veterinaire_id' , $id)->get();

        $animaux = Animal::where('user_id', Auth::id())->get();

        $selectedDate = $request->input('date');
        $slots = [];

        if ($selectedDate) {
            $day = Carbon::parse($selectedDate)->setTime(9, 0);
            for ($i = 0; $i <= 7; $i++) {
                $slots[] = $day->copy()->toDateTimeString();
                $day->addMinutes(60);
            }
        }



        foreach ($rendez_vouss as $rendez_vous) {
            if (in_array($rendez_vous->dateHeuredebut, $slots)) {
                $key = array_search($rendez_vous->dateHeuredebut, $slots);

                if ($key !== false) {
                    unset($slots[$key]);
                }
            }
        }







        return view('rendez-vous.rendez-vous', [
            'selectedDate' => $selectedDate,
            'slots' => $slots,
            'animaux' => $animaux,
            'vet' => $vet,
            'id' => $id
        ]);
    }


    public function store(Request $request, $id){

        $rendez_vous = new RendezVous();
        $rendez_vous->dateHeuredebut = $request->input('slot');
        $rendez_vous->motif = $request->input('motif');
        $rendez_vous->animal_id = $request->input('animal_id');
        $rendez_vous->veterinaire_id = $id;
        $rendez_vous->etat_id = 1;
        $rendez_vous->user_id = Auth::id();


        $rendez_vous->save();
        return redirect('/rendez-vous');

    }


    public function list(){

        $rendezvous = RendezVous::where('user_id' , Auth::id())->get();


        return view('animal.mes-rendez-vous' , [
            'rendezvous' => $rendezvous
        ]);

    }

}
