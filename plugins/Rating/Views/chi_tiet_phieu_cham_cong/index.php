<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phiếu chấm công</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Danh sách phiếu chấm công</h2>
        <a href="<?= base_url('/phieu_cham_cong') ?>" class="btn btn-secondary mb-3">Quay lại danh sách phiếu chấm công</a>

        <?php if (session()->has('success')): ?>
            <div class="alert alert-success"><?= session('success') ?></div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger"><?= session('error') ?></div>
        <?php endif; ?>

        <?php if (isset($id_phieu_cham_cong)): ?>
            <h3>Chi tiết phiếu chấm công ID: <?= esc($id_phieu_cham_cong) ?></h3>
            <?php if (!empty($details)): ?>
                <p><strong>Người tạo:</strong> <?= esc($details[0]['employee_name'] ?? 'Không xác định') ?></p>
                <p><strong>Ngày tạo:</strong> <?= !empty($details[0]['created_at']) ? date('d/m/Y H:i:s', strtotime($details[0]['created_at'])) : 'Không xác định' ?></p>
            <?php endif; ?>
            <?php if (isset($tong_diem)): ?>
                <h4>Tổng điểm: <?= esc($tong_diem) ?></h4>
            <?php endif; ?>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>TIÊU CHÍ</th>
                        <th>STT</th>
                        <th>NỘI DUNG ĐÁNH GIÁ</th>
                        <th>ĐIỂM</th>
                        <!-- <th>HÀNH ĐỘNG</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($details)): ?>
                        <?php
                        $criteriaByCategory = [];
                        foreach ($details as $row) {
                            $categoryId = $row['id_tieu_chi'];
                            if (!isset($criteriaByCategory[$categoryId])) {
                                $criteriaByCategory[$categoryId] = [
                                    'name' => $row['category_name'] ?? 'Chưa phân loại',
                                    'items' => []
                                ];
                            }
                            $criteriaByCategory[$categoryId]['items'][] = $row;
                        }
                        ?>
                        <?php foreach ($criteriaByCategory as $categoryId => $categoryData): ?>
                            <?php $items = $categoryData['items']; ?>
                            <?php foreach ($items as $index => $row): ?>
                                <tr>
                                    <?php if ($index === 0): ?>
                                        <td rowspan="<?= count($items) ?>">
                                            <strong><?= esc($categoryData['name']) ?></strong>
                                        </td>
                                    <?php endif; ?>
                                    <td><?= esc($row['thu_tu_sap_xep']) ?></td>
                                    <td><?= !empty($row['noi_dung']) ? nl2br(esc($row['noi_dung'])) : '<em>Chưa có nội dung</em>' ?></td>
                                    <td class="text-center"><?= esc($row['diem_so']) ?></td>
                                    <!-- <td>
                                        <a href="<?= base_url('chi_tiet_phieu_cham_cong/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning">Sửa</a>
                                        <a href="<?= base_url('chi_tiet_phieu_cham_cong/delete/' . $row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa chi tiết này?')">Xóa</a>
                                    </td> -->
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Không có dữ liệu chi tiết cho phiếu chấm công này.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        <?php else: ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>TIÊU CHÍ</th>
                        <th>NỘI DUNG ĐÁNH GIÁ</th>
                        <th>ĐIỂM SỐ</th>
                        <th>ID PHIẾU CHẤM CÔNG</th>
                        <th>TÊN NHÂN VIÊN</th>
                        <th>NGÀY TẠO</th>
                        <th>HÀNH ĐỘNG</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($details)): ?>
                        <?php foreach ($details as $row): ?>
                            <tr>
                                <td><?= esc($row['id']) ?></td>
                                <td><?= esc($row['category_name'] ?? 'Chưa phân loại') ?></td>
                                <td><?= !empty($row['noi_dung']) ? nl2br(esc($row['noi_dung'])) : '<em>Chưa có nội dung</em>' ?></td>
                                <td class="text-center"><?= esc($row['diem_so']) ?></td>
                                <td>
                                    <a href="<?= base_url('chi_tiet_phieu_cham_cong/index/' . $row['id_phieu_cham_cong']) ?>">
                                        <?= esc($row['id_phieu_cham_cong']) ?>
                                    </a>
                                </td>
                                <td><?= esc($row['employee_name'] ?? 'Không xác định') ?></td>
                                <td><?= !empty($row['created_at']) ? date('d/m/Y H:i:s', strtotime($row['created_at'])) : 'Không xác định' ?></td>
                                <td>
                                    <a href="<?= base_url('chi_tiet_phieu_cham_cong/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="<?= base_url('chi_tiet_phieu_cham_cong/delete/' . $row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa chi tiết này?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có chi tiết phiếu chấm công nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Phân trang -->
            <?php if (isset($pager)): ?>
                <div class="d-flex justify-content-center mt-3">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>