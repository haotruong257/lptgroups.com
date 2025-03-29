<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chấm điểm nhân viên</title>
    <!-- SweetAlert2 CSS (tùy chọn để đẹp hơn) -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <section class="page-wrapper clearfix">
        <div class="card px-3 py-2">
            <h2 class="mb-3">Chấm điểm nhân viên</h2>
            <div class="">
                            <a href=" <?= get_uri("phieu_cham_cong/"); ?>" class="btn btn-secondary mb-3">Quay lại danh sách phiếu chấm công</a>
            </div>
            <h3><?php echo app_lang("list_criteria"); ?></h3>

            <?php echo form_open(get_uri("phieu_cham_cong/create"), array("id" => "phieu-cham-cong", "class" => "general-form", "role" => "form")); ?>

            <div class="table-responsive">
                <table class="table table-bordered ">
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
                    </thead>
                    <tbody>
                        <?php
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
                                        <td rowspan="<?= count($items) ?>" class="align-middle fw-bold">
                                            <?= htmlspecialchars($categoryName) ?>
                                        </td>
                                    <?php endif; ?>

                                    <td class="align-middle"><?= $row['thu_tu_sap_xep'] ?></td>
                                    <td class="align-middle">
                                        <?= !empty($row['noi_dung']) ? nl2br(htmlspecialchars($row['noi_dung'])) : '<em>Chưa có nội dung</em>' ?>
                                    </td>

                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <td class="text-center">
                                        <div class="radio-center">
                                            <input type="radio" class="form-check-input" name="score[<?= $row['id'] ?>]" value="<?= $i ?>" id="score_<?= $row['id'] ?>_<?= $i ?>">
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

            <button type="submit" class="btn btn-primary mt-3">Lưu điểm</button>
            <?php echo form_close(); ?>
        </div>
    </section>

    <!-- Bootstrap JS (cần cho một số tính năng như responsive table) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Script để hiển thị popup -->
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