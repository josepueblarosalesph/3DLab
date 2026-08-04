# Open Lab

Sitio corporativo y plataforma editorial para Open Lab, un hub de innovación tecnológica, fabricación digital e I+D.

## Stack

- Laravel 13
- Livewire 4
- maryUI 2
- Tailwind CSS 4 + daisyUI 5
- SQLite local (configurable para MySQL/PostgreSQL)

## Instalación local

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
composer run dev
```

Sitio: `http://localhost:8000`  
Administrador: `http://localhost:8000/admin/login`

Las credenciales iniciales se configuran mediante `ADMIN_EMAIL` y `ADMIN_PASSWORD` en `.env`. Cambia la contraseña antes de publicar el proyecto.
