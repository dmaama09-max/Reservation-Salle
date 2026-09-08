<?php
/** @var \App\Model\Salle[] $salles */
/** @var array<string,string> $errors */
/** @var array $old */

function valeurReservation(string $champ, array $old): string
{
    return isset($old[$champ]) ? (string) $old[$champ] : '';
}
?>
<div class="page-head">
    <h1>Nouvelle réservation</h1>
</div>

<?php if (isset($errors['general'])): ?>
    <div class="form-alert"><?= e($errors['general']) ?></div>
<?php endif; ?>

<form method="POST" class="form-grid">
    <div class="field <?= isset($errors['salle_id']) ? 'has-error' : '' ?>">
        <label for="salle_id">Salle</label>
        <select id="salle_id" name="salle_id">
            <option value="">— Choisir une salle —</option>
            <?php foreach ($salles as $salle): ?>
                <option value="<?= e($salle->id) ?>" <?= valeurReservation('salle_id', $old) === (string) $salle->id ? 'selected' : '' ?>>
                    <?= e($salle->nom) ?> (<?= e($salle->capacite) ?> places)
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['salle_id'])): ?><span class="field-error"><?= e($errors['salle_id']) ?></span><?php endif; ?>
    </div>

    <div class="field <?= isset($errors['responsable']) ? 'has-error' : '' ?>">
        <label for="responsable">Responsable</label>
        <input type="text" id="responsable" name="responsable" value="<?= e(valeurReservation('responsable', $old)) ?>">
        <?php if (isset($errors['responsable'])): ?><span class="field-error"><?= e($errors['responsable']) ?></span><?php endif; ?>
    </div>

    <div class="field <?= isset($errors['email']) ? 'has-error' : '' ?>">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= e(valeurReservation('email', $old)) ?>">
        <?php if (isset($errors['email'])): ?><span class="field-error"><?= e($errors['email']) ?></span><?php endif; ?>
    </div>

    <div class="field <?= isset($errors['motif']) ? 'has-error' : '' ?>">
        <label for="motif">Motif</label>
        <input type="text" id="motif" name="motif" value="<?= e(valeurReservation('motif', $old)) ?>">
        <?php if (isset($errors['motif'])): ?><span class="field-error"><?= e($errors['motif']) ?></span><?php endif; ?>
    </div>

    <div class="field <?= isset($errors['date_debut']) ? 'has-error' : '' ?>">
        <label for="date_debut">Début</label>
        <input type="datetime-local" id="date_debut" name="date_debut" value="<?= e(valeurReservation('date_debut', $old)) ?>">
        <?php if (isset($errors['date_debut'])): ?><span class="field-error"><?= e($errors['date_debut']) ?></span><?php endif; ?>
    </div>

    <div class="field <?= isset($errors['date_fin']) ? 'has-error' : '' ?>">
        <label for="date_fin">Fin</label>
        <input type="datetime-local" id="date_fin" name="date_fin" value="<?= e(valeurReservation('date_fin', $old)) ?>">
        <?php if (isset($errors['date_fin'])): ?><span class="field-error"><?= e($errors['date_fin']) ?></span><?php endif; ?>
    </div>

    <div class="actions-row">
        <button type="submit" class="btn btn--primary">Réserver</button>
        <a href="/reservations" class="btn">Annuler</a>
    </div>
</form>