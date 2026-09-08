<?php
/** @var \App\Model\Salle $salle */
?>
<div class="record-header">
    <h1><?= echapper($salle->nom) ?></h1>
    <span class="status-dot <?= $salle->active ? 'status-dot--active' : '' ?>">
        <?= $salle->active ? 'Salle active' : 'Salle inactive' ?>
    </span>
</div>

<div class="attributes">
    <div class="attributes__row">
        <span class="attributes__label">Bâtiment</span>
        <span class="attributes__value"><?= echapper($salle->batiment) ?></span>
    </div>
    <div class="attributes__row">
        <span class="attributes__label">Capacité</span>
        <span class="attributes__value"><?= echapper($salle->capacite) ?> places</span>
    </div>
    <div class="attributes__row">
        <span class="attributes__label">Type</span>
        <span class="attributes__value"><?= echapper($salle->type) ?></span>
    </div>
</div>

<div class="actions-row">
    <a href="/reservations?salle_id=<?= echapper($salle->id) ?>" class="btn">Voir les réservations</a>
    <a href="/salles/<?= echapper($salle->id) ?>/edit" class="btn">Modifier</a>
</div>