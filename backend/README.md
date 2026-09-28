# ClinicAI Pro SaaS

This repository contains the foundation for a multi-tenant healthcare SaaS platform built for cPanel-compatible hosting.

## Current implementation status

We have completed the foundational repository structure and are now implementing the core Laravel backend and React frontend foundation.

## Included in the foundation

- Laravel app conventions for the backend API
- RBAC models for roles, permissions, and clinic ownership
- migration skeleton for the first production-critical tables
- API routes for auth and clinic management
- React dashboard shell and healthcare analytics widgets

## Local development

### Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### Frontend

```bash
cd frontend
npm install
npm run dev
```

## Security note

AI-generated content must be shown with the warning label:

`AI Generated Assistance - Requires Professional Review`

This must be treated as assistant-generated guidance only and never as a final diagnosis.
