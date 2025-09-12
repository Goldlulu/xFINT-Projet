## README

# Gestion des Notes de Frais - SUP Herman

Application interne de gestion des notes de frais développée avec Laravel, Livewire et Jetstream. Permet aux employés de soumettre leurs notes de frais, aux managers de les valider/refuser, et à la comptabilité de les traiter.

## Fonctionnalités

- **Authentification** avec rôles (Employé, Manager, Comptabilité)
- **Gestion des notes de frais** : création, validation, traitement
- **Upload de pièces justificatives** multiples
- **Workflow complet** : Créée → Validée/Refusée → Traitée
- **Interface responsive** avec Tailwind CSS

## Comptes de test

- **Manager** : `manager@supherman.com` / `Suph3rm4n!`
- **Employé** : `employee@test.com` / `password`
- **Comptabilité** : `accounting@test.com` / `password`

---

## Installation avec Docker (Recommandé)

### Prérequis
- Docker et Docker Compose installés

### Étapes
```bash
# Cloner le projet
git clone [url-du-projet]
cd gestion-notes-frais

# Lancer l'application
docker-compose up
```

**Accès** :
- Application : http://localhost:8000
- phpMyAdmin : http://localhost:8080 (root/rootpassword)

---

## Installation locale (sans Docker)

### Prérequis
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js & npm

### Étapes

```bash
# Cloner et installer les dépendances
git clone [url-du-projet]
cd gestion-notes-frais
composer install
npm install && npm run build

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données (ajuster selon votre config)
# Créer une base 'gestion_notes_frais' dans MySQL
php artisan migrate
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserSeeder

# Lancer l'application
php artisan serve
```

**Accès** : http://localhost:8000

---

## Structure du projet

- **Pages** : Mes notes, Créer une note, Toutes les notes, Créer utilisateur, Profil
- **Rôles** : Restrictions d'accès selon le rôle utilisateur
- **Upload** : Stockage sécurisé des pièces justificatives
- **Workflow** : Validation manager + traitement comptabilité
