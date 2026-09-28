# ClinicAI Pro SaaS - cPanel Installation Guide

## Quick Start for cPanel Hosting

This guide helps you install ClinicAI Pro SaaS on standard cPanel hosting with Apache, PHP 8.2+, and MySQL.

## Prerequisites

- cPanel hosting account
- PHP 8.2 or higher
- MySQL 8.0 or higher
- Apache with mod_rewrite enabled
- SSH access (optional, for advanced setup)

## Installation Steps

### 1. Upload Project Files

1. Log in to your cPanel account
2. Go to **File Manager**
3. Navigate to your **public_html** directory
4. Upload all project files from the repository

Your directory structure should look like:
```
public_html/
├── install.php (for web-based installation)
├── .htaccess
├── backend/
├── frontend/
├── docs/
└── README.md
```

### 2. Create MySQL Database

1. In cPanel, go to **MySQL Databases**
2. Create a new database (e.g., `username_clinicai`)
3. Create a new user (e.g., `username_clinicai_user`)
4. Assign the user to the database with **All Privileges**
5. Note the database name, username, and password

### 3. Run the Web-Based Installer

1. Open your browser and go to: `https://yourdomain.com/install.php`
2. Follow the installation wizard through all 6 steps:
   - **Step 1**: System requirements check
   - **Step 2**: Database configuration
   - **Step 3**: Application setup
   - **Step 4**: Environment file creation
   - **Step 5**: Database migrations
   - **Step 6**: Completion

### 4. Configure Public Directory (Important)

The web server must serve from the `public/` directory:

**Option A: Using cPanel Public Directory Modifier**
1. In cPanel, go to **Addon Domains** or **Subdomains**
2. Set the public directory to `public_html/backend/public`

**Option B: Using .htaccess (Automatic)**
The included `.htaccess` file automatically rewrites requests to the `public/` directory.

### 5. Set File Permissions

If you encounter permission errors, run via SSH:

```bash
cd public_html/backend
chmod -R 775 storage bootstrap/cache
chown -R nobody:nobody storage bootstrap/cache
```

### 6. Configure Cron Jobs

In cPanel, go to **Cron Jobs** and add:

```bash
* * * * * /usr/local/bin/php /home/username/public_html/backend/artisan schedule:run >> /dev/null 2>&1
```

This runs Laravel's scheduler every minute for appointment reminders and background tasks.

### 7. Configure Mail (Optional)

For appointment reminders and notifications:

1. In cPanel, go to **Email Accounts**
2. Create an email account (e.g., `noreply@yourdomain.com`)
3. Update `.env` file:
   ```
   MAIL_MAILER=sendmail
   MAIL_FROM_ADDRESS=noreply@yourdomain.com
   ```

### 8. Security Hardening

1. **Delete the installer**: Remove `install.php` after installation
2. **Set .env permissions**: Restrict access to `.env` file (already done by .htaccess)
3. **Enable HTTPS**: Use cPanel's AutoSSL or purchase an SSL certificate
4. **Backup regularly**: Use cPanel's backup feature

## After Installation

### First Login

1. Visit `https://yourdomain.com`
2. Login with your admin credentials from the installer
3. Create your first clinic
4. Invite staff members
5. Start managing patients

### Configure AI Features (Optional)

To enable AI clinical assistance:

1. Get an API key from OpenAI, Anthropic, or similar
2. Update `.env` file:
   ```
   AI_API_URL=https://api.openai.com/v1/chat/completions
   AI_API_TOKEN=your-api-key-here
   AI_MODEL=gpt-4o-mini
   ```

### Subscription Plans

Subscription tiers are pre-configured:
- **Starter**: $49/month
- **Professional**: $99/month
- **Enterprise**: $199/month

Customize pricing in the database or admin panel.

## Troubleshooting

### "Composer install required"
Run via SSH:
```bash
cd public_html/backend
composer install --no-dev
```

### "Database connection failed"
- Verify database credentials
- Ensure database user has SELECT, INSERT, UPDATE, DELETE privileges
- Check that MySQL service is running

### "Storage directory not writable"
Run:
```bash
chmod -R 775 backend/storage backend/bootstrap/cache
```

### "404 errors on all routes"
- Ensure mod_rewrite is enabled in Apache
- Verify .htaccess file is in place
- Check that public directory is configured correctly

### "PHP version too old"
You need PHP 8.2+. In cPanel:
1. Go to **Select PHP Version**
2. Choose PHP 8.2 or higher

## Maintenance

### Regular Tasks
- **Backup database**: Via cPanel or `php artisan backup:run`
- **Update SSL**: AutoSSL automatically renews
- **Monitor storage**: Clear old logs periodically
- **Review audit logs**: Check activity logs monthly

### Updating ClinicAI Pro

1. Backup your database
2. Upload new files
3. Run: `php artisan migrate --force`
4. Clear cache: `php artisan cache:clear`

## Support

- Documentation: See `/docs/` folder
- GitHub Issues: Report bugs
- Check server logs: `public_html/backend/storage/logs/`

## Security Note

All AI-generated content is labeled:

**"AI Generated Assistance - Requires Professional Review"**

This is never presented as a medical diagnosis. All clinical recommendations must be reviewed and approved by licensed professionals.
