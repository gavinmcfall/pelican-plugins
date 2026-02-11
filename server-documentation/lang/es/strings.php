<?php

// Spanish translation for Knowledge Base / Documents Plugin
// Copia de cadenas en inglés - traducidas al español

return [
    'navigation' => [
        'documents' => 'Documentos',
        'group' => 'Contenido',
    ],

    'document' => [
        'singular' => 'Documento',
        'plural' => 'Documentos',
        'title' => 'Título',
        'slug' => 'Slug',
        'content' => 'Contenido',
        'is_global' => 'Global',
        'is_published' => 'Publicado',
        'sort_order' => 'Orden de Clasificación',
        'author' => 'Autor',
        'last_edited_by' => 'Editado por última vez por',
        'version' => 'Versión',
    ],

    'visibility' => [
        'title' => 'Visibilidad',
        'description' => 'Controle dónde aparece este documento y quién puede verlo',
        'server' => 'Visibilidad del Servidor',
        'person' => 'Visibilidad de Persona',
        'everyone' => 'Todos',
    ],

    'labels' => [
        'all_servers' => 'Todos los Servidores',
        'all_servers_helper' => 'Mostrar en todos los servidores (de lo contrario, use eggs o servidores específicos abajo)',
        'published_helper' => 'Los documentos no publicados solo son visibles para administradores',
        'sort_order_helper' => 'Los números más bajos aparecen primero',
        'eggs' => 'Tipos de Juego (Eggs)',
        'roles' => 'Roles',
        'users' => 'Usuarios Específicos',
    ],

    'hints' => [
        'roles_empty' => 'Dejar vacío para permitir a todos con acceso al servidor',
        'users_optional' => 'Opcional: conceder acceso a usuarios específicos',
        'eggs_hint' => 'El documento aparecerá en todos los servidores que usen los tipos de juego seleccionados',
    ],

    'form' => [
        'details_section' => 'Detalles del Documento',
        'server_assignment' => 'Asignación de Servidor',
        'server_assignment_description' => 'Seleccione qué servidores deben mostrar este documento',
        'filter_by_egg' => 'Filtrar por Tipo de Juego',
        'all_eggs' => 'Todos los Tipos de Juego',
        'assign_to_servers' => 'Servidores Específicos',
        'assign_servers_helper' => 'Seleccione servidores individuales que deben mostrar este documento',
        'content_type' => 'Tipo de Editor',
        'rich_text' => 'Texto Enriquecido',
        'rich_text_help' => 'Use la barra de herramientas para formatear, o copie de una página web para pegar con formato',
        'markdown' => 'Markdown',
        'markdown_help' => 'Pegue sintaxis Markdown cruda - se convertirá a HTML al mostrarse',
        'raw_html' => 'HTML Puro',
        'raw_html_help' => 'Escriba HTML puro directamente - para usuarios avanzados que quieren control total sobre el formato',
        'variables_hint' => '<strong>Variables:</strong> Use <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> etc. en su contenido. Serán reemplazadas al mostrarse. Use <code>\{{var}}</code> para mostrar una variable literal.',
        'rich_editor_tip' => 'Si el editor deja de responder, cambie al modo HTML Puro y vuelva para restablecerlo.',
        'content_preview' => 'Vista previa del contenido',
        'content_preview_description' => 'Vea cómo aparecerá el documento a los usuarios (con variables procesadas)',
        'content_preview_empty' => 'Ingrese contenido arriba para ver la vista previa',
    ],

    'variables' => [
        'title' => 'Variables Disponibles',
        'show_available' => 'Mostrar variables disponibles',
        'escape_hint' => 'Para mostrar una variable literalmente sin reemplazarla, use una barra invertida antes: \\{{user.name}}',
        'user_name' => 'Nombre para mostrar del usuario actual',
        'user_username' => 'Nombre de usuario del usuario actual',
        'user_email' => 'Correo electrónico del usuario actual',
        'user_id' => 'ID del usuario actual',
        'server_name' => 'Nombre del servidor',
        'server_uuid' => 'UUID del servidor',
        'server_id' => 'ID del servidor',
        'server_egg' => 'Nombre del tipo de juego del servidor',
        'server_node' => 'Nombre del nodo',
        'server_memory' => 'Memoria asignada (MB)',
        'server_disk' => 'Disco asignado (MB)',
        'server_cpu' => 'Límite de CPU (%)',
        'date' => 'Fecha actual (Y-m-d)',
        'time' => 'Hora actual (H:i)',
        'datetime' => 'Fecha y hora actual',
        'year' => 'Año actual',
    ],

    'server' => [
        'node' => 'Nodo',
        'owner' => 'Propietario',
    ],

    'table' => [
        'servers' => 'Servidores',
        'updated_at' => 'Actualizado',
        'type' => 'Tipo',
        'unknown' => 'Desconocido',
        'empty_heading' => 'Aún no hay documentos',
        'empty_description' => 'Cree su primer documento para comenzar.',
    ],

    'permission_guide' => [
        'title' => 'Guía de Visibilidad',
        'modal_heading' => 'Guía de Visibilidad del Documento',
        'description' => 'Entendiendo la visibilidad del documento',
        'intro' => 'Los documentos tienen dos dimensiones de visibilidad: dónde aparecen (servidores) y quién puede verlos (personas).',
        'server_description' => 'Controla qué servidores muestran este documento:',
        'all_servers_desc' => 'El documento aparece en todos los servidores',
        'eggs_desc' => 'El documento aparece en todos los servidores que usan los tipos de juego seleccionados',
        'servers_desc' => 'El documento aparece solo en servidores seleccionados específicamente',
        'person_description' => 'Controla quién puede ver este documento:',
        'roles_desc' => 'Solo usuarios con roles seleccionados pueden ver',
        'users_desc' => 'Solo usuarios listados específicamente pueden ver',
        'everyone_desc' => 'Si no se seleccionan roles o usuarios, todos con acceso al servidor pueden ver',
        'admin_note' => 'Los Administradores Raíz (Root Admins) siempre pueden ver todos los documentos independientemente de la configuración de visibilidad.',
    ],

    'messages' => [
        'version_restored' => 'Versión :version restaurada con éxito.',
        'no_documents' => 'No hay documentos disponibles.',
        'no_versions' => 'Aún no hay versiones.',
    ],

    'versions' => [
        'title' => 'Historial de Versiones',
        'current_document' => 'Documento Actual',
        'current_version' => 'Versión Actual',
        'last_updated' => 'Última Actualización',
        'last_edited_by' => 'Editado Por Última Vez Por',
        'version_number' => 'Versión',
        'edited_by' => 'Editado Por',
        'date' => 'Fecha',
        'change_summary' => 'Resumen de Cambios',
        'preview' => 'Vista Previa',
        'restore' => 'Restaurar',
        'restore_confirm' => '¿Está seguro de que desea restaurar esta versión? Esto creará una nueva versión con el contenido restaurado.',
        'restored' => 'Versión restaurada con éxito.',
    ],

    'server_panel' => [
        'title' => 'Documentos del Servidor',
        'no_documents' => 'No hay documentos disponibles',
        'no_documents_description' => 'Aún no hay documentos para este servidor.',
        'select_document' => 'Seleccione un documento',
        'select_document_description' => 'Elija un documento de la lista para ver su contenido.',
        'last_updated' => 'Última actualización :time',
        'global' => 'Global',
    ],

    'actions' => [
        'new_document' => 'Nuevo Documento',
        'export' => 'Exportar como Markdown',
        'export_json' => 'Exportar Copia de Seguridad',
        'export_json_button' => 'Exportar como JSON',
        'import' => 'Importar Markdown',
        'import_json' => 'Importar Copia de Seguridad',
        'back_to_document' => 'Volver al Documento',
        'close' => 'Cerrar',
    ],

    'import' => [
        'file_label' => 'Archivo Markdown',
        'file_helper' => 'Suba un archivo .md para crear un nuevo documento',
        'json_file_label' => 'Archivo de Copia de Seguridad JSON',
        'json_file_helper' => 'Suba un archivo de copia de seguridad JSON exportado desde este plugin',
        'use_frontmatter' => 'Usar Frontmatter YAML',
        'use_frontmatter_helper' => 'Extraer título y configuración del frontmatter YAML si está presente',
        'overwrite_existing' => 'Sobrescribir Documentos Existentes',
        'overwrite_existing_helper' => 'Si se habilita, los documentos con UUIDs coincidentes se actualizarán. De lo contrario, se omitirán.',
        'success' => 'Documento Importado',
        'success_body' => 'Documento ":title" creado con éxito',
        'json_success' => ':imported importados, :updated actualizados, :skipped omitidos.',
        'error' => 'Importación Fallida',
        'file_too_large' => 'El archivo subido excede el tamaño máximo permitido.',
        'file_read_error' => 'No se pudo leer el archivo subido.',
        'invalid_json' => 'Archivo JSON inválido o falta la matriz de documentos.',
        'unresolved_roles' => 'Algunos roles del frontmatter no se pudieron encontrar: :roles',
        'unresolved_users' => 'Algunos usuarios del frontmatter no se pudieron encontrar: :users',
        'unresolved_eggs' => 'Algunos eggs del frontmatter no se pudieron encontrar: :eggs',
        'unresolved_servers' => 'Algunos servidores del frontmatter no se pudieron encontrar: :servers',
    ],

    'export' => [
        'success' => 'Documento Exportado',
        'success_body' => 'El documento ha sido descargado como Markdown',
        'modal_heading' => 'Exportar Todos los Documentos',
        'modal_description' => 'Esto exportará todos los documentos con su configuración completa (servidores, eggs, roles, usuarios e historial de versiones) como un archivo JSON que se puede volver a importar más tarde.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Servidores Vinculados',
        'no_servers_linked' => 'Ningún servidor vinculado',
        'attach_servers_description' => 'Adjuntar servidores para hacer visible este documento en esos servidores.',
        'no_documents_linked' => 'Ningún documento vinculado',
        'attach_documents_description' => 'Adjuntar documentos para hacerlos visibles en este servidor.',
        'sort_order_helper' => 'Orden en que aparece este documento para este servidor',
    ],
];
