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
if (!function_exists('add_setting')) {
    function add_setting($name, $value = '')
    {
        global $db;
        if (!setting_exists($name)) {
            $db->table(get_db_prefix() . 'settings')->insert([
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
if (!function_exists('setting_exists')) {
    function setting_exists($name)
    {
        global $db;
        return $db->table(get_db_prefix() . 'settings')->where('setting_name', $name)->countAllResults() > 0;
    }
}

/**
 * Kiểm tra bảng có tồn tại hay không
 */
function table_exists($table)
{
    $db = Config::connect(); // Kết nối database
    return $db->tableExists($table); // Sử dụng tableExists() của CodeIgniter
}

// Tạo bảng nếu chưa tồn tại
$tables = [
    // Bảng tieu_chi (tương ứng với evaluation_criteria_categories)
    "evaluation_criteria_categories" => "CREATE TABLE `{$dbprefix}evaluation_criteria_categories` (
        `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL, -- Sửa BIGINT? thành VARCHAR theo logic
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",

    // Bảng noi_dung_danh_gia (tương ứng với evaluation_criteria)
    "evaluation_criteria" => "CREATE TABLE `{$dbprefix}evaluation_criteria` (
        `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        `id_tieu_chi` BIGINT UNSIGNED NOT NULL, -- Đổi tên category_id thành id_tieu_chi theo diagram
        `noi_dung` TEXT NOT NULL, -- Sửa BIGINT? thành TEXT
        `thu_tu_sap_xep` BIGINT NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`id_tieu_chi`) REFERENCES `{$dbprefix}evaluation_criteria_categories`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",

    // Bảng phieu_cham_cong (sửa kiểu dữ liệu của created_id và approve_id thành INT để khớp với bảng users)
    "phieu_cham_cong" => "CREATE TABLE `{$dbprefix}phieu_cham_cong` (
        `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        `created_id` INT NOT NULL,
        `created_at` DATETIME,
        `approve_id` INT,
        `approve_at` DATETIME,
      `trang_thai` TINYINT NOT NULL DEFAULT 1 COMMENT '1: Pending, 2: Approve, 3: Reject',
        `tong_diem` BIGINT,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`created_id`) REFERENCES `{$dbprefix}users`(`id`) ON DELETE RESTRICT,
        FOREIGN KEY (`approve_id`) REFERENCES `{$dbprefix}users`(`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",

    // Bảng chi_tiet_phieu_cham_cong (sửa kiểu dữ liệu của id_phieu_cham_cong thành BIGINT UNSIGNED để khớp với id của phieu_cham_cong)
    "chi_tiet_phieu_cham_cong" => "CREATE TABLE `{$dbprefix}chi_tiet_phieu_cham_cong` (
        `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        `id_noi_dung_danh_gia` BIGINT UNSIGNED NOT NULL,
        `diem_so` BIGINT NOT NULL CHECK (`diem_so` BETWEEN 1 AND 5),
        `id_phieu_cham_cong` BIGINT UNSIGNED NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`id_noi_dung_danh_gia`) REFERENCES `{$dbprefix}evaluation_criteria`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`id_phieu_cham_cong`) REFERENCES `{$dbprefix}phieu_cham_cong`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
];

// Tạo các bảng
foreach ($tables as $table => $query) {
    if (!table_exists($dbprefix . $table)) {
        $db->query($query);
    }
}

// Tạo chỉ mục để tối ưu hóa
$indexes = [
    "CREATE INDEX idx_evaluation_criteria_categories_name ON `{$dbprefix}evaluation_criteria_categories`(name);",
    "CREATE INDEX idx_evaluation_criteria_id_tieu_chi ON `{$dbprefix}evaluation_criteria`(id_tieu_chi);",
    "CREATE INDEX idx_chi_tiet_phieu_cham_cong_id_phieu ON `{$dbprefix}chi_tiet_phieu_cham_cong`(id_phieu_cham_cong);",
    "CREATE INDEX idx_chi_tiet_phieu_cham_cong_id_noi_dung ON `{$dbprefix}chi_tiet_phieu_cham_cong`(id_noi_dung_danh_gia);"
];

foreach ($indexes as $indexQuery) {
    $db->query($indexQuery);
}

// 2. Thêm danh mục tiêu chí đánh giá (tương ứng với bảng tieu_chi)
$categories = [
    'Chuyên Cần Và Tác Phong',
    'Chuyên Môn Hiệu Quả Công Việc Kỹ Năng Khác',
    'Kỹ năng quản lý'
];

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
$query = $db->query("SELECT id, name FROM `{$dbprefix}evaluation_criteria_categories`;");
foreach ($query->getResult() as $row) {
    $categoryMap[$row->name] = $row->id;
}

// 3. Thêm tiêu chí đánh giá (tương ứng với bảng noi_dung_danh_gia)
$evaluationCriteria = [
    'Chuyên Cần Và Tác Phong' => [
        ['noiDung' => 'Đi làm đúng giờ\n- Được phép đi trễ tối đa 30p/tháng, không quá 10p/lần: không xin phép\n- Được phép trễ tối đa 60p/tháng: Có xin duyệt\n- Được phép về sớm tối đa 60p/tháng: Có xin duyệt', 'thuTuSapXep' => 1],
        ['noiDung' => 'Đi làm đầy đủ: đủ công trên tháng, không nghỉ việc\nriêng quá 01 ngày/tháng. (Tính trên check in-out)\nTrừ các trường hợp sau, khi nghỉ không ảnh hưởng\ndiểm chung:\n- Việc hiếu, hỷ theo Luật Lao Động.\n- Bệnh có giấy Bệnh Viện\n- Nghỉ phép năm', 'thuTuSapXep' => 2],
        ['noiDung' => 'Tuân thủ nội quy quy định công ty, không vi phạm kỷ luật.', 'thuTuSapXep' => 3],
        ['noiDung' => 'Tác phong gọn gàng: quần áo, tóc tai,...', 'thuTuSapXep' => 4],
        ['noiDung' => 'Tập trung làm việc, không trì hoãn: luôn check mail, nắm được các thông báo- thay đổi trong quy trình làm việc, nắm được các thông tin từ công ty, ....', 'thuTuSapXep' => 5],
        ['noiDung' => 'Giữ vệ sinh nơi làm việc: bàn làm việc gọn gàng, tắt điện quạt khi không sử dụng,...', 'thuTuSapXep' => 6],
        ['noiDung' => 'Luôn có kế hoạch làm việc phù hợp với các công việc được giao', 'thuTuSapXep' => 7],
        ['noiDung' => 'Có tinh thần cầu tiến trong công việc, tích cực, tử tế, ...', 'thuTuSapXep' => 8],
        ['noiDung' => 'Hòa đồng, vui vẻ, xây dựng mối quan hệ tốt với đồng nghiệp', 'thuTuSapXep' => 9],
        ['noiDung' => 'Luôn có thái độ lắng nghe, tiếp thu, phản hồi, góp ý và cải thiện.', 'thuTuSapXep' => 10],
    ],
    'Chuyên Môn Hiệu Quả Công Việc Kỹ Năng Khác' => [
        ['noiDung' => 'Có chuyên môn tại vị trí đảm nhiệm', 'thuTuSapXep' => 1],
        ['noiDung' => '"Mức độ hoàn thành KPI được giao: 100%, 80%, 70%,….\n"
    "✓ <b>100%</b> trở lên: Vượt chỉ tiêu, xuất sắc.\n"
    "✓ <b>80% - 99%</b>: Đạt yêu cầu, hoàn thành tốt công việc.\n"
    "✓ <b>50% - 79%</b>: Dưới mức mong đợi, cần cải thiện.\n"
    "✓ <b>Dưới 50%</b>: Kém, chưa đáp ứng yêu cầu."', 'thuTuSapXep' => 2],
        ['noiDung' => 'Hoàn thành đúng tiến độ đề ra (deadline công việc, dự án)', 'thuTuSapXep' => 3],
        ['noiDung' => 'Kỹ năng làm việc nhóm và hợp tác với các nhân sự/phòng ban', 'thuTuSapXep' => 4],
        ['noiDung' => 'Kỹ năng làm việc độc lập', 'thuTuSapXep' => 5],
        ['noiDung' => 'Khả năng giao tiếp, báo cáo, trình bày, thuyết trình...', 'thuTuSapXep' => 6],
        ['noiDung' => 'Khả năng thích ứng, linh hoạt với công việc', 'thuTuSapXep' => 7],
        ['noiDung' => 'Đóng góp vào dự án chung', 'thuTuSapXep' => 8],
        ['noiDung' => 'Chất lượng công việc: Không bị Khách hàng/nhân sự khác phản ánh, Ít sai sót trong công việc', 'thuTuSapXep' => 9],
        ['noiDung' => 'Sáng kiến hỗ trợ cải thiện quy trình làm việc hoặc hỗ trợ công việc tốt hơn', 'thuTuSapXep' => 10],
    ],
    'Kỹ năng quản lý' => [
        ['noiDung' => 'Kỹ năng lãnh đạo đội nhóm: Điều phối dự án, Phân chia, sắp xếp công việc', 'thuTuSapXep' => 1],
        ['noiDung' => 'Kỹ năng giao tiếp và truyền đạt, thuyết trình, đảm phấn', 'thuTuSapXep' => 2],
        ['noiDung' => 'Tự dự chiến lược và lập kế hoạch công việc', 'thuTuSapXep' => 3],
        ['noiDung' => 'Khả năng phân tích sự việc và giải quyết vấn đề', 'thuTuSapXep' => 4],
        ['noiDung' => 'Tình chủ động, trách nhiệm với công việc, đội nhóm và cấp trên.', 'thuTuSapXep' => 5],
        ['noiDung' => 'Khả năng đào tạo nhân sự', 'thuTuSapXep' => 6],
        ['noiDung' => 'Tình thích nghi, sáng tạo và mạo hiểm trong dẫn dắt đội nhóm', 'thuTuSapXep' => 7],
        ['noiDung' => 'Kỹ năng báo cáo', 'thuTuSapXep' => 8],
        ['noiDung' => 'Khả năng truyền động lực, cảm hứng làm việc cho nhân sự', 'thuTuSapXep' => 9],
        ['noiDung' => 'Khả năng chịu áp lực', 'thuTuSapXep' => 10],
    ]
];

// Thêm tiêu chí đánh giá
foreach ($evaluationCriteria as $categoryName => $criteriaList) {
    if (!isset($categoryMap[$categoryName])) continue;
    $categoryId = $categoryMap[$categoryName];

    foreach ($criteriaList as $criteria) {
        // Kiểm tra xem tiêu chí đã tồn tại chưa
        $exists = $db->query(
            "SELECT COUNT(*) AS count FROM `{$dbprefix}evaluation_criteria` WHERE id_tieu_chi = ? AND noi_dung = ? AND thu_tu_sap_xep = ?",
            [$categoryId, $criteria['noiDung'], $criteria['thuTuSapXep']]
        )->getRow()->count;

        if ($exists == 0) {
            // Chỉ chèn nếu tiêu chí chưa tồn tại
            $db->query(
                "INSERT INTO `{$dbprefix}evaluation_criteria` (`id_tieu_chi`, `noi_dung`, `thu_tu_sap_xep`) VALUES (?, ?, ?)",
                [$categoryId, $criteria['noiDung'], $criteria['thuTuSapXep']]
            );
        }
    }
}
// 4. Thêm dữ liệu vào bảng phieu_cham_cong (không gán điểm số, để trống tong_diem)
$db->query(
    "INSERT INTO `{$dbprefix}phieu_cham_cong` (`created_id`, `approve_id`, `approve_at`, `trang_thai`, `tong_diem`) VALUES (?, ?, ?, ?, ?)",
    [2, 3, '2025-03-24 10:00:00', 2, NULL]
);

// 5. Bỏ qua việc chèn dữ liệu vào bảng chi_tiet_phieu_cham_cong
// Dữ liệu điểm số sẽ được thêm sau thông qua giao diện hoặc logic khác