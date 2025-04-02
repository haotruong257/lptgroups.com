<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa phiếu chấm công</title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .radio-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <section class="page-wrapper clearfix">
        <div class="card px-3 py-2">
            <h2 class="mb-3">Chỉnh sửa phiếu chấm công</h2>
            <div class="mb-3">
                <a href="<?= get_uri('phieu_cham_cong') ?>" class="btn btn-info">Quay lại danh sách</a>
                <button type="button" class="btn btn-info" id="showRulesBtn">Luật chấm điểm</button>
            </div>

            <?php echo form_open(get_uri("phieu_cham_cong/update/" . $phieu['id']), array("id" => "phieu-cham-cong", "class" => "general-form", "role" => "form")); ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <!-- Giữ nguyên phần table như trước -->
                    <thead class="table-light">
                        <tr>
                            <th rowspan="2" class="align-middle">TIÊU CHÍ</th>
                            <th rowspan="2" class="align-middle">STT</th>
                            <th rowspan="2" class="align-middle">NỘI DUNG ĐÁNH GIÁ</th>
                            <th colspan="5" class="text-center">Điểm</th>
                        </tr>
                        <tr>
                            <th class="text-center">1</th>
                            <th class="text-center">2</th>
                            <th class="text-center">3</th>
                            <th class="text-center">4</th>
                            <th class="text-center">5</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Chọn tất cả:</th>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <th class="text-center">
                                    <input type="radio" name="select_all" value="<?= $i ?>" class="select-all-radio">
                                </th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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
                                    <?php if ($index === 0): ?>
                                        <td rowspan="<?= count($items) ?>" class="align-middle fw-bold">
                                            <?= htmlspecialchars($categoryName) ?>
                                        </td>
                                    <?php endif; ?>

                                    <td class="align-middle"><?= $row['thu_tu_sap_xep'] ?></td>
                                    <td class="align-middle">
                                        <?= !empty($row['noi_dung']) ? nl2br($row['noi_dung']) : '<em>Chưa có nội dung</em>' ?>
                                    </td>

                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <td class="text-center">
                                            <div class="radio-center">
                                                <input type="radio" class="form-check-input score-radio"
                                                    name="score[<?= $row['id'] ?>]"
                                                    value="<?= $i ?>"
                                                    id="score_<?= $row['id'] ?>_<?= $i ?>"
                                                    <?= isset($scores[$row['id']]) && $scores[$row['id']] == $i ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="score_<?= $row['id'] ?>_<?= $i ?>"></label>
                                            </div>
                                        </td>
                                    <?php endfor; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Cập nhật điểm</button>
            <?php echo form_close(); ?>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Import component rating_rules.js -->
    <script src="<?= base_url('plugins/Rating/assets/js/rating_rules.js') ?>"></script>
    <script>
        // Chọn tất cả
        document.querySelectorAll('.select-all-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const value = parseInt(this.value);
                document.querySelectorAll('.score-radio').forEach(scoreRadio => {
                    if (parseInt(scoreRadio.value) === value) {
                        scoreRadio.checked = true;
                    }
                });
            });
        });

        // Gọi hàm từ component
        document.getElementById('showRulesBtn').addEventListener('click', function() {
            showRatingRules();
        });
    </script>

    <?php if (session()->has('popup')): ?>
        <?php $popup = session()->get('popup'); ?>
        <script>
            Swal.fire({
                icon: '<?= esc($popup['type']) ?>',
                title: '<?= esc($popup['title']) ?>',
                text: '<?= esc($popup['message']) ?>',
                timer: <?= $popup['duration'] ?>,
                toast: true,
                position: 'top-end',
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>
</body>

</html>