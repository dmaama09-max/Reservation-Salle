<?php
/** @var string $title */
/** @var string $content */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= echapper($title ?? 'Réservation de salles') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,400;0,500;1,500&family=Space+Grotesk:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header class="site-header">
        <div class="site-header__inner">
            <a href="/" class="wordmark">Répertoire des salles</a>
            <nav class="site-nav">
                <a href="/salles">Salles</a>
                <a href="/reservations">Réservations</a>
            </nav>
        </div>
    </header>
    <main>
        <?= $content ?>
    </main>
</body>
</html>