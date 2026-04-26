# freeCodeCamp Symfony Project

A Symfony 7.4 practice project with authentication, post CRUD, category selection, and image upload support.

## Tech Stack

- PHP >= 8.2
- Symfony 7.4
- Doctrine ORM + Doctrine Migrations
- Twig
- PostgreSQL 16 (Docker)
- Bootstrap (Twig templates)

## Features

- User login/logout with form authentication
- Redirect to post list after login
- Protected routes (ROLE_USER)
- Create, read, update, and delete posts
- Assign category to post
- Upload image for post
- Flash messages for success/error states

## Project Structure

- src/Controller: application controllers
- src/Entity: Doctrine entities (Post, Category, User)
- src/Form: Symfony form classes
- src/Repository: custom query repositories
- src/Services: service classes (FileUploader)
- templates: Twig views
- migrations: database migration files

## Setup

### 1. Install dependencies

```bash
composer install
```

### 2. Start PostgreSQL container

```bash
docker compose up -d database
```

Database defaults from compose.yaml:

- Host: 127.0.0.1
- Port: 5433
- DB: app
- User: app
- Password: admin231

### 3. Configure environment

Make sure your DATABASE_URL points to PostgreSQL on port 5433.

Example:

```env
DATABASE_URL="postgresql://app:admin231@127.0.0.1:5433/app?serverVersion=16&charset=utf8"
```

### 4. Run migrations

```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

### 5. (Optional) Seed categories

```bash
php bin/console doctrine:query:sql "INSERT INTO category (name) VALUES ('Shirts'), ('Pants'), ('Shoes')"
```

### 6. Start Symfony server

```bash
symfony server:start
```

Open:

- http://127.0.0.1:8000

## Useful Commands

```bash
# Clear cache
php bin/console cache:clear

# Validate DI container
php bin/console lint:container

# Validate Twig templates
php bin/console lint:twig templates

# Check Doctrine mapping/schema
php bin/console doctrine:schema:validate
```

## Main Routes

- /login: login page
- /logout: logout
- /post/: post list
- /post/create: create post
- /post/edit/{id}: update post
- /post/show/{id}: post details
- /post/delete/{id}: delete post (POST)

## Notes

- Uploaded images are stored in public/uploads/images.
- File upload is handled by src/Services/FileUploader.php.
- Login firewall uses app_login and redirects to app_post.index.
