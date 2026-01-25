<?php

// Indonesian translation for Knowledge Base / Documents Plugin
// Salinan string Bahasa Inggris - diterjemahkan ke Bahasa Indonesia

return [
    'navigation' => [
        'documents' => 'Dokumen',
        'group' => 'Konten',
    ],

    'document' => [
        'singular' => 'Dokumen',
        'plural' => 'Dokumen',
        'title' => 'Judul',
        'slug' => 'Slug (URL)',
        'content' => 'Konten',
        'is_global' => 'Global',
        'is_published' => 'Diterbitkan',
        'sort_order' => 'Urutan Sortir',
        'author' => 'Penulis',
        'last_edited_by' => 'Terakhir Diedit Oleh',
        'version' => 'Versi',
    ],

    'visibility' => [
        'title' => 'Visibilitas',
        'description' => 'Kontrol di mana dokumen ini muncul dan siapa yang dapat melihatnya',
        'server' => 'Visibilitas Server',
        'person' => 'Visibilitas Orang',
        'everyone' => 'Semua Orang',
    ],

    'labels' => [
        'all_servers' => 'Semua Server',
        'all_servers_helper' => 'Tampilkan di semua server (jika tidak, gunakan egg atau server tertentu di bawah)',
        'published_helper' => 'Dokumen yang tidak diterbitkan hanya terlihat oleh admin',
        'sort_order_helper' => 'Angka yang lebih rendah muncul lebih dulu',
        'eggs' => 'Tipe Game (Egg)',
        'roles' => 'Role',
        'users' => 'Pengguna Spesifik',
    ],

    'hints' => [
        'roles_empty' => 'Biarkan kosong untuk mengizinkan semua orang dengan akses server',
        'users_optional' => 'Opsional: berikan akses ke pengguna tertentu',
        'eggs_hint' => 'Dokumen akan muncul di semua server yang menggunakan tipe game yang dipilih',
    ],

    'form' => [
        'details_section' => 'Detail Dokumen',
        'server_assignment' => 'Penugasan Server',
        'server_assignment_description' => 'Pilih server mana yang harus menampilkan dokumen ini',
        'filter_by_egg' => 'Filter berdasarkan Tipe Game',
        'all_eggs' => 'Semua Tipe Game',
        'assign_to_servers' => 'Server Spesifik',
        'assign_servers_helper' => 'Pilih server individu yang harus menampilkan dokumen ini',
        'content_type' => 'Tipe Editor',
        'rich_text' => 'Rich Text',
        'rich_text_help' => 'Gunakan bilah alat untuk memformat, atau salin dari halaman web untuk menempelkan dengan format',
        'markdown' => 'Markdown',
        'markdown_help' => 'Tempel sintaks Markdown mentah - akan dikonversi menjadi HTML saat ditampilkan',
        'raw_html' => 'HTML Mentah',
        'raw_html_help' => 'Tulis HTML mentah secara langsung - untuk pengguna tingkat lanjut yang menginginkan kontrol penuh atas pemformatan',
        'variables_hint' => '<strong>Variabel:</strong> Gunakan <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> dll. dalam konten Anda. Mereka akan diganti saat ditampilkan. Gunakan <code>\{{var}}</code> untuk menampilkan variabel secara literal.',
        'rich_editor_tip' => 'Jika editor menjadi tidak responsif, beralihlah ke mode HTML Mentah dan kembali lagi untuk meresetnya.',
        'content_preview' => 'Pratinjau konten',
        'content_preview_description' => 'Lihat bagaimana dokumen akan muncul bagi pengguna (dengan variabel yang diproses)',
        'content_preview_empty' => 'Masukkan konten di atas untuk melihat pratinjau',
    ],

    'variables' => [
        'title' => 'Variabel yang Tersedia',
        'show_available' => 'Tampilkan variabel yang tersedia',
        'escape_hint' => 'Untuk menampilkan variabel secara literal tanpa menggantinya, awali dengan garis miring terbalik (backslash): \\{{user.name}}',
        'user_name' => 'Nama tampilan pengguna saat ini',
        'user_username' => 'Username pengguna saat ini',
        'user_email' => 'Email pengguna saat ini',
        'user_id' => 'ID pengguna saat ini',
        'server_name' => 'Nama server',
        'server_uuid' => 'UUID server',
        'server_id' => 'ID server',
        'server_egg' => 'Nama tipe game (Egg) server',
        'server_node' => 'Nama node',
        'server_memory' => 'Memori yang dialokasikan (MB)',
        'server_disk' => 'Disk yang dialokasikan (MB)',
        'server_cpu' => 'Batas CPU (%)',
        'date' => 'Tanggal saat ini (Y-m-d)',
        'time' => 'Waktu saat ini (H:i)',
        'datetime' => 'Tanggal dan waktu saat ini',
        'year' => 'Tahun saat ini',
    ],

    'server' => [
        'node' => 'Node',
        'owner' => 'Pemilik',
    ],

    'table' => [
        'servers' => 'Server',
        'updated_at' => 'Diperbarui',
        'type' => 'Tipe',
        'unknown' => 'Tidak Diketahui',
        'empty_heading' => 'Belum ada dokumen',
        'empty_description' => 'Buat dokumen pertama Anda untuk memulai.',
    ],

    'permission_guide' => [
        'title' => 'Panduan Visibilitas',
        'modal_heading' => 'Panduan Visibilitas Dokumen',
        'description' => 'Memahami visibilitas dokumen',
        'intro' => 'Dokumen memiliki dua dimensi visibilitas: di mana mereka muncul (server) dan siapa yang dapat melihatnya (orang).',
        'server_description' => 'Mengontrol server mana yang menampilkan dokumen ini:',
        'all_servers_desc' => 'Dokumen muncul di setiap server',
        'eggs_desc' => 'Dokumen muncul di semua server yang menggunakan tipe game yang dipilih',
        'servers_desc' => 'Dokumen hanya muncul di server yang dipilih secara khusus',
        'person_description' => 'Mengontrol siapa yang dapat melihat dokumen ini:',
        'roles_desc' => 'Hanya pengguna dengan role yang dipilih yang dapat melihat',
        'users_desc' => 'Hanya pengguna yang terdaftar secara khusus yang dapat melihat',
        'everyone_desc' => 'Jika tidak ada role atau pengguna yang dipilih, semua orang dengan akses server dapat melihat',
        'admin_note' => 'Admin Root selalu dapat melihat semua dokumen terlepas dari pengaturan visibilitas.',
    ],

    'messages' => [
        'version_restored' => 'Versi :version berhasil dipulihkan.',
        'no_documents' => 'Tidak ada dokumen yang tersedia.',
        'no_versions' => 'Belum ada versi.',
    ],

    'versions' => [
        'title' => 'Riwayat Versi',
        'current_document' => 'Dokumen Saat Ini',
        'current_version' => 'Versi Saat Ini',
        'last_updated' => 'Terakhir Diperbarui',
        'last_edited_by' => 'Terakhir Diedit Oleh',
        'version_number' => 'Versi',
        'edited_by' => 'Diedit Oleh',
        'date' => 'Tanggal',
        'change_summary' => 'Ringkasan Perubahan',
        'preview' => 'Pratinjau',
        'restore' => 'Pulihkan',
        'restore_confirm' => 'Apakah Anda yakin ingin memulihkan versi ini? Ini akan membuat versi baru dengan konten yang dipulihkan.',
        'restored' => 'Versi berhasil dipulihkan.',
    ],

    'server_panel' => [
        'title' => 'Dokumen Server',
        'no_documents' => 'Tidak ada dokumen yang tersedia',
        'no_documents_description' => 'Belum ada dokumen untuk server ini.',
        'select_document' => 'Pilih dokumen',
        'select_document_description' => 'Pilih dokumen dari daftar untuk melihat isinya.',
        'last_updated' => 'Terakhir diperbarui :time',
        'global' => 'Global',
    ],

    'actions' => [
        'new_document' => 'Dokumen Baru',
        'export' => 'Ekspor sebagai Markdown',
        'export_json' => 'Ekspor Cadangan',
        'export_json_button' => 'Ekspor sebagai JSON',
        'import' => 'Impor Markdown',
        'import_json' => 'Impor Cadangan',
        'back_to_document' => 'Kembali ke Dokumen',
        'close' => 'Tutup',
    ],

    'import' => [
        'file_label' => 'File Markdown',
        'file_helper' => 'Unggah file .md untuk membuat dokumen baru',
        'json_file_label' => 'File Cadangan JSON',
        'json_file_helper' => 'Unggah file cadangan JSON yang diekspor dari plugin ini',
        'use_frontmatter' => 'Gunakan YAML Frontmatter',
        'use_frontmatter_helper' => 'Ekstrak judul dan pengaturan dari YAML frontmatter jika ada',
        'overwrite_existing' => 'Timpa Dokumen yang Ada',
        'overwrite_existing_helper' => 'Jika diaktifkan, dokumen dengan UUID yang cocok akan diperbarui. Jika tidak, mereka akan dilewati.',
        'success' => 'Dokumen Diimpor',
        'success_body' => 'Berhasil membuat dokumen ":title"',
        'json_success' => ':imported diimpor, :updated diperbarui, :skipped dilewati.',
        'error' => 'Impor Gagal',
        'file_too_large' => 'File yang diunggah melebihi ukuran maksimum yang diizinkan.',
        'file_read_error' => 'Tidak dapat membaca file yang diunggah.',
        'invalid_json' => 'File JSON tidak valid atau array dokumen hilang.',
        'unresolved_roles' => 'Beberapa role dari frontmatter tidak dapat ditemukan: :roles',
        'unresolved_users' => 'Beberapa pengguna dari frontmatter tidak dapat ditemukan: :users',
        'unresolved_eggs' => 'Beberapa egg dari frontmatter tidak dapat ditemukan: :eggs',
        'unresolved_servers' => 'Beberapa server dari frontmatter tidak dapat ditemukan: :servers',
    ],

    'export' => [
        'success' => 'Dokumen Diekspor',
        'success_body' => 'Dokumen telah diunduh sebagai Markdown',
        'modal_heading' => 'Ekspor Semua Dokumen',
        'modal_description' => 'Ini akan mengekspor semua dokumen dengan konfigurasi lengkapnya (server, egg, role, pengguna, dan riwayat versi) sebagai file JSON yang dapat diimpor kembali nanti.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Server Terkait',
        'no_servers_linked' => 'Tidak ada server yang terkait',
        'attach_servers_description' => 'Lampirkan server untuk membuat dokumen ini terlihat di server tersebut.',
        'no_documents_linked' => 'Tidak ada dokumen yang terkait',
        'attach_documents_description' => 'Lampirkan dokumen untuk membuatnya terlihat di server ini.',
        'sort_order_helper' => 'Urutan tampilan dokumen ini untuk server ini',
    ],
];