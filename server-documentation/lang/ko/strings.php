<?php

// Korean translation for Knowledge Base / Documents Plugin
// English strings copy - translated to Korean

return [
    'navigation' => [
        'documents' => '문서',
        'group' => '콘텐츠',
    ],

    'document' => [
        'singular' => '문서',
        'plural' => '문서',
        'title' => '제목',
        'slug' => '슬러그 (URL 별칭)',
        'content' => '내용',
        'is_global' => '전역 설정',
        'is_published' => '게시됨',
        'sort_order' => '정렬 순서',
        'author' => '작성자',
        'last_edited_by' => '마지막 수정자',
        'version' => '버전',
    ],

    'visibility' => [
        'title' => '공개 설정',
        'description' => '이 문서가 표시되는 위치와 볼 수 있는 사용자를 제어합니다',
        'server' => '서버 공개 설정',
        'person' => '사용자 공개 설정',
        'everyone' => '모든 사용자',
    ],

    'labels' => [
        'all_servers' => '모든 서버',
        'all_servers_helper' => '모든 서버에 표시 (그렇지 않으면 아래의 에그(Eggs)나 특정 서버 사용)',
        'published_helper' => '게시되지 않은 문서는 관리자만 볼 수 있습니다',
        'sort_order_helper' => '낮은 숫자가 먼저 표시됩니다',
        'eggs' => '게임 유형 (Eggs)',
        'roles' => '역할 (Roles)',
        'users' => '특정 사용자',
    ],

    'hints' => [
        'roles_empty' => '서버 액세스 권한이 있는 모든 사용자를 허용하려면 비워 두세요',
        'users_optional' => '선택 사항: 특정 사용자에게 액세스 권한 부여',
        'eggs_hint' => '선택된 게임 유형을 사용하는 모든 서버에 문서가 표시됩니다',
    ],

    'form' => [
        'details_section' => '문서 세부 정보',
        'server_assignment' => '서버 할당',
        'server_assignment_description' => '이 문서를 표시할 서버를 선택하세요',
        'filter_by_egg' => '게임 유형별 필터링',
        'all_eggs' => '모든 게임 유형',
        'assign_to_servers' => '특정 서버',
        'assign_servers_helper' => '이 문서를 표시할 개별 서버를 선택하세요',
        'content_type' => '에디터 유형',
        'rich_text' => '리치 텍스트 (Rich Text)',
        'rich_text_help' => '도구 모음을 사용하여 서식을 지정하거나 웹페이지에서 복사하여 서식과 함께 붙여넣으세요',
        'markdown' => '마크다운 (Markdown)',
        'markdown_help' => '원시 마크다운 구문을 붙여넣으세요 - 표시될 때 HTML로 변환됩니다',
        'raw_html' => '원시 HTML (Raw HTML)',
        'raw_html_help' => '원시 HTML을 직접 작성하세요 - 서식을 완전히 제어하려는 고급 사용자를 위한 기능입니다',
        'variables_hint' => '<strong>변수:</strong> 내용에 <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> 등을 사용하세요. 표시될 때 교체됩니다. 변수를 문자 그대로 표시하려면 <code>\{{var}}</code>를 사용하세요.',
        'rich_editor_tip' => '에디터가 응답하지 않으면 원시 HTML 모드로 전환했다가 다시 돌아와서 초기화하세요.',
        'content_preview' => '내용 미리보기',
        'content_preview_description' => '사용자에게 문서가 어떻게 표시되는지 확인하세요 (변수 처리됨)',
        'content_preview_empty' => '미리보기를 보려면 위에 내용을 입력하세요',
    ],

    'variables' => [
        'title' => '사용 가능한 변수',
        'show_available' => '사용 가능한 변수 표시',
        'escape_hint' => '변수를 교체하지 않고 문자 그대로 표시하려면 앞에 백슬래시를 붙이세요: \\{{user.name}}',
        'user_name' => '현재 사용자의 표시 이름',
        'user_username' => '현재 사용자의 사용자 이름',
        'user_email' => '현재 사용자의 이메일',
        'user_id' => '현재 사용자의 ID',
        'server_name' => '서버 이름',
        'server_uuid' => '서버 UUID',
        'server_id' => '서버 ID',
        'server_egg' => '서버 게임 유형 이름 (Egg)',
        'server_node' => '노드 이름',
        'server_memory' => '할당된 메모리 (MB)',
        'server_disk' => '할당된 디스크 (MB)',
        'server_cpu' => 'CPU 제한 (%)',
        'date' => '현재 날짜 (Y-m-d)',
        'time' => '현재 시간 (H:i)',
        'datetime' => '현재 날짜 및 시간',
        'year' => '현재 연도',
    ],

    'server' => [
        'node' => '노드',
        'owner' => '소유자',
    ],

    'table' => [
        'servers' => '서버',
        'updated_at' => '업데이트됨',
        'type' => '유형',
        'unknown' => '알 수 없음',
        'empty_heading' => '문서가 없습니다',
        'empty_description' => '첫 번째 문서를 작성하여 시작하세요.',
    ],

    'permission_guide' => [
        'title' => '공개 설정 가이드',
        'modal_heading' => '문서 공개 설정 가이드',
        'description' => '문서 공개 설정 이해하기',
        'intro' => '문서에는 두 가지 공개 범위 차원이 있습니다: 표시되는 위치(서버)와 볼 수 있는 사용자(사람).',
        'server_description' => '이 문서를 표시할 서버를 제어합니다:',
        'all_servers_desc' => '문서가 모든 서버에 표시됩니다',
        'eggs_desc' => '선택된 게임 유형을 사용하는 모든 서버에 문서가 표시됩니다',
        'servers_desc' => '특별히 선택된 서버에만 문서가 표시됩니다',
        'person_description' => '이 문서를 볼 수 있는 사용자를 제어합니다:',
        'roles_desc' => '선택된 역할을 가진 사용자만 볼 수 있습니다',
        'users_desc' => '특별히 나열된 사용자만 볼 수 있습니다',
        'everyone_desc' => '역할이나 사용자가 선택되지 않은 경우, 서버 액세스 권한이 있는 모든 사용자가 볼 수 있습니다',
        'admin_note' => '루트 관리자(Root Admins)는 공개 설정과 관계없이 항상 모든 문서를 볼 수 있습니다.',
    ],

    'messages' => [
        'version_restored' => '버전 :version 이(가) 성공적으로 복원되었습니다.',
        'no_documents' => '사용 가능한 문서가 없습니다.',
        'no_versions' => '아직 버전이 없습니다.',
    ],

    'versions' => [
        'title' => '버전 기록',
        'current_document' => '현재 문서',
        'current_version' => '현재 버전',
        'last_updated' => '마지막 업데이트',
        'last_edited_by' => '마지막 수정자',
        'version_number' => '버전',
        'edited_by' => '수정자',
        'date' => '날짜',
        'change_summary' => '변경 요약',
        'preview' => '미리보기',
        'restore' => '복원',
        'restore_confirm' => '이 버전을 복원하시겠습니까? 복원된 내용으로 새 버전이 생성됩니다.',
        'restored' => '버전이 성공적으로 복원되었습니다.',
    ],

    'server_panel' => [
        'title' => '서버 문서',
        'no_documents' => '사용 가능한 문서 없음',
        'no_documents_description' => '이 서버에 대한 문서가 아직 없습니다.',
        'select_document' => '문서 선택',
        'select_document_description' => '목록에서 문서를 선택하여 내용을 확인하세요.',
        'last_updated' => '마지막 업데이트 :time',
        'global' => '전역',
    ],

    'actions' => [
        'new_document' => '새 문서',
        'export' => '마크다운으로 내보내기',
        'export_json' => '백업 내보내기',
        'export_json_button' => 'JSON으로 내보내기',
        'import' => '마크다운 가져오기',
        'import_json' => '백업 가져오기',
        'back_to_document' => '문서로 돌아가기',
        'close' => '닫기',
    ],

    'import' => [
        'file_label' => '마크다운 파일',
        'file_helper' => '.md 파일을 업로드하여 새 문서를 생성합니다',
        'json_file_label' => 'JSON 백업 파일',
        'json_file_helper' => '이 플러그인에서 내보낸 JSON 백업 파일을 업로드합니다',
        'use_frontmatter' => 'YAML 프론트매터 사용',
        'use_frontmatter_helper' => 'YAML 프론트매터가 있는 경우 제목과 설정을 추출합니다',
        'overwrite_existing' => '기존 문서 덮어쓰기',
        'overwrite_existing_helper' => '활성화하면 일치하는 UUID를 가진 문서가 업데이트됩니다. 그렇지 않으면 건너뜁니다.',
        'success' => '문서 가져오기 완료',
        'success_body' => '":title" 문서가 성공적으로 생성되었습니다',
        'json_success' => ':imported 개 가져옴, :updated 개 업데이트됨, :skipped 개 건너뜀.',
        'error' => '가져오기 실패',
        'file_too_large' => '업로드된 파일이 허용된 최대 크기를 초과합니다.',
        'file_read_error' => '업로드된 파일을 읽을 수 없습니다.',
        'invalid_json' => '유효하지 않은 JSON 파일이거나 문서 배열이 없습니다.',
        'unresolved_roles' => '프론트매터에서 일부 역할을 찾을 수 없습니다: :roles',
        'unresolved_users' => '프론트매터에서 일부 사용자를 찾을 수 없습니다: :users',
        'unresolved_eggs' => '프론트매터에서 일부 에그(eggs)를 찾을 수 없습니다: :eggs',
        'unresolved_servers' => '프론트매터에서 일부 서버를 찾을 수 없습니다: :servers',
    ],

    'export' => [
        'success' => '문서 내보내기 완료',
        'success_body' => '문서가 마크다운으로 다운로드되었습니다',
        'modal_heading' => '모든 문서 내보내기',
        'modal_description' => '모든 문서를 전체 구성(서버, 에그, 역할, 사용자 및 버전 기록)과 함께 나중에 다시 가져올 수 있는 JSON 파일로 내보냅니다.',
    ],

    'relation_managers' => [
        'linked_servers' => '연결된 서버',
        'no_servers_linked' => '연결된 서버 없음',
        'attach_servers_description' => '이 문서가 해당 서버에서 보이도록 서버를 연결하세요.',
        'no_documents_linked' => '연결된 문서 없음',
        'attach_documents_description' => '이 서버에서 보이도록 문서를 연결하세요.',
        'sort_order_helper' => '이 서버에서 이 문서가 표시되는 순서',
    ],
];
