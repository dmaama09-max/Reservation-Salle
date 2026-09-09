<?php

declare(strict_types=1);

namespace App;

use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;
use Psr\Container\ContainerInterface;
use App\View\View;

final class Application
{
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly View $view
    ) {
    }

    public function run(): void
    {
        // Force le démarrage d'Eloquent via le conteneur (voir config/container.php).
        $this->container->get(\Illuminate\Database\Capsule\Manager::class);

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $dispatcher = simpleDispatcher(require dirname(__DIR__) . '/routes/web.php');
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                echo $this->view->render('error/404', [], 'Page introuvable');
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);
                header('Allow: ' . implode(', ', $routeInfo[1]));
                echo $this->view->render('error/405', [], 'Méthode non autorisée');
                break;

            case Dispatcher::FOUND:
                [$controllerClass, $method] = $routeInfo[1];
                $params = $routeInfo[2];

                $controller = $this->container->get($controllerClass);
                $resultat = $controller->$method($params);

                if (is_string($resultat)) {
                    echo $resultat;
                }
                break;
        }
    }
}