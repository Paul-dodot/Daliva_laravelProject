# Daliva Laravel Game Catalog - AI Coding Guidelines

## Project Overview
This is a Laravel 12 application for managing a personal game catalog. Authenticated users can create, view, update, and delete games and gaming platforms. Games are associated with platforms (e.g., PlayStation, Xbox).

## Architecture
- **Framework**: Laravel 12 (PHP 8.2+), Eloquent ORM
- **Frontend**: Livewire with Flux UI components, Tailwind CSS 4, Vite for asset compilation
- **Authentication**: Laravel Fortify with two-factor authentication support
- **Database**: Relational (MySQL/PostgreSQL), migrations with foreign key constraints
- **Key Models**: 
  - `User` (Fortify 2FA enabled)
  - `Platform` (hasMany Games)
  - `Game` (belongsTo Platform)
- **Structure**: Standard Laravel app/ structure, Blade views in resources/views/

## Key Patterns & Conventions
- **CRUD Operations**: Controllers use `$request->validate()` for input validation, Eloquent for DB operations
- **Relationships**: Always eager load with `->with()` (e.g., `Game::with('platform')->get()`)
- **Routes**: RESTful routes grouped under `middleware(['auth', 'verified'])`, resourceful naming (games.index, platforms.store)
- **Views**: Use `<x-layouts.app>` layout, Flux components for UI, session flashes for success/error messages
- **Migrations**: Anonymous classes, foreign keys with `->constrained()->onDelete('set null')`
- **Models**: `$fillable` arrays, standard Eloquent relationships
- **Validation**: Required fields like 'title', 'platform_id' with 'exists:platforms,id'

## Developer Workflows
- **Initial Setup**: `composer install`, copy `.env.example` to `.env`, `php artisan key:generate`, `php artisan migrate`
- **Development Server**: `php artisan serve` (backend), `npm run dev` (Vite hot reload)
- **Build Assets**: `npm run build` (production assets)
- **Testing**: `php artisan test` (PHPUnit), feature tests in `tests/Feature/`
- **Code Style**: `./vendor/bin/pint` (Laravel Pint for formatting)
- **Debugging**: Check `storage/logs/laravel.log`, use `dd()` in controllers/views

## Common Tasks
- Adding new game fields: Update migration (e.g., `add_column_to_games_table.php`), model `$fillable`, controller validation, view form
- New platform features: Follow PlatformController pattern, add routes to `web.php`
- UI changes: Use Flux components in Blade templates, Tailwind classes

## Reference Files
- Models: `app/Models/Game.php`, `app/Models/Platform.php`
- Controllers: `app/Http/Controllers/GameController.php`
- Routes: `routes/web.php`
- Views: `resources/views/dashboard.blade.php` (games list), `resources/views/platform.blade.php`
- Migrations: `database/migrations/` (note filename typo in `add_platform_id_to_students_table.php` - it's for games table)