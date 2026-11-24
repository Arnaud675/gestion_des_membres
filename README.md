# Gestion des membres

Application Laravel de gestion des membres, de leurs cotisations et des dépenses de l’association. Elle comprend un tableau de bord administrateur, une caisse globale et une gestion des accès par rôle.

## Prérequis

- PHP 8.2 ou supérieur avec les extensions Laravel nécessaires
- Composer
- Node.js et npm
- SQLite (configuration par défaut) ou MySQL

## Installation

À la racine du projet, exécuter :

```bash
composer install
npm install
```

Créer le fichier d’environnement et la clé Laravel :

```bash
cp .env.example .env
php artisan key:generate
```

Sous Windows PowerShell, remplacer la commande `cp` par :

```powershell
Copy-Item .env.example .env
```

La configuration par défaut utilise SQLite. Créer le fichier de base de données s’il n’existe pas :

```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

Configurer les comptes initiaux dans `.env` avant de lancer les migrations et le seeder. Définir des mots de passe privés; ne jamais publier le fichier `.env`.

```dotenv
ADMIN_NAME="Administrateur"
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=remplacer-par-un-mot-de-passe
STAFF_NAME="Gestionnaire"
STAFF_EMAIL=gestionnaire@example.com
STAFF_PASSWORD=remplacer-par-un-autre-mot-de-passe
```

Créer le schéma et les comptes :

```bash
php artisan migrate --seed
```

Construire les ressources front-end :

```bash
npm run build
```

## Lancement

```bash
php artisan serve
```

Ouvrir l’adresse indiquée par Artisan, généralement `http://127.0.0.1:8000`. Pour développer les ressources front-end avec Vite dans un autre terminal :

```bash
npm run dev
```

## Fonctionnalités

- Membres : ajout, consultation, modification et suppression, avec photo, recherche, filtres et pagination.
- Cotisations : suivi des paiements mensuels et mise à jour de la caisse.
- Dépenses : enregistrement par événement et membre, filtres, références et contrôle du solde disponible.
- Administration : tableau de bord avec indicateurs, activités récentes et répartition des cotisations.
- Accès : connexion requise; les comptes administrateur sont en lecture seule sur les opérations de gestion, tandis que le compte gestionnaire peut les effectuer.

## Tests

Lancer toute la suite :

```bash
php artisan test
```

L’environnement PHPUnit utilise SQLite en mémoire. Les tests fonctionnels des membres couvrent notamment la création avec nationalité et profession, la sélection des valeurs lors de la modification, ainsi que la recherche et la pagination.

## Base de données MySQL

Pour utiliser MySQL au lieu de SQLite, renseigner dans `.env` les variables `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` et `DB_PASSWORD`, puis exécuter :

```bash
php artisan config:clear
php artisan migrate --seed
```

## Fichiers téléversés

Les photos sont conservées sur le disque public Laravel. Après l’installation, créer le lien de stockage si nécessaire :

```bash
php artisan storage:link
```
