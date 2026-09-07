#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$initDatabase = require __DIR__ . '/config/database.php';

$command = $argv[1] ?? null;

match ($command) {
    'migrate' => runMigrations($initDatabase),
    default => showHelp(),
};

function runMigrations(callable $initDatabase): void
{
    $capsule = $initDatabase();

    $migrationsDir = __DIR__ . '/database/migrations';
    $migrations = glob($migrationsDir . '/*.php');
    sort($migrations);

    foreach ($migrations as $migrationFile) {
        $migration = require $migrationFile;
        $migration($capsule);
        echo "Migration exécutée : " . basename($migrationFile) . "\n";
    }

    echo "Toutes les migrations ont été exécutées.\n";
}

function showHelp(): void
{
    echo "Commandes disponibles :\n";
    echo "  migrate    Exécute les migrations\n";
}
