<?php

namespace App\Services;

use App\DTOs\Requests\RendezVousRequestDTO;
use App\DTOs\Response\RendezVousResponseDTO;
use App\Http\Requests\RendezVousRequest;
use App\Models\RendezVous;
use App\Repositories\RendezVousRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class RendezVousService
{

    private RendezVousRepository $rendezVousRepository;
    private VeterinaireService $veterinarianService;
    private AnimalService $animalService;


    public function __construct(RendezVousRepository $rendezVousRepository, VeterinaireService $veterinarianService, AnimalService $animalService)
    {
        $this->rendezVousRepository = $rendezVousRepository;
        $this->veterinarianService = $veterinarianService;
        $this->animalService = $animalService;

    }



    public function getAllApointementsByVet()
    {
        $paginatedRvs = $this->rendezVousRepository
            ->findAllByVet(auth()->user()->vet->id)
            ->paginate(10)
            ->withQueryString();

        $paginatedRvs->getCollection()->transform(fn($rendezVous) => RendezVousResponseDTO::fromModel($rendezVous));



       return $paginatedRvs;

    }


    public function getAvailableSlotsForVet(int $vetId, int $userId, mixed $date) : array
    {

        $vet = $this->veterinarianService->getVet($vetId);
        $rendez_vouss = $this->rendezVousRepository->findAllByVet($vetId);
        $animaux = $this->animalService->getAllanimalsByUser($userId);
        $slots = $this->calculateAvailableSlots($date, $rendez_vouss);

        return [
            'selectedDate' => $date,
            'slots'        => $slots,
            'animaux'      => $animaux,
            'vet'          => $vet,
        ];

    }

    public function calculateAvailableSlots(mixed $date, mixed $rendez_vouss) : array
    {
        $slots = [];

        if ($date) {
            $day = Carbon::parse($date)->setTime(9, 0);
            for ($i = 0; $i <= 7; $i++) {
                $slots[] = $day->copy()->toDateTimeString();
                $day->addMinutes(60);
            }
        }


        $slots = array_filter($slots, fn($slot) =>
        !$rendez_vouss->pluck('dateHeureDebut')->contains($slot)
        );

        return $slots;
    }


    public function getRendezVousByUser(int $userId) : Collection
    {

        $rendezVouss =  $this->rendezVousRepository->findAllByUser($userId);

        return $rendezVouss->map(fn($rendezVous) => RendezVousResponseDTO::fromModel($rendezVous));

    }

    public function create(RendezVousRequest $request)
    {
        $dto = RendezVousRequestDTO::fromRequest($request);

        $data = $dto->toArray();


        return $this->rendezVousRepository->create($data);

    }

    public function getTodaysApointement(): array
    {
        $today = [];
        $appointement = $this->getAllApointementsByVet();


        foreach ($appointement as $app) {

            $appDate = $app->dateHeureDebut->format('Y-m-d');

            if ($appDate == now()->format('Y-m-d')) {
                $today[] = $app;
            }

        }

        return $today;

    }

    public function getRendezVousByVet()
    {
        $this->rendezVousRepository->findAllByVet(auth()->user()->vet->id);
    }


}
