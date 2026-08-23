# Deployment & Production Guidelines

This document details the configuration required to deploy the portal to a production environment.

## 1. System Requirements
- **PHP**: ^8.4
- **Database**: PostgreSQL (v15+)
- **Cache & Queue**: Redis (v7+)
- **Storage**: AWS S3 or S3-Compatible Cloud Storage (e.g. MinIO, DigitalOcean Spaces)

## 2. Production Settings (.env)
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://speaker.gov.ng

DB_CONNECTION=pgsql
DB_HOST=your-production-pg-host
DB_PORT=5432
DB_DATABASE=speaker_portal
DB_USERNAME=speaker_user
DB_PASSWORD=secure-password

QUEUE_CONNECTION=redis
CACHE_STORE=redis
REDIS_HOST=127.0.0.1
```

## 3. Deployment Steps
1. **Repository & Dependencies**: Clone the repository and run:
   ```bash
   composer install --no-dev --optimize-autoloader
   npm ci
   ```
2. **Build Assets**: Run Vite compiler:
   ```bash
   npm run build
   ```
3. **Database Migration**: Safely run migrations in production:
   ```bash
   php artisan migrate --force
   ```
4. **Caching & Optimization**:
   ```bash
   php artisan config:cache
   # php artisan route:cache
   ```
