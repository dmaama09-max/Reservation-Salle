<?php
/** @var \App\Model\Salle $salle */
?>
<div class="record-header">
    <h1><?= e($salle->nom) ?></h1>
    <span class="status-dot <?= $salle->active ? 'status-dot--active' : '' ?>">
        <?= $salle->active ? 'Salle active' : 'Salle inactive' ?>
    </span>
</div>

<div class="attributes">
    <div class="attributes__row">
        <span class="attributes__label">Bâtiment</span>
        <span class="attributes__value"><?= e($salle->batiment) ?></span>
    </div>
    <div class="attributes__row">
        <span class="attributes__label">Capacité</span>
        <span class="attributes__value"><?= e($salle->capacite) ?> places</span>
    </div>
    <div class="attributes__row">
        <span class="attributes__label">Type</span>
        <span class="attributes__value"><?= e($salle->type) ?></span>
    </div>
</div>

<div class="actions-row">
    <a href="/reservations?salle_id=<?= e($salle->id) ?>" class="btn">Voir les réservations</a>
    <a href="/salles/<?= e($salle->id) ?>/edit" class="btn">Modifier</a>
</div>