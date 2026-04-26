# FreeCodeCamp Symfony Project

A hands-on learning project built with **Symfony 7.4** as part of a FreeCodeCamp-style curriculum. It demonstrates core Symfony concepts including routing, Doctrine ORM, user authentication, form handling, and file uploads through a simple blog-style application where users can register, log in, and manage categorised posts with optional images.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Symfony 7.4 |
| Language | PHP ≥ 8.2 (project uses 8.3) |
| Database | PostgreSQL 16 |
| ORM | Doctrine ORM 3 + Doctrine Migrations |
| Templating | Twig 3 |
| Auth | Symfony Security Bundle |
| Dev tooling | Symfony Web Profiler, Maker Bundle |
| Container | Docker Compose (database service) |

---

## Prerequisites

- **PHP 8.2+** with extensions: `ctype`, `iconv`, `pdo_pgsql`
- **Composer** (https://getcomposer.org)
- **PostgreSQL 16** — either installed locally or via Docker
- **Docker & Docker Compose** (optional but recommended for the DB)
- **Symfony CLI** (optional, https://symfony.com/download) — provides the `symfony` command and a local dev server with TLS support

---

## Setup Instructions

### 1. Clone the repository

```bash
git clone https://github.com/ENGRSHEHLA/freecodecamp-symfony-project.git
cd freecodecamp-symfony-project
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure environment variables

Copy `.env` and create a local override file (never committed):

```bash
cp .env .env.local
```

Open `.env.local` and update at minimum:

```dotenv
APP_ENV=dev
APP_SECRET=<generate-a-random-32-char-hex-string>

# PostgreSQL connection — adjust credentials/port to match your setup
DATABASE_URL="postgresql://app:admin231@127.0.0.1:5433/app?serverVersion=16&charset=utf8"
```

> **Tip:** generate a secret with `php -r "echo bin2hex(random_bytes(16));"`.

### 4. Start the database (Docker)

The repository ships with a `compose.yaml` that starts a PostgreSQL 16 container on port **5433**:

```bash
docker compose up -d
```

If you prefer a local PostgreSQL installation, make sure a database named `app` exists and update `DATABASE_URL` accordingly.

### 5. Run database migrations

```bash
php bin/console doctrine:migrations:migrate
```

Confirm the prompt with `yes` when asked.

### 6. Start the development server

**Option A — Symfony CLI (recommended):**

```bash
symfony server:start
```

The app will be available at <https://127.0.0.1:8000> (or the URL shown in the terminal).

**Option B — PHP built-in server:**

```bash
php -S 127.0.0.1:8000 -t public/
```

---

## Application Routes

| URL | Description |
|-----|-------------|
| `/` | Home page |
| `/registeration` | User registration (note: URL uses the original spelling from the codebase) |
| `/login` | User login |
| `/logout` | User logout |
| `/post/` | List all posts |
| `/post/create` | Create a new post (with optional image) |
| `/post/show/{id}` | View a single post |
| `/post/edit/{id}` | Edit an existing post |
| `/post/delete/{id}` | Delete a post (POST method) |
| `/custome/{name?}` | Custom demo route (note: URL uses the original spelling from the codebase) |

---

## Common Commands

### Cache

```bash
# Clear and warm up the cache
php bin/console cache:clear
```

### Database & Migrations

```bash
# Create the database (first-time only)
php bin/console doctrine:database:create

# Generate a new migration after changing entities
php bin/console make:migration

# Run pending migrations
php bin/console doctrine:migrations:migrate

# Check current migration status
php bin/console doctrine:migrations:status
```

### Routing & Debug

```bash
# List all registered routes
php bin/console debug:router

# Show services registered in the container
php bin/console debug:container
```

### Maker Bundle (code generation)

```bash
# Generate a new controller
php bin/console make:controller

# Generate a new entity
php bin/console make:entity

# Generate a CRUD scaffold
php bin/console make:crud
```

### Tests

> **Note:** No test suite is configured in this project yet.  
> When tests are added, run them with:

```bash
php bin/phpunit
```

---

## Project Structure Overview

```
freecodecamp-symfony-project/
├── bin/                    # Console entry point (bin/console)
├── config/                 # Symfony configuration (packages, routes, services)
│   ├── packages/           # Per-bundle config files
│   ├── routes/             # Route loaders
│   └── services.yaml       # Dependency injection definitions
├── migrations/             # Doctrine migration files
├── public/                 # Web root (index.php, uploaded assets)
├── src/
│   ├── Controller/         # Request handlers
│   │   ├── MainController.php
│   │   ├── PostController.php
│   │   ├── RegisterationController.php  (registration — original filename)
│   │   └── SecurityController.php
│   ├── Entity/             # Doctrine entities (Post, Category, User)
│   ├── Form/               # Symfony Form types (PostType, …)
│   ├── Repository/         # Doctrine repositories
│   ├── Security/           # Custom authenticators / voters (if any)
│   └── Services/           # Application services (FileUploader)
├── templates/              # Twig templates
├── .env                    # Default environment variables (committed)
├── .env.local              # Local overrides (NOT committed)
├── compose.yaml            # Docker Compose — PostgreSQL service
├── composer.json           # PHP dependencies
└── symfony.lock            # Symfony Flex lock file
```

---

## Troubleshooting

### `Class "App\..." not found` after pulling changes

Run `composer dump-autoload` or simply `composer install` again.

### Database connection refused

- Ensure Docker is running: `docker compose ps`
- Check `DATABASE_URL` in `.env.local` matches the port exposed by Docker (`5433` by default).
- If using a local PostgreSQL, verify the service is running and the credentials are correct.

### `An exception occurred while executing a query` / table not found

You likely have pending migrations. Run:

```bash
php bin/console doctrine:migrations:migrate
```

### Symfony cache issues (stale routes, config, etc.)

```bash
php bin/console cache:clear
```

### `The stream or file ".../var/log/dev.log" could not be opened` (permissions)

```bash
chmod -R 775 var/
```

Or use `chown` to give the web-server user ownership of the `var/` directory.

### Composer `memory limit` error during `composer install`

```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

### `php bin/console` reports missing `.env` variables

Make sure `.env.local` exists and contains `DATABASE_URL` (and any other variables you have overridden). Symfony will not throw an error for variables that have defaults in `.env`, but will fail if a variable is referenced without any value at all.

---

## License

This project uses a **proprietary** license (as declared in `composer.json`). No open-source license file is present in the repository.

---

## Acknowledgements

Built as part of a [FreeCodeCamp](https://www.freecodecamp.org/) Symfony learning path. Symfony is a trademark of [Symfony SAS](https://symfony.com).
