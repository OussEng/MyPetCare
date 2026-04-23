<?php

namespace App\Services;

use App\DTOs\Requests\RendezVous\RendezVousRequestDTO;
use App\DTOs\Response\RendezVous\RendezVousResponseDTO;
use App\Enums\Etat;
use App\Http\Requests\RendezVousRequest;
use App\Managers\RendezVousManager;
use App\Repositories\RendezVousRepository;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class RendezVousService
{

    private RendezVousRepository $rendezVousRepository;
    private VeterinaireService $veterinarianService;
    private AnimalService $animalService;
    private RendezVousManager $rendezVousManager;


    public function __construct(RendezVousRepository $rendezVousRepository, VeterinaireService $veterinarianService, AnimalService $animalService, RendezVousManager $rendezVousManager)
    {
        $this->rendezVousRepository = $rendezVousRepository;
        $this->veterinarianService = $veterinarianService;
        $this->animalService = $animalService;
        $this->rendezVousManager = $rendezVousManager;

    }



    public function getAllApointementsByVet(?string $etat = null,?string $jour = null)
    {

        $this->rendezVousManager->handleState();

        $etat = $etat ? Etat::tryFrom($etat) : null;
        $today = CarbonImmutable::now();

        $query = $this->rendezVousRepository
            ->findAllByVet(auth()->user()->vet->id);

        if($etat){
            $query->where('etat', $etat->value);
        }

        if($jour){
            $query->where('dateHeureDebut', 'like', "%{$today->format('Y-m-d')}%")
            ->where('etat', Etat::CONFIRMER);
        }

        $paginatedRvs = $query
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




    public function getRendezVousByUser(Request $request)
    {
        $this->rendezVousManager->handleState();


        $filterByDay = $request->get('jour') !== null;
        $etat = $request->get('etat');

        $etatEnum = match (true) {
            $filterByDay, $etat === 'tous' => null,
            $etat !== null   => Etat::tryFrom($etat),
            default          => Etat::CONFIRMER,
        };

        $paginatedRvs = $this->rendezVousRepository->findAllByUser(Auth::id(), $etatEnum, $filterByDay);

        return $paginatedRvs->through(fn($rendezVous) => RendezVousResponseDTO::fromModel($rendezVous));
    }


    public function create(RendezVousRequest $request)
    {
        $dto = RendezVousRequestDTO::fromRequest($request);

        $data = $dto->toArray();


        return $this->rendezVousRepository->create($data);

    }

    public function getTodaysApointement(): Collection
    {

        return $this->rendezVousRepository->findTodayApointement();

    }

    public function getCurrentAndNextAppointments(): array
    {
        $this->rendezVousManager->handleState();
        $vetId = auth()->user()->vet->id;

        return [
            'current' => $this->rendezVousRepository->findCurrentAppointment($vetId),
            'next'    => $this->rendezVousRepository->findNextAppointment($vetId),
        ];
    }

    public function getRendezVousByVet()
    {
        $this->rendezVousRepository->findAllByVet(auth()->user()->vet->id);
    }


    public function getPendingAponintements()
    {

        $rendezVouss = $this->rendezVousRepository->findPending();

        return $rendezVouss->map(fn($rendezVous) => RendezVousResponseDTO::fromModel($rendezVous));

    }

    public function cancel(int $id, int $userId) : bool
    {
        return $this->rendezVousRepository->cancel($id, $userId);
    }

    public function cancelByVet(int $id, int $vetId) : bool
    {
        return $this->rendezVousRepository->cancelByVet($id, $vetId);
    }



}
