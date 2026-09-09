<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Salle;
use App\Repository\EloquentSalleRepository;

final class SalleIntegrationTest extends IntegrationTestCase
{
    public function testCreationDuneSalleAvecEloquent(): void
    {
        $repository = new EloquentSalleRepository();

        $salle = new Salle([
            'nom' => 'Salle Test',
            'batiment' => 'Bâtiment Test',
            'capacite' => 25,
            'type' => 'cours',
            'active' => true,
        ]);

        $salleEnregistree = $repository->enregistrer($salle);

        $this->assertNotNull($salleEnregistree->id);

        $salleRetrouvee = $repository->trouver($salleEnregistree->id);
        $this->assertSame('Salle Test', $salleRetrouvee->nom);
    }

    public function testRelationSalleReservations(): void
    {
        $salle = new Salle([
            'nom' => 'Salle Test',
            'batiment' => 'Bâtiment Test',
            'capacite' => 25,
            'type' => 'cours',
            'active' => true,
        ]);
        $salle->save();

        $salle->reservations()->create([
            'responsable' => 'Awa Ndiaye',
            'email' => 'awa@universite.sn',
            'motif' => 'Cours de test',
            'date_debut' => '2026-09-10 10:00:00',
            'date_fin' => '2026-09-10 12:00:00',
            'statut' => 'confirmée',
        ]);

        $salle->refresh();

        $this->assertCount(1, $salle->reservations);
        $this->assertSame('Awa Ndiaye', $salle->reservations->first()->responsable);
    }
}