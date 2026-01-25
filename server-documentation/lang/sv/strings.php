<?php

// Swedish translation for Knowledge Base / Documents Plugin
// Kopia av engelska strängar - översatt till svenska

return [
    'navigation' => [
        'documents' => 'Dokument',
        'group' => 'Innehåll',
    ],

    'document' => [
        'singular' => 'Dokument',
        'plural' => 'Dokument',
        'title' => 'Titel',
        'slug' => 'Slug (URL-alias)',
        'content' => 'Innehåll',
        'is_global' => 'Global',
        'is_published' => 'Publicerad',
        'sort_order' => 'Sorteringsordning',
        'author' => 'Författare',
        'last_edited_by' => 'Senast redigerad av',
        'version' => 'Version',
    ],

    'visibility' => [
        'title' => 'Synlighet',
        'description' => 'Kontrollera var detta dokument visas och vem som kan se det',
        'server' => 'Serversynlighet',
        'person' => 'Användarsynlighet',
        'everyone' => 'Alla',
    ],

    'labels' => [
        'all_servers' => 'Alla servrar',
        'all_servers_helper' => 'Visa på alla servrar (annars använd eggs eller specifika servrar nedan)',
        'published_helper' => 'Opublicerade dokument är endast synliga för administratörer',
        'sort_order_helper' => 'Lägre nummer visas först',
        'eggs' => 'Speltyper (Eggs)',
        'roles' => 'Roller',
        'users' => 'Specifika användare',
    ],

    'hints' => [
        'roles_empty' => 'Lämna tomt för att tillåta alla med serveråtkomst',
        'users_optional' => 'Valfritt: ge åtkomst till specifika användare',
        'eggs_hint' => 'Dokumentet kommer att visas på alla servrar som använder valda speltyper',
    ],

    'form' => [
        'details_section' => 'Dokumentinformation',
        'server_assignment' => 'Servertilldelning',
        'server_assignment_description' => 'Välj vilka servrar som ska visa detta dokument',
        'filter_by_egg' => 'Filtrera efter speltyp',
        'all_eggs' => 'Alla speltyper',
        'assign_to_servers' => 'Specifika servrar',
        'assign_servers_helper' => 'Välj enskilda servrar som ska visa detta dokument',
        'content_type' => 'Redigerare',
        'rich_text' => 'Formaterad text (Rich Text)',
        'rich_text_help' => 'Använd verktygsfältet för att formatera, eller kopiera från en webbsida för att klistra in med formatering',
        'markdown' => 'Markdown',
        'markdown_help' => 'Klistra in rå Markdown-syntax - det konverteras till HTML vid visning',
        'raw_html' => 'Rå HTML',
        'raw_html_help' => 'Skriv rå HTML direkt - för avancerade användare som vill ha full kontroll över formateringen',
        'variables_hint' => '<strong>Variabler:</strong> Använd <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> osv. i ditt innehåll. De ersätts vid visning. Använd <code>\{{var}}</code> för att visa en variabel bokstavligt.',
        'rich_editor_tip' => 'Om redigeraren slutar svara, växla till Rå HTML-läge och tillbaka för att återställa den.',
        'content_preview' => 'Förhandsgranskning',
        'content_preview_description' => 'Se hur dokumentet kommer att se ut för användare (med variabler behandlade)',
        'content_preview_empty' => 'Ange innehåll ovan för att se förhandsgranskning',
    ],

    'variables' => [
        'title' => 'Tillgängliga variabler',
        'show_available' => 'Visa tillgängliga variabler',
        'escape_hint' => 'För att visa en variabel bokstavligt utan att ersätta den, lägg till ett omvänt snedstreck innan: \\{{user.name}}',
        'user_name' => 'Nuvarande användares visningsnamn',
        'user_username' => 'Nuvarande användares användarnamn',
        'user_email' => 'Nuvarande användares e-post',
        'user_id' => 'Nuvarande användares ID',
        'server_name' => 'Servernamn',
        'server_uuid' => 'Server UUID',
        'server_id' => 'Server ID',
        'server_egg' => 'Serverns speltypsnamn (Egg)',
        'server_node' => 'Nodnamn',
        'server_memory' => 'Tilldelat minne (MB)',
        'server_disk' => 'Tilldelad disk (MB)',
        'server_cpu' => 'CPU-gräns (%)',
        'date' => 'Dagens datum (Y-m-d)',
        'time' => 'Aktuell tid (H:i)',
        'datetime' => 'Dagens datum och tid',
        'year' => 'Innevarande år',
    ],

    'server' => [
        'node' => 'Nod',
        'owner' => 'Ägare',
    ],

    'table' => [
        'servers' => 'Servrar',
        'updated_at' => 'Uppdaterad',
        'type' => 'Typ',
        'unknown' => 'Okänd',
        'empty_heading' => 'Inga dokument än',
        'empty_description' => 'Skapa ditt första dokument för att komma igång.',
    ],

    'permission_guide' => [
        'title' => 'Synlighetsguide',
        'modal_heading' => 'Guide för dokumentets synlighet',
        'description' => 'Förstå dokumentets synlighet',
        'intro' => 'Dokument har två synlighetsdimensioner: var de visas (servrar) och vem som kan se dem (personer).',
        'server_description' => 'Styr vilka servrar som visar detta dokument:',
        'all_servers_desc' => 'Dokumentet visas på alla servrar',
        'eggs_desc' => 'Dokumentet visas på alla servrar som använder valda speltyper',
        'servers_desc' => 'Dokumentet visas endast på specifikt valda servrar',
        'person_description' => 'Styr vem som kan visa detta dokument:',
        'roles_desc' => 'Endast användare med valda roller kan visa',
        'users_desc' => 'Endast specifikt listade användare kan visa',
        'everyone_desc' => 'Om inga roller eller användare väljs kan alla med serveråtkomst visa',
        'admin_note' => 'Root-administratörer kan alltid se alla dokument oavsett synlighetsinställningar.',
    ],

    'messages' => [
        'version_restored' => 'Version :version har återställts.',
        'no_documents' => 'Inga dokument tillgängliga.',
        'no_versions' => 'Inga versioner än.',
    ],

    'versions' => [
        'title' => 'Versionshistorik',
        'current_document' => 'Nuvarande dokument',
        'current_version' => 'Nuvarande version',
        'last_updated' => 'Senast uppdaterad',
        'last_edited_by' => 'Senast redigerad av',
        'version_number' => 'Version',
        'edited_by' => 'Redigerad av',
        'date' => 'Datum',
        'change_summary' => 'Sammanfattning av ändringar',
        'preview' => 'Förhandsgranska',
        'restore' => 'Återställ',
        'restore_confirm' => 'Är du säker på att du vill återställa denna version? Detta skapar en ny version med det återställda innehållet.',
        'restored' => 'Versionen återställdes.',
    ],

    'server_panel' => [
        'title' => 'Serverdokument',
        'no_documents' => 'Inga dokument tillgängliga',
        'no_documents_description' => 'Det finns inga dokument för denna server än.',
        'select_document' => 'Välj ett dokument',
        'select_document_description' => 'Välj ett dokument från listan för att se dess innehåll.',
        'last_updated' => 'Senast uppdaterad :time',
        'global' => 'Global',
    ],

    'actions' => [
        'new_document' => 'Nytt dokument',
        'export' => 'Exportera som Markdown',
        'export_json' => 'Exportera säkerhetskopia',
        'export_json_button' => 'Exportera som JSON',
        'import' => 'Importera Markdown',
        'import_json' => 'Importera säkerhetskopia',
        'back_to_document' => 'Tillbaka till dokument',
        'close' => 'Stäng',
    ],

    'import' => [
        'file_label' => 'Markdown-fil',
        'file_helper' => 'Ladda upp en .md-fil för att skapa ett nytt dokument',
        'json_file_label' => 'JSON-säkerhetskopia',
        'json_file_helper' => 'Ladda upp en JSON-säkerhetskopia exporterad från detta plugin',
        'use_frontmatter' => 'Använd YAML Frontmatter',
        'use_frontmatter_helper' => 'Extrahera titel och inställningar från YAML frontmatter om det finns',
        'overwrite_existing' => 'Skriv över befintliga dokument',
        'overwrite_existing_helper' => 'Om aktiverat kommer dokument med matchande UUIDs att uppdateras. Annars hoppas de över.',
        'success' => 'Dokument importerat',
        'success_body' => 'Skapade dokumentet ":title"',
        'json_success' => ':imported importerade, :updated uppdaterade, :skipped hoppades över.',
        'error' => 'Import misslyckades',
        'file_too_large' => 'Den uppladdade filen överskrider maximal tillåten storlek.',
        'file_read_error' => 'Kunde inte läsa den uppladdade filen.',
        'invalid_json' => 'Ogiltig JSON-fil eller dokumentmatris saknas.',
        'unresolved_roles' => 'Vissa roller från frontmatter kunde inte hittas: :roles',
        'unresolved_users' => 'Vissa användare från frontmatter kunde inte hittas: :users',
        'unresolved_eggs' => 'Vissa eggs från frontmatter kunde inte hittas: :eggs',
        'unresolved_servers' => 'Vissa servrar från frontmatter kunde inte hittas: :servers',
    ],

    'export' => [
        'success' => 'Dokument exporterat',
        'success_body' => 'Dokumentet har laddats ner som Markdown',
        'modal_heading' => 'Exportera alla dokument',
        'modal_description' => 'Detta kommer att exportera alla dokument med deras fullständiga konfiguration (servrar, eggs, roller, användare och versionshistorik) som en JSON-fil som kan importeras igen senare.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Länkade servrar',
        'no_servers_linked' => 'Inga servrar länkade',
        'attach_servers_description' => 'Koppla servrar för att göra detta dokument synligt på dessa servrar.',
        'no_documents_linked' => 'Inga dokument länkade',
        'attach_documents_description' => 'Koppla dokument för att göra dem synliga på denna server.',
        'sort_order_helper' => 'Ordning som detta dokument visas i för denna server',
    ],
];