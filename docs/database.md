# Database Architecture - Speaker Achievement Portal

This document lists the schema structure, migrations, and model relationships configured for the portal.

## Database Schema Modules

### 1. Users, Roles & Permissions
- **Tables**: `users`, `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`.
- **Roles**:
  - `Super Admin`: Full system controls and settings access.
  - `Publisher`: Content approval and publishing authority.
  - `Editor`: Content creation and modification privileges.
  - `Viewer`: Internal read-only portal access.

### 2. Achievement Management
- **Tables**: `achievement_categories`, `achievements`.
- **Fields**: Supports workflow status (`draft`, `review`, `approved`, `published`, `archived`), `published_at`, audits (`created_by`, `updated_by`), and SEO metadata.

### 3. Legislation Tracking
- **Tables**: `bills`, `motions`, `legislative_works`.
- **Legislative Statuses**: `First Reading`, `Second Reading`, `Committee Stage`, `Report Stage`, `Third Reading`, `Passed House`, `Passed Senate`, `Assented`, `Vetoed`.

### 4. Constituency Projects
- **Tables**: `project_categories`, `constituency_projects`, `states`, `lgas`.
- **Project Statuses**: `Proposed`, `Ongoing`, `Completed`, `Commissioned`.

### 5. News & Speeches
- **Tables**: `news_categories`, `news`, `speeches`.

### 6. Events & Publications
- **Tables**: `events`, `publications`.

### 7. Media Center
- **Tables**: `media_albums`, `media_items` (custom media wrapper to avoid spatie conflicts), `media` (Spatie polymorphic media registry).

### 8. System & User Feedback
- **Tables**: `testimonials`, `contact_messages`, `newsletter_subscribers`, `site_settings`, `audit_logs`.
