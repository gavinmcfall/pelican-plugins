<?php

// Vietnamese translation for Knowledge Base / Documents Plugin
// Bản sao chuỗi tiếng Anh - được dịch sang tiếng Việt

return [
    'navigation' => [
        'documents' => 'Tài liệu',
        'group' => 'Nội dung',
    ],

    'document' => [
        'singular' => 'Tài liệu',
        'plural' => 'Tài liệu',
        'title' => 'Tiêu đề',
        'slug' => 'Slug (Đường dẫn tĩnh)',
        'content' => 'Nội dung',
        'is_global' => 'Toàn cầu',
        'is_published' => 'Đã xuất bản',
        'sort_order' => 'Thứ tự sắp xếp',
        'author' => 'Tác giả',
        'last_edited_by' => 'Chỉnh sửa lần cuối bởi',
        'version' => 'Phiên bản',
    ],

    'visibility' => [
        'title' => 'Khả năng hiển thị',
        'description' => 'Kiểm soát nơi tài liệu này xuất hiện và ai có thể xem nó',
        'server' => 'Hiển thị trên máy chủ',
        'person' => 'Hiển thị cho người dùng',
        'everyone' => 'Mọi người',
    ],

    'labels' => [
        'all_servers' => 'Tất cả máy chủ',
        'all_servers_helper' => 'Hiển thị trên tất cả máy chủ (nếu không, hãy sử dụng Eggs hoặc máy chủ cụ thể bên dưới)',
        'published_helper' => 'Tài liệu chưa xuất bản chỉ hiển thị với quản trị viên',
        'sort_order_helper' => 'Số nhỏ hơn sẽ xuất hiện trước',
        'eggs' => 'Loại trò chơi (Eggs)',
        'roles' => 'Vai trò',
        'users' => 'Người dùng cụ thể',
    ],

    'hints' => [
        'roles_empty' => 'Để trống để cho phép tất cả những người có quyền truy cập máy chủ',
        'users_optional' => 'Tùy chọn: cấp quyền truy cập cho người dùng cụ thể',
        'eggs_hint' => 'Tài liệu sẽ xuất hiện trên tất cả các máy chủ sử dụng loại trò chơi đã chọn',
    ],

    'form' => [
        'details_section' => 'Chi tiết tài liệu',
        'server_assignment' => 'Gán máy chủ',
        'server_assignment_description' => 'Chọn máy chủ nào sẽ hiển thị tài liệu này',
        'filter_by_egg' => 'Lọc theo loại trò chơi',
        'all_eggs' => 'Tất cả loại trò chơi',
        'assign_to_servers' => 'Máy chủ cụ thể',
        'assign_servers_helper' => 'Chọn từng máy chủ riêng lẻ sẽ hiển thị tài liệu này',
        'content_type' => 'Loại trình soạn thảo',
        'rich_text' => 'Văn bản phong phú (Rich Text)',
        'rich_text_help' => 'Sử dụng thanh công cụ để định dạng, hoặc sao chép từ trang web để dán kèm định dạng',
        'markdown' => 'Markdown',
        'markdown_help' => 'Dán cú pháp Markdown thô - sẽ được chuyển đổi thành HTML khi hiển thị',
        'raw_html' => 'HTML thô',
        'raw_html_help' => 'Viết HTML thô trực tiếp - dành cho người dùng nâng cao muốn kiểm soát hoàn toàn định dạng',
        'variables_hint' => '<strong>Biến số:</strong> Sử dụng <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> v.v. trong nội dung của bạn. Chúng sẽ được thay thế khi hiển thị. Sử dụng <code>\{{var}}</code> để hiển thị biến theo nghĩa đen.',
        'rich_editor_tip' => 'Nếu trình soạn thảo không phản hồi, hãy chuyển sang chế độ HTML thô rồi quay lại để đặt lại.',
        'content_preview' => 'Xem trước nội dung',
        'content_preview_description' => 'Xem cách tài liệu sẽ xuất hiện cho người dùng (với các biến đã được xử lý)',
        'content_preview_empty' => 'Nhập nội dung ở trên để xem bản xem trước',
    ],

    'variables' => [
        'title' => 'Các biến có sẵn',
        'show_available' => 'Hiển thị các biến có sẵn',
        'escape_hint' => 'Để hiển thị biến theo nghĩa đen mà không thay thế nó, hãy thêm dấu gạch chéo ngược vào trước: \\{{user.name}}',
        'user_name' => 'Tên hiển thị của người dùng hiện tại',
        'user_username' => 'Tên đăng nhập của người dùng hiện tại',
        'user_email' => 'Email của người dùng hiện tại',
        'user_id' => 'ID của người dùng hiện tại',
        'server_name' => 'Tên máy chủ',
        'server_uuid' => 'UUID máy chủ',
        'server_id' => 'ID máy chủ',
        'server_egg' => 'Tên loại trò chơi (Egg) của máy chủ',
        'server_node' => 'Tên Node',
        'server_memory' => 'Bộ nhớ được phân bổ (MB)',
        'server_disk' => 'Dung lượng đĩa được phân bổ (MB)',
        'server_cpu' => 'Giới hạn CPU (%)',
        'date' => 'Ngày hiện tại (Y-m-d)',
        'time' => 'Giờ hiện tại (H:i)',
        'datetime' => 'Ngày và giờ hiện tại',
        'year' => 'Năm hiện tại',
    ],

    'server' => [
        'node' => 'Node',
        'owner' => 'Chủ sở hữu',
    ],

    'table' => [
        'servers' => 'Máy chủ',
        'updated_at' => 'Đã cập nhật',
        'type' => 'Loại',
        'unknown' => 'Không xác định',
        'empty_heading' => 'Chưa có tài liệu nào',
        'empty_description' => 'Tạo tài liệu đầu tiên của bạn để bắt đầu.',
    ],

    'permission_guide' => [
        'title' => 'Hướng dẫn hiển thị',
        'modal_heading' => 'Hướng dẫn hiển thị tài liệu',
        'description' => 'Hiểu về khả năng hiển thị tài liệu',
        'intro' => 'Tài liệu có hai chiều hiển thị: nơi chúng xuất hiện (máy chủ) và ai có thể xem chúng (người).',
        'server_description' => 'Kiểm soát máy chủ nào hiển thị tài liệu này:',
        'all_servers_desc' => 'Tài liệu xuất hiện trên mọi máy chủ',
        'eggs_desc' => 'Tài liệu xuất hiện trên tất cả các máy chủ sử dụng các loại trò chơi đã chọn',
        'servers_desc' => 'Tài liệu chỉ xuất hiện trên các máy chủ được chọn cụ thể',
        'person_description' => 'Kiểm soát ai có thể xem tài liệu này:',
        'roles_desc' => 'Chỉ người dùng có vai trò được chọn mới có thể xem',
        'users_desc' => 'Chỉ những người dùng được liệt kê cụ thể mới có thể xem',
        'everyone_desc' => 'Nếu không có vai trò hoặc người dùng nào được chọn, tất cả những người có quyền truy cập máy chủ đều có thể xem',
        'admin_note' => 'Quản trị viên cấp cao (Root Admins) luôn có thể xem tất cả tài liệu bất kể cài đặt hiển thị.',
    ],

    'messages' => [
        'version_restored' => 'Phiên bản :version đã được khôi phục thành công.',
        'no_documents' => 'Không có tài liệu nào.',
        'no_versions' => 'Chưa có phiên bản nào.',
    ],

    'versions' => [
        'title' => 'Lịch sử phiên bản',
        'current_document' => 'Tài liệu hiện tại',
        'current_version' => 'Phiên bản hiện tại',
        'last_updated' => 'Cập nhật lần cuối',
        'last_edited_by' => 'Chỉnh sửa lần cuối bởi',
        'version_number' => 'Phiên bản',
        'edited_by' => 'Được chỉnh sửa bởi',
        'date' => 'Ngày',
        'change_summary' => 'Tóm tắt thay đổi',
        'preview' => 'Xem trước',
        'restore' => 'Khôi phục',
        'restore_confirm' => 'Bạn có chắc chắn muốn khôi phục phiên bản này không? Hành động này sẽ tạo ra một phiên bản mới với nội dung được khôi phục.',
        'restored' => 'Phiên bản đã được khôi phục thành công.',
    ],

    'server_panel' => [
        'title' => 'Tài liệu máy chủ',
        'no_documents' => 'Không có tài liệu nào',
        'no_documents_description' => 'Chưa có tài liệu nào cho máy chủ này.',
        'select_document' => 'Chọn tài liệu',
        'select_document_description' => 'Chọn một tài liệu từ danh sách để xem nội dung của nó.',
        'last_updated' => 'Cập nhật lần cuối :time',
        'global' => 'Toàn cầu',
    ],

    'actions' => [
        'new_document' => 'Tài liệu mới',
        'export' => 'Xuất dưới dạng Markdown',
        'export_json' => 'Xuất bản sao lưu',
        'export_json_button' => 'Xuất dưới dạng JSON',
        'import' => 'Nhập Markdown',
        'import_json' => 'Nhập bản sao lưu',
        'back_to_document' => 'Quay lại tài liệu',
        'close' => 'Đóng',
    ],

    'import' => [
        'file_label' => 'Tệp Markdown',
        'file_helper' => 'Tải lên tệp .md để tạo tài liệu mới',
        'json_file_label' => 'Tệp sao lưu JSON',
        'json_file_helper' => 'Tải lên tệp sao lưu JSON đã xuất từ plugin này',
        'use_frontmatter' => 'Sử dụng YAML Frontmatter',
        'use_frontmatter_helper' => 'Trích xuất tiêu đề và cài đặt từ YAML frontmatter nếu có',
        'overwrite_existing' => 'Ghi đè tài liệu hiện có',
        'overwrite_existing_helper' => 'Nếu được bật, các tài liệu có UUID trùng khớp sẽ được cập nhật. Nếu không, chúng sẽ bị bỏ qua.',
        'success' => 'Đã nhập tài liệu',
        'success_body' => 'Đã tạo thành công tài liệu ":title"',
        'json_success' => 'Đã nhập :imported, đã cập nhật :updated, đã bỏ qua :skipped.',
        'error' => 'Nhập thất bại',
        'file_too_large' => 'Tệp tải lên vượt quá kích thước tối đa cho phép.',
        'file_read_error' => 'Không thể đọc tệp đã tải lên.',
        'invalid_json' => 'Tệp JSON không hợp lệ hoặc thiếu mảng tài liệu.',
        'unresolved_roles' => 'Không tìm thấy một số vai trò từ frontmatter: :roles',
        'unresolved_users' => 'Không tìm thấy một số người dùng từ frontmatter: :users',
        'unresolved_eggs' => 'Không tìm thấy một số eggs từ frontmatter: :eggs',
        'unresolved_servers' => 'Không tìm thấy một số máy chủ từ frontmatter: :servers',
    ],

    'export' => [
        'success' => 'Đã xuất tài liệu',
        'success_body' => 'Tài liệu đã được tải xuống dưới dạng Markdown',
        'modal_heading' => 'Xuất tất cả tài liệu',
        'modal_description' => 'Hành động này sẽ xuất tất cả tài liệu với cấu hình đầy đủ của chúng (máy chủ, eggs, vai trò, người dùng và lịch sử phiên bản) dưới dạng tệp JSON có thể nhập lại sau này.',
    ],

    'relation_managers' => [
        'linked_servers' => 'Máy chủ liên kết',
        'no_servers_linked' => 'Không có máy chủ nào được liên kết',
        'attach_servers_description' => 'Đính kèm máy chủ để hiển thị tài liệu này trên các máy chủ đó.',
        'no_documents_linked' => 'Không có tài liệu nào được liên kết',
        'attach_documents_description' => 'Đính kèm tài liệu để hiển thị chúng trên máy chủ này.',
        'sort_order_helper' => 'Thứ tự xuất hiện của tài liệu này đối với máy chủ này',
    ],
];