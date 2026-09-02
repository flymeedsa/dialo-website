# Dialo Official Website

Independent Laravel application for Dialo's bilingual public website and website-only CMS. It must use its own repository, Cloudways application, environment, database, storage, logs, domain, SSL, and deployment workflow. It does not share runtime state with the Dialo core product.

## Stack

- Laravel 13 / PHP 8.3+
- Blade, Tailwind CSS 4, Alpine.js, Vite
- MySQL or MariaDB in production
- SQLite for local development and automated tests

## Local setup on Windows

The bundled PowerShell scripts enable the PHP extensions required by this workstation without changing the global PHP configuration.

```powershell
.\scripts\setup.ps1
.\scripts\test.ps1
.\scripts\dev.ps1
```

For live CSS/JS rebuilding, run `pnpm dev` in a second terminal. Local CMS login is created only when `WEBSITE_ADMIN_EMAIL` and `WEBSITE_ADMIN_PASSWORD` are supplied in `.env`, followed by `scripts/php.ps1 artisan db:seed`. Never commit those values.

## Production configuration

Copy `.env.example` to the dedicated Cloudways application's `.env`. Set a unique `APP_KEY`, dedicated MySQL credentials, canonical `APP_URL`, mail delivery, and initial administrator variables. Run migrations only against the website database and keep `APP_DEBUG=false`.

The Cloudways document root must point to this application's `public/` directory. Configure the scheduler, queue worker, storage link, HTTPS redirect, and canonical host only inside the dedicated website application.

## Verification

```powershell
.\scripts\php.ps1 artisan migrate:fresh --seed
.\scripts\php.ps1 artisan test
pnpm build
```

Deployment is approval-gated. A local build, GitHub push, staging deployment, and production deployment are four separate states.
