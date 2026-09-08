<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Reservation;

final class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function lister(?int $salleId = null): array
    {
        $query = Reservation::query();

        if ($salleId !== null) {
            $query->where('salle_id', $salleId);
        }

        return $query->get()->all();
    }

    public function trouver(int $id): ?Reservation
    {
        return Reservation::find($id);
    }

    public function trouverConflit(
        int $salleId,
        \DateTimeImmutable $dateDebut,
        \DateTimeImmutable $dateFin,
        ?int $exclureReservationId = null
    ): ?Reservation {
        $query = Reservation::query()
            ->where('salle_id', $salleId)
            ->where('statut', 'confirmée')
            ->where('date_debut', '<', $dateFin)
            ->where('date_fin', '>', $dateDebut);

        if ($exclureReservationId !== null) {
            $query->where('id', '!=', $exclureReservationId);
        }

        return $query->first();
    }

    public function enregistrer(Reservation $reservation): Reservation
    {
        $reservation->save();

        return $reservation;
    }

    public function annuler(Reservation $reservation): Reservation
    {
        $reservation->statut = 'annulée';
        $reservation->save();

        return $reservation;
    }
}