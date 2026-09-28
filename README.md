# ClinicAI Pro SaaS

## Current repository status

This repository now contains the initial production-oriented foundation for a healthcare SaaS platform, organized as a Laravel backend and a React dashboard frontend.

## Included system coverage

- authentication foundation and RBAC models
- patient management and medical record workflows
- appointments and doctor availability
- billing, payment, and expense logic
- dental chart and treatment plan support
- AI assistant review labeling and tracking
- subscription and SaaS platform layer
- secure headers and cPanel-compatible .htaccess configuration

## Deployment guidance

The platform is designed to operate in a standard cPanel-based environment with Apache, PHP 8.2+, MySQL 8, and cron jobs. The public web root should route requests through the Laravel `public` folder.

## Security and medical guidance

All AI-generated recommendations must be labeled:

`AI Generated Assistance - Requires Professional Review`

This must never be represented as a medical diagnosis or final treatment decision.

## Next milestone

The project is advancing toward a complete multi-clinic healthcare SaaS product architecture with operational, financial, and AI-enabled workflows.
