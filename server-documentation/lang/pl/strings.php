<?php

// Polish translation for Knowledge Base / Documents Plugin
// Kopia angielskich ciągów znaków - przetłumaczona na język polski

return [
    'navigation' => [
        'documents' => 'Dokumenty',
        'group' => 'Treść',
    ],

    'document' => [
        'singular' => 'Dokument',
        'plural' => 'Dokumenty',
        'title' => 'Tytuł',
        'slug' => 'Slug (Przyjazny link)',
        'content' => 'Treść',
        'is_global' => 'Globalny',
        'is_published' => 'Opublikowany',
        'sort_order' => 'Kolejność sortowania',
        'author' => 'Autor',
        'last_edited_by' => 'Ostatnio edytowany przez',
        'version' => 'Wersja',
    ],

    'visibility' => [
        'title' => 'Widoczność',
        'description' => 'Kontroluj, gdzie ten dokument się pojawia i kto może go zobaczyć',
        'server' => 'Widoczność serwera',
        'person' => 'Widoczność dla osób',
        'everyone' => 'Wszyscy',
    ],

    'labels' => [
        'all_servers' => 'Wszystkie serwery',
        'all_servers_helper' => 'Pokaż na wszystkich serwerach (w przeciwnym razie użyj jaj (eggs) lub konkretnych serwerów poniżej)',
        'published_helper' => 'Nieopublikowane dokumenty są widoczne tylko dla administratorów',
        'sort_order_helper' => 'Niższe liczby pojawiają się jako pierwsze',
        'eggs' => 'Typy gier (Jaja)',
        'roles' => 'Role',
        'users' => 'Konkretni użytkownicy',
    ],

    'hints' => [
        'roles_empty' => 'Pozostaw puste, aby zezwolić wszystkim z dostępem do serwera',
        'users_optional' => 'Opcjonalnie: przyznaj dostęp konkretnym użytkownikom',
        'eggs_hint' => 'Dokument pojawi się na wszystkich serwerach używających wybranych typów gier',
    ],

    'form' => [
        'details_section' => 'Szczegóły dokumentu',
        'server_assignment' => 'Przypisanie do serwera',
        'server_assignment_description' => 'Wybierz, które serwery powinny wyświetlać ten dokument',
        'filter_by_egg' => 'Filtruj według typu gry',
        'all_eggs' => 'Wszystkie typy gier',
        'assign_to_servers' => 'Konkretne serwery',
        'assign_servers_helper' => 'Wybierz poszczególne serwery, które powinny wyświetlać ten dokument',
        'content_type' => 'Typ edytora',
        'rich_text' => 'Tekst sformatowany (Rich Text)',
        'rich_text_help' => 'Użyj paska narzędzi do formatowania lub skopiuj ze strony internetowej, aby wkleić z formatowaniem',
        'markdown' => 'Markdown',
        'markdown_help' => 'Wklej surową składnię Markdown - zostanie ona przekonwertowana na HTML podczas wyświetlania',
        'raw_html' => 'Czysty HTML',
        'raw_html_help' => 'Pisz bezpośrednio w czystym HTML - dla zaawansowanych użytkowników, którzy chcą pełnej kontroli nad formatowaniem',
        'variables_hint' => '<strong>Zmienne:</strong> Użyj <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> itp. w swojej treści. Zostaną one zastąpione podczas wyświetlania. Użyj <code>\{{var}}</code>, aby pokazać zmienną dosłownie.',
        'rich_editor_tip' => 'Jeśli edytor przestanie odpowiadać, przełącz się na tryb Czysty HTML i z powrotem, aby go zresetować.',
        'content_preview' => 'Podgląd treści',
        'content_preview_description' => 'Zobacz, jak dokument będzie wyglądał dla użytkowników (z przetworzonymi zmiennymi)',
        'content_preview_empty' => 'Wprowadź treść powyżej, aby zobaczyć podgląd',
    ],

    'variables' => [
        'title' => 'Dostępne zmienne',
        'show_available' => 'Pokaż dostępne zmienne',
        'escape_hint' => 'Aby pokazać zmienną dosłownie bez jej zastępowania, poprzedź ją ukośnikiem odwrotnym: \\{{user.name}}',
        'user_name' => 'Nazwa wyświetlana obecnego użytkownika',
        'user_username' => 'Nazwa użytkownika obecnego użytkownika',
        'user_email' => 'Email obecnego użytkownika',
        'user_id' => 'ID obecnego użytkownika',
        'server_name' => 'Nazwa serwera',
        'server_uuid' => 'UUID serwera',
        'server_id' => 'ID serwera',
        'server_egg' => 'Nazwa typu gry serwera (Jajo)',
        'server_node' => 'Nazwa węzła (Node)',
        'server_memory' => 'Przydzielona pamięć (MB)',
        'server_disk' => 'Przydzielony dysk (MB)',
        'server_cpu' => 'Limit CPU (%)',
        'date' => 'Bieżąca data (Y-m-d)',
        'time' => 'Bieżący czas (H:i)',
        'datetime' => 'Bieżąca data i czas',
        'year' => 'Bieżący rok',
    ],

    'server' => [
        'node' => 'Węzeł (Node)',
        'owner' => 'Właściciel',
    ],

    'table' => [
        'servers' => 'Serwery',
        'updated_at' => 'Zaktualizowano',
        'type' => 'Typ',
        'unknown' => 'Nieznany',
        'empty_heading' => 'Brak dokumentów',
        'empty_description' => 'Utwórz swój pierwszy dokument, aby rozpocząć.',
    ],

    'permission_guide' => [
        'title' => 'Przewodnik widoczności',
        'modal_heading' => 'Przewodnik widoczności dokumentów',
        'description' => 'Zrozumienie widoczności dokumentów',
        'intro' => 'Dokumenty mają dwa wymiary widoczności: gdzie się pojawiają (serwery) i kto może je zobaczyć (ludzie).',
        'server_description' => 'Kontroluje, które serwery wyświetlają ten dokument:',
        'all_servers_desc' => 'Dokument pojawia się na każdym serwerze',
        'eggs_desc' => 'Dokument pojawia się na wszystkich serwerach używających wybranych typów gier',
        'servers_desc' => 'Dokument pojawia się tylko na konkretnie wybranych serwerach',
        'person_description' => 'Kontroluje, kto może przeglądać ten dokument:',
        'roles_desc' => 'Tylko użytkownicy z wybranymi rolami mogą przeglądać',
        'users_desc' => 'Tylko konkretnie wymienieni użytkownicy mogą przeglądać',
        'everyone_desc' => 'Jeśli nie wybrano ról ani użytkowników, każdy z dostępem do serwera może przeglądać',
        'admin_note' => 'Główni Administratorzy (Root Admins) zawsze mogą przeglądać wszystkie dokumenty niezależnie od ustawień widoczności.',
    ],

    'messages' => [
        'version_restored' => 'Wersja :version została pomyślnie przywrócona.',
        'no_documents' => 'Brak dostępnych dokumentów.',
        'no_versions' => 'Brak wersji.',
    ],

    'versions' => [
        'title' => 'Historia wersji',
        'current_document' => 'Obecny dokument',
        'current_version' => 'Obecna wersja',
        'last_updated' => 'Ostatnia aktualizacja',
        'last_edited_by' => 'Ostatnio edytowany przez',
        'version_number' => 'Wersja',
        'edited_by' => 'Edytowany przez',
        'date' => 'Data',
        'change_summary' => 'Podsumowanie zmian',
        'preview' => 'Podgląd',
        'restore' => 'Przywróć',
        'restore_confirm' => 'Czy na pewno chcesz przywrócić tę wersję? Spowoduje to utworzenie nowej wersji z przywróconą treścią.',
        'restored' => 'Wersja przywrócona pomyślnie.',
    ],

    'server_panel' => [
        'title' => 'Dokumenty serwera',
        'no_documents' => 'Brak dostępnych dokumentów',
        'no_documents_description' => 'Nie ma jeszcze dokumentów dla tego serwera.',
        'select_document' => 'Wybierz dokument',
        'select_document_description' => 'Wybierz dokument z listy, aby zobaczyć jego zawartość.',
        'last_updated' => 'Ostatnia aktualizacja :time',
        'global' => 'Globalny',
    ],

    'actions' => [
        'new_document' => 'Nowy dokument',
        'export' => 'Eksportuj jako Markdown',
        'export_json' => 'Eksportuj kopię zapasową',
        'export_json_button' => 'Eksportuj jako JSON',
        'import' => 'Importuj Markdown',
        'import_json' => 'Importuj kopię zapasową',
        'back_to_document' => 'Powrót do dokumentu',
        'close' => 'Zamknij',
    ],

    'import' => [
        'file_label' => 'Plik Markdown',
        'file_helper' => 'Prześlij plik .md, aby utworzyć nowy dokument',
        'json_file_label' => 'Plik kopii zapasowej JSON',
        'json_file_helper' => 'Prześlij plik kopii zapasowej JSON wyeksportowany z tej wtyczki',
        'use_frontmatter' => 'Użyj YAML Frontmatter',
        'use_frontmatter_helper' => 'Wyodrębnij tytuł i ustawienia z YAML frontmatter, jeśli jest obecny',
        'overwrite_existing' => 'Nadpisz istniejące dokumenty',
        'overwrite_existing_helper' => 'Jeśli włączone, dokumenty z pasującymi identyfikatorami UUID zostaną zaktualizowane. W przeciwnym razie zostaną pominięte.',
        'success' => 'Dokument zaimportowany',
        'success_body' => 'Pomyślnie utworzono dokument ":title"',
        'json_success' => ':imported zaimportowano, :updated zaktualizowano, :skipped pominięto.',
        'error' => 'Import nie powiódł się',
        'file_too_large' => 'Przesłany plik przekracza maksymalny dozwolony rozmiar.',
        'file_read_error' => 'Nie można odczytać przesłanego pliku.',
        'invalid_json' => 'Nieprawidłowy plik JSON lub brak tablicy dokumentów.',
        'unresolved_roles' => 'Niektóre role z frontmatter nie mogły zostać znalezione: :roles',
        'unresolved_users' => 'Niektórzy użytkownicy z frontmatter nie mogli zostać znalezieni: :users',
        'unresolved_eggs' => 'Niektóre jaja (eggs) z frontmatter nie mogły zostać znalezione: :eggs',
        'unresolved_servers' => 'Niektóre serwery z frontmatter nie mogły zostać znalezione: :servers',
    ],

    'export' => [
        'success' => 'Dokument wyeksportowany',
        'success_body' => 'Dokument został pobrany jako Markdown',
        'modal_heading' => 'Eksportuj wszystkie dokumenty',
        'modal_description' => 'Spowoduje to wyeksportowanie wszystkich dokumentów wraz z ich pełną konfiguracją (serwery, jaja, role, użytkownicy i historia wersji) jako plik JSON, który można później ponownie zaimportować.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Powiązane serwery',
        'no_servers_linked' => 'Brak powiązanych serwerów',
        'attach_servers_description' => 'Dołącz serwery, aby ten dokument był na nich widoczny.',
        'no_documents_linked' => 'Brak powiązanych dokumentów',
        'attach_documents_description' => 'Dołącz dokumenty, aby były widoczne na tym serwerze.',
        'sort_order_helper' => 'Kolejność, w jakiej ten dokument pojawia się dla tego serwera',
    ],
];