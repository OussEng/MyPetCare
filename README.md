# My Little Pet

![Laravel](https://img.shields.io/badge/Laravel-12.8.1-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-4169E1?style=flat&logo=postgresql&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-Templates-FF2D20?style=flat&logo=laravel&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind_CSS-3.4.17-06B6D4?style=flat&logo=tailwindcss&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-ready-2496ED?style=flat&logo=docker&logoColor=white)

Plateforme dédiée au bien-être animal, permettant aux propriétaires de gérer leurs animaux, suivre leurs vaccinations et prendre rendez-vous avec des vétérinaires vérifiés. Les vétérinaires disposent d'un espace dédié pour gérer leurs clients, leurs dossiers animaux et leur planning — le tout-en-un seul endroit.

---

## Stack

|                 |                        |
|-----------------|------------------------|
| Backend         | Laravel 12             |
| Langage         | PHP 8.2                |
| Frontend        | Blade + Tailwind       |
| Base de données | PostgreSQL             |
| Environnement   | Docker (Laravel Sail)  |

---

## Prérequis
- [Docker](https://docs.docker.com/get-started/get-docker/)

**Windows :** [WSL](https://learn.microsoft.com/en-us/windows/wsl/) est requis avec une distro Linux [installée via WSL](https://learn.microsoft.com/en-us/windows/wsl/install).

---

## Installation

### 1. Cloner le projet

```
git clone https://github.com/OussEng/MyLittlePet.git
```

### Windows :
 Si vous êtes sur Windows il est recommandé de cloner le repo dans l'environnement WSL pour de meilleures performances.
```
User@DESKTOP-XXXXXXX:/mnt/c/Users/User$ ❌
```

```
User@DESKTOP-XXXXXXX:/$ ✅
```

### 2. Se déplacer dans le dossier du projet

```
cd MyLittlePet/
```


### 3. Installer les dépendances

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install
```

### 4. Configuration de l'environnement

```bash
cp .env.example .env
```

### 5. Démarrer les conteneurs

```bash
./vendor/bin/sail up -d
```

### 6. Générer la clé d'application

```bash
./vendor/bin/sail artisan key:generate
```

### 7. Migrations & Seeders

```bash
./vendor/bin/sail artisan migrate --seed
```

### 8. Dépendances frontend & serveur de développement

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

L'application est disponible sur **http://localhost**.

---

## Arrêter l'application

```bash
./vendor/bin/sail down
```

---

## Comptes par défaut

|             | Email            | Mot de passe |
|-------------|------------------|--------------|
| Admin       | admin@mypet.com  | Pa$$w0rd     |
| Vétérinaire | vet@mypet.com    | Pa$$w0rd     |
| Client      | client@mypet.com | Pa$$w0rd     |

---

## Commandes utiles

| Commande                                         | Description                       |
|--------------------------------------------------|-----------------------------------|
| `./vendor/bin/sail up -d`                        | Démarrer les conteneurs           |
| `./vendor/bin/sail down`                         | Arrêter les conteneurs            |
| `./vendor/bin/sail artisan migrate:fresh --seed` | Réinitialiser la base de données  |
| `./vendor/bin/sail artisan <cmd>`                | Lancer une commande Artisan       |
| `./vendor/bin/sail npm run dev`                  | Démarrer le serveur Vite          |
| `./vendor/bin/sail npm run build`                | Compiler les assets               |
| `./vendor/bin/sail shell`                        | Ouvrir un shell dans le conteneur |
| `./vendor/bin/sail tinker`                       | Ouvrir Laravel Tinker             |
