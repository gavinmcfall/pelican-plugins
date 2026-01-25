<?php

// Portuguese translation for Knowledge Base / Documents Plugin
// Cópia das strings em inglês - traduzidas para o português

return [
    'navigation' => [
        'documents' => 'Documentos',
        'group' => 'Conteúdo',
    ],

    'document' => [
        'singular' => 'Documento',
        'plural' => 'Documentos',
        'title' => 'Título',
        'slug' => 'Slug',
        'content' => 'Conteúdo',
        'is_global' => 'Global',
        'is_published' => 'Publicado',
        'sort_order' => 'Ordem de Classificação',
        'author' => 'Autor',
        'last_edited_by' => 'Editado por última vez por',
        'version' => 'Versão',
    ],

    'visibility' => [
        'title' => 'Visibilidade',
        'description' => 'Controle onde este documento aparece e quem pode vê-lo',
        'server' => 'Visibilidade do Servidor',
        'person' => 'Visibilidade de Pessoa',
        'everyone' => 'Todos',
    ],

    'labels' => [
        'all_servers' => 'Todos os Servidores',
        'all_servers_helper' => 'Mostrar em todos os servidores (caso contrário, use eggs ou servidores específicos abaixo)',
        'published_helper' => 'Documentos não publicados são visíveis apenas para administradores',
        'sort_order_helper' => 'Números menores aparecem primeiro',
        'eggs' => 'Tipos de Jogo (Eggs)',
        'roles' => 'Cargos',
        'users' => 'Usuários Específicos',
    ],

    'hints' => [
        'roles_empty' => 'Deixe vazio para permitir todos com acesso ao servidor',
        'users_optional' => 'Opcional: conceder acesso a usuários específicos',
        'eggs_hint' => 'O documento aparecerá em todos os servidores que usam os tipos de jogo selecionados',
    ],

    'form' => [
        'details_section' => 'Detalhes do Documento',
        'server_assignment' => 'Atribuição de Servidor',
        'server_assignment_description' => 'Selecione quais servidores devem exibir este documento',
        'filter_by_egg' => 'Filtrar por Tipo de Jogo',
        'all_eggs' => 'Todos os Tipos de Jogo',
        'assign_to_servers' => 'Servidores Específicos',
        'assign_servers_helper' => 'Selecione servidores individuais que devem exibir este documento',
        'content_type' => 'Tipo de Editor',
        'rich_text' => 'Texto Rico',
        'rich_text_help' => 'Use a barra de ferramentas para formatar, ou copie de uma página da web para colar com formatação',
        'markdown' => 'Markdown',
        'markdown_help' => 'Cole a sintaxe Markdown bruta - ela será convertida para HTML ao ser exibida',
        'raw_html' => 'HTML Puro',
        'raw_html_help' => 'Escreva HTML puro diretamente - para usuários avançados que desejam controle total sobre a formatação',
        'variables_hint' => '<strong>Variáveis:</strong> Use <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> etc. em seu conteúdo. Elas serão substituídas ao serem exibidas. Use <code>\{{var}}</code> para mostrar uma variável literal.',
        'rich_editor_tip' => 'Se o editor parar de responder, mude para o modo HTML Puro e volte para redefini-lo.',
        'content_preview' => 'Pré-visualização do conteúdo',
        'content_preview_description' => 'Veja como o documento aparecerá para os usuários (com variáveis processadas)',
        'content_preview_empty' => 'Insira conteúdo acima para ver a pré-visualização',
    ],

    'variables' => [
        'title' => 'Variáveis Disponíveis',
        'show_available' => 'Mostrar variáveis disponíveis',
        'escape_hint' => 'Para mostrar uma variável literalmente sem substituí-la, prefixe com uma barra invertida: \\{{user.name}}',
        'user_name' => 'Nome de exibição do usuário atual',
        'user_username' => 'Nome de usuário do usuário atual',
        'user_email' => 'E-mail do usuário atual',
        'user_id' => 'ID do usuário atual',
        'server_name' => 'Nome do servidor',
        'server_uuid' => 'UUID do servidor',
        'server_id' => 'ID do servidor',
        'server_egg' => 'Nome do tipo de jogo do servidor',
        'server_node' => 'Nome do nó (Node)',
        'server_memory' => 'Memória alocada (MB)',
        'server_disk' => 'Disco alocado (MB)',
        'server_cpu' => 'Limite de CPU (%)',
        'date' => 'Data atual (Y-m-d)',
        'time' => 'Hora atual (H:i)',
        'datetime' => 'Data e hora atuais',
        'year' => 'Ano atual',
    ],

    'server' => [
        'node' => 'Nó (Node)',
        'owner' => 'Proprietário',
    ],

    'table' => [
        'servers' => 'Servidores',
        'updated_at' => 'Atualizado',
        'type' => 'Tipo',
        'unknown' => 'Desconhecido',
        'empty_heading' => 'Nenhum documento ainda',
        'empty_description' => 'Crie seu primeiro documento para começar.',
    ],

    'permission_guide' => [
        'title' => 'Guia de Visibilidade',
        'modal_heading' => 'Guia de Visibilidade do Documento',
        'description' => 'Entendendo a visibilidade do documento',
        'intro' => 'Os documentos têm duas dimensões de visibilidade: onde aparecem (servidores) e quem pode vê-los (pessoas).',
        'server_description' => 'Controla quais servidores exibem este documento:',
        'all_servers_desc' => 'O documento aparece em todos os servidores',
        'eggs_desc' => 'O documento aparece em todos os servidores usando os tipos de jogo selecionados',
        'servers_desc' => 'O documento aparece apenas em servidores selecionados especificamente',
        'person_description' => 'Controla quem pode visualizar este documento:',
        'roles_desc' => 'Apenas usuários com cargos selecionados podem visualizar',
        'users_desc' => 'Apenas usuários listados especificamente podem visualizar',
        'everyone_desc' => 'Se nenhum cargo ou usuário for selecionado, todos com acesso ao servidor podem visualizar',
        'admin_note' => 'Administradores Root sempre podem visualizar todos os documentos, independentemente das configurações de visibilidade.',
    ],

    'messages' => [
        'version_restored' => 'Versão :version restaurada com sucesso.',
        'no_documents' => 'Nenhum documento disponível.',
        'no_versions' => 'Nenhuma versão ainda.',
    ],

    'versions' => [
        'title' => 'Histórico de Versões',
        'current_document' => 'Documento Atual',
        'current_version' => 'Versão Atual',
        'last_updated' => 'Última Atualização',
        'last_edited_by' => 'Editado Por Última Vez Por',
        'version_number' => 'Versão',
        'edited_by' => 'Editado Por',
        'date' => 'Data',
        'change_summary' => 'Resumo de Alterações',
        'preview' => 'Pré-visualização',
        'restore' => 'Restaurar',
        'restore_confirm' => 'Tem certeza de que deseja restaurar esta versão? Isso criará uma nova versão com o conteúdo restaurado.',
        'restored' => 'Versão restaurada com sucesso.',
    ],

    'server_panel' => [
        'title' => 'Documentos do Servidor',
        'no_documents' => 'Nenhum documento disponível',
        'no_documents_description' => 'Ainda não há documentos para este servidor.',
        'select_document' => 'Selecione um documento',
        'select_document_description' => 'Escolha um documento da lista para ver seu conteúdo.',
        'last_updated' => 'Última atualização :time',
        'global' => 'Global',
    ],

    'actions' => [
        'new_document' => 'Novo Documento',
        'export' => 'Exportar como Markdown',
        'export_json' => 'Exportar Backup',
        'export_json_button' => 'Exportar como JSON',
        'import' => 'Importar Markdown',
        'import_json' => 'Importar Backup',
        'back_to_document' => 'Voltar para o Documento',
        'close' => 'Fechar',
    ],

    'import' => [
        'file_label' => 'Arquivo Markdown',
        'file_helper' => 'Envie um arquivo .md para criar um novo documento',
        'json_file_label' => 'Arquivo de Backup JSON',
        'json_file_helper' => 'Envie um arquivo de backup JSON exportado deste plugin',
        'use_frontmatter' => 'Usar YAML Frontmatter',
        'use_frontmatter_helper' => 'Extrair título e configurações do frontmatter YAML, se presente',
        'overwrite_existing' => 'Sobrescrever Documentos Existentes',
        'overwrite_existing_helper' => 'Se ativado, documentos com UUIDs correspondentes serão atualizados. Caso contrário, serão ignorados.',
        'success' => 'Documento Importado',
        'success_body' => 'Documento ":title" criado com sucesso',
        'json_success' => ':imported importados, :updated atualizados, :skipped ignorados.',
        'error' => 'Falha na Importação',
        'file_too_large' => 'O arquivo enviado excede o tamanho máximo permitido.',
        'file_read_error' => 'Não foi possível ler o arquivo enviado.',
        'invalid_json' => 'Arquivo JSON inválido ou matriz de documentos ausente.',
        'unresolved_roles' => 'Alguns cargos do frontmatter não puderam ser encontrados: :roles',
        'unresolved_users' => 'Alguns usuários do frontmatter não puderam ser encontrados: :users',
        'unresolved_eggs' => 'Alguns eggs do frontmatter não puderam ser encontrados: :eggs',
        'unresolved_servers' => 'Alguns servidores do frontmatter não puderam ser encontrados: :servers',
    ],

    'export' => [
        'success' => 'Documento Exportado',
        'success_body' => 'O documento foi baixado como Markdown',
        'modal_heading' => 'Exportar Todos os Documentos',
        'modal_description' => 'Isso exportará todos os documentos com sua configuração completa (servidores, eggs, cargos, usuários e histórico de versões) como um arquivo JSON que pode ser reimportado posteriormente.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Servidores Vinculados',
        'no_servers_linked' => 'Nenhum servidor vinculado',
        'attach_servers_description' => 'Anexar servidores para tornar este documento visível nesses servidores.',
        'no_documents_linked' => 'Nenhum documento vinculado',
        'attach_documents_description' => 'Anexar documentos para torná-los visíveis neste servidor.',
        'sort_order_helper' => 'Ordem em que este documento aparece para este servidor',
    ],
];