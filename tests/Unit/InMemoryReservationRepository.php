<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;

final class InMemoryReservationRepository implements ReservationRepositoryInterface
{
    /** @var Reservation[] */
    private array $reservations = [];
    private int $prochainId = 1;

    public function lister(?int $salleId = null): array
    {
        $resultats = array_values($this->reservations);

        if ($salleId !== null) {
            $resultats = array_filter($resultats, fn (Reservation $r) => $r->salle_id === $salleId);
        }

        return array_values($resultats);
    }

    public function trouver(int $id): ?Reservation
    {
        return $this->reservations[$id] ?? null;
    }

    public function trouverConflit(
        int $salleId,
        \DateTimeImmutable $dateDebut,
        \DateTimeImmutable $dateFin,
        ?int $exclureReservationId = null
    ): ?Reservation {
        foreach ($this->reservations as $reservation) {
            if ($reservation->salle_id !== $salleId) {
                continue;
            }

            if ($reservation->statut !== 'confirmée') {
                continue;
            }

            if ($exclureReservationId !== null && $reservation->id === $exclureReservationId) {
                continue;
            }

            $chevauche = $dateDebut < $reservation->date_fin && $dateFin > $reservation->date_debut;

            if ($chevauche) {
                return $reservation;
            }
        }

        return null;
    }

    public function enregistrer(Reservation $reservation): Reservation
    {
        if ($reservation->id === null) {
            $reservation->id = $this->prochainId++;
        }

        $this->reservations[$reservation->id] = $reservation;

        return $reservation;
    }

    public function annuler(Reservation $reservation): Reservation
    {
        $reservation->statut = 'annulée';
        $this->reservations[$reservation->id] = $reservation;

        return $reservation;
    }
}