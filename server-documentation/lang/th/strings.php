<?php

// Thai translation for Knowledge Base / Documents Plugin
// English strings copy - translated to Thai

return [
    'navigation' => [
        'documents' => 'เอกสาร',
        'group' => 'เนื้อหา',
    ],

    'document' => [
        'singular' => 'เอกสาร',
        'plural' => 'เอกสาร',
        'title' => 'หัวข้อ',
        'slug' => 'Slug (ส่วนท้าย URL)',
        'content' => 'เนื้อหา',
        'is_global' => 'Global (ส่วนกลาง)',
        'is_published' => 'เผยแพร่แล้ว',
        'sort_order' => 'ลำดับการเรียง',
        'author' => 'ผู้เขียน',
        'last_edited_by' => 'แก้ไขล่าสุดโดย',
        'version' => 'เวอร์ชัน',
    ],

    'visibility' => [
        'title' => 'การมองเห็น',
        'description' => 'ควบคุมตำแหน่งที่เอกสารนี้จะปรากฏและผู้ที่สามารถมองเห็นได้',
        'server' => 'การมองเห็นบนเซิร์ฟเวอร์',
        'person' => 'การมองเห็นสำหรับบุคคล',
        'everyone' => 'ทุกคน',
    ],

    'labels' => [
        'all_servers' => 'เซิร์ฟเวอร์ทั้งหมด',
        'all_servers_helper' => 'แสดงบนเซิร์ฟเวอร์ทั้งหมด (มิฉะนั้นให้ใช้ Eggs หรือเซิร์ฟเวอร์เฉพาะด้านล่าง)',
        'published_helper' => 'เอกสารที่ยังไม่เผยแพร่จะมองเห็นได้เฉพาะผู้ดูแลระบบเท่านั้น',
        'sort_order_helper' => 'ตัวเลขน้อยจะแสดงก่อน',
        'eggs' => 'ประเภทเกม (Eggs)',
        'roles' => 'บทบาท (Roles)',
        'users' => 'ผู้ใช้ที่ระบุ',
    ],

    'hints' => [
        'roles_empty' => 'เว้นว่างไว้เพื่ออนุญาตให้ทุกคนที่มีสิทธิ์เข้าถึงเซิร์ฟเวอร์',
        'users_optional' => 'ไม่บังคับ: ให้สิทธิ์การเข้าถึงแก่ผู้ใช้เฉพาะราย',
        'eggs_hint' => 'เอกสารจะปรากฏบนเซิร์ฟเวอร์ทั้งหมดที่ใช้ประเภทเกมที่เลือก',
    ],

    'form' => [
        'details_section' => 'รายละเอียดเอกสาร',
        'server_assignment' => 'การกำหนดเซิร์ฟเวอร์',
        'server_assignment_description' => 'เลือกเซิร์ฟเวอร์ที่ควรแสดงเอกสารนี้',
        'filter_by_egg' => 'กรองตามประเภทเกม',
        'all_eggs' => 'ประเภทเกมทั้งหมด',
        'assign_to_servers' => 'เซิร์ฟเวอร์เฉพาะ',
        'assign_servers_helper' => 'เลือกเซิร์ฟเวอร์แต่ละเครื่องที่ควรแสดงเอกสารนี้',
        'content_type' => 'ประเภทตัวแก้ไข',
        'rich_text' => 'Rich Text',
        'rich_text_help' => 'ใช้แถบเครื่องมือเพื่อจัดรูปแบบ หรือคัดลอกหน้าเว็บเพื่อวางพร้อมรูปแบบ',
        'markdown' => 'Markdown',
        'markdown_help' => 'วางไวยากรณ์ Markdown ดิบ - จะถูกแปลงเป็น HTML เมื่อแสดงผล',
        'raw_html' => 'HTML ดิบ',
        'raw_html_help' => 'เขียน HTML ดิบโดยตรง - สำหรับผู้ใช้ขั้นสูงที่ต้องการควบคุมการจัดรูปแบบอย่างเต็มที่',
        'variables_hint' => '<strong>ตัวแปร:</strong> ใช้ <code>{{user.name}}</code>, <code>{{server.name}}</code>, <code>{{server.egg}}</code>, <code>{{date}}</code> ฯลฯ ในเนื้อหาของคุณ โดยจะถูกแทนที่เมื่อแสดงผล ใช้ <code>\{{var}}</code> เพื่อแสดงตัวแปรตามตัวอักษร',
        'rich_editor_tip' => 'หากตัวแก้ไขไม่ตอบสนอง ให้สลับไปที่โหมด HTML ดิบ แล้วกลับมาเพื่อรีเซ็ต',
        'content_preview' => 'ตัวอย่างเนื้อหา',
        'content_preview_description' => 'ดูว่าเอกสารจะปรากฏต่อผู้ใช้อย่างไร (พร้อมประมวลผลตัวแปร)',
        'content_preview_empty' => 'ป้อนเนื้อหาด้านบนเพื่อดูตัวอย่าง',
    ],

    'variables' => [
        'title' => 'ตัวแปรที่ใช้ได้',
        'show_available' => 'แสดงตัวแปรที่ใช้ได้',
        'escape_hint' => 'หากต้องการแสดงตัวแปรตามตัวอักษรโดยไม่ต้องแทนที่ ให้ใส่เครื่องหมาย backslash นำหน้า: \\{{user.name}}',
        'user_name' => 'ชื่อที่แสดงของผู้ใช้ปัจจุบัน',
        'user_username' => 'ชื่อผู้ใช้ของผู้ใช้ปัจจุบัน',
        'user_email' => 'อีเมลของผู้ใช้ปัจจุบัน',
        'user_id' => 'ID ของผู้ใช้ปัจจุบัน',
        'server_name' => 'ชื่อเซิร์ฟเวอร์',
        'server_uuid' => 'UUID ของเซิร์ฟเวอร์',
        'server_id' => 'ID ของเซิร์ฟเวอร์',
        'server_egg' => 'ชื่อประเภทเกม (Egg) ของเซิร์ฟเวอร์',
        'server_node' => 'ชื่อโหนด (Node)',
        'server_memory' => 'หน่วยความจำที่จัดสรร (MB)',
        'server_disk' => 'ดิสก์ที่จัดสรร (MB)',
        'server_cpu' => 'ขีดจำกัด CPU (%)',
        'date' => 'วันที่ปัจจุบัน (Y-m-d)',
        'time' => 'เวลาปัจจุบัน (H:i)',
        'datetime' => 'วันที่และเวลาปัจจุบัน',
        'year' => 'ปีปัจจุบัน',
    ],

    'server' => [
        'node' => 'โหนด (Node)',
        'owner' => 'เจ้าของ',
    ],

    'table' => [
        'servers' => 'เซิร์ฟเวอร์',
        'updated_at' => 'อัปเดตเมื่อ',
        'type' => 'ประเภท',
        'unknown' => 'ไม่ทราบ',
        'empty_heading' => 'ยังไม่มีเอกสาร',
        'empty_description' => 'สร้างเอกสารฉบับแรกของคุณเพื่อเริ่มต้น',
    ],

    'permission_guide' => [
        'title' => 'คู่มือการมองเห็น',
        'modal_heading' => 'คู่มือการมองเห็นเอกสาร',
        'description' => 'ทำความเข้าใจเกี่ยวกับการมองเห็นเอกสาร',
        'intro' => 'เอกสารมีมิติการมองเห็นสองแบบ: ตำแหน่งที่ปรากฏ (เซิร์ฟเวอร์) และผู้ที่สามารถมองเห็นได้ (บุคคล)',
        'server_description' => 'ควบคุมว่าเซิร์ฟเวอร์ใดแสดงเอกสารนี้:',
        'all_servers_desc' => 'เอกสารปรากฏบนทุกเซิร์ฟเวอร์',
        'eggs_desc' => 'เอกสารปรากฏบนเซิร์ฟเวอร์ทั้งหมดที่ใช้ประเภทเกมที่เลือก',
        'servers_desc' => 'เอกสารปรากฏเฉพาะบนเซิร์ฟเวอร์ที่เลือกไว้เท่านั้น',
        'person_description' => 'ควบคุมว่าใครสามารถดูเอกสารนี้ได้:',
        'roles_desc' => 'เฉพาะผู้ใช้ที่มีบทบาทที่เลือกเท่านั้นที่สามารถดูได้',
        'users_desc' => 'เฉพาะผู้ใช้ที่ระบุไว้เท่านั้นที่สามารถดูได้',
        'everyone_desc' => 'หากไม่ได้เลือกบทบาทหรือผู้ใช้ ทุกคนที่มีสิทธิ์เข้าถึงเซิร์ฟเวอร์จะสามารถดูได้',
        'admin_note' => 'ผู้ดูแลระบบระดับสูง (Root Admins) สามารถดูเอกสารทั้งหมดได้เสมอโดยไม่คำนึงถึงการตั้งค่าการมองเห็น',
    ],

    'messages' => [
        'version_restored' => 'กู้คืนเวอร์ชัน :version สำเร็จแล้ว',
        'no_documents' => 'ไม่มีเอกสารที่ใช้ได้',
        'no_versions' => 'ยังไม่มีเวอร์ชัน',
    ],

    'versions' => [
        'title' => 'ประวัติเวอร์ชัน',
        'current_document' => 'เอกสารปัจจุบัน',
        'current_version' => 'เวอร์ชันปัจจุบัน',
        'last_updated' => 'อัปเดตล่าสุด',
        'last_edited_by' => 'แก้ไขล่าสุดโดย',
        'version_number' => 'เวอร์ชัน',
        'edited_by' => 'แก้ไขโดย',
        'date' => 'วันที่',
        'change_summary' => 'สรุปการเปลี่ยนแปลง',
        'preview' => 'ดูตัวอย่าง',
        'restore' => 'กู้คืน',
        'restore_confirm' => 'คุณแน่ใจหรือไม่ว่าต้องการกู้คืนเวอร์ชันนี้? การดำเนินการนี้จะสร้างเวอร์ชันใหม่ที่มีเนื้อหาที่กู้คืน',
        'restored' => 'กู้คืนเวอร์ชันสำเร็จแล้ว',
    ],

    'server_panel' => [
        'title' => 'เอกสารของเซิร์ฟเวอร์',
        'no_documents' => 'ไม่มีเอกสาร',
        'no_documents_description' => 'ยังไม่มีเอกสารสำหรับเซิร์ฟเวอร์นี้',
        'select_document' => 'เลือกเอกสาร',
        'select_document_description' => 'เลือกเอกสารจากรายการเพื่อดูเนื้อหา',
        'last_updated' => 'อัปเดตล่าสุดเมื่อ :time',
        'global' => 'Global (ส่วนกลาง)',
    ],

    'actions' => [
        'new_document' => 'สร้างเอกสารใหม่',
        'export' => 'ส่งออกเป็น Markdown',
        'export_json' => 'ส่งออกข้อมูลสำรอง',
        'export_json_button' => 'ส่งออกเป็น JSON',
        'import' => 'นำเข้า Markdown',
        'import_json' => 'นำเข้าข้อมูลสำรอง',
        'back_to_document' => 'กลับไปที่เอกสาร',
        'close' => 'ปิด',
    ],

    'import' => [
        'file_label' => 'ไฟล์ Markdown',
        'file_helper' => 'อัปโหลดไฟล์ .md เพื่อสร้างเอกสารใหม่',
        'json_file_label' => 'ไฟล์สำรอง JSON',
        'json_file_helper' => 'อัปโหลดไฟล์สำรอง JSON ที่ส่งออกจากปลั๊กอินนี้',
        'use_frontmatter' => 'ใช้ YAML Frontmatter',
        'use_frontmatter_helper' => 'ดึงหัวข้อและการตั้งค่าจาก YAML frontmatter หากมี',
        'overwrite_existing' => 'เขียนทับเอกสารที่มีอยู่',
        'overwrite_existing_helper' => 'หากเปิดใช้งาน เอกสารที่มี UUID ตรงกันจะได้รับการอัปเดต มิฉะนั้นจะถูกข้าม',
        'success' => 'นำเข้าเอกสารแล้ว',
        'success_body' => 'สร้างเอกสาร ":title" สำเร็จแล้ว',
        'json_success' => 'นำเข้า :imported รายการ, อัปเดต :updated รายการ, ข้าม :skipped รายการ',
        'error' => 'การนำเข้าล้มเหลว',
        'file_too_large' => 'ไฟล์ที่อัปโหลดมีขนาดเกินขีดจำกัดที่อนุญาต',
        'file_read_error' => 'ไม่สามารถอ่านไฟล์ที่อัปโหลดได้',
        'invalid_json' => 'ไฟล์ JSON ไม่ถูกต้องหรือไม่มีอาร์เรย์เอกสาร',
        'unresolved_roles' => 'ไม่พบข้อมูลบทบาทบางส่วนจาก frontmatter: :roles',
        'unresolved_users' => 'ไม่พบข้อมูลผู้ใช้บางส่วนจาก frontmatter: :users',
        'unresolved_eggs' => 'ไม่พบข้อมูล Eggs บางส่วนจาก frontmatter: :eggs',
        'unresolved_servers' => 'ไม่พบข้อมูลเซิร์ฟเวอร์บางส่วนจาก frontmatter: :servers',
    ],

    'export' => [
        'success' => 'ส่งออกเอกสารแล้ว',
        'success_body' => 'ดาวน์โหลดเอกสารเป็น Markdown แล้ว',
        'modal_heading' => 'ส่งออกเอกสารทั้งหมด',
        'modal_description' => 'การดำเนินการนี้จะส่งออกเอกสารทั้งหมดพร้อมการกำหนดค่าทั้งหมด (เซิร์ฟเวอร์, Eggs, บทบาท, ผู้ใช้ และประวัติเวอร์ชัน) เป็นไฟล์ JSON ที่สามารถนำเข้าใหม่ได้ในภายหลัง',
    ],

    'relation_managers' => [
        'linked_servers' => 'เซิร์ฟเวอร์ที่เชื่อมโยง',
        'no_servers_linked' => 'ไม่มีเซิร์ฟเวอร์ที่เชื่อมโยง',
        'attach_servers_description' => 'แนบเซิร์ฟเวอร์เพื่อให้เอกสารนี้มองเห็นได้บนเซิร์ฟเวอร์เหล่านั้น',
        'no_documents_linked' => 'ไม่มีเอกสารที่เชื่อมโยง',
        'attach_documents_description' => 'แนบเอกสารเพื่อให้มองเห็นได้บนเซิร์ฟเวอร์นี้',
        'sort_order_helper' => 'ลำดับที่เอกสารนี้ปรากฏสำหรับเซิร์ฟเวอร์นี้',
    ],
];