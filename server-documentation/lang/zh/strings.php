<?php

// Chinese (Simplified) translation for Knowledge Base / Documents Plugin
// English strings copy - translated to Chinese

return [
    'navigation' => [
        'documents' => '文档',
        'group' => '内容',
    ],

    'document' => [
        'singular' => '文档',
        'plural' => '文档',
        'title' => '标题',
        'slug' => 'Slug (URL别名)',
        'content' => '内容',
        'is_global' => '全局',
        'is_published' => '已发布',
        'sort_order' => '排序顺序',
        'author' => '作者',
        'last_edited_by' => '最后编辑者',
        'version' => '版本',
    ],

    'visibility' => [
        'title' => '可见性',
        'description' => '控制此文档显示的去处以及谁可以看到它',
        'server' => '服务器可见性',
        'person' => '人员可见性',
        'everyone' => '所有人',
    ],

    'labels' => [
        'all_servers' => '所有服务器',
        'all_servers_helper' => '在所有服务器上显示（否则请使用下方的 Eggs 或特定服务器）',
        'published_helper' => '未发布的文档仅对管理员可见',
        'sort_order_helper' => '数字越小越靠前',
        'eggs' => '游戏类型 (Eggs)',
        'roles' => '角色',
        'users' => '特定用户',
    ],

    'hints' => [
        'roles_empty' => '留空以允许所有拥有服务器访问权限的人查看',
        'users_optional' => '可选：授予特定用户访问权限',
        'eggs_hint' => '文档将出现在所有使用选定游戏类型的服务器上',
    ],

    'form' => [
        'details_section' => '文档详情',
        'server_assignment' => '服务器分配',
        'server_assignment_description' => '选择哪些服务器应显示此文档',
        'filter_by_egg' => '按游戏类型筛选',
        'all_eggs' => '所有游戏类型',
        'assign_to_servers' => '特定服务器',
        'assign_servers_helper' => '选择应显示此文档的单个服务器',
        'content_type' => '编辑器类型',
        'rich_text' => '富文本 (Rich Text)',
        'rich_text_help' => '使用工具栏进行格式化，或从网页复制以粘贴带格式的内容',
        'markdown' => 'Markdown',
        'markdown_help' => '粘贴原始 Markdown 语法 - 显示时将转换为 HTML',
        'raw_html' => '原始 HTML',
        'raw_html_help' => '直接编写原始 HTML - 适用于想要完全控制格式的高级用户',
        'variables_hint' => '<strong>变量：</strong> 在内容中使用 <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> 等。显示时它们会被替换。使用 <code>\{{var}}</code> 来显示文字变量。',
        'rich_editor_tip' => '如果编辑器无响应，请切换到“原始 HTML”模式再切换回来以重置它。',
        'content_preview' => '内容预览',
        'content_preview_description' => '查看文档对用户的显示效果（变量已处理）',
        'content_preview_empty' => '在上方输入内容以查看预览',
    ],

    'variables' => [
        'title' => '可用变量',
        'show_available' => '显示可用变量',
        'escape_hint' => '要按字面显示变量而不替换它，请在前面加上反斜杠：\\{{user.name}}',
        'user_name' => '当前用户的显示名称',
        'user_username' => '当前用户的用户名',
        'user_email' => '当前用户的电子邮件',
        'user_id' => '当前用户的 ID',
        'server_name' => '服务器名称',
        'server_uuid' => '服务器 UUID',
        'server_id' => '服务器 ID',
        'server_egg' => '服务器游戏类型名称',
        'server_node' => '节点名称',
        'server_memory' => '分配的内存 (MB)',
        'server_disk' => '分配的磁盘 (MB)',
        'server_cpu' => 'CPU 限制 (%)',
        'date' => '当前日期 (Y-m-d)',
        'time' => '当前时间 (H:i)',
        'datetime' => '当前日期和时间',
        'year' => '当前年份',
    ],

    'server' => [
        'node' => '节点',
        'owner' => '所有者',
    ],

    'table' => [
        'servers' => '服务器',
        'updated_at' => '更新于',
        'type' => '类型',
        'unknown' => '未知',
        'empty_heading' => '暂无文档',
        'empty_description' => '创建您的第一个文档以开始。',
    ],

    'permission_guide' => [
        'title' => '可见性指南',
        'modal_heading' => '文档可见性指南',
        'description' => '了解文档可见性',
        'intro' => '文档有两个可见性维度：它们出现的位置（服务器）和谁可以看到它们（人员）。',
        'server_description' => '控制哪些服务器显示此文档：',
        'all_servers_desc' => '文档出现在每个服务器上',
        'eggs_desc' => '文档出现在所有使用选定游戏类型的服务器上',
        'servers_desc' => '文档仅出现在特别选定的服务器上',
        'person_description' => '控制谁可以查看此文档：',
        'roles_desc' => '只有具有选定角色的用户可以查看',
        'users_desc' => '只有特别列出的用户可以查看',
        'everyone_desc' => '如果未选择角色或用户，则所有拥有服务器访问权限的人都可以查看',
        'admin_note' => '无论可见性设置如何，超级管理员 (Root Admins) 始终可以查看所有文档。',
    ],

    'messages' => [
        'version_restored' => '版本 :version 已成功恢复。',
        'no_documents' => '无可用的文档。',
        'no_versions' => '暂无版本。',
    ],

    'versions' => [
        'title' => '版本历史',
        'current_document' => '当前文档',
        'current_version' => '当前版本',
        'last_updated' => '最后更新',
        'last_edited_by' => '最后编辑者',
        'version_number' => '版本',
        'edited_by' => '编辑者',
        'date' => '日期',
        'change_summary' => '更改摘要',
        'preview' => '预览',
        'restore' => '恢复',
        'restore_confirm' => '您确定要恢复此版本吗？这将创建一个包含恢复内容的新版本。',
        'restored' => '版本恢复成功。',
    ],

    'server_panel' => [
        'title' => '服务器文档',
        'no_documents' => '无可用文档',
        'no_documents_description' => '此服务器暂无文档。',
        'select_document' => '选择文档',
        'select_document_description' => '从列表中选择一个文档以查看其内容。',
        'last_updated' => '最后更新 :time',
        'global' => '全局',
    ],

    'actions' => [
        'new_document' => '新文档',
        'export' => '导出为 Markdown',
        'export_json' => '导出备份',
        'export_json_button' => '导出为 JSON',
        'import' => '导入 Markdown',
        'import_json' => '导入备份',
        'back_to_document' => '返回文档',
        'close' => '关闭',
    ],

    'import' => [
        'file_label' => 'Markdown 文件',
        'file_helper' => '上传 .md 文件以创建新文档',
        'json_file_label' => 'JSON 备份文件',
        'json_file_helper' => '上传从此插件导出的 JSON 备份文件',
        'use_frontmatter' => '使用 YAML Frontmatter',
        'use_frontmatter_helper' => '如果存在，从 YAML frontmatter 中提取标题和设置',
        'overwrite_existing' => '覆盖现有文档',
        'overwrite_existing_helper' => '如果启用，具有匹配 UUID 的文档将被更新。否则，它们将被跳过。',
        'success' => '文档已导入',
        'success_body' => '成功创建文档 ":title"',
        'json_success' => '已导入 :imported 个，已更新 :updated 个，已跳过 :skipped 个。',
        'error' => '导入失败',
        'file_too_large' => '上传的文件超过了允许的最大大小。',
        'file_read_error' => '无法读取上传的文件。',
        'invalid_json' => '无效的 JSON 文件或缺少文档数组。',
        'unresolved_roles' => '无法找到 Frontmatter 中的某些角色：:roles',
        'unresolved_users' => '无法找到 Frontmatter 中的某些用户：:users',
        'unresolved_eggs' => '无法找到 Frontmatter 中的某些游戏类型 (Eggs)：:eggs',
        'unresolved_servers' => '无法找到 Frontmatter 中的某些服务器：:servers',
    ],

    'export' => [
        'success' => '文档已导出',
        'success_body' => '文档已下载为 Markdown',
        'modal_heading' => '导出所有文档',
        'modal_description' => '这将导出所有文档及其完整配置（服务器、Eggs、角色、用户和版本历史记录）为 JSON 文件，以便以后重新导入。',
    ],

    'relation_managers' => [
        'linked_servers' => '关联的服务器',
        'no_servers_linked' => '无关联的服务器',
        'attach_servers_description' => '附加服务器以使此文档在这些服务器上可见。',
        'no_documents_linked' => '无关联的文档',
        'attach_documents_description' => '附加文档以使其在此服务器上可见。',
        'sort_order_helper' => '此文档在此服务器上的显示顺序',
    ],
];