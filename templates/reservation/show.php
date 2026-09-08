<?php
/** @var \App\Model\Reservation $reservation */
?>
<div class="record-header">
    <h1><?= echapper($reservation->salle->nom) ?></h1>
    <span class="status-pill <?= $reservation->statut === 'confirmée' ? 'status-pill--confirmee' : 'status-pill--annulee' ?>">
        <?= echapper($reservation->statut) ?>
    </span>
</div>

<div class="attributes">
    <div class="attributes__row">
        <span class="attributes__label">Créneau</span>
        <span class="attributes__value">
            <?= echapper($reservation->date_debut->format('d/m/Y H:i')) ?> → <?= echapper($reservation->date_fin->format('H:i')) ?>
        </span>
    </div>
    <div class="attributes__row">
        <span class="attributes__label">Responsable</span>
        <span class="attributes__value"><?= echapper($reservation->responsable) ?></span>
    </div>
    <div class="attributes__row">
        <span class="attributes__label">Email</span>
        <span class="attributes__value"><?= echapper($reservation->email) ?></span>
    </div>
    <div class="attributes__row">
        <span class="attributes__label">Motif</span>
        <span class="attributes__value"><?= echapper($reservation->motif) ?></span>
    </div>
</div>

<div class="actions-row">
    <a href="/salles/<?= echapper($reservation->salle->id) ?>" class="btn">Voir la salle</a>
    <?php if ($reservation->statut === 'confirmée'): ?>
        <form method="POST" action="/reservations/<?= echapper($reservation->id) ?>/cancel">
            <button type="submit" class="btn btn--danger">Annuler la réservation</button>
        </form>
    <?php endif; ?>
</div>