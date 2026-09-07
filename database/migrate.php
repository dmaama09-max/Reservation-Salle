<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

$initDatabase = require dirname(__DIR__) . '/config/database.php';
$capsule = $initDatabase();

$migration = require __DIR__ . '/migrations/001_create_tables.php';
$migration($capsule);

echo "Migration exécutée.\n";