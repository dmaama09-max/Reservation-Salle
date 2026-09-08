<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;
use App\Validation\SalleValidator;
use App\View\View;

final class SalleController
{
    public function __construct(
        private readonly SalleRepositoryInterface $salles,
        private readonly SalleValidator $validator,
        private readonly View $view
    ) {
    }

    public function index(): string
    {
        $salles = $this->salles->lister();

        return $this->view->render('salle/index', ['salles' => $salles]);
    }

    public function show(array $params): string
    {
        $salle = $this->salles->trouver((int) $params['id']);

        if ($salle === null) {
            http_response_code(404);
            return $this->view->render('error/404');
        }

        return $this->view->render('salle/show', ['salle' => $salle]);
    }

    public function create(): string
    {
        return $this->view->render('salle/form', ['salle' => null, 'errors' => [], 'old' => []]);
    }

    public function store(): void
    {
        $data = [
            'nom' => $_POST['nom'] ?? '',
            'batiment' => $_POST['batiment'] ?? '',
            'capacite' => $_POST['capacite'] ?? '',
            'type' => $_POST['type'] ?? '',
            'active' => isset($_POST['active']),
        ];

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            echo $this->view->render('salle/form', [
                'salle' => null,
                'errors' => $result->errors(),
                'old' => $data,
            ]);
            return;
        }

        $dto = CreerSalleDTO::depuisTableau($result->data());

        $salle = new Salle([
            'nom' => $dto->nom,
            'batiment' => $dto->batiment,
            'capacite' => $dto->capacite,
            'type' => $dto->type,
            'active' => $dto->active,
        ]);

        $this->salles->enregistrer($salle);

        header('Location: /salles');
    }

    public function edit(array $params): string
    {
        $salle = $this->salles->trouver((int) $params['id']);

        if ($salle === null) {
            http_response_code(404);
            return $this->view->render('error/404');
        }

        return $this->view->render('salle/form', ['salle' => $salle, 'errors' => [], 'old' => []]);
    }

    public function update(array $params): void
    {
        $salle = $this->salles->trouver((int) $params['id']);

        if ($salle === null) {
            http_response_code(404);
            echo $this->view->render('error/404');
            return;
        }

        $data = [
            'nom' => $_POST['nom'] ?? '',
            'batiment' => $_POST['batiment'] ?? '',
            'capacite' => $_POST['capacite'] ?? '',
            'type' => $_POST['type'] ?? '',
            'active' => isset($_POST['active']),
        ];

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            echo $this->view->render('salle/form', [
                'salle' => $salle,
                'errors' => $result->errors(),
                'old' => $data,
            ]);
            return;
        }

        $salle->fill($result->data());
        $this->salles->enregistrer($salle);

        header('Location: /salles/' . $salle->id);
    }
}