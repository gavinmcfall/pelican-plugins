<?php

// Czech translation for Knowledge Base / Documents Plugin
// Kopie anglických řetězců - přeloženo do češtiny

return [
    'navigation' => [
        'documents' => 'Dokumenty',
        'group' => 'Obsah',
    ],

    'document' => [
        'singular' => 'Dokument',
        'plural' => 'Dokumenty',
        'title' => 'Název',
        'slug' => 'Slug (URL alias)',
        'content' => 'Obsah',
        'is_global' => 'Globální',
        'is_published' => 'Publikováno',
        'sort_order' => 'Pořadí řazení',
        'author' => 'Autor',
        'last_edited_by' => 'Naposledy upravil',
        'version' => 'Verze',
    ],

    'visibility' => [
        'title' => 'Viditelnost',
        'description' => 'Ovládání, kde se tento dokument zobrazí a kdo jej může vidět',
        'server' => 'Viditelnost na serveru',
        'person' => 'Viditelnost pro osoby',
        'everyone' => 'Všichni',
    ],

    'labels' => [
        'all_servers' => 'Všechny servery',
        'all_servers_helper' => 'Zobrazit na všech serverech (jinak použijte typy her nebo konkrétní servery níže)',
        'published_helper' => 'Nepublikované dokumenty jsou viditelné pouze pro administrátory',
        'sort_order_helper' => 'Nižší čísla se zobrazují jako první',
        'eggs' => 'Herní typy (Eggs)',
        'roles' => 'Role',
        'users' => 'Konkrétní uživatelé',
    ],

    'hints' => [
        'roles_empty' => 'Ponechte prázdné pro povolení všem s přístupem k serveru',
        'users_optional' => 'Volitelné: udělit přístup konkrétním uživatelům',
        'eggs_hint' => 'Dokument se zobrazí na všech serverech používajících vybrané herní typy',
    ],

    'form' => [
        'details_section' => 'Podrobnosti dokumentu',
        'server_assignment' => 'Přiřazení serveru',
        'server_assignment_description' => 'Vyberte, které servery mají tento dokument zobrazovat',
        'filter_by_egg' => 'Filtrovat podle typu hry',
        'all_eggs' => 'Všechny typy her',
        'assign_to_servers' => 'Konkrétní servery',
        'assign_servers_helper' => 'Vyberte jednotlivé servery, které mají tento dokument zobrazovat',
        'content_type' => 'Typ editoru',
        'rich_text' => 'Formátovaný text',
        'rich_text_help' => 'Použijte panel nástrojů pro formátování nebo zkopírujte obsah z webové stránky a vložte jej i s formátováním',
        'markdown' => 'Markdown',
        'markdown_help' => 'Vložte hrubou syntaxi Markdown - při zobrazení bude převedena na HTML',
        'raw_html' => 'Čisté HTML',
        'raw_html_help' => 'Pište přímo HTML kód - pro pokročilé uživatele, kteří chtějí plnou kontrolu nad formátováním',
        'variables_hint' => '<strong>Proměnné:</strong> V obsahu používejte <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> atd. Při zobrazení budou nahrazeny. Použijte <code>\{{var}}</code> pro zobrazení proměnné jako textu.',
        'rich_editor_tip' => 'Pokud editor přestane reagovat, přepněte do režimu Čisté HTML a zpět pro jeho resetování.',
        'content_preview' => 'Náhled obsahu',
        'content_preview_description' => 'Podívejte se, jak se dokument zobrazí uživatelům (se zpracovanými proměnnými)',
        'content_preview_empty' => 'Zadejte obsah výše pro zobrazení náhledu',
    ],

    'variables' => [
        'title' => 'Dostupné proměnné',
        'show_available' => 'Zobrazit dostupné proměnné',
        'escape_hint' => 'Pro zobrazení proměnné doslovně bez jejího nahrazení, přidejte před ni zpětné lomítko: \\{{user.name}}',
        'user_name' => 'Zobrazované jméno aktuálního uživatele',
        'user_username' => 'Uživatelské jméno aktuálního uživatele',
        'user_email' => 'Email aktuálního uživatele',
        'user_id' => 'ID aktuálního uživatele',
        'server_name' => 'Název serveru',
        'server_uuid' => 'UUID serveru',
        'server_id' => 'ID serveru',
        'server_egg' => 'Název herního typu (Egg) serveru',
        'server_node' => 'Název uzlu (Node)',
        'server_memory' => 'Přidělená paměť (MB)',
        'server_disk' => 'Přidělený disk (MB)',
        'server_cpu' => 'Limit CPU (%)',
        'date' => 'Aktuální datum (Y-m-d)',
        'time' => 'Aktuální čas (H:i)',
        'datetime' => 'Aktuální datum a čas',
        'year' => 'Aktuální rok',
    ],

    'server' => [
        'node' => 'Uzel (Node)',
        'owner' => 'Vlastník',
    ],

    'table' => [
        'servers' => 'Servery',
        'updated_at' => 'Aktualizováno',
        'type' => 'Typ',
        'unknown' => 'Neznámý',
        'empty_heading' => 'Zatím žádné dokumenty',
        'empty_description' => 'Vytvořte svůj první dokument a začněte.',
    ],

    'permission_guide' => [
        'title' => 'Průvodce viditelností',
        'modal_heading' => 'Průvodce viditelností dokumentu',
        'description' => 'Pochopení viditelnosti dokumentu',
        'intro' => 'Dokumenty mají dvě dimenze viditelnosti: kde se zobrazují (servery) a kdo je může vidět (osoby).',
        'server_description' => 'Ovládá, které servery zobrazují tento dokument:',
        'all_servers_desc' => 'Dokument se zobrazí na každém serveru',
        'eggs_desc' => 'Dokument se zobrazí na všech serverech používajících vybrané typy her',
        'servers_desc' => 'Dokument se zobrazí pouze na konkrétně vybraných serverech',
        'person_description' => 'Ovládá, kdo může tento dokument prohlížet:',
        'roles_desc' => 'Prohlížet mohou pouze uživatelé s vybranými rolemi',
        'users_desc' => 'Prohlížet mohou pouze konkrétně uvedení uživatelé',
        'everyone_desc' => 'Pokud nejsou vybrány žádné role ani uživatelé, mohou prohlížet všichni s přístupem k serveru',
        'admin_note' => 'Hlavní administrátoři (Root Admins) mohou vždy prohlížet všechny dokumenty bez ohledu na nastavení viditelnosti.',
    ],

    'messages' => [
        'version_restored' => 'Verze :version byla úspěšně obnovena.',
        'no_documents' => 'Žádné dokumenty k dispozici.',
        'no_versions' => 'Zatím žádné verze.',
    ],

    'versions' => [
        'title' => 'Historie verzí',
        'current_document' => 'Aktuální dokument',
        'current_version' => 'Aktuální verze',
        'last_updated' => 'Poslední aktualizace',
        'last_edited_by' => 'Naposledy upravil',
        'version_number' => 'Verze',
        'edited_by' => 'Upravil',
        'date' => 'Datum',
        'change_summary' => 'Souhrn změn',
        'preview' => 'Náhled',
        'restore' => 'Obnovit',
        'restore_confirm' => 'Jste si jisti, že chcete obnovit tuto verzi? Tím se vytvoří nová verze s obnoveným obsahem.',
        'restored' => 'Verze úspěšně obnovena.',
    ],

    'server_panel' => [
        'title' => 'Dokumenty serveru',
        'no_documents' => 'Žádné dokumenty k dispozici',
        'no_documents_description' => 'Pro tento server zatím nejsou žádné dokumenty.',
        'select_document' => 'Vyberte dokument',
        'select_document_description' => 'Vyberte dokument ze seznamu pro zobrazení jeho obsahu.',
        'last_updated' => 'Poslední aktualizace :time',
        'global' => 'Globální',
    ],

    'actions' => [
        'new_document' => 'Nový dokument',
        'export' => 'Exportovat jako Markdown',
        'export_json' => 'Exportovat zálohu',
        'export_json_button' => 'Exportovat jako JSON',
        'import' => 'Importovat Markdown',
        'import_json' => 'Importovat zálohu',
        'back_to_document' => 'Zpět na dokument',
        'close' => 'Zavřít',
    ],

    'import' => [
        'file_label' => 'Soubor Markdown',
        'file_helper' => 'Nahrajte soubor .md pro vytvoření nového dokumentu',
        'json_file_label' => 'Soubor zálohy JSON',
        'json_file_helper' => 'Nahrajte soubor zálohy JSON exportovaný z tohoto pluginu',
        'use_frontmatter' => 'Použít YAML hlavičku (Frontmatter)',
        'use_frontmatter_helper' => 'Extrahovat název a nastavení z YAML hlavičky, pokud je přítomna',
        'overwrite_existing' => 'Přepsat existující dokumenty',
        'overwrite_existing_helper' => 'Pokud je povoleno, dokumenty se shodnými UUID budou aktualizovány. V opačném případě budou přeskočeny.',
        'success' => 'Dokument importován',
        'success_body' => 'Úspěšně vytvořen dokument ":title"',
        'json_success' => ':imported importováno, :updated aktualizováno, :skipped přeskočeno.',
        'error' => 'Import selhal',
        'file_too_large' => 'Nahraný soubor překračuje maximální povolenou velikost.',
        'file_read_error' => 'Nelze přečíst nahraný soubor.',
        'invalid_json' => 'Neplatný soubor JSON nebo chybí pole dokumentů.',
        'unresolved_roles' => 'Některé role z hlavičky nebylo možné nalézt: :roles',
        'unresolved_users' => 'Některé uživatele z hlavičky nebylo možné nalézt: :users',
        'unresolved_eggs' => 'Některé herní typy (eggs) z hlavičky nebylo možné nalézt: :eggs',
        'unresolved_servers' => 'Některé servery z hlavičky nebylo možné nalézt: :servers',
    ],

    'export' => [
        'success' => 'Dokument exportován',
        'success_body' => 'Dokument byl stažen jako Markdown',
        'modal_heading' => 'Exportovat všechny dokumenty',
        'modal_description' => 'Tímto vyexportujete všechny dokumenty s jejich kompletní konfigurací (servery, herní typy, role, uživatelé a historie verzí) jako soubor JSON, který lze později znovu importovat.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Propojené servery',
        'no_servers_linked' => 'Žádné propojené servery',
        'attach_servers_description' => 'Připojte servery, aby byl tento dokument na nich viditelný.',
        'no_documents_linked' => 'Žádné propojené dokumenty',
        'attach_documents_description' => 'Připojte dokumenty, aby byly viditelné na tomto serveru.',
        'sort_order_helper' => 'Pořadí, v jakém se tento dokument zobrazí pro tento server',
    ],
];
