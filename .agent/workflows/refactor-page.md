---
description: How to Refactor old Blade pages to the New Premium Theme
---

# Modernization Workflow for YouLeggings

This workflow describes the process for rewriting old project pages into the new premium coding structure and design.

## Phase 1: CSS & Assets

1. Ensure `backend_premium.css` is linked in `backend.layouts.head`.
2. Use modern icon sets (Dripicons, MDI) for better visual clarity.

## Phase 2: Page Structure (Blade)

1. Extend `backend.layouts.master`.
2. Use `<div class="page-content-wrapper">` as the main container.
3. Group breadcrumbs and page titles at the top with a short description.
4. Use **Cards** for grouping related content (Stats, Tables, Forms).
5. Ensure all interactive elements (buttons, inputs) use the new design tokens.

## Phase 3: Coding Standards (PHP)

1. **Validation**: Always use `$request->validate([...])` at the start of controller methods.
2. **Flash Messages**: Use `->with('success', '...')` on redirects instead of manual Session calls.
3. **Eloquent**: Prefer Eloquent relationships (`$user->orders`) over raw DB queries where possible.
4. **DRY**: If a UI element is used on multiple pages, extract it to `@include('backend.layouts.partials.xxx')`.

## Phase 4: Quality Assurance

1. Verify responsiveness on mobile/tablet.
2. Ensure all action buttons (Edit, Delete, Status Toggle) work as expected with the new UI.
3. Check for consistent hover states and transitions.
