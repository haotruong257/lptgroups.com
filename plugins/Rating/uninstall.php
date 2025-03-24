<?php

$db = db_connect('default');
$dbprefix = get_db_prefix();

// Xóa các bảng theo thứ tự ngược lại với thứ tự tạo để tránh lỗi khóa ngoại
// Thứ tự: chi_tiet_phieu_cham_cong -> phieu_cham_cong -> evaluation_criteria -> evaluation_criteria_categories -> user

// Xóa bảng chi_tiet_phieu_cham_cong
if ($db->tableExists($dbprefix . 'chi_tiet_phieu_cham_cong')) {
    $db->query('DROP TABLE `' . $dbprefix . 'chi_tiet_phieu_cham_cong`;');
}

// Xóa bảng phieu_cham_cong
if ($db->tableExists($dbprefix . 'phieu_cham_cong')) {
    $db->query('DROP TABLE `' . $dbprefix . 'phieu_cham_cong`;');
}

// Xóa bảng evaluation_criteria (tương ứng với noi_dung_danh_gia)
if ($db->tableExists($dbprefix . 'evaluation_criteria')) {
    $db->query('DROP TABLE `' . $dbprefix . 'evaluation_criteria`;');
}

// Xóa bảng evaluation_criteria_categories (tương ứng với tieu_chi)
if ($db->tableExists($dbprefix . 'evaluation_criteria_categories')) {
    $db->query('DROP TABLE `' . $dbprefix . 'evaluation_criteria_categories`;');
}

// Xóa bảng user
if ($db->tableExists($dbprefix . 'user')) {
    $db->query('DROP TABLE `' . $dbprefix . 'user`;');
}
