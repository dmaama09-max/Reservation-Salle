<?php

declare(strict_types=1);

use function DI\autowire;
use function DI\factory;
use function DI\get;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Repository\SalleRepositoryInterface;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\EloquentSalleRepository;
use App\Repository\EloquentReservationRepository;
use App\View\View;

return [
    // --- Base de données ------------------------------------------------
    Capsule::class => factory(function (): Capsule {
        $initDatabase = require dirname(__DIR__) . '/config/database.php';

        return $initDatabase();
    }),

    // --- Repositories : liaison interface -> implémentation --------------
    SalleRepositoryInterface::class => autowire(EloquentSalleRepository::class),
    ReservationRepositoryInterface::class => autowire(EloquentReservationRepository::class),

    // --- Vue : injection du chemin des templates -------------------------
    View::class => factory(function (): View {
        return new View(dirname(__DIR__) . '/templates');
    }),
];