<?php

namespace Tests\Unit\Enums;

use App\Enums\Etat;
use Tests\TestCase;

class EtatTest extends TestCase
{
    public function test_isPending_returns_true_for_EN_ATTENT(): void
    {
        $this->assertTrue(Etat::EN_ATTENT->isPending());
    }

    public function test_isPending_returns_false_for_non_pending(): void
    {
        $this->assertFalse(Etat::CONFIRMER->isPending());
        $this->assertFalse(Etat::TERMINER->isPending());
        $this->assertFalse(Etat::ANULLER->isPending());
    }

    public function test_isConfirmed_returns_true_for_CONFIRMER(): void
    {
        $this->assertTrue(Etat::CONFIRMER->isConfirmed());
    }

    public function test_isConfirmed_returns_false_for_non_confirmed(): void
    {
        $this->assertFalse(Etat::EN_ATTENT->isConfirmed());
        $this->assertFalse(Etat::TERMINER->isConfirmed());
        $this->assertFalse(Etat::ANULLER->isConfirmed());
    }

    public function test_isFinished_returns_true_for_TERMINER(): void
    {
        $this->assertTrue(Etat::TERMINER->isFinished());
    }

    public function test_isFinished_returns_false_for_non_finished(): void
    {
        $this->assertFalse(Etat::EN_ATTENT->isFinished());
        $this->assertFalse(Etat::CONFIRMER->isFinished());
        $this->assertFalse(Etat::ANULLER->isFinished());
    }

    public function test_isCancelled_returns_true_for_ANULLER(): void
    {
        $this->assertTrue(Etat::ANULLER->isCancelled());
    }

    public function test_isCancelled_returns_false_for_non_cancelled(): void
    {
        $this->assertFalse(Etat::EN_ATTENT->isCancelled());
        $this->assertFalse(Etat::CONFIRMER->isCancelled());
        $this->assertFalse(Etat::TERMINER->isCancelled());
    }

    public function test_tryFrom_returns_enum_for_valid_value(): void
    {
        $this->assertSame(Etat::EN_ATTENT, Etat::tryFrom('en attente'));
    }

    public function test_tryFrom_returns_null_for_invalid_value(): void
    {
        $this->assertNull(Etat::tryFrom('invalid'));
    }

    public function test_enum_values_are_correct(): void
    {
        $this->assertSame('en attente', Etat::EN_ATTENT->value);
        $this->assertSame('confirmé', Etat::CONFIRMER->value);
        $this->assertSame('terminé', Etat::TERMINER->value);
        $this->assertSame('annulé', Etat::ANULLER->value);
    }
}

