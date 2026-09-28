# ClinicAI Pro SaaS - Foundation Plan

This repository starts the implementation of a secure, scalable, cPanel-friendly Clinic AI SaaS platform.

## Product intent

Build a multi-clinic, healthcare practice management platform with:

- patient lifecycle management
- medical records and clinical notes
- appointment scheduling and reminders
- billing and financial tracking
- dental workflow support
- AI-generated assistance with human review

## Architecture snapshot

### Backend
- Laravel 11/12
- PHP 8.2+
- MySQL 8+
- Sanctum for authentication
- Service layer for business logic
- Form requests and policies

### Frontend
- React 18
- Vite
- Tailwind CSS
- Reusable dashboard and CRUD components

### SaaS model
- tenants = clinics
- users = clinic staff and admin accounts
- subscriptions and plans for future expansion

## Phase 1 deliverables

The first implementation milestone includes:

- Laravel backend foundation
- SANCTUM auth layer
- user roles and permissions model
- clinic model and ownership relation
- database migration skeleton
- frontend app shell and dashboard layout
- deployment documentation and cPanel hardening notes

## Recommended next implementation steps

1. Setup Laravel 12 app under `backend/`
2. Configure `AppServiceProvider`, auth, middleware, and RBAC
3. Create migrations for users, roles, permissions, clinics, subscriptions
4. Add seeders for admin roles and sample clinic data
5. Scaffold React dashboard and auth pages in `frontend/`
6. Add API resource responses and versioned endpoints
7. Prepare cPanel-specific `.htaccess`, public config, and cron scripts

## Important medical AI rule

AI-generated outputs must always be labeled:

`AI Generated Assistance - Requires Professional Review`

and must never be presented as a final diagnosis.

## Security baseline

- robust auth and permission checks
- validation on all requests
- CSRF protection for web forms
- API throttling
- secure storage configuration for attachments
- audit logs for sensitive actions

## Project status

Initial repository scaffold created and architecture documents are in place. The next phase is implementation of the actual Laravel and React foundation files.
