# ClinicAI Pro SaaS

Commercial-grade Clinic AI SaaS Platform for small and medium-sized clinics, dental centers, and healthcare practices.

## Mission

ClinicAI Pro SaaS is designed to help clinics manage patients, appointments, digital records, billing, AI-assisted documentation, and clinical workflows in a secure, cPanel-compatible environment.

## Stack

- Backend: Laravel 11/12, PHP 8.2+, MySQL 8+
- Frontend: React 18, Vite, Tailwind CSS
- Auth: Laravel Sanctum + RBAC
- Deployment: cPanel, Apache, PHP-FPM where supported, cron jobs
- AI layer: secure external LLM API integration, doctor-reviewed output only

## Repository Structure

```text
/
├── README.md
├── docs/
│   ├── architecture.md
│   ├── cpanel-deployment.md
│   ├── database-schema.md
│   └── phase-1-foundation.md
├── backend/
│   ├── README.md
│   ├── .env.example
│   └── composer.json
├── frontend/
│   ├── README.md
│   ├── package.json
│   ├── vite.config.js
│   ├── index.html
│   └── src/
│       ├── App.jsx
│       ├── main.jsx
│       └── index.css
└── .gitignore
```

## Phase roadmap

1. Phase 1: Foundation
   - Laravel setup and auth
   - Role-based access control
   - Core database schema

2. Phase 2: Clinic management
   - Clinics and staff setup
   - Permissions and ownership model

3. Phase 3: Patient system
   - Profiles, records, timelines, attachments

4. Phase 4: Appointments
   - Scheduling, calendars, reminders

5. Phase 5: Dental workflow
   - Dental chart, treatment plans, tooth records

6. Phase 6: Billing and financials
   - Invoices, payments, expenses, receipts

7. Phase 7: AI integration
   - Summaries, treatment drafts, follow-up suggestions

8. Phase 8: SaaS expansion
   - Plans, subscriptions, tenant features, analytics

## Security and compliance principles

- Role-based authorization for all modules
- Sanctum token auth for SPA/API clients
- Soft deletes and audit logging
- SQL-safe ORM queries and request validation
- CSRF protection for web views
- Secure file handling and storage policy
- Medical AI outputs labeled clearly as assistant-generated, not diagnosis

## Deployment goal

This product is designed to run in standard cPanel environments without Docker, Kubernetes, Redis, or Node.js runtime in production.

## Start here

- See `docs/phase-1-foundation.md` for the initial implementation plan.
- See `docs/cpanel-deployment.md` for hosting guidance.
- See `docs/database-schema.md` for the startup database model.

## License

MIT
