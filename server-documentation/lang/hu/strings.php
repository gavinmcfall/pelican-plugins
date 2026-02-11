<?php

// Hungarian translation for Knowledge Base / Documents Plugin
// Az angol szövegek másolata - magyarra fordítva

return [
    'navigation' => [
        'documents' => 'Dokumentumok',
        'group' => 'Tartalom',
    ],

    'document' => [
        'singular' => 'Dokumentum',
        'plural' => 'Dokumentumok',
        'title' => 'Cím',
        'slug' => 'Slug (URL útvonal)',
        'content' => 'Tartalom',
        'is_global' => 'Globális',
        'is_published' => 'Közzétéve',
        'sort_order' => 'Rendezési sorrend',
        'author' => 'Szerző',
        'last_edited_by' => 'Utoljára szerkesztette',
        'version' => 'Verzió',
    ],

    'visibility' => [
        'title' => 'Láthatóság',
        'description' => 'Szabályozza, hol jelenjen meg a dokumentum, és ki láthatja azt',
        'server' => 'Szerver láthatóság',
        'person' => 'Személyi láthatóság',
        'everyone' => 'Mindenki',
    ],

    'labels' => [
        'all_servers' => 'Minden szerver',
        'all_servers_helper' => 'Megjelenítés minden szerveren (egyébként használja a lenti játéktípusokat vagy konkrét szervereket)',
        'published_helper' => 'A nem közzétett dokumentumokat csak az adminisztrátorok látják',
        'sort_order_helper' => 'Az alacsonyabb számok jelennek meg előbb',
        'eggs' => 'Játéktípusok (Eggs)',
        'roles' => 'Szerepkörök',
        'users' => 'Konkrét felhasználók',
    ],

    'hints' => [
        'roles_empty' => 'Hagyja üresen, hogy minden szerver-hozzáféréssel rendelkező láthassa',
        'users_optional' => 'Opcionális: hozzáférés biztosítása konkrét felhasználóknak',
        'eggs_hint' => 'A dokumentum minden olyan szerveren megjelenik, amely a kiválasztott játéktípusokat használja',
    ],

    'form' => [
        'details_section' => 'Dokumentum részletei',
        'server_assignment' => 'Szerver hozzárendelés',
        'server_assignment_description' => 'Válassza ki, mely szerverek jelenítsék meg ezt a dokumentumot',
        'filter_by_egg' => 'Szűrés játéktípus szerint',
        'all_eggs' => 'Minden játéktípus',
        'assign_to_servers' => 'Konkrét szerverek',
        'assign_servers_helper' => 'Válassza ki azokat az egyedi szervereket, amelyeknek meg kell jeleníteniük ezt a dokumentumot',
        'content_type' => 'Szerkesztő típusa',
        'rich_text' => 'Formázott szöveg (Rich Text)',
        'rich_text_help' => 'Használja az eszköztárat a formázáshoz, vagy másoljon weboldalról a formázás megtartásával',
        'markdown' => 'Markdown',
        'markdown_help' => 'Illesszen be nyers Markdown szintaxist - megjelenítéskor HTML-re konvertálódik',
        'raw_html' => 'Nyers HTML',
        'raw_html_help' => 'Írjon közvetlenül HTML kódot - haladó felhasználóknak, akik teljes kontrollt akarnak a formázás felett',
        'variables_hint' => '<strong>Változók:</strong> Használja a <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> stb. változókat a tartalomban. Megjelenítéskor ezek lecserélésre kerülnek. Használja a <code>\{{var}}</code> formátumot a változó szó szerinti megjelenítéséhez.',
        'rich_editor_tip' => 'Ha a szerkesztő nem reagál, váltson át Nyers HTML módba, majd vissza az alaphelyzetbe állításhoz.',
        'content_preview' => 'Tartalom előnézete',
        'content_preview_description' => 'Lássa, hogyan jelenik meg a dokumentum a felhasználóknak (feldolgozott változókkal)',
        'content_preview_empty' => 'Írjon be tartalmat fentebb az előnézet megtekintéséhez',
    ],

    'variables' => [
        'title' => 'Elérhető változók',
        'show_available' => 'Elérhető változók megjelenítése',
        'escape_hint' => 'Változó szó szerinti megjelenítéséhez (behelyettesítés nélkül) tegyen elé egy fordított perjelet: \\{{user.name}}',
        'user_name' => 'Aktuális felhasználó megjelenített neve',
        'user_username' => 'Aktuális felhasználó felhasználóneve',
        'user_email' => 'Aktuális felhasználó e-mail címe',
        'user_id' => 'Aktuális felhasználó azonosítója',
        'server_name' => 'Szerver neve',
        'server_uuid' => 'Szerver UUID',
        'server_id' => 'Szerver azonosítója',
        'server_egg' => 'Szerver játéktípusának neve (Egg)',
        'server_node' => 'Csomópont neve (Node)',
        'server_memory' => 'Kiosztott memória (MB)',
        'server_disk' => 'Kiosztott tárhely (MB)',
        'server_cpu' => 'CPU limit (%)',
        'date' => 'Aktuális dátum (ÉÉÉÉ-HH-NN)',
        'time' => 'Aktuális idő (ÓÓ:PP)',
        'datetime' => 'Aktuális dátum és idő',
        'year' => 'Aktuális év',
    ],

    'server' => [
        'node' => 'Csomópont (Node)',
        'owner' => 'Tulajdonos',
    ],

    'table' => [
        'servers' => 'Szerverek',
        'updated_at' => 'Frissítve',
        'type' => 'Típus',
        'unknown' => 'Ismeretlen',
        'empty_heading' => 'Még nincsenek dokumentumok',
        'empty_description' => 'Hozza létre első dokumentumát a kezdéshez.',
    ],

    'permission_guide' => [
        'title' => 'Láthatósági útmutató',
        'modal_heading' => 'Dokumentum láthatósági útmutató',
        'description' => 'A dokumentum láthatóságának megértése',
        'intro' => 'A dokumentumoknak két láthatósági dimenziója van: hol jelennek meg (szerverek) és ki láthatja őket (személyek).',
        'server_description' => 'Szabályozza, mely szerverek jelenítik meg a dokumentumot:',
        'all_servers_desc' => 'A dokumentum minden szerveren megjelenik',
        'eggs_desc' => 'A dokumentum minden olyan szerveren megjelenik, amely a kiválasztott játéktípusokat használja',
        'servers_desc' => 'A dokumentum csak a kifejezetten kiválasztott szervereken jelenik meg',
        'person_description' => 'Szabályozza, ki tekintheti meg a dokumentumot:',
        'roles_desc' => 'Csak a kiválasztott szerepkörökkel rendelkező felhasználók láthatják',
        'users_desc' => 'Csak a kifejezetten felsorolt felhasználók láthatják',
        'everyone_desc' => 'Ha nincsenek kiválasztva szerepkörök vagy felhasználók, minden szerver-hozzáféréssel rendelkező láthatja',
        'admin_note' => 'A Főadminisztrátorok (Root Admins) mindig láthatják az összes dokumentumot, a láthatósági beállításoktól függetlenül.',
    ],

    'messages' => [
        'version_restored' => 'A(z) :version verzió sikeresen helyreállítva.',
        'no_documents' => 'Nincsenek elérhető dokumentumok.',
        'no_versions' => 'Még nincsenek verziók.',
    ],

    'versions' => [
        'title' => 'Verzióelőzmények',
        'current_document' => 'Jelenlegi dokumentum',
        'current_version' => 'Jelenlegi verzió',
        'last_updated' => 'Utoljára frissítve',
        'last_edited_by' => 'Utoljára szerkesztette',
        'version_number' => 'Verzió',
        'edited_by' => 'Szerkesztette',
        'date' => 'Dátum',
        'change_summary' => 'Változások összefoglalása',
        'preview' => 'Előnézet',
        'restore' => 'Helyreállítás',
        'restore_confirm' => 'Biztosan helyreállítja ezt a verziót? Ez létrehoz egy új verziót a helyreállított tartalommal.',
        'restored' => 'A verzió sikeresen helyreállítva.',
    ],

    'server_panel' => [
        'title' => 'Szerver dokumentumok',
        'no_documents' => 'Nincsenek elérhető dokumentumok',
        'no_documents_description' => 'Ehhez a szerverhez még nincsenek dokumentumok.',
        'select_document' => 'Válasszon egy dokumentumot',
        'select_document_description' => 'Válasszon egy dokumentumot a listából a tartalmának megtekintéséhez.',
        'last_updated' => 'Utoljára frissítve: :time',
        'global' => 'Globális',
    ],

    'actions' => [
        'new_document' => 'Új dokumentum',
        'export' => 'Exportálás Markdown-ként',
        'export_json' => 'Biztonsági mentés exportálása',
        'export_json_button' => 'Exportálás JSON-ként',
        'import' => 'Markdown importálása',
        'import_json' => 'Biztonsági mentés importálása',
        'back_to_document' => 'Vissza a dokumentumhoz',
        'close' => 'Bezárás',
    ],

    'import' => [
        'file_label' => 'Markdown fájl',
        'file_helper' => 'Töltsön fel egy .md fájlt új dokumentum létrehozásához',
        'json_file_label' => 'JSON biztonsági mentés fájl',
        'json_file_helper' => 'Töltsön fel egy ebből a bővítményből exportált JSON biztonsági mentés fájlt',
        'use_frontmatter' => 'YAML Frontmatter használata',
        'use_frontmatter_helper' => 'Cím és beállítások kinyerése a YAML frontmatterből, ha van',
        'overwrite_existing' => 'Létező dokumentumok felülírása',
        'overwrite_existing_helper' => 'Ha engedélyezve van, az egyező UUID-vel rendelkező dokumentumok frissülnek. Ellenkező esetben kihagyásra kerülnek.',
        'success' => 'Dokumentum importálva',
        'success_body' => 'A(z) ":title" dokumentum sikeresen létrehozva',
        'json_success' => ':imported importálva, :updated frissítve, :skipped kihagyva.',
        'error' => 'Az importálás sikertelen',
        'file_too_large' => 'A feltöltött fájl mérete meghaladja a megengedett maximumot.',
        'file_read_error' => 'Nem sikerült olvasni a feltöltött fájlt.',
        'invalid_json' => 'Érvénytelen JSON fájl vagy hiányzó dokumentum tömb.',
        'unresolved_roles' => 'Néhány szerepkört nem sikerült megtalálni a frontmatterből: :roles',
        'unresolved_users' => 'Néhány felhasználót nem sikerült megtalálni a frontmatterből: :users',
        'unresolved_eggs' => 'Néhány játéktípust (egg) nem sikerült megtalálni a frontmatterből: :eggs',
        'unresolved_servers' => 'Néhány szervert nem sikerült megtalálni a frontmatterből: :servers',
    ],

    'export' => [
        'success' => 'Dokumentum exportálva',
        'success_body' => 'A dokumentum letöltésre került Markdown formátumban',
        'modal_heading' => 'Összes dokumentum exportálása',
        'modal_description' => 'Ez exportálja az összes dokumentumot a teljes konfigurációjukkal (szerverek, játéktípusok, szerepkörök, felhasználók és verzióelőzmények) egy JSON fájlba, amely később újra importálható.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Kapcsolt szerverek',
        'no_servers_linked' => 'Nincsenek kapcsolt szerverek',
        'attach_servers_description' => 'Csatoljon szervereket, hogy a dokumentum látható legyen rajtuk.',
        'no_documents_linked' => 'Nincsenek kapcsolt dokumentumok',
        'attach_documents_description' => 'Csatoljon dokumentumokat, hogy azok láthatóak legyenek ezen a szerveren.',
        'sort_order_helper' => 'A dokumentum megjelenítési sorrendje ezen a szerveren',
    ],
];
