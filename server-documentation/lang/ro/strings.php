<?php

// Romanian translation for Knowledge Base / Documents Plugin
// Copie a șirurilor din engleză - traduse în română

return [
    'navigation' => [
        'documents' => 'Documente',
        'group' => 'Conținut',
    ],

    'document' => [
        'singular' => 'Document',
        'plural' => 'Documente',
        'title' => 'Titlu',
        'slug' => 'Slug (Alias URL)',
        'content' => 'Conținut',
        'is_global' => 'Global',
        'is_published' => 'Publicat',
        'sort_order' => 'Ordine Sortare',
        'author' => 'Autor',
        'last_edited_by' => 'Ultima editare de',
        'version' => 'Versiune',
    ],

    'visibility' => [
        'title' => 'Vizibilitate',
        'description' => 'Controlați unde apare acest document și cine îl poate vedea',
        'server' => 'Vizibilitate Server',
        'person' => 'Vizibilitate Persoane',
        'everyone' => 'Toată lumea',
    ],

    'labels' => [
        'all_servers' => 'Toate Serverele',
        'all_servers_helper' => 'Afișează pe toate serverele (altfel utilizați eggs sau servere specifice mai jos)',
        'published_helper' => 'Documentele nepublicate sunt vizibile doar pentru administratori',
        'sort_order_helper' => 'Numerele mai mici apar primele',
        'eggs' => 'Tipuri de Joc (Eggs)',
        'roles' => 'Roluri',
        'users' => 'Utilizatori Specifici',
    ],

    'hints' => [
        'roles_empty' => 'Lăsați gol pentru a permite tuturor celor cu acces la server',
        'users_optional' => 'Opțional: acordați acces unor utilizatori specifici',
        'eggs_hint' => 'Documentul va apărea pe toate serverele care utilizează tipurile de joc selectate',
    ],

    'form' => [
        'details_section' => 'Detalii Document',
        'server_assignment' => 'Atribuire Server',
        'server_assignment_description' => 'Selectați care servere ar trebui să afișeze acest document',
        'filter_by_egg' => 'Filtrare după Tip Joc',
        'all_eggs' => 'Toate Tipurile de Joc',
        'assign_to_servers' => 'Servere Specifice',
        'assign_servers_helper' => 'Selectați serverele individuale care ar trebui să afișeze acest document',
        'content_type' => 'Tip Editor',
        'rich_text' => 'Text Formatat (Rich Text)',
        'rich_text_help' => 'Utilizați bara de instrumente pentru formatare sau copiați de pe o pagină web pentru a lipi cu formatare',
        'markdown' => 'Markdown',
        'markdown_help' => 'Lipiți sintaxa Markdown brută - va fi convertită în HTML la afișare',
        'raw_html' => 'HTML Brut',
        'raw_html_help' => 'Scrieți direct HTML brut - pentru utilizatori avansați care doresc control total asupra formatării',
        'variables_hint' => '<strong>Variabile:</strong> Utilizați <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> etc. în conținutul dvs. Acestea vor fi înlocuite la afișare. Utilizați <code>\{{var}}</code> pentru a afișa o variabilă literal.',
        'rich_editor_tip' => 'Dacă editorul nu mai răspunde, comutați la modul HTML Brut și înapoi pentru a-l reseta.',
        'content_preview' => 'Previzualizare conținut',
        'content_preview_description' => 'Vedeți cum va apărea documentul pentru utilizatori (cu variabilele procesate)',
        'content_preview_empty' => 'Introduceți conținut mai sus pentru a vedea previzualizarea',
    ],

    'variables' => [
        'title' => 'Variabile Disponibile',
        'show_available' => 'Afișează variabilele disponibile',
        'escape_hint' => 'Pentru a afișa o variabilă literal fără a o înlocui, adăugați un backslash înainte: \\{{user.name}}',
        'user_name' => 'Numele afișat al utilizatorului curent',
        'user_username' => 'Numele de utilizator al utilizatorului curent',
        'user_email' => 'Email-ul utilizatorului curent',
        'user_id' => 'ID-ul utilizatorului curent',
        'server_name' => 'Nume server',
        'server_uuid' => 'UUID server',
        'server_id' => 'ID server',
        'server_egg' => 'Numele tipului de joc (Egg) al serverului',
        'server_node' => 'Nume nod',
        'server_memory' => 'Memorie alocată (MB)',
        'server_disk' => 'Disk alocat (MB)',
        'server_cpu' => 'Limită CPU (%)',
        'date' => 'Data curentă (Y-m-d)',
        'time' => 'Ora curentă (H:i)',
        'datetime' => 'Data și ora curentă',
        'year' => 'Anul curent',
    ],

    'server' => [
        'node' => 'Nod',
        'owner' => 'Proprietar',
    ],

    'table' => [
        'servers' => 'Servere',
        'updated_at' => 'Actualizat',
        'type' => 'Tip',
        'unknown' => 'Necunoscut',
        'empty_heading' => 'Încă nu există documente',
        'empty_description' => 'Creați primul document pentru a începe.',
    ],

    'permission_guide' => [
        'title' => 'Ghid Vizibilitate',
        'modal_heading' => 'Ghid Vizibilitate Document',
        'description' => 'Înțelegerea vizibilității documentelor',
        'intro' => 'Documentele au două dimensiuni de vizibilitate: unde apar (servere) și cine le poate vedea (persoane).',
        'server_description' => 'Controlează care servere afișează acest document:',
        'all_servers_desc' => 'Documentul apare pe fiecare server',
        'eggs_desc' => 'Documentul apare pe toate serverele care utilizează tipurile de joc selectate',
        'servers_desc' => 'Documentul apare doar pe serverele selectate specific',
        'person_description' => 'Controlează cine poate vizualiza acest document:',
        'roles_desc' => 'Doar utilizatorii cu rolurile selectate pot vizualiza',
        'users_desc' => 'Doar utilizatorii enumerați specific pot vizualiza',
        'everyone_desc' => 'Dacă nu sunt selectate roluri sau utilizatori, toți cei cu acces la server pot vizualiza',
        'admin_note' => 'Administratorii Root pot vizualiza întotdeauna toate documentele, indiferent de setările de vizibilitate.',
    ],

    'messages' => [
        'version_restored' => 'Versiunea :version a fost restaurată cu succes.',
        'no_documents' => 'Nu există documente disponibile.',
        'no_versions' => 'Încă nu există versiuni.',
    ],

    'versions' => [
        'title' => 'Istoric Versiuni',
        'current_document' => 'Document Curent',
        'current_version' => 'Versiune Curentă',
        'last_updated' => 'Ultima Actualizare',
        'last_edited_by' => 'Ultima Editare De',
        'version_number' => 'Versiune',
        'edited_by' => 'Editat De',
        'date' => 'Dată',
        'change_summary' => 'Rezumat Modificări',
        'preview' => 'Previzualizare',
        'restore' => 'Restaurare',
        'restore_confirm' => 'Sunteți sigur că doriți să restaurați această versiune? Aceasta va crea o nouă versiune cu conținutul restaurat.',
        'restored' => 'Versiune restaurată cu succes.',
    ],

    'server_panel' => [
        'title' => 'Documente Server',
        'no_documents' => 'Nu există documente disponibile',
        'no_documents_description' => 'Nu există încă documente pentru acest server.',
        'select_document' => 'Selectați un document',
        'select_document_description' => 'Alegeți un document din listă pentru a-i vedea conținutul.',
        'last_updated' => 'Ultima actualizare :time',
        'global' => 'Global',
    ],

    'actions' => [
        'new_document' => 'Document Nou',
        'export' => 'Export ca Markdown',
        'export_json' => 'Export Copie de Rezervă',
        'export_json_button' => 'Export ca JSON',
        'import' => 'Import Markdown',
        'import_json' => 'Import Copie de Rezervă',
        'back_to_document' => 'Înapoi la Document',
        'close' => 'Închide',
    ],

    'import' => [
        'file_label' => 'Fișier Markdown',
        'file_helper' => 'Încărcați un fișier .md pentru a crea un document nou',
        'json_file_label' => 'Fișier Copie de Rezervă JSON',
        'json_file_helper' => 'Încărcați un fișier de backup JSON exportat din acest plugin',
        'use_frontmatter' => 'Utilizare YAML Frontmatter',
        'use_frontmatter_helper' => 'Extrageți titlul și setările din YAML frontmatter dacă există',
        'overwrite_existing' => 'Suprascriere Documente Existente',
        'overwrite_existing_helper' => 'Dacă este activat, documentele cu UUID-uri corespunzătoare vor fi actualizate. Altfel, vor fi omise.',
        'success' => 'Document Importat',
        'success_body' => 'Documentul ":title" a fost creat cu succes',
        'json_success' => ':imported importate, :updated actualizate, :skipped omise.',
        'error' => 'Import Eșuat',
        'file_too_large' => 'Fișierul încărcat depășește dimensiunea maximă permisă.',
        'file_read_error' => 'Nu s-a putut citi fișierul încărcat.',
        'invalid_json' => 'Fișier JSON invalid sau matricea de documente lipsește.',
        'unresolved_roles' => 'Unele roluri din frontmatter nu au putut fi găsite: :roles',
        'unresolved_users' => 'Unii utilizatori din frontmatter nu au putut fi găsiți: :users',
        'unresolved_eggs' => 'Unele eggs din frontmatter nu au putut fi găsite: :eggs',
        'unresolved_servers' => 'Unele servere din frontmatter nu au putut fi găsite: :servers',
    ],

    'export' => [
        'success' => 'Document Exportat',
        'success_body' => 'Documentul a fost descărcat ca Markdown',
        'modal_heading' => 'Export Toate Documentele',
        'modal_description' => 'Aceasta va exporta toate documentele cu configurația lor completă (servere, eggs, roluri, utilizatori și istoric versiuni) ca un fișier JSON care poate fi reimportat ulterior.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Servere Conectate',
        'no_servers_linked' => 'Niciun server conectat',
        'attach_servers_description' => 'Atașați servere pentru a face acest document vizibil pe acele servere.',
        'no_documents_linked' => 'Niciun document conectat',
        'attach_documents_description' => 'Atașați documente pentru a le face vizibile pe acest server.',
        'sort_order_helper' => 'Ordinea în care apare acest document pentru acest server',
    ],
];