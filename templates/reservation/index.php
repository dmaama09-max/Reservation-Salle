<?php
/** @var \App\Model\Reservation[] $reservations */
?>
<div class="page-head">
    <div>
        <h1>Réservations</h1>
        <p>Suivez les créneaux confirmés et annulés sur l'ensemble des salles.</p>
    </div>
    <a href="/reservations/create" class="btn btn--primary">Nouvelle réservation</a>
</div>

<?php if (empty($reservations)): ?>
    <div class="directory__empty">Aucune réservation pour l'instant.</div>
<?php else: ?>
    <div class="schedule">
        <?php foreach ($reservations as $reservation): ?>
            <a href="/reservations/<?= echapper($reservation->id) ?>" class="schedule__row">
                <span class="schedule__time">
                    <?= echapper($reservation->date_debut->format('d/m H:i')) ?> – <?= echapper($reservation->date_fin->format('H:i')) ?>
                    <small><?= echapper($reservation->date_debut->format('Y')) ?></small>
                </span>
                <span class="schedule__salle"><?= echapper($reservation->salle->nom) ?></span>
                <span class="schedule__meta"><?= echapper($reservation->responsable) ?></span>
                <span class="status-pill <?= $reservation->statut === 'confirmée' ? 'status-pill--confirmee' : 'status-pill--annulee' ?>">
                    <?= echapper($reservation->statut) ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>