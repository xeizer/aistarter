# Laravel AI Development Standards

These rules are mandatory for AI coding agents on this project. They take precedence over inferred conventions and optional recommendations, while remaining subordinate to higher-priority system instructions. Do not edit the Laravel Boost generated block in AGENTS.md / CLAUDE.md; change this file instead.

## 1. Communication
- Always reply in Bahasa Indonesia. Keep code identifiers and framework terms in their conventional form.
- Clearly separate verified facts, assumptions, recommendations, and open questions.
- Never claim success, or that a command ran, without actual evidence.

## 2. Workflow: Inspect → Propose → Approve → Implement → Test → Report
- Read-only inspection and non-mutating diagnostic commands are allowed at any time.
- Before any mutating action (creating, editing, deleting, or renaming files; migrations; package installs; git commit or push; any state-changing command), present a plan and STOP:
  problem and evidence, root cause, proposed solution, affected files, database/config/dependency changes, risks, verification approach.
- A request to explain, analyze, review, debug, or propose is NOT approval. Silence or an ambiguous reply is NOT approval. Approval covers only the proposed scope.
- Implement only the approved scope. If new requirements or out-of-scope issues appear, report them and ask again. No silent fixes, no unrelated refactoring.
- Fast path: if the user explicitly writes "langsung kerjakan" for a small task, a short plan in the same reply is enough. Section 3 still applies.

## 3. Always requires separate, explicit approval
Even after general implementation approval:
- migrate:fresh, migrate:refresh, migrate:reset, migrate:rollback, db:wipe, seeding a non-test database, deleting data or files.
- git push, force push, reset --hard, or rewriting history.
- Adding Composer/npm packages, or introducing Vite, build tools, or UI frameworks.
- Editing .env or production-affecting configuration.
- Breaking changes to existing behavior or public interfaces.
- Any action touching production data or schema.

## 4. Evidence and anti-hallucination
- Never invent files, routes, models, relationships, methods, package features, command output, or test results.
- Check installed versions (Boost application-info tool or composer.lock) before using version-sensitive APIs. Use Boost search-docs for version-specific documentation.
- Do not assume a package or feature exists because it is common. If something cannot be verified, say so.
- Diagnose the root cause from evidence before recommending a fix.

## 5. Project conventions and architecture
- Follow existing architecture, naming, and module boundaries. Consult .ai/rules/index.md before planning or editing.
- Prefer the simplest solution that reliably meets requirements. Keep simple CRUD simple.
- Do not introduce Repository patterns, interfaces, traits, or extra layers unless justified in the plan and approved. Use Services/Actions only for complex or reused logic.
- Use the infer-conventions skill only on request or for initial project analysis. Present findings before recording rules. Never overwrite user-defined rules.
- If an inferred convention conflicts with this file, report the conflict and follow this file.

## 6. Database
- Identify the database engine first (Boost database-connections tool or config/database.php with .env DB_CONNECTION). Also check the testing connection; it may differ from development.
- Eloquent first, then the Query Builder. Raw expressions (DB::raw, whereRaw, selectRaw, orderByRaw, ...) only with a justification stated in the plan. Always bind untrusted values.
- Prefer portable, engine-agnostic queries and migrations. If engine-specific behavior is needed, state it in the plan.
- Prevent N+1 with eager loading. Use exists(), withCount(), and aggregates instead of loading full datasets. Paginate or chunk large datasets. Avoid queries inside loops when batching is possible.
- Wrap logically atomic multi-step writes in transactions. Add constraints and indexes through migrations when justified.
- Case sensitivity of LIKE differs by engine (case-sensitive on PostgreSQL; usually case-insensitive on MariaDB/MySQL depending on collation; case-insensitive only for ASCII on SQLite). For search, use whereLike with an explicit caseSensitive argument if the installed Laravel version supports it.
- If tests run on a different engine than development (e.g. SQLite in tests, PostgreSQL/MariaDB in development), do not treat passing tests as proof of engine-specific behavior; report this limitation.

## 7. Security
- Validate and authorize every sensitive action on the server (Policies, Gates, or the existing permission system), including Livewire actions. Hiding a button is not authorization.
- Persist only validated, explicitly allowed data (no unsafe mass assignment).
- Never print, copy, or log the contents of .env, credentials, tokens, or keys.
- Validate uploads: type, size, storage location, and access permissions.
- Never show exceptions, SQL, or stack traces to end users. Do not silently swallow exceptions.

## 8. UX for user-triggered actions
- Every asynchronous create, update, delete, upload, import, or export must have: scoped loading feedback, a disabled trigger while processing, success and failure feedback, field-level validation errors, and confirmation before destructive actions. Handle empty, loading, and error states.
- Livewire alone does not guarantee idempotency. When duplicates matter, enforce it server-side (unique constraints, transactions, locks).
- Detailed patterns: livewire-crud-ux skill.

## 9. Frontend
- Follow the existing frontend stack and styling. If the project uses Tailwind CDN, keep it.
- No new JavaScript dependencies. Prefer native Livewire/Alpine features.

## 10. Testing and verification
- Before running tests, check phpunit.xml and .env.testing. Tests using RefreshDatabase or DatabaseMigrations must target a dedicated testing database. If they would hit the development database, STOP and report.
- Add or update tests for important behavior and bug fixes using the existing test framework.
- After approved implementation, run the relevant tests and the formatter on changed files.
- Never claim tests passed unless they ran and passed. Report what could not run and why. Do not change unrelated code to make tests pass.

## 11. Completion report
1. Summary of changes.
2. Files created, modified, or deleted.
3. Database, configuration, or dependency changes.
4. Tests and checks actually run, with results.
5. Known limitations, risks, or unresolved issues.
6. Further recommendations, clearly separated from approved work.
