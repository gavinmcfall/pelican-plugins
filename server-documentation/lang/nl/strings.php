<?php

// Dutch translation for Knowledge Base / Documents Plugin
// Kopie van Engelse strings - vertaald naar het Nederlands

return [
    'navigation' => [
        'documents' => 'Documenten',
        'group' => 'Inhoud',
    ],

    'document' => [
        'singular' => 'Document',
        'plural' => 'Documenten',
        'title' => 'Titel',
        'slug' => 'Slug',
        'content' => 'Inhoud',
        'is_global' => 'Globaal',
        'is_published' => 'Gepubliceerd',
        'sort_order' => 'Sorteervolgorde',
        'author' => 'Auteur',
        'last_edited_by' => 'Laatst bewerkt door',
        'version' => 'Versie',
    ],

    'visibility' => [
        'title' => 'Zichtbaarheid',
        'description' => 'Beheer waar dit document verschijnt en wie het kan zien',
        'server' => 'Server Zichtbaarheid',
        'person' => 'Persoonlijke Zichtbaarheid',
        'everyone' => 'Iedereen',
    ],

    'labels' => [
        'all_servers' => 'Alle Servers',
        'all_servers_helper' => 'Toon op alle servers (gebruik anders eggs of specifieke servers hieronder)',
        'published_helper' => 'Niet-gepubliceerde documenten zijn alleen zichtbaar voor beheerders',
        'sort_order_helper' => 'Lagere nummers verschijnen eerst',
        'eggs' => 'Speltypes (Eggs)',
        'roles' => 'Rollen',
        'users' => 'Specifieke Gebruikers',
    ],

    'hints' => [
        'roles_empty' => 'Laat leeg om iedereen met servertoegang toe te staan',
        'users_optional' => 'Optioneel: geef toegang aan specifieke gebruikers',
        'eggs_hint' => 'Document verschijnt op alle servers die de geselecteerde speltypes gebruiken',
    ],

    'form' => [
        'details_section' => 'Document Details',
        'server_assignment' => 'Server Toewijzing',
        'server_assignment_description' => 'Selecteer welke servers dit document moeten weergeven',
        'filter_by_egg' => 'Filter op Speltype',
        'all_eggs' => 'Alle Speltypes',
        'assign_to_servers' => 'Specifieke Servers',
        'assign_servers_helper' => 'Selecteer individuele servers die dit document moeten weergeven',
        'content_type' => 'Editor Type',
        'rich_text' => 'Rich Text',
        'rich_text_help' => 'Gebruik de werkbalk om op te maken, of kopieer van een webpagina om met opmaak te plakken',
        'markdown' => 'Markdown',
        'markdown_help' => 'Plak ruwe Markdown syntax - dit wordt omgezet naar HTML bij weergave',
        'raw_html' => 'Ruwe HTML',
        'raw_html_help' => 'Schrijf direct ruwe HTML - voor geavanceerde gebruikers die volledige controle over de opmaak willen',
        'variables_hint' => '<strong>Variabelen:</strong> Gebruik <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> etc. in uw inhoud. Deze worden vervangen bij weergave. Gebruik <code>\{{var}}</code> om een letterlijke variabele te tonen.',
        'rich_editor_tip' => 'Als de editor niet meer reageert, schakel dan naar Ruwe HTML modus en terug om te resetten.',
        'content_preview' => 'Inhoud voorbeeld',
        'content_preview_description' => 'Zie hoe het document eruitziet voor gebruikers (met verwerkte variabelen)',
        'content_preview_empty' => 'Voer hierboven inhoud in om een voorbeeld te zien',
    ],

    'variables' => [
        'title' => 'Beschikbare Variabelen',
        'show_available' => 'Toon beschikbare variabelen',
        'escape_hint' => 'Om een variabele letterlijk te tonen zonder vervanging, zet er een backslash voor: \\{{user.name}}',
        'user_name' => 'Weergavenaam van huidige gebruiker',
        'user_username' => 'Gebruikersnaam van huidige gebruiker',
        'user_email' => 'E-mail van huidige gebruiker',
        'user_id' => 'ID van huidige gebruiker',
        'server_name' => 'Servernaam',
        'server_uuid' => 'Server UUID',
        'server_id' => 'Server ID',
        'server_egg' => 'Naam van server speltype',
        'server_node' => 'Node naam',
        'server_memory' => 'Toegewezen geheugen (MB)',
        'server_disk' => 'Toegewezen schijfruimte (MB)',
        'server_cpu' => 'CPU limiet (%)',
        'date' => 'Huidige datum (Y-m-d)',
        'time' => 'Huidige tijd (H:i)',
        'datetime' => 'Huidige datum en tijd',
        'year' => 'Huidig jaar',
    ],

    'server' => [
        'node' => 'Node',
        'owner' => 'Eigenaar',
    ],

    'table' => [
        'servers' => 'Servers',
        'updated_at' => 'Bijgewerkt',
        'type' => 'Type',
        'unknown' => 'Onbekend',
        'empty_heading' => 'Nog geen documenten',
        'empty_description' => 'Maak uw eerste document aan om te beginnen.',
    ],

    'permission_guide' => [
        'title' => 'Zichtbaarheidsgids',
        'modal_heading' => 'Document Zichtbaarheidsgids',
        'description' => 'Document zichtbaarheid begrijpen',
        'intro' => 'Documenten hebben twee zichtbaarheidsdimensies: waar ze verschijnen (servers) en wie ze kan zien (mensen).',
        'server_description' => 'Bepaalt welke servers dit document weergeven:',
        'all_servers_desc' => 'Document verschijnt op elke server',
        'eggs_desc' => 'Document verschijnt op alle servers die de geselecteerde speltypes gebruiken',
        'servers_desc' => 'Document verschijnt alleen op specifiek geselecteerde servers',
        'person_description' => 'Bepaalt wie dit document kan bekijken:',
        'roles_desc' => 'Alleen gebruikers met geselecteerde rollen kunnen kijken',
        'users_desc' => 'Alleen specifiek vermelde gebruikers kunnen kijken',
        'everyone_desc' => 'Als er geen rollen of gebruikers zijn geselecteerd, kan iedereen met servertoegang kijken',
        'admin_note' => 'Root Admins kunnen altijd alle documenten bekijken, ongeacht de zichtbaarheidsinstellingen.',
    ],

    'messages' => [
        'version_restored' => 'Versie :version succesvol hersteld.',
        'no_documents' => 'Geen documenten beschikbaar.',
        'no_versions' => 'Nog geen versies.',
    ],

    'versions' => [
        'title' => 'Versiegeschiedenis',
        'current_document' => 'Huidig Document',
        'current_version' => 'Huidige Versie',
        'last_updated' => 'Laatst Bijgewerkt',
        'last_edited_by' => 'Laatst Bewerkt Door',
        'version_number' => 'Versie',
        'edited_by' => 'Bewerkt Door',
        'date' => 'Datum',
        'change_summary' => 'Samenvatting van Wijzigingen',
        'preview' => 'Voorbeeld',
        'restore' => 'Herstellen',
        'restore_confirm' => 'Weet u zeker dat u deze versie wilt herstellen? Dit maakt een nieuwe versie aan met de herstelde inhoud.',
        'restored' => 'Versie succesvol hersteld.',
    ],

    'server_panel' => [
        'title' => 'Server Documenten',
        'no_documents' => 'Geen documenten beschikbaar',
        'no_documents_description' => 'Er zijn nog geen documenten voor deze server.',
        'select_document' => 'Selecteer een document',
        'select_document_description' => 'Kies een document uit de lijst om de inhoud te bekijken.',
        'last_updated' => 'Laatst bijgewerkt :time',
        'global' => 'Globaal',
    ],

    'actions' => [
        'new_document' => 'Nieuw Document',
        'export' => 'Exporteren als Markdown',
        'export_json' => 'Backup Exporteren',
        'export_json_button' => 'Exporteren als JSON',
        'import' => 'Markdown Importeren',
        'import_json' => 'Backup Importeren',
        'back_to_document' => 'Terug naar Document',
        'close' => 'Sluiten',
    ],

    'import' => [
        'file_label' => 'Markdown Bestand',
        'file_helper' => 'Upload een .md bestand om een nieuw document te maken',
        'json_file_label' => 'JSON Backup Bestand',
        'json_file_helper' => 'Upload een JSON backup bestand geëxporteerd vanuit deze plugin',
        'use_frontmatter' => 'Gebruik YAML Frontmatter',
        'use_frontmatter_helper' => 'Extraheer titel en instellingen uit YAML frontmatter indien aanwezig',
        'overwrite_existing' => 'Bestaande Documenten Overschrijven',
        'overwrite_existing_helper' => 'Indien ingeschakeld, worden documenten met overeenkomende UUID\'s bijgewerkt. Anders worden ze overgeslagen.',
        'success' => 'Document Geïmporteerd',
        'success_body' => 'Document ":title" succesvol aangemaakt',
        'json_success' => ':imported geïmporteerd, :updated bijgewerkt, :skipped overgeslagen.',
        'error' => 'Import Mislukt',
        'file_too_large' => 'Het geüploade bestand overschrijdt de maximaal toegestane grootte.',
        'file_read_error' => 'Kon het geüploade bestand niet lezen.',
        'invalid_json' => 'Ongeldig JSON bestand of ontbrekende documenten array.',
        'unresolved_roles' => 'Sommige rollen uit de frontmatter konden niet worden gevonden: :roles',
        'unresolved_users' => 'Sommige gebruikers uit de frontmatter konden niet worden gevonden: :users',
        'unresolved_eggs' => 'Sommige eggs uit de frontmatter konden niet worden gevonden: :eggs',
        'unresolved_servers' => 'Sommige servers uit de frontmatter konden niet worden gevonden: :servers',
    ],

    'export' => [
        'success' => 'Document Geëxporteerd',
        'success_body' => 'Document is gedownload als Markdown',
        'modal_heading' => 'Alle Documenten Exporteren',
        'modal_description' => 'Dit exporteert alle documenten met hun volledige configuratie (servers, eggs, rollen, gebruikers en versiegeschiedenis) als een JSON bestand dat later opnieuw geïmporteerd kan worden.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Gekoppelde Servers',
        'no_servers_linked' => 'Geen servers gekoppeld',
        'attach_servers_description' => 'Koppel servers om dit document zichtbaar te maken op die servers.',
        'no_documents_linked' => 'Geen documenten gekoppeld',
        'attach_documents_description' => 'Koppel documenten om ze zichtbaar te maken op deze server.',
        'sort_order_helper' => 'Volgorde waarin dit document verschijnt voor deze server',
    ],
];
