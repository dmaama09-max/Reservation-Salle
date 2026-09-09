<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Reservation;
use App\Model\Salle;
use App\Repository\EloquentReservationRepository;

final class ReservationIntegrationTest extends IntegrationTestCase
{
    private function creerSalle(): Salle
    {
        $salle = new Salle([
            'nom' => 'Salle Test',
            'batiment' => 'Bâtiment Test',
            'capacite' => 25,
            'type' => 'cours',
            'active' => true,
        ]);
        $salle->save();

        return $salle;
    }

    public function testRechercheDeChevauchement(): void
    {
        $salle = $this->creerSalle();
        $repository = new EloquentReservationRepository();

        $reservation = new Reservation([
            'salle_id' => $salle->id,
            'responsable' => 'Awa Ndiaye',
            'email' => 'awa@universite.sn',
            'motif' => 'Cours de test',
            'date_debut' => '2026-09-10 10:00:00',
            'date_fin' => '2026-09-10 12:00:00',
            'statut' => 'confirmée',
        ]);
        $repository->enregistrer($reservation);

        $conflit = $repository->trouverConflit(
            $salle->id,
            new \DateTimeImmutable('2026-09-10 11:00:00'),
            new \DateTimeImmutable('2026-09-10 13:00:00')
        );

        $this->assertNotNull($conflit);

        $sansConflit = $repository->trouverConflit(
            $salle->id,
            new \DateTimeImmutable('2026-09-10 12:00:00'),
            new \DateTimeImmutable('2026-09-10 14:00:00')
        );

        $this->assertNull($sansConflit);
    }

    public function testAnnulationDuneReservation(): void
    {
        $salle = $this->creerSalle();
        $repository = new EloquentReservationRepository();

        $reservation = new Reservation([
            'salle_id' => $salle->id,
            'responsable' => 'Awa Ndiaye',
            'email' => 'awa@universite.sn',
            'motif' => 'Cours de test',
            'date_debut' => '2026-09-10 10:00:00',
            'date_fin' => '2026-09-10 12:00:00',
            'statut' => 'confirmée',
        ]);
        $repository->enregistrer($reservation);

        $repository->annuler($reservation);

        $reservationMiseAJour = $repository->trouver($reservation->id);
        $this->assertSame('annulée', $reservationMiseAJour->statut);

        // Une réservation annulée ne doit plus bloquer la salle.
        $conflit = $repository->trouverConflit(
            $salle->id,
            new \DateTimeImmutable('2026-09-10 10:00:00'),
            new \DateTimeImmutable('2026-09-10 12:00:00')
        );

        $this->assertNull($conflit);
    }
}