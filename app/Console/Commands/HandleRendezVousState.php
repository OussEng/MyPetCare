<?php

namespace App\Console\Commands;

use App\Managers\RendezVousManager;
use Illuminate\Console\Command;

class HandleRendezVousState extends Command
{
    protected $signature = 'rv:handle-state';
    protected $description = 'Transitions finished appointments to TERMINER';

    private RendezVousManager $manager;

    public function __construct(RendezVousManager $rendezVousManager){
        parent::__construct();
        $this->manager = $rendezVousManager;
    }


    public function handle(): int
    {
        $this->manager->handleState();
        $this->info('Done.');
        return 0;
    }
}
