<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Salle;
use App\Service\CreerReservationService;
use PHPUnit\Framework\TestCase;

final class CreerReservationServiceTest extends TestCase
{
    private InMemorySalleRepository $salles;
    private InMemoryReservationRepository $reservations;
    private CreerReservationService $service;

    protected function setUp(): void
    {
        $this->salles = new InMemorySalleRepository();
        $this->reservations = new InMemoryReservationRepository();
        $this->service = new CreerReservationService($this->salles, $this->reservations);
    }

    private function creerSalleActive(): Salle
    {
        return $this->salles->ajouter(new Salle([
            'nom' => 'Salle B12',
            'batiment' => 'Bâtiment B',
            'capacite' => 40,
            'type' => 'cours',
            'active' => true,
        ]));
    }

    private function dto(array $overrides = []): CreerReservationDTO
    {
        $data = array_merge([
            'salle_id' => 1,
            'responsable' => 'Awa Ndiaye',
            'email' => 'awa@universite.sn',
            'motif' => 'Cours de test',
            'date_debut' => (new \DateTimeImmutable('+1 day 10:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new \DateTimeImmutable('+1 day 12:00'))->format('Y-m-d H:i:s'),
        ], $overrides);

        return CreerReservationDTO::depuisTableau($data);
    }

    public function testReservationValideEstCreee(): void
    {
        $salle = $this->creerSalleActive();

        $reservation = $this->service->creer($this->dto(['salle_id' => $salle->id]));

        $this->assertSame('confirmée', $reservation->statut);
    }

    public function testSalleInexistanteEstRejetee(): void
    {
        $this->expectException(SalleIndisponibleException::class);

        $this->service->creer($this->dto(['salle_id' => 999]));
    }

    public function testSalleInactiveEstRejetee(): void
    {
        $salle = $this->salles->ajouter(new Salle([
            'nom' => 'Salle fermée',
            'batiment' => 'Bâtiment B',
            'capacite' => 20,
            'type' => 'cours',
            'active' => false,
        ]));

        $this->expectException(SalleIndisponibleException::class);

        $this->service->creer($this->dto(['salle_id' => $salle->id]));
    }

    public function testDateFinAnterieureAuDebutEstRejetee(): void
    {
        $salle = $this->creerSalleActive();

        $this->expectException(SalleIndisponibleException::class);

        $this->service->creer($this->dto([
            'salle_id' => $salle->id,
            'date_debut' => (new \DateTimeImmutable('+1 day 12:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new \DateTimeImmutable('+1 day 10:00'))->format('Y-m-d H:i:s'),
        ]));
    }

    public function testDureeSuperieureAQuatreHeuresEstRejetee(): void
    {
        $salle = $this->creerSalleActive();

        $this->expectException(SalleIndisponibleException::class);

        $this->service->creer($this->dto([
            'salle_id' => $salle->id,
            'date_debut' => (new \DateTimeImmutable('+1 day 08:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new \DateTimeImmutable('+1 day 14:00'))->format('Y-m-d H:i:s'),
        ]));
    }

    public function testDatePasseeEstRejetee(): void
    {
        $salle = $this->creerSalleActive();

        $this->expectException(SalleIndisponibleException::class);

        $this->service->creer($this->dto([
            'salle_id' => $salle->id,
            'date_debut' => (new \DateTimeImmutable('-1 day 10:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new \DateTimeImmutable('-1 day 12:00'))->format('Y-m-d H:i:s'),
        ]));
    }

    public function testConflitAvecUneReservationExistanteEstRejete(): void
    {
        $salle = $this->creerSalleActive();

        $this->service->creer($this->dto(['salle_id' => $salle->id]));

        $this->expectException(SalleIndisponibleException::class);

        $this->service->creer($this->dto([
            'salle_id' => $salle->id,
            'date_debut' => (new \DateTimeImmutable('+1 day 11:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new \DateTimeImmutable('+1 day 13:00'))->format('Y-m-d H:i:s'),
        ]));
    }

    public function testReservationVoisineSansChevauchementEstAcceptee(): void
    {
        $salle = $this->creerSalleActive();

        $this->service->creer($this->dto(['salle_id' => $salle->id]));

        $reservation = $this->service->creer($this->dto([
            'salle_id' => $salle->id,
            'date_debut' => (new \DateTimeImmutable('+1 day 12:00'))->format('Y-m-d H:i:s'),
            'date_fin' => (new \DateTimeImmutable('+1 day 14:00'))->format('Y-m-d H:i:s'),
        ]));

        $this->assertSame('confirmée', $reservation->statut);
    }
}