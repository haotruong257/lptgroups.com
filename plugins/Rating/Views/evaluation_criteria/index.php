<h2>Chấm điểm nhân viên</h2>
<h2><?php echo app_lang("list_criteria"); ?></h2>
<?php echo form_open(get_uri("phieu_cham_cong/create"), array("id" => "phieu-cham-cong", "class" => "general-form", "role" => "form")); ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">TIÊU CHÍ</th>
            <th rowspan="2">STT</th>
            <th rowspan="2">NỘI DUNG ĐÁNH GIÁ</th>
            <th colspan="5" class="text-center">Điểm</th>
        </tr>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $displayedCategories = []; // Mảng theo dõi danh mục đã hiển thị
        $stt = 1; // Số thứ tự tiêu chí

        // Nhóm các tiêu chí theo danh mục
        $criteriaByCategory = [];
        foreach ($criteria as $row) {
            $categoryId = $row['id_tieu_chi'];
            if (!isset($criteriaByCategory[$categoryId])) {
                $criteriaByCategory[$categoryId] = [
                    'name' => $row['category_name'] ?? 'Chưa phân loại',
                    'items' => []
                ];
            }
            $criteriaByCategory[$categoryId]['items'][] = $row;
        }

        foreach ($criteriaByCategory as $categoryId => $categoryData):
            $categoryName = $categoryData['name'];
            $items = $categoryData['items'];
        ?>
            <?php foreach ($items as $index => $row): ?>
                <tr>
                    <?php if ($index === 0): // Chỉ hiển thị danh mục ở dòng đầu tiên của nhóm 
                    ?>
                        <td rowspan="<?= count($items) ?>">
                            <strong><?= htmlspecialchars($categoryName) ?></strong>
                        </td>
                    <?php endif; ?>

                    <td><?= $row['thu_tu_sap_xep'] ?></td>

                    <td><?= !empty($row['noi_dung']) ? nl2br(htmlspecialchars($row['noi_dung'])) : '<em>Chưa có nội dung</em>' ?></td>

                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <td class="text-center">
                            <input type="radio" name="score[<?= $row['id'] ?>]" value="<?= $i ?>">
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<button type="submit" class="btn btn-primary">Lưu điểm</button>
<?php echo form_close(); ?>