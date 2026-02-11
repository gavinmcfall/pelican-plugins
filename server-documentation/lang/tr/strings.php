<?php

// Turkish translation for Knowledge Base / Documents Plugin
// İngilizce dizelerin kopyası - Türkçe'ye çevrildi

return [
    'navigation' => [
        'documents' => 'Belgeler',
        'group' => 'İçerik',
    ],

    'document' => [
        'singular' => 'Belge',
        'plural' => 'Belgeler',
        'title' => 'Başlık',
        'slug' => 'Kısa Ad (Slug)',
        'content' => 'İçerik',
        'is_global' => 'Küresel',
        'is_published' => 'Yayınlandı',
        'sort_order' => 'Sıralama Düzeni',
        'author' => 'Yazar',
        'last_edited_by' => 'Son Düzenleyen',
        'version' => 'Sürüm',
    ],

    'visibility' => [
        'title' => 'Görünürlük',
        'description' => 'Bu belgenin nerede görüneceğini ve kimlerin görebileceğini kontrol edin',
        'server' => 'Sunucu Görünürlüğü',
        'person' => 'Kişi Görünürlüğü',
        'everyone' => 'Herkes',
    ],

    'labels' => [
        'all_servers' => 'Tüm Sunucular',
        'all_servers_helper' => 'Tüm sunucularda göster (aksi takdirde aşağıda egg veya belirli sunucuları kullanın)',
        'published_helper' => 'Yayınlanmamış belgeler yalnızca yöneticiler tarafından görülebilir',
        'sort_order_helper' => 'Düşük numaralar önce görünür',
        'eggs' => 'Oyun Türleri (Eggs)',
        'roles' => 'Roller',
        'users' => 'Belirli Kullanıcılar',
    ],

    'hints' => [
        'roles_empty' => 'Sunucu erişimi olan herkese izin vermek için boş bırakın',
        'users_optional' => 'İsteğe bağlı: belirli kullanıcılara erişim verin',
        'eggs_hint' => 'Belge, seçilen oyun türlerini kullanan tüm sunucularda görünecektir',
    ],

    'form' => [
        'details_section' => 'Belge Detayları',
        'server_assignment' => 'Sunucu Ataması',
        'server_assignment_description' => 'Bu belgeyi hangi sunucuların göstereceğini seçin',
        'filter_by_egg' => 'Oyun Türüne Göre Filtrele',
        'all_eggs' => 'Tüm Oyun Türleri',
        'assign_to_servers' => 'Belirli Sunucular',
        'assign_servers_helper' => 'Bu belgeyi göstermesi gereken bireysel sunucuları seçin',
        'content_type' => 'Editör Türü',
        'rich_text' => 'Zengin Metin (Rich Text)',
        'rich_text_help' => 'Biçimlendirmek için araç çubuğunu kullanın veya biçimlendirmeyle yapıştırmak için bir web sayfasından kopyalayın',
        'markdown' => 'Markdown',
        'markdown_help' => 'Ham Markdown sözdizimini yapıştırın - görüntülenirken HTML\'ye dönüştürülecektir',
        'raw_html' => 'Ham HTML',
        'raw_html_help' => 'Doğrudan ham HTML yazın - biçimlendirme üzerinde tam kontrol isteyen ileri düzey kullanıcılar için',
        'variables_hint' => '<strong>Değişkenler:</strong> İçeriğinizde <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> vb. kullanın. Görüntülenirken değiştirileceklerdir. Bir değişkeni olduğu gibi göstermek için <code>\{{var}}</code> kullanın.',
        'rich_editor_tip' => 'Editör yanıt vermezse, sıfırlamak için Ham HTML moduna geçip tekrar geri dönün.',
        'content_preview' => 'İçerik önizlemesi',
        'content_preview_description' => 'Belgenin kullanıcılara nasıl görüneceğini görün (işlenmiş değişkenlerle)',
        'content_preview_empty' => 'Önizlemeyi görmek için yukarıya içerik girin',
    ],

    'variables' => [
        'title' => 'Kullanılabilir Değişkenler',
        'show_available' => 'Kullanılabilir değişkenleri göster',
        'escape_hint' => 'Bir değişkeni değiştirmeden kelimesi kelimesine göstermek için önüne ters eğik çizgi koyun: \\{{user.name}}',
        'user_name' => 'Mevcut kullanıcının görünen adı',
        'user_username' => 'Mevcut kullanıcının kullanıcı adı',
        'user_email' => 'Mevcut kullanıcının e-postası',
        'user_id' => 'Mevcut kullanıcının ID\'si',
        'server_name' => 'Sunucu adı',
        'server_uuid' => 'Sunucu UUID',
        'server_id' => 'Sunucu ID',
        'server_egg' => 'Sunucu oyun türü adı (Egg)',
        'server_node' => 'Düğüm (Node) adı',
        'server_memory' => 'Tahsis edilen bellek (MB)',
        'server_disk' => 'Tahsis edilen disk (MB)',
        'server_cpu' => 'CPU limiti (%)',
        'date' => 'Mevcut tarih (Y-m-d)',
        'time' => 'Mevcut saat (H:i)',
        'datetime' => 'Mevcut tarih ve saat',
        'year' => 'Mevcut yıl',
    ],

    'server' => [
        'node' => 'Düğüm (Node)',
        'owner' => 'Sahip',
    ],

    'table' => [
        'servers' => 'Sunucular',
        'updated_at' => 'Güncellendi',
        'type' => 'Tür',
        'unknown' => 'Bilinmiyor',
        'empty_heading' => 'Henüz belge yok',
        'empty_description' => 'Başlamak için ilk belgenizi oluşturun.',
    ],

    'permission_guide' => [
        'title' => 'Görünürlük Rehberi',
        'modal_heading' => 'Belge Görünürlük Rehberi',
        'description' => 'Belge görünürlüğünü anlama',
        'intro' => 'Belgelerin iki görünürlük boyutu vardır: nerede göründükleri (sunucular) ve kimlerin görebileceği (kişiler).',
        'server_description' => 'Bu belgeyi hangi sunucuların görüntüleyeceğini kontrol eder:',
        'all_servers_desc' => 'Belge her sunucuda görünür',
        'eggs_desc' => 'Belge, seçilen oyun türlerini kullanan tüm sunucularda görünür',
        'servers_desc' => 'Belge yalnızca özel olarak seçilen sunucularda görünür',
        'person_description' => 'Bu belgeyi kimlerin görüntüleyebileceğini kontrol eder:',
        'roles_desc' => 'Yalnızca seçilen rollere sahip kullanıcılar görüntüleyebilir',
        'users_desc' => 'Yalnızca özel olarak listelenen kullanıcılar görüntüleyebilir',
        'everyone_desc' => 'Hiçbir rol veya kullanıcı seçilmezse, sunucu erişimi olan herkes görüntüleyebilir',
        'admin_note' => 'Kök Yöneticiler (Root Admins), görünürlük ayarlarından bağımsız olarak tüm belgeleri her zaman görüntüleyebilir.',
    ],

    'messages' => [
        'version_restored' => 'Sürüm :version başarıyla geri yüklendi.',
        'no_documents' => 'Kullanılabilir belge yok.',
        'no_versions' => 'Henüz sürüm yok.',
    ],

    'versions' => [
        'title' => 'Sürüm Geçmişi',
        'current_document' => 'Mevcut Belge',
        'current_version' => 'Mevcut Sürüm',
        'last_updated' => 'Son Güncelleme',
        'last_edited_by' => 'Son Düzenleyen',
        'version_number' => 'Sürüm',
        'edited_by' => 'Düzenleyen',
        'date' => 'Tarih',
        'change_summary' => 'Değişiklik Özeti',
        'preview' => 'Önizleme',
        'restore' => 'Geri Yükle',
        'restore_confirm' => 'Bu sürümü geri yüklemek istediğinizden emin misiniz? Bu, geri yüklenen içerikle yeni bir sürüm oluşturacaktır.',
        'restored' => 'Sürüm başarıyla geri yüklendi.',
    ],

    'server_panel' => [
        'title' => 'Sunucu Belgeleri',
        'no_documents' => 'Kullanılabilir belge yok',
        'no_documents_description' => 'Bu sunucu için henüz belge yok.',
        'select_document' => 'Bir belge seçin',
        'select_document_description' => 'İçeriğini görüntülemek için listeden bir belge seçin.',
        'last_updated' => 'Son güncelleme :time',
        'global' => 'Küresel',
    ],

    'actions' => [
        'new_document' => 'Yeni Belge',
        'export' => 'Markdown Olarak Dışa Aktar',
        'export_json' => 'Yedeği Dışa Aktar',
        'export_json_button' => 'JSON Olarak Dışa Aktar',
        'import' => 'Markdown İçe Aktar',
        'import_json' => 'Yedeği İçe Aktar',
        'back_to_document' => 'Belgeye Dön',
        'close' => 'Kapat',
    ],

    'import' => [
        'file_label' => 'Markdown Dosyası',
        'file_helper' => 'Yeni bir belge oluşturmak için bir .md dosyası yükleyin',
        'json_file_label' => 'JSON Yedek Dosyası',
        'json_file_helper' => 'Bu eklentiden dışa aktarılan bir JSON yedek dosyasını yükleyin',
        'use_frontmatter' => 'YAML Frontmatter Kullan',
        'use_frontmatter_helper' => 'Varsa YAML frontmatter\'dan başlık ve ayarları çıkar',
        'overwrite_existing' => 'Mevcut Belgelerin Üzerine Yaz',
        'overwrite_existing_helper' => 'Etkinleştirilirse, eşleşen UUID\'lere sahip belgeler güncellenir. Aksi takdirde atlanırlar.',
        'success' => 'Belge İçe Aktarıldı',
        'success_body' => '":title" belgesi başarıyla oluşturuldu',
        'json_success' => ':imported içe aktarıldı, :updated güncellendi, :skipped atlandı.',
        'error' => 'İçe Aktarma Başarısız',
        'file_too_large' => 'Yüklenen dosya izin verilen maksimum boyutu aşıyor.',
        'file_read_error' => 'Yüklenen dosya okunamadı.',
        'invalid_json' => 'Geçersiz JSON dosyası veya eksik belge dizisi.',
        'unresolved_roles' => 'Frontmatter\'daki bazı roller bulunamadı: :roles',
        'unresolved_users' => 'Frontmatter\'daki bazı kullanıcılar bulunamadı: :users',
        'unresolved_eggs' => 'Frontmatter\'daki bazı egg\'ler bulunamadı: :eggs',
        'unresolved_servers' => 'Frontmatter\'daki bazı sunucular bulunamadı: :servers',
    ],

    'export' => [
        'success' => 'Belge Dışa Aktarıldı',
        'success_body' => 'Belge Markdown olarak indirildi',
        'modal_heading' => 'Tüm Belgeleri Dışa Aktar',
        'modal_description' => 'Bu işlem, tüm belgeleri tam yapılandırmalarıyla (sunucular, egg\'ler, roller, kullanıcılar ve sürüm geçmişi) daha sonra tekrar içe aktarılabilecek bir JSON dosyası olarak dışa aktaracaktır.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Bağlı Sunucular',
        'no_servers_linked' => 'Bağlı sunucu yok',
        'attach_servers_description' => 'Bu belgeyi ilgili sunucularda görünür kılmak için sunucular ekleyin.',
        'no_documents_linked' => 'Bağlı belge yok',
        'attach_documents_description' => 'Bu sunucuda görünür kılmak için belgeler ekleyin.',
        'sort_order_helper' => 'Bu belgenin bu sunucu için görünme sırası',
    ],
];
