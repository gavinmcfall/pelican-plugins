<?php

// Italian translation for Knowledge Base / Documents Plugin
// Copia delle stringhe inglesi - tradotte in italiano

return [
    'navigation' => [
        'documents' => 'Documenti',
        'group' => 'Contenuto',
    ],

    'document' => [
        'singular' => 'Documento',
        'plural' => 'Documenti',
        'title' => 'Titolo',
        'slug' => 'Slug (Alias URL)',
        'content' => 'Contenuto',
        'is_global' => 'Globale',
        'is_published' => 'Pubblicato',
        'sort_order' => 'Ordinamento',
        'author' => 'Autore',
        'last_edited_by' => 'Ultima modifica di',
        'version' => 'Versione',
    ],

    'visibility' => [
        'title' => 'Visibilità',
        'description' => 'Controlla dove appare questo documento e chi può vederlo',
        'server' => 'Visibilità Server',
        'person' => 'Visibilità Utente',
        'everyone' => 'Tutti',
    ],

    'labels' => [
        'all_servers' => 'Tutti i Server',
        'all_servers_helper' => 'Mostra su tutti i server (altrimenti usa le eggs o server specifici qui sotto)',
        'published_helper' => 'I documenti non pubblicati sono visibili solo agli amministratori',
        'sort_order_helper' => 'I numeri più bassi appaiono per primi',
        'eggs' => 'Tipi di Gioco (Eggs)',
        'roles' => 'Ruoli',
        'users' => 'Utenti Specifici',
    ],

    'hints' => [
        'roles_empty' => 'Lascia vuoto per consentire a tutti coloro che hanno accesso al server',
        'users_optional' => 'Opzionale: concedi l\'accesso a utenti specifici',
        'eggs_hint' => 'Il documento apparirà su tutti i server che utilizzano i tipi di gioco selezionati',
    ],

    'form' => [
        'details_section' => 'Dettagli Documento',
        'server_assignment' => 'Assegnazione Server',
        'server_assignment_description' => 'Seleziona quali server devono mostrare questo documento',
        'filter_by_egg' => 'Filtra per Tipo di Gioco',
        'all_eggs' => 'Tutti i Tipi di Gioco',
        'assign_to_servers' => 'Server Specifici',
        'assign_servers_helper' => 'Seleziona i singoli server che devono mostrare questo documento',
        'content_type' => 'Tipo di Editor',
        'rich_text' => 'Rich Text',
        'rich_text_help' => 'Usa la barra degli strumenti per formattare, o copia da una pagina web per incollare con la formattazione',
        'markdown' => 'Markdown',
        'markdown_help' => 'Incolla la sintassi Markdown grezza - verrà convertita in HTML quando visualizzata',
        'raw_html' => 'HTML Puro',
        'raw_html_help' => 'Scrivi direttamente HTML puro - per utenti avanzati che vogliono il controllo totale sulla formattazione',
        'variables_hint' => '<strong>Variabili:</strong> Usa <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> ecc. nel tuo contenuto. Verranno sostituite quando visualizzate. Usa <code>\{{var}}</code> per mostrare una variabile letteralmente.',
        'rich_editor_tip' => 'Se l\'editor smette di rispondere, passa alla modalità HTML Puro e torna indietro per resettarlo.',
        'content_preview' => 'Anteprima contenuto',
        'content_preview_description' => 'Vedi come apparirà il documento agli utenti (con le variabili elaborate)',
        'content_preview_empty' => 'Inserisci il contenuto sopra per vedere l\'anteprima',
    ],

    'variables' => [
        'title' => 'Variabili Disponibili',
        'show_available' => 'Mostra variabili disponibili',
        'escape_hint' => 'Per mostrare una variabile letteralmente senza sostituirla, aggiungi una barra rovesciata prima: \\{{user.name}}',
        'user_name' => 'Nome visualizzato dell\'utente corrente',
        'user_username' => 'Nome utente dell\'utente corrente',
        'user_email' => 'Email dell\'utente corrente',
        'user_id' => 'ID dell\'utente corrente',
        'server_name' => 'Nome del server',
        'server_uuid' => 'UUID del server',
        'server_id' => 'ID del server',
        'server_egg' => 'Nome del tipo di gioco (Egg) del server',
        'server_node' => 'Nome del nodo',
        'server_memory' => 'Memoria allocata (MB)',
        'server_disk' => 'Disco allocato (MB)',
        'server_cpu' => 'Limite CPU (%)',
        'date' => 'Data corrente (Y-m-d)',
        'time' => 'Ora corrente (H:i)',
        'datetime' => 'Data e ora correnti',
        'year' => 'Anno corrente',
    ],

    'server' => [
        'node' => 'Nodo',
        'owner' => 'Proprietario',
    ],

    'table' => [
        'servers' => 'Server',
        'updated_at' => 'Aggiornato',
        'type' => 'Tipo',
        'unknown' => 'Sconosciuto',
        'empty_heading' => 'Nessun documento ancora',
        'empty_description' => 'Crea il tuo primo documento per iniziare.',
    ],

    'permission_guide' => [
        'title' => 'Guida alla Visibilità',
        'modal_heading' => 'Guida alla Visibilità del Documento',
        'description' => 'Comprendere la visibilità dei documenti',
        'intro' => 'I documenti hanno due dimensioni di visibilità: dove appaiono (server) e chi può vederli (persone).',
        'server_description' => 'Controlla quali server mostrano questo documento:',
        'all_servers_desc' => 'Il documento appare su ogni server',
        'eggs_desc' => 'Il documento appare su tutti i server che usano i tipi di gioco selezionati',
        'servers_desc' => 'Il documento appare solo sui server specificamente selezionati',
        'person_description' => 'Controlla chi può visualizzare questo documento:',
        'roles_desc' => 'Solo gli utenti con i ruoli selezionati possono visualizzare',
        'users_desc' => 'Solo gli utenti specificamente elencati possono visualizzare',
        'everyone_desc' => 'Se non sono selezionati ruoli o utenti, tutti coloro che hanno accesso al server possono visualizzare',
        'admin_note' => 'Gli Amministratori Root possono sempre visualizzare tutti i documenti indipendentemente dalle impostazioni di visibilità.',
    ],

    'messages' => [
        'version_restored' => 'Versione :version ripristinata con successo.',
        'no_documents' => 'Nessun documento disponibile.',
        'no_versions' => 'Nessuna versione ancora.',
    ],

    'versions' => [
        'title' => 'Cronologia Versioni',
        'current_document' => 'Documento Corrente',
        'current_version' => 'Versione Corrente',
        'last_updated' => 'Ultimo Aggiornamento',
        'last_edited_by' => 'Ultima Modifica Di',
        'version_number' => 'Versione',
        'edited_by' => 'Modificato Da',
        'date' => 'Data',
        'change_summary' => 'Riepilogo Modifiche',
        'preview' => 'Anteprima',
        'restore' => 'Ripristina',
        'restore_confirm' => 'Sei sicuro di voler ripristinare questa versione? Questo creerà una nuova versione con il contenuto ripristinato.',
        'restored' => 'Versione ripristinata con successo.',
    ],

    'server_panel' => [
        'title' => 'Documenti del Server',
        'no_documents' => 'Nessun documento disponibile',
        'no_documents_description' => 'Non ci sono ancora documenti per questo server.',
        'select_document' => 'Seleziona un documento',
        'select_document_description' => 'Scegli un documento dalla lista per vederne il contenuto.',
        'last_updated' => 'Ultimo aggiornamento :time',
        'global' => 'Globale',
    ],

    'actions' => [
        'new_document' => 'Nuovo Documento',
        'export' => 'Esporta come Markdown',
        'export_json' => 'Esporta Backup',
        'export_json_button' => 'Esporta come JSON',
        'import' => 'Importa Markdown',
        'import_json' => 'Importa Backup',
        'back_to_document' => 'Torna al Documento',
        'close' => 'Chiudi',
    ],

    'import' => [
        'file_label' => 'File Markdown',
        'file_helper' => 'Carica un file .md per creare un nuovo documento',
        'json_file_label' => 'File di Backup JSON',
        'json_file_helper' => 'Carica un file di backup JSON esportato da questo plugin',
        'use_frontmatter' => 'Usa YAML Frontmatter',
        'use_frontmatter_helper' => 'Estrai titolo e impostazioni dal frontmatter YAML se presente',
        'overwrite_existing' => 'Sovrascrivi Documenti Esistenti',
        'overwrite_existing_helper' => 'Se abilitato, i documenti con UUID corrispondenti verranno aggiornati. Altrimenti, verranno saltati.',
        'success' => 'Documento Importato',
        'success_body' => 'Creato con successo il documento ":title"',
        'json_success' => ':imported importati, :updated aggiornati, :skipped saltati.',
        'error' => 'Importazione Fallita',
        'file_too_large' => 'Il file caricato supera la dimensione massima consentita.',
        'file_read_error' => 'Impossibile leggere il file caricato.',
        'invalid_json' => 'File JSON non valido o array dei documenti mancante.',
        'unresolved_roles' => 'Alcuni ruoli dal frontmatter non sono stati trovati: :roles',
        'unresolved_users' => 'Alcuni utenti dal frontmatter non sono stati trovati: :users',
        'unresolved_eggs' => 'Alcune eggs dal frontmatter non sono state trovate: :eggs',
        'unresolved_servers' => 'Alcuni server dal frontmatter non sono stati trovati: :servers',
    ],

    'export' => [
        'success' => 'Documento Esportato',
        'success_body' => 'Il documento è stato scaricato come Markdown',
        'modal_heading' => 'Esporta Tutti i Documenti',
        'modal_description' => 'Questo esporterà tutti i documenti con la loro configurazione completa (server, eggs, ruoli, utenti e cronologia versioni) come file JSON che può essere reimportato in seguito.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Server Collegati',
        'no_servers_linked' => 'Nessun server collegato',
        'attach_servers_description' => 'Collega i server per rendere questo documento visibile su quei server.',
        'no_documents_linked' => 'Nessun documento collegato',
        'attach_documents_description' => 'Collega documenti per renderli visibili su questo server.',
        'sort_order_helper' => 'Ordine in cui appare questo documento per questo server',
    ],
];
