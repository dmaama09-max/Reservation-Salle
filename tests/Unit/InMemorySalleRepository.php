<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;

final class InMemorySalleRepository implements SalleRepositoryInterface
{
    /** @var Salle[] */
    private array $salles = [];
    private int $prochainId = 1;

    public function ajouter(Salle $salle): Salle
    {
        $salle->id = $this->prochainId++;
        $this->salles[$salle->id] = $salle;

        return $salle;
    }

    public function lister(): array
    {
        return array_values($this->salles);
    }

    public function trouver(int $id): ?Salle
    {
        return $this->salles[$id] ?? null;
    }

    public function enregistrer(Salle $salle): Salle
    {
        if ($salle->id === null) {
            return $this->ajouter($salle);
        }

        $this->salles[$salle->id] = $salle;

        return $salle;
    }
}