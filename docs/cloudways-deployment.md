# dialo-website Cloudways deployment

This is the deployment runbook for the independent Dialo informational website.
It must never use the Dialo APP repository, database, `.env`, storage, or
Cloudways application.

## Environments

- Local development: `http://127.0.0.1:8000`
- GitHub source: the dedicated `dialo-website` repository
- Production: the dedicated Cloudways application named `dialo-website`

The final public production URL is determined by the domain configured in
Cloudways. Do not put a guessed domain in `APP_URL`.

## Cloudways application

Create or select a separate Cloudways application with the exact name
`dialo-website` and configure:

- PHP 8.3 or later
- a dedicated MySQL/MariaDB database and database user
- the document root at this application's `public/` directory
- HTTPS and the canonical website domain
- a separate `.env` with a unique `APP_KEY`
- `APP_ENV=production` and `APP_DEBUG=false`
- mail delivery settings and the website administrator values
- a scheduler cron and queue worker if enabled by the website features

The production `.env` is created and maintained in Cloudways, never committed
to GitHub, and never copied from the local machine.

## GitHub Actions secrets

Add these repository secrets before enabling the workflow:

- `CLOUDWAYS_SSH_HOST`: Cloudways server IP or SSH host
- `CLOUDWAYS_SSH_PORT`: SSH port, normally `22`
- `CLOUDWAYS_SSH_USER`: the application SSH user
- `CLOUDWAYS_SSH_PRIVATE_KEY`: a dedicated deploy key
- `CLOUDWAYS_DEPLOY_PATH`: the absolute path of this application's release root

The workflow is `.github/workflows/deploy-cloudways.yml`. It runs on pushes to
`main` and can also be started manually. It installs production PHP packages,
builds Vite assets, uploads only to the configured application path, runs
migrations with `--force`, creates the storage link, and optimizes Laravel.

## Future update path

1. Develop and test locally on `develop`.
2. Run `scripts/test.ps1` and review the website locally.
3. Push the change to the dedicated GitHub repository.
4. Merge the reviewed change from `develop` into `main`.
5. GitHub Actions deploys `main` to the Cloudways application `dialo-website`.
6. Verify the production homepage, localized routes, CMS login, forms, assets,
   `robots.txt`, `sitemap.xml`, logs, and the deployment commit.

Rollback is performed by reverting the release commit and deploying `main`
again. Database migrations require a reviewed down/forward migration strategy
and a Cloudways backup before production changes.
