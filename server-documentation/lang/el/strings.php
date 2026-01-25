<?php

// TODO: Greek translation needed
// Copy of English strings - please translate the values


return [
    'navigation' => [
        'documents' => 'Documents',
        'group' => 'Content',
    ],

    'document' => [
        'singular' => 'Document',
        'plural' => 'Documents',
        'title' => 'Title',
        'slug' => 'Slug',
        'content' => 'Content',
        'is_global' => 'Global',
        'is_published' => 'Published',
        'sort_order' => 'Sort Order',
        'author' => 'Author',
        'last_edited_by' => 'Last Edited By',
        'version' => 'Version',
    ],

    'visibility' => [
        'title' => 'Visibility',
        'description' => 'Control where this document appears and who can see it',
        'server' => 'Server Visibility',
        'person' => 'Person Visibility',
        'everyone' => 'Everyone',
    ],

    'labels' => [
        'all_servers' => 'All Servers',
        'all_servers_helper' => 'Show on all servers (otherwise use eggs or specific servers below)',
        'published_helper' => 'Unpublished documents are only visible to admins',
        'sort_order_helper' => 'Lower numbers appear first',
        'eggs' => 'Game Types (Eggs)',
        'roles' => 'Roles',
        'users' => 'Specific Users',
    ],

    'hints' => [
        'roles_empty' => 'Leave empty to allow everyone with server access',
        'users_optional' => 'Optional: grant access to specific users',
        'eggs_hint' => 'Document will appear on all servers using selected game types',
    ],

    'form' => [
        'details_section' => 'Document Details',
        'server_assignment' => 'Server Assignment',
        'server_assignment_description' => 'Select which servers should display this document',
        'filter_by_egg' => 'Filter by Game Type',
        'all_eggs' => 'All Game Types',
        'assign_to_servers' => 'Specific Servers',
        'assign_servers_helper' => 'Select individual servers that should display this document',
        'content_type' => 'Editor Type',
        'rich_text' => 'Rich Text',
        'rich_text_help' => 'Use the toolbar to format, or copy from a webpage to paste with formatting',
        'markdown' => 'Markdown',
        'markdown_help' => 'Paste raw Markdown syntax - it will be converted to HTML when displayed',
        'raw_html' => 'Raw HTML',
        'raw_html_help' => 'Write raw HTML directly - for advanced users who want full control over formatting',
        'variables_hint' => '<strong>Variables:</strong> Use <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> etc. in your content. They will be replaced when displayed. Use <code>\{{var}}</code> to show a literal variable.',
        'rich_editor_tip' => 'If the editor becomes unresponsive, switch to Raw HTML mode and back to reset it.',
        'content_preview' => 'Content preview',
        'content_preview_description' => 'See how the document will appear to users (with variables processed)',
        'content_preview_empty' => 'Enter content above to see preview',
    ],

    'variables' => [
        'title' => 'Available Variables',
        'show_available' => 'Show available variables',
        'escape_hint' => 'To show a variable literally without replacing it, prefix with a backslash: \\{{user.name}}',
        'user_name' => 'Current user\'s display name',
        'user_username' => 'Current user\'s username',
        'user_email' => 'Current user\'s email',
        'user_id' => 'Current user\'s ID',
        'server_name' => 'Server name',
        'server_uuid' => 'Server UUID',
        'server_id' => 'Server ID',
        'server_egg' => 'Server game type name',
        'server_node' => 'Node name',
        'server_memory' => 'Allocated memory (MB)',
        'server_disk' => 'Allocated disk (MB)',
        'server_cpu' => 'CPU limit (%)',
        'date' => 'Current date (Y-m-d)',
        'time' => 'Current time (H:i)',
        'datetime' => 'Current date and time',
        'year' => 'Current year',
    ],

    'server' => [
        'node' => 'Node',
        'owner' => 'Owner',
    ],

    'table' => [
        'servers' => 'Servers',
        'updated_at' => 'Updated',
        'type' => 'Type',
        'unknown' => 'Unknown',
        'empty_heading' => 'No documents yet',
        'empty_description' => 'Create your first document to get started.',
    ],

    'permission_guide' => [
        'title' => 'Visibility Guide',
        'modal_heading' => 'Document Visibility Guide',
        'description' => 'Understanding document visibility',
        'intro' => 'Documents have two visibility dimensions: where they appear (servers) and who can see them (people).',
        'server_description' => 'Controls which servers display this document:',
        'all_servers_desc' => 'Document appears on every server',
        'eggs_desc' => 'Document appears on all servers using selected game types',
        'servers_desc' => 'Document appears only on specifically selected servers',
        'person_description' => 'Controls who can view this document:',
        'roles_desc' => 'Only users with selected roles can view',
        'users_desc' => 'Only specifically listed users can view',
        'everyone_desc' => 'If no roles or users are selected, everyone with server access can view',
        'admin_note' => 'Root Admins can always view all documents regardless of visibility settings.',
    ],

    'messages' => [
        'version_restored' => 'Version :version restored successfully.',
        'no_documents' => 'No documents available.',
        'no_versions' => 'No versions yet.',
    ],

    'versions' => [
        'title' => 'Version History',
        'current_document' => 'Current Document',
        'current_version' => 'Current Version',
        'last_updated' => 'Last Updated',
        'last_edited_by' => 'Last Edited By',
        'version_number' => 'Version',
        'edited_by' => 'Edited By',
        'date' => 'Date',
        'change_summary' => 'Change Summary',
        'preview' => 'Preview',
        'restore' => 'Restore',
        'restore_confirm' => 'Are you sure you want to restore this version? This will create a new version with the restored content.',
        'restored' => 'Version restored successfully.',
    ],

    'server_panel' => [
        'title' => 'Server Documents',
        'no_documents' => 'No documents available',
        'no_documents_description' => 'There are no documents for this server yet.',
        'select_document' => 'Select a document',
        'select_document_description' => 'Choose a document from the list to view its contents.',
        'last_updated' => 'Last updated :time',
        'global' => 'Global',
    ],

    'actions' => [
        'new_document' => 'New Document',
        'export' => 'Export as Markdown',
        'export_json' => 'Export Backup',
        'export_json_button' => 'Export as JSON',
        'import' => 'Import Markdown',
        'import_json' => 'Import Backup',
        'back_to_document' => 'Back to Document',
        'close' => 'Close',
    ],

    'import' => [
        'file_label' => 'Markdown File',
        'file_helper' => 'Upload a .md file to create a new document',
        'json_file_label' => 'JSON Backup File',
        'json_file_helper' => 'Upload a JSON backup file exported from this plugin',
        'use_frontmatter' => 'Use YAML Frontmatter',
        'use_frontmatter_helper' => 'Extract title and settings from YAML frontmatter if present',
        'overwrite_existing' => 'Overwrite Existing Documents',
        'overwrite_existing_helper' => 'If enabled, documents with matching UUIDs will be updated. Otherwise, they will be skipped.',
        'success' => 'Document Imported',
        'success_body' => 'Successfully created document ":title"',
        'json_success' => ':imported imported, :updated updated, :skipped skipped.',
        'error' => 'Import Failed',
        'file_too_large' => 'The uploaded file exceeds the maximum allowed size.',
        'file_read_error' => 'Could not read the uploaded file.',
        'invalid_json' => 'Invalid JSON file or missing documents array.',
        'unresolved_roles' => 'Some roles from the frontmatter could not be found: :roles',
        'unresolved_users' => 'Some users from the frontmatter could not be found: :users',
        'unresolved_eggs' => 'Some eggs from the frontmatter could not be found: :eggs',
        'unresolved_servers' => 'Some servers from the frontmatter could not be found: :servers',
    ],

    'export' => [
        'success' => 'Document Exported',
        'success_body' => 'Document has been downloaded as Markdown',
        'modal_heading' => 'Export All Documents',
        'modal_description' => 'This will export all documents with their full configuration (servers, eggs, roles, users, and version history) as a JSON file that can be re-imported later.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Linked Servers',
        'no_servers_linked' => 'No servers linked',
        'attach_servers_description' => 'Attach servers to make this document visible on those servers.',
        'no_documents_linked' => 'No documents linked',
        'attach_documents_description' => 'Attach documents to make them visible on this server.',
        'sort_order_helper' => 'Order this document appears for this server',
    ],
];
