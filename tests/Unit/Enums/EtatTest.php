<?php

namespace Tests\Unit\Enums;

use App\Enums\Etat;
use Tests\TestCase;

class EtatTest extends TestCase
{


    public function test_isConfirmed_returns_true_for_CONFIRMER(): void
    {
        $this->assertTrue(Etat::CONFIRMER->isConfirmed());
    }

    public function test_isConfirmed_returns_false_for_non_confirmed(): void
    {

        $this->assertFalse(Etat::TERMINER->isConfirmed());
        $this->assertFalse(Etat::ANULLER->isConfirmed());
    }

    public function test_isFinished_returns_true_for_TERMINER(): void
    {
        $this->assertTrue(Etat::TERMINER->isFinished());
    }

    public function test_isFinished_returns_false_for_non_finished(): void
    {

        $this->assertFalse(Etat::CONFIRMER->isFinished());
        $this->assertFalse(Etat::ANULLER->isFinished());
    }

    public function test_isCancelled_returns_true_for_ANULLER(): void
    {
        $this->assertTrue(Etat::ANULLER->isCancelled());
    }

    public function test_isCancelled_returns_false_for_non_cancelled(): void
    {

        $this->assertFalse(Etat::CONFIRMER->isCancelled());
        $this->assertFalse(Etat::TERMINER->isCancelled());
    }


    public function test_tryFrom_returns_null_for_invalid_value(): void
    {
        $this->assertNull(Etat::tryFrom('invalid'));
    }


}

