# Changelog

Toutes les modifications notables de ce projet seront documentées dans ce fichier.

Le format est basé sur [Keep a Changelog](https://keepachangelog.com/fr/1.0.0/),
et ce projet adhère au [Semantic Versioning](https://semver.org/lang/fr/).

## [Non publié]

## [0.3.0] - 2026-09-07
### Ajouté
- Modèle Eloquent `Salle` avec propriétés assignables et conversion du champ `active` en booléen.
- Modèle Eloquent `Reservation` avec conversion des dates `date_debut` et `date_fin`.
- Relation `hasMany` entre `Salle` et `Reservation`.
- Relation `belongsTo` entre `Reservation` et `Salle`.

## [0.2.0] - 2026-09-07
### Ajouté
- Configuration de la connexion à la base via `Capsule\Manager`.
- Chargement des variables d'environnement avec `vlucas/phpdotenv`.
- Conteneurisation de MySQL avec Docker Compose.
- Migrations séparées pour les tables `salle` et `reservation`.
- Point d'entrée CLI unifié `mk` (commande `migrate`).

### Supprimé
- Ancienne migration monolithique `001_create_tables.php`, remplacée par des migrations séparées par table.

## [0.1.0] - 2026-09-07
### Ajouté
- Initialisation du projet Composer avec autoloading PSR-4 (`App\` → `src/`).
- Installation des dépendances imposées : `nikic/fast-route`, `respect/validation`, `illuminate/database`, `php-di/php-di`, `vlucas/phpdotenv`.
- Arborescence complète du projet.

## [0.0.0] - 2026-09-07
### Ajouté
- Initialisation du dépôt Git.