<?php
/** @var \App\Model\Salle[] $salles */
?>
<div class="page-head">
    <div>
        <h1>Salles</h1>
        <p>Consultez les espaces disponibles pour vos cours, réunions et soutenances.</p>
    </div>
    <a href="/salles/create" class="btn btn--primary">Ajouter une salle</a>
</div>

<?php if (empty($salles)): ?>
    <div class="directory__empty">Aucune salle enregistrée pour l'instant.</div>
<?php else: ?>
    <div class="directory">
        <?php foreach ($salles as $salle): ?>
            <a href="/salles/<?= echapper($salle->id) ?>" class="directory__row">
                <span class="directory__name"><?= echapper($salle->nom) ?></span>
                <span class="directory__meta"><?= echapper($salle->batiment) ?></span>
                <span class="directory__meta"><?= echapper($salle->type) ?></span>
                <span class="directory__meta"><?= echapper($salle->capacite) ?> places</span>
                <span class="status-dot <?= $salle->active ? 'status-dot--active' : '' ?>">
                    <?= $salle->active ? 'Active' : 'Inactive' ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>