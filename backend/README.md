# Database Schema Foundation

## Overview

The database layer supports multi-tenant clinic administration, patient records, appointment tracking, billing, dental workflows, and AI audit logs.

## Required entities

### Authentication and authorization
- users
- roles
- permissions
- model_has_roles
- role_has_permissions

### SaaS and clinic data
- clinics
- subscriptions
- plans
- settings

### Patients and records
- patients
- medical_records
- attachments
- patient_timeline_entries

### Appointments and availability
- appointments
- availability
- appointment_statuses

### Dental workflow
- teeth
- treatments
- treatment_plans
- dental_chart_records

### Billing
- invoices
- payments
- expenses
- invoice_items

### AI layer
- ai_requests
- ai_logs
- ai_usage

### System and audit
- notifications
- audit_logs

## Design rules

- use foreign keys and proper relationships
- store clinic_id on tenant-scoped records
- use soft deletes on business entities
- index status, clinic_id, patient_id, doctor_id, date fields
- use audit tables for state-changing actions

## Sample relational strategy

```text
clinics 1---* users
clinics 1---* patients
patients 1---* appointments
patients 1---* medical_records
patients 1---* attachments
patients 1---* invoices
clinics 1---* subscriptions
```

## Audit expectations

Core actions to log:
- login and logout
- user privilege changes
- patient record creation and edits
- billing and payment changes
- AI assistant record generation
- deletion or archival of patient data
