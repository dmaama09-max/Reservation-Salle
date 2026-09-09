<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerReservationDTO;
use App\Exception\ReservationIntrouvableException;
use App\Exception\SalleIndisponibleException;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Validation\ReservationValidator;
use App\View\View;

final class ReservationController
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservations,
        private readonly SalleRepositoryInterface $salles,
        private readonly ReservationValidator $validator,
        private readonly CreerReservationService $creerService,
        private readonly AnnulerReservationService $annulerService,
        private readonly View $view
    ) {
    }

    public function index(): string
    {
        $salleId = isset($_GET['salle_id']) ? (int) $_GET['salle_id'] : null;
        $reservations = $this->reservations->lister($salleId);

        return $this->view->render('reservation/index', ['reservations' => $reservations]);
    }

    public function show(array $params): string
    {
        $reservation = $this->reservations->trouver((int) $params['id']);

        if ($reservation === null) {
            http_response_code(404);
            return $this->view->render('error/404');
        }

        return $this->view->render('reservation/show', ['reservation' => $reservation]);
    }

    public function create(): string
    {
        $salles = $this->salles->lister();

        return $this->view->render('reservation/form', ['salles' => $salles, 'errors' => [], 'old' => []]);
    }

    public function store(): void
    {
        $data = [
            'salle_id' => $_POST['salle_id'] ?? '',
            'responsable' => $_POST['responsable'] ?? '',
            'email' => $_POST['email'] ?? '',
            'motif' => $_POST['motif'] ?? '',
            'date_debut' => $_POST['date_debut'] ?? '',
            'date_fin' => $_POST['date_fin'] ?? '',
        ];

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            echo $this->view->render('reservation/form', [
                'salles' => $this->salles->lister(),
                'errors' => $result->errors(),
                'old' => $data,
            ]);
            return;
        }

        $dto = CreerReservationDTO::depuisTableau($result->data());

        try {
            $this->creerService->creer($dto);
        } catch (SalleIndisponibleException $exception) {
            echo $this->view->render('reservation/form', [
                'salles' => $this->salles->lister(),
                'errors' => ['general' => $exception->getMessage()],
                'old' => $data,
            ]);
            return;
        }
        flash('success', 'Réservation confirmée.');
        header('Location: /reservations');
    }

    public function cancel(array $params): void
    {
        try {
            $this->annulerService->annuler((int) $params['id']);
            flash('success', 'Réservation annulée.');
            header('Location: /reservations');

        } catch (ReservationIntrouvableException $exception) {
            http_response_code(404);
            echo $this->view->render('error/404');
            return;
        }
    }
}
