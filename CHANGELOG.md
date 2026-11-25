# Changelog

All notable changes to `xeizer/aistarter` are documented in this file.

## v1.1.1 - 2026-11-25

### Added
- Rule to create Laravel files (including Livewire components) with php artisan make:* and --no-interaction, and to list the exact make commands and options in the plan.

## v1.1.0 - 2026-11-22

### Added
- Precedence clause: this guideline wins over Boost or other package guidelines on scope, approval, safety, and security.
- Rule that extra artifacts (factories, seeders, docs, extra tests) are created only when part of the approved plan.
- Package verification before proposing new dependencies (exists, correct name, maintained).
- env() only inside config files.
- Allowlist validation for user-supplied sort/filter/group columns.
- Expanded security section: ownership checks for client-supplied IDs, scoped route bindings, authorization tests, no GET for state-changing routes, CSRF exemptions, escaped output, untrusted LLM output, upload filename/storage/SVG rules, hashed and encrypted casts, hidden attributes, rate limiting for auth/contact/API endpoints.
- Skill: locked ID properties, update and delete action examples with server-side authorization, table sorting allowlist, upload storage rules.

### Changed
- Pint must run with --dirty only; never format the whole project unless asked.
- Agent no longer runs npm run build / npm run dev itself; it tells the user which command to run.
- Version and database checks now use composer show and php artisan config:show, matching Boost's own guidance.
- Intro text clarifies the rules are generated from this package and must not be edited in CLAUDE.md / AGENTS.md.
- Removed duplicate .ai/rules instruction (already covered by Boost).
- Skill: authorize before validate; transactions only for multi-step writes; form wrapper in submit example; updateOrCreate noted as safe only with a unique constraint.
- Requires laravel/boost ^2.10.

## v1.0.0 - 2026-11-22

- Initial release: core guideline and livewire-crud-ux skill.
