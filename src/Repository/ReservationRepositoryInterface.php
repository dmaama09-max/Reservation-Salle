<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Reservation;

interface ReservationRepositoryInterface
{
    /**
     * @return Reservation[]
     */
    public function lister(?int $salleId = null): array;

    public function trouver(int $id): ?Reservation;

    /**
     * Recherche une réservation confirmée qui chevauche la période donnée pour une salle.
     */
    public function trouverConflit(
        int $salleId,
        \DateTimeImmutable $dateDebut,
        \DateTimeImmutable $dateFin,
        ?int $exclureReservationId = null
    ): ?Reservation;

    public function enregistrer(Reservation $reservation): Reservation;

    public function annuler(Reservation $reservation): Reservation;
}