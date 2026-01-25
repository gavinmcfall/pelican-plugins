<?php

// Japanese translation for Knowledge Base / Documents Plugin
// English strings copy - translated to Japanese

return [
    'navigation' => [
        'documents' => 'ドキュメント',
        'group' => 'コンテンツ',
    ],

    'document' => [
        'singular' => 'ドキュメント',
        'plural' => 'ドキュメント',
        'title' => 'タイトル',
        'slug' => 'スラッグ (URL)',
        'content' => '内容',
        'is_global' => 'グローバル',
        'is_published' => '公開済み',
        'sort_order' => '並び順',
        'author' => '作成者',
        'last_edited_by' => '最終編集者',
        'version' => 'バージョン',
    ],

    'visibility' => [
        'title' => '公開範囲',
        'description' => 'このドキュメントが表示される場所と、閲覧できるユーザーを制御します',
        'server' => 'サーバーの公開範囲',
        'person' => 'ユーザーの公開範囲',
        'everyone' => '全員',
    ],

    'labels' => [
        'all_servers' => '全てのサーバー',
        'all_servers_helper' => '全てのサーバーに表示します（特定のサーバーを指定する場合は、下のEggまたは特定のサーバーを使用してください）',
        'published_helper' => '未公開のドキュメントは管理者のみ閲覧可能です',
        'sort_order_helper' => '数字が小さいほど先に表示されます',
        'eggs' => 'ゲームタイプ (Eggs)',
        'roles' => 'ロール (役割)',
        'users' => '特定のユーザー',
    ],

    'hints' => [
        'roles_empty' => '空欄にすると、サーバーへのアクセス権を持つ全員に許可されます',
        'users_optional' => 'オプション: 特定のユーザーにアクセス権を付与します',
        'eggs_hint' => '選択されたゲームタイプを使用している全てのサーバーにドキュメントが表示されます',
    ],

    'form' => [
        'details_section' => 'ドキュメントの詳細',
        'server_assignment' => 'サーバーの割り当て',
        'server_assignment_description' => 'このドキュメントを表示するサーバーを選択してください',
        'filter_by_egg' => 'ゲームタイプでフィルタ',
        'all_eggs' => '全てのゲームタイプ',
        'assign_to_servers' => '特定のサーバー',
        'assign_servers_helper' => 'このドキュメントを表示する個別のサーバーを選択してください',
        'content_type' => 'エディタの種類',
        'rich_text' => 'リッチテキスト',
        'rich_text_help' => 'ツールバーを使用してフォーマットするか、Webページからコピーしてフォーマット付きで貼り付けます',
        'markdown' => 'Markdown',
        'markdown_help' => '生のMarkdown構文を貼り付けます - 表示時にHTMLに変換されます',
        'raw_html' => '生のHTML',
        'raw_html_help' => '生のHTMLを直接記述します - フォーマットを完全に制御したい上級ユーザー向けです',
        'variables_hint' => '<strong>変数:</strong> コンテンツ内で <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> などを使用できます。これらは表示時に置き換えられます。変数を文字通り表示するには <code>\{{var}}</code> を使用してください。',
        'rich_editor_tip' => 'エディタが反応しなくなった場合は、一度「生のHTML」モードに切り替えてから戻すとリセットされます。',
        'content_preview' => 'コンテンツのプレビュー',
        'content_preview_description' => 'ユーザーにどのように表示されるかを確認できます（変数は処理されます）',
        'content_preview_empty' => 'プレビューを表示するには、上にコンテンツを入力してください',
    ],

    'variables' => [
        'title' => '利用可能な変数',
        'show_available' => '利用可能な変数を表示',
        'escape_hint' => '変数を置き換えずに文字通り表示するには、バックスラッシュを前に付けます: \\{{user.name}}',
        'user_name' => '現在のユーザーの表示名',
        'user_username' => '現在のユーザーのユーザー名',
        'user_email' => '現在のユーザーのメールアドレス',
        'user_id' => '現在のユーザーID',
        'server_name' => 'サーバー名',
        'server_uuid' => 'サーバーUUID',
        'server_id' => 'サーバーID',
        'server_egg' => 'サーバーのゲームタイプ名 (Egg)',
        'server_node' => 'ノード名',
        'server_memory' => '割り当てメモリ (MB)',
        'server_disk' => '割り当てディスク (MB)',
        'server_cpu' => 'CPU制限 (%)',
        'date' => '現在の日付 (Y-m-d)',
        'time' => '現在の時刻 (H:i)',
        'datetime' => '現在の日時',
        'year' => '現在の年',
    ],

    'server' => [
        'node' => 'ノード',
        'owner' => '所有者',
    ],

    'table' => [
        'servers' => 'サーバー',
        'updated_at' => '更新日時',
        'type' => 'タイプ',
        'unknown' => '不明',
        'empty_heading' => 'ドキュメントはまだありません',
        'empty_description' => '最初のドキュメントを作成して始めましょう。',
    ],

    'permission_guide' => [
        'title' => '公開範囲ガイド',
        'modal_heading' => 'ドキュメント公開範囲ガイド',
        'description' => 'ドキュメントの公開範囲について',
        'intro' => 'ドキュメントには2つの公開設定があります：どこに表示されるか（サーバー）と、誰が見られるか（人）です。',
        'server_description' => 'このドキュメントを表示するサーバーを制御します:',
        'all_servers_desc' => 'ドキュメントは全てのサーバーに表示されます',
        'eggs_desc' => '選択されたゲームタイプを使用している全てのサーバーに表示されます',
        'servers_desc' => '具体的に選択されたサーバーにのみ表示されます',
        'person_description' => 'このドキュメントを閲覧できる人を制御します:',
        'roles_desc' => '選択されたロールを持つユーザーのみ閲覧できます',
        'users_desc' => '具体的に指定されたユーザーのみ閲覧できます',
        'everyone_desc' => 'ロールやユーザーが選択されていない場合、サーバーへのアクセス権を持つ全員が閲覧できます',
        'admin_note' => 'ルート管理者 (Root Admins) は、公開設定に関わらず常に全てのドキュメントを閲覧できます。',
    ],

    'messages' => [
        'version_restored' => 'バージョン :version が正常に復元されました。',
        'no_documents' => '利用可能なドキュメントはありません。',
        'no_versions' => 'バージョンはまだありません。',
    ],

    'versions' => [
        'title' => 'バージョン履歴',
        'current_document' => '現在のドキュメント',
        'current_version' => '現在のバージョン',
        'last_updated' => '最終更新',
        'last_edited_by' => '最終編集者',
        'version_number' => 'バージョン',
        'edited_by' => '編集者',
        'date' => '日付',
        'change_summary' => '変更の概要',
        'preview' => 'プレビュー',
        'restore' => '復元',
        'restore_confirm' => '本当にこのバージョンを復元しますか？これにより、復元された内容で新しいバージョンが作成されます。',
        'restored' => 'バージョンが正常に復元されました。',
    ],

    'server_panel' => [
        'title' => 'サーバーのドキュメント',
        'no_documents' => '利用可能なドキュメントはありません',
        'no_documents_description' => 'このサーバーにはまだドキュメントがありません。',
        'select_document' => 'ドキュメントを選択',
        'select_document_description' => 'リストからドキュメントを選択して内容を表示します。',
        'last_updated' => '最終更新 :time',
        'global' => 'グローバル',
    ],

    'actions' => [
        'new_document' => '新規ドキュメント',
        'export' => 'Markdownとしてエクスポート',
        'export_json' => 'バックアップのエクスポート',
        'export_json_button' => 'JSONとしてエクスポート',
        'import' => 'Markdownのインポート',
        'import_json' => 'バックアップのインポート',
        'back_to_document' => 'ドキュメントに戻る',
        'close' => '閉じる',
    ],

    'import' => [
        'file_label' => 'Markdownファイル',
        'file_helper' => '.mdファイルをアップロードして新しいドキュメントを作成します',
        'json_file_label' => 'JSONバックアップファイル',
        'json_file_helper' => 'このプラグインからエクスポートされたJSONバックアップファイルをアップロードします',
        'use_frontmatter' => 'YAMLフロントマターを使用',
        'use_frontmatter_helper' => 'YAMLフロントマターが存在する場合、タイトルと設定を抽出します',
        'overwrite_existing' => '既存のドキュメントを上書き',
        'overwrite_existing_helper' => '有効にすると、UUIDが一致するドキュメントが更新されます。それ以外の場合はスキップされます。',
        'success' => 'ドキュメントをインポートしました',
        'success_body' => 'ドキュメント ":title" を正常に作成しました',
        'json_success' => ':imported 件をインポート、:updated 件を更新、:skipped 件をスキップしました。',
        'error' => 'インポートに失敗しました',
        'file_too_large' => 'アップロードされたファイルが最大許容サイズを超えています。',
        'file_read_error' => 'アップロードされたファイルを読み取れませんでした。',
        'invalid_json' => '無効なJSONファイル、またはドキュメント配列が不足しています。',
        'unresolved_roles' => 'フロントマター内の一部のロールが見つかりませんでした: :roles',
        'unresolved_users' => 'フロントマター内の一部のユーザーが見つかりませんでした: :users',
        'unresolved_eggs' => 'フロントマター内の一部のEggが見つかりませんでした: :eggs',
        'unresolved_servers' => 'フロントマター内の一部のサーバーが見つかりませんでした: :servers',
    ],

    'export' => [
        'success' => 'ドキュメントをエクスポートしました',
        'success_body' => 'ドキュメントがMarkdownとしてダウンロードされました',
        'modal_heading' => '全てのドキュメントをエクスポート',
        'modal_description' => '全てのドキュメントを完全な設定（サーバー、Egg、ロール、ユーザー、バージョン履歴）とともにJSONファイルとしてエクスポートし、後で再インポートできるようにします。',
    ],

    'relation_managers' => [
        'linked_servers' => 'リンクされたサーバー',
        'no_servers_linked' => 'リンクされたサーバーはありません',
        'attach_servers_description' => 'サーバーを紐付けて、そのサーバーでこのドキュメントを表示できるようにします。',
        'no_documents_linked' => 'リンクされたドキュメントはありません',
        'attach_documents_description' => 'ドキュメントを紐付けて、このサーバーで表示できるようにします。',
        'sort_order_helper' => 'このサーバーでのドキュメントの表示順序',
    ],
];