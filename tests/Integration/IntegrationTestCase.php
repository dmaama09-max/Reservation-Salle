<?php

declare(strict_types=1);

namespace Tests\Integration;

use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    protected static ?Capsule $capsule = null;

    public static function setUpBeforeClass(): void
    {
        if (self::$capsule === null) {
            $initDatabase = require dirname(__DIR__, 2) . '/config/database.php';
            self::$capsule = $initDatabase();
        }
    }

    protected function setUp(): void
    {
        // On repart d'une base propre avant chaque test, dans le bon ordre
        // (reservation avant salle, à cause de la contrainte de clé étrangère).
        Capsule::table('reservation')->delete();
        Capsule::table('salle')->delete();
    }
}