# cPanel Deployment Guide

## Objective

Deploy ClinicAI Pro SaaS on standard cPanel hosting without Docker or Kubernetes.

## Hosting assumptions

- Apache web server
- PHP 8.2+
- MySQL 8+
- cPanel file manager or FTP access
- cron jobs enabled

## Deployment steps

### 1. Upload project files
- upload Laravel app files to the cPanel document root or a subdirectory
- if using a subdirectory, configure the app root appropriately

### 2. Configure database
- create a MySQL database and user
- assign full privileges to the app user
- note database host, database name, username, and password

### 3. Configure .env
Set production values such as:

```env
APP_NAME="ClinicAI Pro SaaS"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clinicai_db
DB_USERNAME=clinicai_user
DB_PASSWORD=secure_password

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=database
```

### 4. Run migrations

```bash
php artisan migrate --force
php artisan db:seed
```

### 5. Configure storage

```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

### 6. Set up cron jobs

Recommended schedule:

```bash
php /home/username/public_html/artisan schedule:run >> /dev/null 2>&1
```

### 7. Configure Apache rewrite

The app should use the Laravel public directory as the web root or a properly configured rewrite to route all traffic to `public/index.php`.

Example `.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^ - [L]
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ /public/$1 [L]
</IfModule>
```

## Laravel optimization

- enable OPcache when supported
- set `APP_ENV=production`
- run `php artisan config:cache`
- run `php artisan route:cache`
- run `php artisan view:cache`
- ensure logs and uploads directories are writable

## Security hardening

- disable debug mode in production
- restrict access to `.env` and sensitive directories
- use HTTPS only
- keep PHP version current
- rotate credentials regularly
- use audit logs for privileged actions
