<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\User;
use App\Models\Vet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RendezVousController extends Controller
{

    public function list_vets()
    {
        $vets = Vet::all();

        return view('vet.vet-list' , [
            'vets' => $vets]);
    }

    public function vet_profile($id)
    {
        $vet = Vet::find($id);

        return view('vet.vet-profile' , [
            'vet' => $vet
        ]);

    }



    public function index(Request $request)
    {
        $rendez_vouss = RendezVous::all();

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
        ]);
    }


    public function store(Request $request){

        $rendez_vous = new RendezVous();
        $rendez_vous->datededebut = $request->input('slot');
        $rendez_vous->motif = $request->input('motif');
        $rendez_vous->user_id = Auth::id();


        dd($rendez_vous);










    }

}
