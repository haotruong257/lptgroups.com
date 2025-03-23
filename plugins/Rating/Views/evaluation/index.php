<h2>Chấm điểm nhân viên</h2>
<a href="<?= site_url('category') ?>">
    <button> Quản Lý Danh Mục Tiêu Chí Đánh Giá</button>
</a>

<h2><?php echo app_lang("list_criteria"); ?></h2>
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
        $displayedCategories = []; // Mảng để theo dõi category đã hiển thị
        foreach ($criteria as $index => $row):
        ?>
            <tr>
                <?php if (!in_array($row['category_id'], $displayedCategories)): ?>
                    <td rowspan="<?php echo count(array_filter($criteria, fn($item) => $item['category_id'] === $row['category_id'])); ?>">
                        <strong><?php echo $row['category_name']; ?></strong>
                    </td>
                    <?php $displayedCategories[] = $row['category_id']; ?>
                <?php endif; ?>

                <td><?php echo $row['id'] ?? '-'; ?></td>
                <td><?php echo !empty($row['noi_dung']) ? nl2br($row['noi_dung']) : '<em>Chưa có nội dung</em>'; ?></td>

                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <td class="text-center">
                        <input type="radio" name="score[<?php echo $row['id'] ?? '0'; ?>]" value="<?php echo $i; ?>">
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>