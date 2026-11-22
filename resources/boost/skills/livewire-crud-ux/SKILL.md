---
name: livewire-crud-ux
description: UX and safety patterns for Livewire CRUD and other user-triggered actions (create, update, delete, upload, import, export). Use when building or changing forms, action buttons, tables with row actions, or upload/import/export flows in Livewire.
---

# Livewire CRUD UX Patterns

Check the installed Livewire version first and follow the project's existing components and notification mechanism. Do not add toast, modal, or JS libraries.

## Checklist for every user-triggered action
- [ ] Loading indicator scoped to that action (wire:target), not blocking unrelated UI.
- [ ] Trigger button disabled while processing; accidental double clicks cannot fire twice.
- [ ] Server-side validation, with field-level errors shown next to each field.
- [ ] Server-side authorization inside the action method.
- [ ] Clear success and failure feedback through the project's existing flash/notification pattern.
- [ ] Confirmation before destructive actions.
- [ ] Form input preserved after validation failure.
- [ ] Empty, loading, and error states handled.
- [ ] Accessible labels, visible focus, understandable status text.

## Button with scoped loading and disabled state

```blade
<button type="submit"
        wire:loading.attr="disabled"
        wire:target="save">
    <span wire:loading.remove wire:target="save">Simpan</span>
    <span wire:loading wire:target="save">Menyimpan...</span>
</button>
```

Set wire:target explicitly even when Livewire has default form behavior, so loading states never leak to other actions.

## Field-level error

```blade
<label for="name">Nama</label>
<input id="name" type="text" wire:model="name">
@error('name') <p role="alert">{{ $message }}</p> @enderror
```

## Destructive action with confirmation

```blade
<button type="button"
        wire:click="delete({{ $item->id }})"
        wire:confirm="Yakin ingin menghapus data ini?"
        wire:loading.attr="disabled"
        wire:target="delete({{ $item->id }})">
    Hapus
</button>
```

Verify that wire:confirm exists in the installed Livewire version before using it.

## Action method shape

```php
public function save(): void
{
    $validated = $this->validate();

    $this->authorize('create', Model::class);

    DB::transaction(function () use ($validated) {
        // persist only $validated
    });

    // success feedback using the project's existing mechanism
}
```

- Re-check authorization on the server for every action, including delete/update by ID. Never trust IDs sent from the browser.
- Catch expected failures and show a friendly message. Log details server-side; never show exception text to users.

## Duplicate protection beyond the UI
Disabling a button only protects against double clicks in one browser tab. When duplicates would cause real harm (payments, registrations, stock, numbered documents), also use:
- unique constraints in the database,
- transactions with row locks (lockForUpdate) for read-then-write logic,
- idempotent operations (e.g. updateOrCreate on a natural key) where appropriate.

## Uploads, imports, exports
- Show progress or a loading state for the whole operation.
- Validate file type and size on the server; store outside public paths unless the file is meant to be public.
- Move long-running imports/exports to queued jobs if the project has queues configured, and show their status.
