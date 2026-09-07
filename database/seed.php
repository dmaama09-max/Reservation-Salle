<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Model\Salle;

$initDatabase = require dirname(__DIR__) . '/config/database.php';
$initDatabase();

$salles = [
    ['nom' => 'Amphithéâtre A', 'batiment' => 'Bâtiment principal', 'capacite' => 250, 'type' => 'amphitheatre', 'active' => true],
    ['nom' => 'Salle B12', 'batiment' => 'Bâtiment B', 'capacite' => 40, 'type' => 'cours', 'active' => true],
    ['nom' => 'Laboratoire Chimie', 'batiment' => 'Bâtiment sciences', 'capacite' => 24, 'type' => 'laboratoire', 'active' => true],
    ['nom' => 'Salle Informatique 1', 'batiment' => 'Bâtiment C', 'capacite' => 30, 'type' => 'informatique', 'active' => true],
    ['nom' => 'Salle de réunion', 'batiment' => 'Bâtiment administratif', 'capacite' => 12, 'type' => 'reunion', 'active' => true],
];

foreach ($salles as $donneesSalle) {
    Salle::firstOrCreate(
        ['nom' => $donneesSalle['nom'], 'batiment' => $donneesSalle['batiment']],
        $donneesSalle
    );
}

echo "Données initiales : " . Salle::count() . " salle(s) en base.\n";