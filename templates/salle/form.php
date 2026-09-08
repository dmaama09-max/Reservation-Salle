<?php
/** @var \App\Model\Salle|null $salle */
/** @var array<string,string> $errors */
/** @var array $old */

$types = ['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion'];

function valeur(string $champ, $salle, array $old): string
{
    if (isset($old[$champ])) {
        return (string) $old[$champ];
    }
    if ($salle !== null) {
        return (string) $salle->{$champ};
    }
    return '';
}
?>
<div class="page-head">
    <h1><?= $salle ? 'Modifier la salle' : 'Ajouter une salle' ?></h1>
</div>

<?php if (isset($errors['general'])): ?>
    <div class="form-alert"><?= echapper($errors['general']) ?></div>
<?php endif; ?>

<form method="POST" class="form-grid">
    <div class="field <?= isset($errors['nom']) ? 'has-error' : '' ?>">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?= echapper(valeur('nom', $salle, $old)) ?>">
        <?php if (isset($errors['nom'])): ?><span class="field-error"><?= echapper($errors['nom']) ?></span><?php endif; ?>
    </div>

    <div class="field <?= isset($errors['batiment']) ? 'has-error' : '' ?>">
        <label for="batiment">Bâtiment</label>
        <input type="text" id="batiment" name="batiment" value="<?= echapper(valeur('batiment', $salle, $old)) ?>">
        <?php if (isset($errors['batiment'])): ?><span class="field-error"><?= echapper($errors['batiment']) ?></span><?php endif; ?>
    </div>

    <div class="field <?= isset($errors['capacite']) ? 'has-error' : '' ?>">
        <label for="capacite">Capacité</label>
        <input type="number" id="capacite" name="capacite" value="<?= echapper(valeur('capacite', $salle, $old)) ?>">
        <?php if (isset($errors['capacite'])): ?><span class="field-error"><?= echapper($errors['capacite']) ?></span><?php endif; ?>
    </div>

    <div class="field <?= isset($errors['type']) ? 'has-error' : '' ?>">
        <label for="type">Type</label>
        <select id="type" name="type">
            <?php foreach ($types as $type): ?>
                <option value="<?= echapper($type) ?>" <?= valeur('type', $salle, $old) === $type ? 'selected' : '' ?>>
                    <?= echapper($type) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['type'])): ?><span class="field-error"><?= echapper($errors['type']) ?></span><?php endif; ?>
    </div>

    <div class="field field--checkbox">
        <input type="checkbox" id="active" name="active" value="1"
            <?= ($salle?->active ?? true) ? 'checked' : '' ?>>
        <label for="active">Salle active</label>
    </div>

    <div class="actions-row">
        <button type="submit" class="btn btn--primary">Enregistrer</button>
        <a href="/salles" class="btn">Annuler</a>
    </div>
</form>