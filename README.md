# Réservation de salles universitaires

Application web de gestion des réservations de salles universitaires (cours,
soutenances, réunions, travaux pratiques, événements étudiants), développée en
PHP orienté objet sans framework complet, avec des composants spécialisés
installés via Composer (routeur, ORM, validation, conteneur d'injection).

## Prérequis

- PHP 8.2 ou 8.3
- Composer
- Docker et Docker Compose (pour MySQL)

## Installation

### 1. Cloner le dépôt

```bash
git clone git@github.com:dmaama09-max/Reservation-Salle.git
cd Reservation-Salle
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Configurer l'environnement

```bash
cp .env.example .env
```

Le fichier `.env.example` est déjà pré-rempli avec les identifiants utilisés
par le conteneur Docker de développement (`reservation_user` /
`reservation_pass`).

### 4. Démarrer MySQL

```bash
docker compose up -d
```

### 5. Créer les tables

```bash
php mk migrate
```

### 6. Ajouter les données initiales (5 salles)

```bash
php mk seed
```

Cette commande peut être relancée sans risque : elle n'insère pas de doublons.

### 7. Lancer le serveur de développement

```bash
php -S localhost:8000 -t public public/index.php
```

L'application est accessible sur [http://localhost:8000](http://localhost:8000).

## Exécuter les tests

```bash
vendor/bin/phpunit
```

Pour ne lancer qu'une suite en particulier :

```bash
vendor/bin/phpunit --testsuite Unit
vendor/bin/phpunit --testsuite Integration
```

Les tests unitaires (`tests/Unit`) ne nécessitent pas MySQL — ils utilisent
des repositories en mémoire. Les tests d'intégration (`tests/Integration`)
nécessitent que le conteneur MySQL soit démarré, et **réinitialisent les
tables `salle` et `reservation`** à chaque exécution.

## Fonctionnalités

- Gestion des salles : consultation, création, modification, activation/désactivation
- Gestion des réservations : consultation (avec filtre par salle), création, annulation
- Règles métier : salle active obligatoire, durée maximale de 4 heures,
  réservation dans le futur, détection des chevauchements d'horaires

## Documentation complémentaire

Voir [ARCHITECTURE.md](ARCHITECTURE.md) pour une analyse des choix
architecturaux (MVC, Repository, DTO, injection de dépendances, principes
SOLID).
