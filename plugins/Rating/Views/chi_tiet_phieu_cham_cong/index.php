<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <section class="page-wrapper clearfix">
        <div class="card px-3 py-2">

            <?php

use Rating\Helpers\StatusEnum;

 if (session()->has('success')): ?>
                <div class="alert alert-success"><?= session('success') ?></div>
            <?php endif; ?>
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <?php if (isset($id_phieu_cham_cong)): ?>
                <div class="card">
                    <div class="card-header">
                        <h2>Danh sách phiếu chấm công</h2>
                        <div class="">
                            <a href=" <?= get_uri("phieu_cham_cong/"); ?>" class="btn btn-secondary mb-3">Quay lại danh sách phiếu chấm công</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>Chi tiết phiếu chấm công ID: <?= esc($id_phieu_cham_cong) ?></h3>
                        <?php if (!empty($details)): ?>
                            <p><strong>Người tạo:</strong> <?= esc($details[0]['employee_name'] ?? 'Không xác định') ?></p>
                            <p><strong>Ngày tạo:</strong> <?= !empty($details[0]['created_at']) ? date('d/m/Y H:i:s', strtotime($details[0]['created_at'])) : 'Không xác định' ?></p>
                            <p><strong>Trạng thái phiếu:</strong> <?= esc($details[0]['trang_thai'] ?? 'Chưa xác định') ?></p>
                            <?php endif; ?>
                        <div class="d-flex w-100 gap-3">
                            <?php if (isset($tong_diem)): ?>
                                <h4>Tổng điểm: <?= esc($tong_diem) ?></h4>
                            <?php endif; ?>
                            <form action="<?= get_uri("phieu_cham_cong/update/" . esc($id_phieu_cham_cong)); ?>" method="POST" style="display:inline;">
                                <input type="hidden" name="trang_thai" value="<?= StatusEnum::APPROVED->value ?>">
                                <input type="hidden" name="approve_id" value="<?= get_staff_user_id() ?>">
                                <input type="hidden" name="approve_at" value="<?= date('Y-m-d H:i:s') ?>">
                                <button type="submit" class="btn btn-success">Duyệt</button>
                            </form>
                            <form action="<?= get_uri("phieu_cham_cong/update/" . esc($id_phieu_cham_cong)); ?>" method="POST" style="display:inline;">
                                <input type="hidden" name="trang_thai" value="<?= StatusEnum::REJECTED->value ?>">
                                <input type="hidden" name="approve_id" value="<?= get_staff_user_id() ?>">
                                <input type="hidden" name="approve_at" value="<?= date('Y-m-d H:i:s') ?>">
                                <button type="submit" class="btn btn-danger">Từ Chối</button>
                            </form>     
                        </div>
                    </div>
                </div>


                <table class=" table-responsive table-bordered border-secondary ">
                    <thead>
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
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>