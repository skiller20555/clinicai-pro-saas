# Professional Project Update Prompt

## For Development Teams & Contractors

Use this prompt when requesting enhancements, upgrades, or maintenance work on the ClinicAI Pro SaaS platform.

---

## Standard Update Request Template

### 1. Executive Summary
Provide a brief overview of what features or improvements are being requested.

**Example**:
> "Upgrade the patient management module with advanced search capabilities, bulk import functionality, and a patient communication portal to improve user engagement and operational efficiency."

### 2. Business Context
Explain why this update is needed from a business perspective.

**Example**:
> "Current patient management is limited. Customers are requesting the ability to import patient data from CSV, search across multiple criteria, and communicate directly with patients. This is causing feature gap compared to competitors."

### 3. Detailed Requirements

Provide specific, measurable requirements.

**Template**:
```
**Feature Name**: [Feature Name]
**Priority**: [Critical/High/Medium/Low]
**User Story**: As a [user role], I want to [action] so that [benefit]

**Requirements**:
- [ ] Requirement 1 with specific details
- [ ] Requirement 2 with specific details
- [ ] Requirement 3 with specific details

**Acceptance Criteria**:
- [ ] Criteria 1
- [ ] Criteria 2
- [ ] Criteria 3
```

### 4. Technical Specifications

Define technical implementation details.

**Template**:
```
**Backend Changes**:
- New models/tables needed
- API endpoints required
- Database migrations
- Services/business logic

**Frontend Changes**:
- New components/pages
- State management updates
- UI/UX requirements
- Third-party library integrations

**Integration Points**:
- External APIs
- Payment processors
- Notification systems
- Analytics
```

### 5. Dependencies & Constraints

List what this feature depends on.

**Template**:
```
**Dependencies**:
- [ ] Feature A must be completed first
- [ ] Database schema changes required
- [ ] Third-party API access needed

**Constraints**:
- Must maintain HIPAA compliance
- Must work on cPanel hosting
- Must support multi-tenant isolation
- Must not break existing APIs
- Performance: < 200ms response time
```

### 6. Scope & Timeline

Define what's included and timeline.

**Template**:
```
**Scope**:
- In Scope: Features 1, 2, 3
- Out of Scope: Features 4, 5
- Future Consideration: Features 6, 7

**Timeline**:
- Start Date: [Date]
- Target Completion: [Date]
- Sprint Duration: [X weeks]
```

### 7. Testing Requirements

Define how the work will be validated.

**Template**:
```
**Unit Tests**:
- [ ] Model tests
- [ ] Service tests
- [ ] API endpoint tests

**Integration Tests**:
- [ ] End-to-end workflows
- [ ] Third-party integrations
- [ ] Database operations

**Performance Tests**:
- [ ] Load testing with 1000+ concurrent users
- [ ] Query performance analysis
- [ ] API response time profiling

**Security Tests**:
- [ ] Authorization checks
- [ ] SQL injection prevention
- [ ] XSS protection
- [ ] Data privacy compliance

**Manual Testing**:
- [ ] UAT checklist
- [ ] Cross-browser testing
- [ ] Mobile responsiveness
```

### 8. Documentation Needs

Define documentation requirements.

**Template**:
```
**Code Documentation**:
- [ ] API endpoint documentation
- [ ] Model relationships documentation
- [ ] Service layer documentation
- [ ] Configuration documentation

**User Documentation**:
- [ ] Feature user guide
- [ ] Video tutorials (if applicable)
- [ ] FAQ section
- [ ] Troubleshooting guide

**Admin Documentation**:
- [ ] Configuration guide
- [ ] Deployment guide
- [ ] Maintenance procedures
- [ ] Monitoring and alerting
```

### 9. Success Metrics

Define how success will be measured.

**Template**:
```
**Technical Metrics**:
- [ ] Code coverage > 80%
- [ ] API response time < 200ms
- [ ] Zero critical bugs in first month
- [ ] Performance degradation < 5%

**Business Metrics**:
- [ ] Customer satisfaction score > 4.5/5
- [ ] Feature adoption > 70% within 3 months
- [ ] Support tickets related to feature < 5/week
- [ ] Feature reduces user time by > 30%

**Compliance Metrics**:
- [ ] HIPAA compliance verified
- [ ] Zero data breaches
- [ ] All audit logs complete
```

### 10. Approval & Sign-off

Require stakeholder approval.

**Template**:
```
**Approvals Required**:
- [ ] Product Manager: _______________ Date: _____
- [ ] Engineering Lead: _______________ Date: _____
- [ ] Security Officer: _______________ Date: _____
- [ ] Compliance Officer: _______________ Date: _____

**Stakeholders**:
- Product Owner: [Name]
- Tech Lead: [Name]
- QA Lead: [Name]
```

---

## Common Update Patterns

### Pattern 1: Feature Addition
**Request**: "Add [feature] to [module]"

**Prompt Structure**:
1. What problem does it solve?
2. Which user roles need it?
3. What data does it require?
4. How does it integrate with existing features?
5. What's the estimated complexity (Small/Medium/Large)?

### Pattern 2: Integration Addition
**Request**: "Integrate with [external service]"

**Prompt Structure**:
1. What's the integration purpose?
2. What data flows between systems?
3. What's the authentication method?
4. How often does data sync?
5. What's the fallback if integration fails?

### Pattern 3: Performance Optimization
**Request**: "Optimize [component/system]"

**Prompt Structure**:
1. What's the current performance metric?
2. What's the target performance?
3. What's the user impact?
4. Where is the bottleneck?
5. What's acceptable trade-off?

### Pattern 4: Security Enhancement
**Request**: "Implement [security feature]"

**Prompt Structure**:
1. What's the security vulnerability?
2. What compliance standards apply?
3. What user experience impact?
4. What's the implementation complexity?
5. What's the testing strategy?

### Pattern 5: Bug Fix
**Request**: "Fix [bug description]"

**Prompt Structure**:
1. What's the exact issue?
2. How to reproduce?
3. What's the expected behavior?
4. What's the actual behavior?
5. What systems are affected?

---

## Quality Standards

All updates must meet these standards:

### Code Quality
- [ ] Follows Laravel/React best practices
- [ ] DRY principle applied
- [ ] No code duplication
- [ ] Proper error handling
- [ ] Clear variable/function names

### Testing
- [ ] Unit test coverage > 80%
- [ ] Integration tests for workflows
- [ ] Security tests for sensitive operations
- [ ] Performance tests for database queries

### Documentation
- [ ] Code comments for complex logic
- [ ] README updated
- [ ] API documentation updated
- [ ] User guide created if needed

### Security
- [ ] HIPAA compliance verified
- [ ] Data validation on all inputs
- [ ] SQL injection prevention
- [ ] XSS protection
- [ ] CSRF tokens on forms
- [ ] Rate limiting on API

### Performance
- [ ] Database queries optimized
- [ ] No N+1 queries
- [ ] API response < 200ms (p95)
- [ ] Pagination for large datasets
- [ ] Caching strategy implemented

### Compliance
- [ ] Audit logs created for sensitive actions
- [ ] User role permissions verified
- [ ] Multi-tenant isolation maintained
- [ ] Soft deletes for data retention

---

## Escalation Process

If requirements are unclear or conflicting:

1. **Clarification Request**: Ask specific questions
2. **Documentation**: Provide written clarification
3. **Stakeholder Meeting**: Align on priorities
4. **Scope Adjustment**: Update timeline/resources if needed
5. **Approval**: Get written sign-off before proceeding

---

## Handoff Checklist

Before marking work complete:

- [ ] All acceptance criteria met
- [ ] Tests passing (unit, integration, performance)
- [ ] Code review approved
- [ ] Documentation complete
- [ ] Deployed to staging environment
- [ ] QA testing passed
- [ ] Security review complete
- [ ] Performance impact verified
- [ ] User documentation ready
- [ ] Training materials prepared
- [ ] Deployment plan documented
- [ ] Rollback plan prepared
- [ ] Monitoring/alerting configured
- [ ] Stakeholder sign-off obtained

---

## Contact & Support

For update requests:
- Email: development@clinicai-pro.com
- Slack: #clinicai-development
- JIRA: Create ticket in CLINIC-SAAS project
- GitHub Issues: Comment on relevant issue

---

**Document Version**: 1.0
**Last Updated**: 2026-09-28
**Maintained By**: ClinicAI Pro Development Team
