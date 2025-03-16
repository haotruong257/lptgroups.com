<?php

use CodeIgniter\Database\Config;
$db = db_connect('default');
$dbprefix = get_db_prefix();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Thêm setting mới nếu chưa tồn tại
 */
if (!function_exists(function: 'add_setting')) {
    function add_setting($name, $value = '')
    {
        global $db;
        if (!setting_exists($name)) {
            $db->table(tableName: get_db_prefix() . 'settings')->insert([
                'setting_name'  => $name,
                'setting_value' => $value
            ]);
            return $db->insertID() ? true : false;
        }
        return false;
    }
}

/**
 * Kiểm tra setting có tồn tại không
 */
if (!function_exists(function: 'setting_exists')) {
    function setting_exists($name)
    {
        global $db;
        return $db->table(tableName: get_db_prefix() . 'settings')->where('setting_name',  $name)->countAllResults() > 0;
    }
}

/**
 * Kiểm tra bảng có tồn tại hay không
 */


function table_exists($table)
{
    $db = Config::connect(); // Kết nối database
    return $db->query("SHOW TABLES LIKE '{$table}'")->getNumRows() > 0;
}


// Tạo bảng nếu chưa tồn tại
$tables = [
    "evaluation_criteria_categories" => "CREATE TABLE `{$dbprefix}evaluation_criteria_categories` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` varchar(200) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
    "evaluation_criteria" => "CREATE TABLE `{$dbprefix}evaluation_criteria` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `category_id` int(11) UNSIGNED NOT NULL,
        `noi_dung` varchar(500) NOT NULL,
        `diem` int(11) NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`category_id`) REFERENCES `{$dbprefix}evaluation_criteria_categories`(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
    "evaluation_criteria_details" => "CREATE TABLE `{$dbprefix}evaluation_criteria_details` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `criteria_id` int(11) UNSIGNED NOT NULL,
        `chi_tiet` text NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`criteria_id`) REFERENCES `{$dbprefix}evaluation_criteria`(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
];

foreach ($tables as $table => $query) {
    if (!table_exists($dbprefix . $table)) {
        $db->query($query);
    }
}

// Thêm danh mục tiêu chí đánh giá
$categories = ['Chuyên Cần Và Tác Phong', 'Chuyên Môn Hiệu Quả Công Việc Kỹ Năng Khác'];
foreach ($categories as $category) {
    $exists = $db->query("SELECT COUNT(*) AS count FROM `{$dbprefix}evaluation_criteria_categories` WHERE name = ?", [$category])
        ->getRow()
        ->count;
    if ($exists == 0) {
        $db->query("INSERT INTO `{$dbprefix}evaluation_criteria_categories` (`name`) VALUES (?)", [$category]);
    }
}

// Lấy ID của danh mục
$categoryMap = [];
$query = $db->query(sql: "SELECT id, name FROM `{$dbprefix}evaluation_criteria_categories`;");
foreach ($query->getResult() as $row) {
    $categoryMap[$row->name] = $row->id;
}

// Dữ liệu tiêu chí đánh giá
$evaluationCriteria = [
    'Chuyên Cần Và Tác Phong' => [
        [
            'noiDung' => "Đi làm đúng giờ",
            'diem' => null,
            'chiTiet' => [
                "Được phép đi trễ tối đa 30p/tháng, không quá 10p/lần: không xin phép",
                "Được phép trễ tối đa 60p/tháng: Có xin duyệt",
                "Được phép về sớm tối đa 60p/tháng: Có xin duyệt"
            ]
        ]
    ],
    'Chuyên Môn Hiệu Quả Công Việc Kỹ Năng Khác' => [
        [
            'noiDung' => "Có chuyên môn tại vị trí đảm nhiệm",
            'diem' => null,
            'chiTiet' => []
        ]
    ]
];

// Thêm tiêu chí đánh giá và chi tiết
foreach ($evaluationCriteria as $categoryName => $criteriaList) {
    if (!isset($categoryMap[$categoryName])) continue;
    $categoryId = $categoryMap[$categoryName];

    foreach ($criteriaList as $criteria) {
        $db->query("INSERT INTO `{$dbprefix}evaluation_criteria` (`category_id`, `noi_dung`, `diem`) VALUES (?, ?, ?)", [$categoryId, $criteria['noiDung'], $criteria['diem']]);
        $criteriaId = $db->insertID();

        foreach ($criteria['chiTiet'] as $chiTiet) {
            $db->query("INSERT INTO `{$dbprefix}evaluation_criteria_details` (`criteria_id`, `chi_tiet`) VALUES (?, ?)",  [$criteriaId, $chiTiet]);
        }
    }
}

