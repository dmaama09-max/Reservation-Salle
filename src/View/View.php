<?php

declare(strict_types=1);

namespace App\View;

final class View
{
    public function __construct(
        private readonly string $templatesDir
    ) {
    }

    public function render(string $vue, array $donnees = [], string $titre = 'Réservation de salles'): string
    {
        extract($donnees);
        ob_start();
        require $this->templatesDir . "/{$vue}.php";
        $content = ob_get_clean();

        ob_start();
        require $this->templatesDir . '/layout/base.php';
        return ob_get_clean();
    }
}