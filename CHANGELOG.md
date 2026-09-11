# Changelog

Toutes les modifications notables de ce projet seront documentées dans ce fichier.

Le format est basé sur [Keep a Changelog](https://keepachangelog.com/fr/1.0.0/),
et ce projet adhère au [Semantic Versioning](https://semver.org/lang/fr/).

## [Non publié]

## [0.12.0] - 2026-09-09
### Ajouté
- Tests unitaires du service `CreerReservationService` (8 scénarios), avec
  des repositories en mémoire ne nécessitant pas MySQL.
- Tests unitaires des validateurs `SalleValidator` et `ReservationValidator`.
- Tests d'intégration Eloquent : création d'une salle, relation
  salle/réservations, recherche de chevauchement, annulation.
- Correction : ajout de `$dateFormat` sur le modèle `Reservation` pour
  permettre son utilisation sans connexion à la base active.

## [0.11.0] - 2026-09-08
### Ajouté
- Configuration du conteneur PHP-DI (`config/container.php`) avec autowiring
  pour les classes concrètes et définitions explicites pour les interfaces
  et la connexion à la base.
- Classe `App\Application`, point d'entrée logique de l'application.
- Finalisation de `public/index.php`, désormais limité à la construction du
  conteneur et à l'appel de `Application::run()`.

## [0.10.0] - 2026-09-08
### Ajouté
- Configuration de FastRoute (`routes/web.php`) pour l'ensemble des routes
  salles et réservations.
- Gestion des réponses 404 (route inconnue) et 405 (méthode non autorisée,
  avec en-tête `Allow`).

## [0.9.0] - 2026-09-07
### Ajouté
- Contrôleurs `SalleController` et `ReservationController`.
- Classe `View` pour le rendu des templates avec layout commun.
- Templates pour les salles, les réservations et les pages d'erreur.
- Identité visuelle complète (typographies, couleurs, mise en page).
- Fonction d'échappement globale `echapper()`.

## [0.8.0] - 2026-09-07
### Ajouté
- Service `CreerReservationService` implémentant l'ensemble des règles
  métier de réservation (salle active, durée maximale, date future,
  détection de chevauchement).
- Service `AnnulerReservationService`.
- Exceptions `SalleIndisponibleException` et `ReservationIntrouvableException`.

## [0.7.0] - 2026-09-07
### Ajouté
- Interfaces `SalleRepositoryInterface` et `ReservationRepositoryInterface`.
- Implémentations Eloquent des deux repositories, isolant tout accès ORM
  hors des contrôleurs et services.

## [0.6.0] - 2026-09-07
### Ajouté
- DTO `CreerSalleDTO` et `CreerReservationDTO`, avec conversion des chaînes
  en `DateTimeImmutable` à la construction.

## [0.5.0] - 2026-09-07
### Ajouté
- Interface `ValidatorInterface` et classe `ValidationResult`.
- Validateurs `SalleValidator` et `ReservationValidator` basés sur
  Respect\Validation.

## [0.4.0] - 2026-09-07
### Ajouté
- Script de données initiales (`database/seed.php`) insérant 5 salles,
  exécutable plusieurs fois sans doublon (`firstOrCreate`).
- Commande `php mk seed`.

## [0.3.0] - 2026-09-07
### Ajouté
- Modèles Eloquent `Salle` et `Reservation`, avec relation `hasMany` /
  `belongsTo`, conversions de types et gestion des dates.

## [0.2.0] - 2026-09-07
### Ajouté
- Connexion à la base via `Capsule\Manager`, chargée depuis les variables
  d'environnement (`vlucas/phpdotenv`).
- Conteneurisation de MySQL avec Docker Compose.
- Migrations séparées pour les tables `salle` et `reservation`.
- Point d'entrée CLI unifié `mk` (commandes `migrate` et `seed`).

### Supprimé
- Ancienne migration monolithique, remplacée par des migrations séparées
  par table.

## [0.1.0] - 2026-09-07
### Ajouté
- Initialisation du projet Composer avec autoloading PSR-4.
- Installation des dépendances imposées : `nikic/fast-route`,
  `respect/validation`, `illuminate/database`, `php-di/php-di`,
  `vlucas/phpdotenv`.
- Arborescence complète du projet.

## [0.0.0] - 2026-09-07
### Ajouté
- Initialisation du dépôt Git.
