<?php
/** @var \App\Model\Reservation $reservation */
?>
<div class="record-header">
    <h1><?= e($reservation->salle->nom) ?></h1>
    <span class="status-pill <?= $reservation->statut === 'confirmée' ? 'status-pill--confirmee' : 'status-pill--annulee' ?>">
        <?= e($reservation->statut) ?>
    </span>
</div>

<div class="attributes">
    <div class="attributes__row">
        <span class="attributes__label">Créneau</span>
        <span class="attributes__value">
            <?= e($reservation->date_debut->format('d/m/Y H:i')) ?> → <?= e($reservation->date_fin->format('H:i')) ?>
        </span>
    </div>
    <div class="attributes__row">
        <span class="attributes__label">Responsable</span>
        <span class="attributes__value"><?= e($reservation->responsable) ?></span>
    </div>
    <div class="attributes__row">
        <span class="attributes__label">Email</span>
        <span class="attributes__value"><?= e($reservation->email) ?></span>
    </div>
    <div class="attributes__row">
        <span class="attributes__label">Motif</span>
        <span class="attributes__value"><?= e($reservation->motif) ?></span>
    </div>
</div>

<div class="actions-row">
    <a href="/salles/<?= e($reservation->salle->id) ?>" class="btn">Voir la salle</a>
    <?php if ($reservation->statut === 'confirmée'): ?>
        <form method="POST" action="/reservations/<?= e($reservation->id) ?>/cancel">
            <button type="submit" class="btn btn--danger">Annuler la réservation</button>
        </form>
    <?php endif; ?>
</div>