<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

$initDatabase = require dirname(__DIR__) . '/config/database.php';
$initDatabase();

// Laisse le serveur intégré de PHP servir les fichiers statiques directement.
if (PHP_SAPI === 'cli-server') {
    $fichier = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($_SERVER['REQUEST_URI'] !== '/' && is_file($fichier)) {
        return false;
    }
}

$dispatcher = simpleDispatcher(require dirname(__DIR__) . '/routes/web.php');

$httpMethod = $_SERVER['REQUEST_METHOD'];
// On supprime la query string avant le dispatch : PHP_URL_PATH ne garde que le chemin.
$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

$view = new App\View\View(dirname(__DIR__) . '/templates');

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo $view->render('error/404', [], 'Page introuvable');
        break;

    case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        header('Allow: ' . implode(', ', $routeInfo[1]));
        echo $view->render('error/405', [], 'Méthode non autorisée');
        break;

    case Dispatcher::FOUND:
        [$controllerClass, $method] = $routeInfo[1];
        $params = $routeInfo[2];

        // ⚠️ Résolution TEMPORAIRE en attendant le conteneur PHP-DI (étape 11).
        $controller = resoudreControleurTemporaire($controllerClass, $view);

        $resultat = $controller->$method($params);

        if (is_string($resultat)) {
            echo $resultat;
        }
        break;
}

/**
 * @deprecated Sera supprimée à l'étape 11 au profit du conteneur PHP-DI.
 */
function resoudreControleurTemporaire(string $controllerClass, App\View\View $view): object
{
    $salleRepo = new App\Repository\EloquentSalleRepository();
    $reservationRepo = new App\Repository\EloquentReservationRepository();

    return match ($controllerClass) {
        App\Controller\SalleController::class => new App\Controller\SalleController(
            $salleRepo,
            new App\Validation\SalleValidator(),
            $view
        ),
        App\Controller\ReservationController::class => new App\Controller\ReservationController(
            $reservationRepo,
            $salleRepo,
            new App\Validation\ReservationValidator(),
            new App\Service\CreerReservationService($salleRepo, $reservationRepo),
            new App\Service\AnnulerReservationService($reservationRepo),
            $view
        ),
        default => throw new RuntimeException("Contrôleur inconnu : {$controllerClass}"),
    };
}