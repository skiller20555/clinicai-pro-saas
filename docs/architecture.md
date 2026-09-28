# Phase 1: Foundation

## Architecture explanation

The foundation phase establishes the base system for all future modules. We separate concerns across a Laravel API backend and a React dashboard frontend. This keeps the platform maintainable and suitable for market-ready SaaS deployment.

## Core principles

- service-oriented API backend
- RBAC authorization
- tenant-aware data modeling
- cPanel-safe deployment approach
- clear separation of application logic and presentation

## Implemented direction

### Backend modules
- users
- roles
- permissions
- clinics
- subscriptions
- settings
- audit logs

### Frontend modules
- auth shell
- dashboard layout
- navigation sidebar
- appointment widgets
- patient summary cards
- billing overview

## Database changes for Phase 1

```sql
users
  id
  clinic_id
  name
  email
  password
  role_id
  status
  created_at
  updated_at
  deleted_at

roles
  id
  name
  guard_name

permissions
  id
  name
  description

clinics
  id
  name
  slug
  status
  owner_user_id
  created_at
  updated_at
  deleted_at

subscriptions
  id
  clinic_id
  plan_name
  status
  started_at
  ends_at
  created_at
  updated_at
```

## Testing instructions

- run auth and role tests with PHPUnit
- validate RBAC checks with feature tests
- verify clinic ownership and access policies
- ensure secure front-end routes require auth

## Deployment notes

- set `APP_ENV=production`
- configure `APP_URL` to the cPanel domain
- route public traffic to Laravel `public/`
- ensure storage and bootstrap caches are writable
- set up cron jobs for scheduled tasks

## Next phase focus

After the foundation is complete, the next milestone is clinic management with ownership and staff access.
