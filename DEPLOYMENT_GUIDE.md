# Vercel Deployment Guide for Laravel Application

## Prerequisites

-   Vercel account
-   PlanetScale or other database provider
-   GitHub/GitLab/Bitbucket repository for the project

## Deployment Steps

1. **Set up environment variables** in Vercel:

    - `APP_KEY`: Run `php artisan key:generate` and copy the output
    - Database credentials (use PlanetScale or similar for Vercel)
    - Any other Laravel environment variables from your .env file

2. **Configure Vercel project**:

    - Set root directory to project root
    - Set build command to: `npm install && npm run build && composer install --no-dev`
    - Set output directory to: `public`

3. **Database setup**:

    - Create a PlanetScale database
    - Run migrations: `php artisan migrate --force`
    - Seed if needed: `php artisan db:seed --force`

4. **Deployment notes**:
    - Static assets will be served from /build
    - All other routes will be handled by Laravel
    - May need to adjust `vercel.json` routes for your specific needs

## Post-Deployment

-   Set up cron jobs for scheduled tasks (if any)
-   Configure domain and SSL
-   Set up monitoring and error tracking
