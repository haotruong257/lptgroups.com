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


// //Tạo bảng nếu chưa tồn tại
// $tables = [
//     "evaluation_criteria_categories" => "CREATE TABLE `{$dbprefix}evaluation_criteria_categories` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `name` varchar(200) NOT NULL,
//         PRIMARY KEY (`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
//     "evaluation_criteria" => "CREATE TABLE `{$dbprefix}evaluation_criteria` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `category_id` int(11) UNSIGNED NOT NULL,
//         `noi_dung` varchar(500) NOT NULL,
//         `diem` int(11) NULL,
//         PRIMARY KEY (`id`),
//         FOREIGN KEY (`category_id`) REFERENCES `{$dbprefix}evaluation_criteria_categories`(`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
//     "evaluation_criteria_details" => "CREATE TABLE `{$dbprefix}evaluation_criteria_details` (
//         `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//         `criteria_id` int(11) UNSIGNED NOT NULL,
//         `chi_tiet` text NOT NULL,
//         PRIMARY KEY (`id`),
//         FOREIGN KEY (`criteria_id`) REFERENCES `{$dbprefix}evaluation_criteria`(`id`)
//     ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
// ];

$tables = [
    //Bảng Danh Mục 
    "evaluation_criteria_categories" => "CREATE TABLE `{$dbprefix}evaluation_criteria_categories` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` varchar(200) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
    //Bảng tiêu chí đánh giá 
    "evaluation_criteria" => "CREATE TABLE `{$dbprefix}evaluation_criteria` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `category_id` int(11) UNSIGNED NOT NULL,
        `content` varchar(500) NOT NULL,
        `score_id` int(11) UNSIGNED NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`category_id`) REFERENCES `{$dbprefix}evaluation_criteria_categories`(`id`),
        FOREIGN KEY (`score_id`) REFERENCES `{$dbprefix}evaluation_scores`(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
    //bảng chi tiết tiêu chí đánh giá
    "evaluation_criteria_details" => "CREATE TABLE `{$dbprefix}evaluation_criteria_details` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `criteria_id` int(11) UNSIGNED NOT NULL,
        `chi_tiet` text NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`criteria_id`) REFERENCES `{$dbprefix}evaluation_criteria`(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
    //Bảng điểm của từng tiêu chí
    "evaluation_scores" => "CREATE TABLE `{$dbprefix}evaluation_scores` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` int(11) UNSIGNED NOT NULL,
        `criteria_id` int(11) UNSIGNED NOT NULL,
        `score` int(11) NOT NULL,
        `period` varchar(50) NOT NULL,
        `evaluation_date` DATE NOT NULL,
        `status` ENUM('Pending', 'Approved', 'Declined') NOT NULL DEFAULT 'Pending',
        PRIMARY KEY (`id`),
        FOREIGN KEY (`user_id`) REFERENCES `{$dbprefix}users`(`id`),
        FOREIGN KEY (`criteria_id`) REFERENCES `{$dbprefix}evaluation_criteria`(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
    //Bảng tổng hợp điểm
    "evaluation_summary" => "CREATE TABLE `{$dbprefix}evaluation_summary` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` int(11) UNSIGNED NOT NULL,
        `period` varchar(50) NOT NULL,
        `total_score` int(11) NOT NULL,
        `summary_content` TEXT NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`user_id`) REFERENCES `{$dbprefix}users`(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
];

/*
    //Relation table
    evaluation_criteria_categories 1:n Evaluation_criteria 
    evaluation_criteria_details 1:1  Evaluation_criteria 
    Evaluation_criteria 1 :n Evaluation_scores :n User
    Evaluation_scores 1:1 Evaluation_criteria
    Evaluation_summary 1:n Evaluation_scores
    user 1:n Evaluation_scores
*/

foreach ($tables as $table => $query) {
    if (!table_exists($dbprefix . $table)) {
        $db->query($query);
    }
}

// Thêm danh mục tiêu chí đánh giá
$categories = ['Chuyên Cần Và Tác Phong', 'Chuyên Môn Hiệu Quả Công Việc Kỹ Năng Khác', 'Kỹ năng quản lý'];
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
    ],
    'Kỹ năng quản lý' => [
        [
            'noiDung' => "Kỹ năng lãnh đạo đội nhóm: ",
            'diem' => null,
            'chiTiet' => [' Điều phối dự án ', 'Phân chia, sắp xếp công việc']
        ]
    ]
];

// Thêm tiêu chí đánh giá và chi tiết
foreach ($evaluationCriteria as $categoryName => $criteriaList) {
    if (!isset($categoryMap[$categoryName])) continue;
    $categoryId = $categoryMap[$categoryName];

    foreach ($criteriaList as $criteria) {
        $db->query("INSERT INTO `{$dbprefix}evaluation_criteria` (`category_id`, `noi_dung`, `diem`) VALUES (?, ?, ?)", binds: [$categoryId, $criteria['noiDung'], $criteria['diem']]);
        $criteriaId = $db->insertID();

        foreach ($criteria['chiTiet'] as $chiTiet) {
            $db->query("INSERT INTO `{$dbprefix}evaluation_criteria_details` (`criteria_id`, `chi_tiet`) VALUES (?, ?)",  [$criteriaId, $chiTiet]);
        }
    }
}
