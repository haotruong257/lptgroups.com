<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        .btn {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        }
        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 14px;
            padding: 5px 10px;
        }
        .text-nowrap {
            white-space: nowrap;
        }
        .badge {
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <section class="page-wrapper clearfix">
        <div class="card px-3 py-2">

            <?php if (session()->has('success')): ?>
                <div class="alert alert-success"><?= session('success') ?></div>
            <?php endif; ?>
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <?php if (isset($id_phieu_cham_cong)): ?>
                <div class="card">
                    <div class="card-header">
                            <a href=" <?= get_uri("phieu_cham_cong/"); ?>" class="btn btn-info back-button">Quay lại danh sách</a>
                    </div>
                    <div class="card-body">
                    <h2 class="mb-3">ID Phiếu: <?= esc($id_phieu_cham_cong) ?></h2>
                        <?php if (!empty($details)): ?>
                            <p><strong>Người tạo:</strong> <?= esc($details[0]['employee_name'] ?? 'Không xác định') ?></p>
                            <p><strong>Ngày tạo:</strong> <?= !empty($details[0]['created_at']) ? date('d/m/Y H:i:s', strtotime($details[0]['created_at'])) : 'Không xác định' ?></p>
                            <p><strong>Ngày duyệt:</strong> <?= !empty($details[0]['approved_at']) ? date('d/m/Y H:i:s', strtotime($details[0]['approved_at'])) : 'Chưa C' ?></p>
                            <p></p><strong>Trạng thái:</strong> 
                                <?php if ($trang_thai == 1): ?>
                                    <span class="badge bg-warning text-align">Chờ duyệt</span>
                                <?php elseif ($trang_thai == 2): ?>
                                    <span class="badge bg-success text-align">Đã Duyệt</span>
                                <?php else: ?>
                                    <span class="badge bg-danger text-align">Từ Chối</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        <div class="d-flex w-100 gap-3">
                            <?php if (isset($tong_diem)): ?>
                                <h4>Tổng điểm: <?= esc($tong_diem) ?></h4>
                            <?php endif; ?>
                            <?php if($trang_thai == 1 || $trang_thai == null): ?>
                            <a href="#" class="btn btn-success approve-btn" data-id="<?= esc($id_phieu_cham_cong) ?>">Duyệt</a>
                            <a href="#" class="btn btn-danger reject-btn" data-id="<?= esc($id_phieu_cham_cong) ?>">Từ chối</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
            <!-- Bảng Đánh Giá -->
            <h3>Bảng Đánh Giá </h3>
            <?php if (!empty($details)): ?>
                <div class="table-responsive table-bordered border-secondary">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">TIÊU CHÍ</th>
                                <th class="text-center">TỔNG ĐIỂM</th>
                                <th class="text-center">ĐÁNH GIÁ</th>
                            </tr>
                        </thead>
                            <?php
                            $criteriaByCategory = [];
                            foreach ($details as $row) {
                                $categoryId = $row['id_tieu_chi'];
                                if (!isset($criteriaByCategory[$categoryId])) {
                                    $criteriaByCategory[$categoryId] = [
                                        'name' => $row['category_name'] ?? 'Chưa phân loại',
                                        'items' => [],
                                        'total_score' => 0 // Biến lưu tổng điểm của category
                                    ];
                                }
                                $criteriaByCategory[$categoryId]['items'][] = $row;
                                $criteriaByCategory[$categoryId]['total_score'] += $row['diem_so']; // Cộng tổng điểm
                            }
                            ?>
                            <?php foreach ($criteriaByCategory as $categoryId => $categoryData): ?>
                                <!-- Hiển thị tổng điểm ngay sau nhóm nội dung -->
                                        <tbody>
                                            <tr>
                                                <td colspan="1" class="text-center"><strong><?= esc($categoryData['name']) ?></strong></td>
                                                <td colspan="1" class=" text-center"><?= esc($categoryData['total_score']) ?></td>
                                                <!-- Dòng hiển thị trạng thái -->
                                                <!-- <td colspan="3" class="text-center text-nowrap">                           -->
                                                    <?php 
                                                        $totalScore = $categoryData['total_score'];
                                                        if ($totalScore < 20) {
                                                            echo '<td colspan="3" class="table-danger text-center text-nowrap">
                                                            Biên bản cảnh cáo
                                                            </td>';
                                                        } elseif ($totalScore >= 20 && $totalScore <= 30) {
                                                            echo '<td colspan="3" class="table-warning text-center text-nowrap">
                                                            Họp nhắc nhở
                                                            </td>';
                                                        } else {
                                                            echo '<td colspan="3" class="table-success text-center text-nowrap">
                                                            An toàn
                                                            </td>';
                                                        }
                                                    ?>
                                                <!-- </td> -->
                                            </tr>
                                        </tbody>
                                    
                            <?php endforeach; ?>
                     </table>
                </div>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Không có dữ liệu chi tiết cho phiếu chấm công này.</td>
                            </tr>
                        <?php endif; ?>
                <!-- Bảng Chi Tiết -->
                <h3>Bảng Chi Tiết</h3>
                <table class=" table-responsive table-bordered border-secondary">
                    <thead>
                        <tr>
                            <th class="text-center">TIÊU CHÍ</th>
                            <th class="text-center">STT</th>
                            <th class="text-center">NỘI DUNG ĐÁNH GIÁ</th>
                            <th class="text-center" >ĐIỂM</th>
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
                                        'items' => [],
                                        'total_score' => 0 // Biến lưu tổng điểm của category
                                    ];
                                }
                                $criteriaByCategory[$categoryId]['items'][] = $row;
                                $criteriaByCategory[$categoryId]['total_score'] += $row['diem_so']; // Cộng tổng điểm
                            }
                            ?>
                            <?php foreach ($criteriaByCategory as $categoryId => $categoryData): ?>
                                <?php $items = $categoryData['items']; ?>
                                <?php foreach ($items as $index => $row): ?>
                                    <tr>
                                        <?php if ($index === 0): ?>
                                            <td class="text-center" rowspan="<?= count($items) ?>">
                                                <strong><?= esc($categoryData['name']) ?></strong>
                                            </td>
                                        <?php endif; ?>
                                        <td><?= esc($row['thu_tu_sap_xep']) ?></td>
                                        <td><?= !empty($row['noi_dung']) ? nl2br($row['noi_dung']) : '<em>Chưa có nội dung</em>' ?></td>
                                        <td class="text-center"><?= esc($row['diem_so']) ?></td>
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
    </section>
    <!-- JavaScript xử lý popup xác nhận -->
    <script>
        // Xác nhận duyệt
        document.querySelectorAll('.approve-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const approveUrl = '<?= get_uri("phieu_cham_cong/approve/") ?>' + id;

                Swal.fire({
                    title: 'Xác nhận duyệt',
                    text: 'Bạn có chắc chắn muốn duyệt phiếu chấm công này không?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = approveUrl;
                    }
                });
            });
        });

        // Xác nhận từ chối
        document.querySelectorAll('.reject-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const rejectUrl = '<?= get_uri("phieu_cham_cong/reject/") ?>' + id;

                Swal.fire({
                    title: 'Xác nhận từ chối',
                    text: 'Bạn có chắc chắn muốn từ chối phiếu chấm công này không?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = rejectUrl;
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>