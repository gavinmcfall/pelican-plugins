# Changelog

All notable changes to the Server Documentation plugin will be documented in this file.

---

## [1.1.0] - 2025-01-23

### ⚠️ IMPORTANT: Upgrading from v1.0.x

**If you have existing documents you want to keep, you MUST run the pre-upgrade patch before uninstalling the old version.**

```bash
cd /var/www/pelican
php plugins/server-documentation/scripts/pre-upgrade-patch.php
```

Then uninstall via Admin Panel, upload the new version, and install. Your documents will be preserved.

**If you don't need to keep existing documents**, simply uninstall the old version and install v1.1.0. Fresh tables will be created.

---

### New Features

#### Three Editor Modes
Choose the best editor for each document:
- **Rich Text (WYSIWYG)** - Formatting toolbar, paste from web pages
- **Markdown** - Write in Markdown with live preview
- **Raw HTML** - Full control for advanced users

#### Template Variables
Dynamic content that's replaced when displayed to users:
- `{{user.name}}`, `{{user.username}}`, `{{user.email}}`
- `{{server.name}}`, `{{server.uuid}}`, `{{server.egg}}`, `{{server.node}}`
- `{{server.memory}}`, `{{server.disk}}`, `{{server.cpu}}`
- `{{date}}`, `{{time}}`, `{{datetime}}`, `{{year}}`

Escape with backslash to show literally: `\{{user.name}}`

#### Syntax Highlighting
Code blocks in documents are automatically syntax-highlighted using highlight.js:
- Supports JavaScript, Python, Bash, YAML, JSON, PHP, and 180+ languages
- Works in admin preview and server panel view
- Persists through Livewire updates

#### JSON Backup & Restore
Full backup and restore of all documents:
- **Export Backup** - Downloads JSON with all documents, settings, version history
- **Import Backup** - Restore from JSON, optionally overwrite existing documents
- Portable format using UUIDs and names (not database IDs)

#### Improved Admin Interface
- Editor type dropdown when creating new documents
- Type badges in document list (Rich Text, Markdown, Raw HTML)
- Live preview with syntax highlighting
- Variables reference panel with expandable list

### Changes

- Removed auto-update functionality (manual updates only, like official plugins)
- Migrations are now idempotent (safe to run multiple times)
- Improved caching with proper invalidation for egg-based visibility
- Better error handling in import/export

### Bug Fixes

- Fixed egg-based visibility not showing documents (caching issue)
- Fixed export button saying "Export as Markdown" when exporting JSON
- Fixed syntax highlighting disappearing after Livewire form interactions
- Fixed content preview not updating when switching editor types

### Technical

- Added `content_type` column to documents table (`html`, `markdown`, `raw_html`)
- Added `VariableProcessor` service for template variable replacement
- Integrated highlight.js 11.9.0 for code highlighting
- Added pre-upgrade patch script for v1.0.x → v1.1.x migrations

---

## [1.0.0] - 2025-01-15

### Initial Release

- Rich Text and Markdown editor support
- Role-based document visibility
- Egg-based server assignment
- Global and server-specific documents
- Version history with restore functionality
- Markdown import/export with YAML frontmatter
- Server panel integration
- Admin panel with full CRUD
- Drag-and-drop reordering
- Audit logging
