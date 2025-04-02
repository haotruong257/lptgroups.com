<!DOCTYPE html>
<html>

<head>
    <title>Danh sách phiếu chấm điểm</title>
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

        td.no-wrap {
            white-space: nowrap;
        }

        td.no-wrap .btn {
            display: inline-block;
            margin: 2px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .search-form {
            margin: 20px 0;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn {
            padding: 5px 10px;
            margin-right: 5px;
            text-decoration: none;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-info {
            background-color: #17a2b8;
        }

        .btn-success {
            background-color: #28a745;
        }

        input[type="text"],
        input[type="date"],
        select {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <section class="page-wrapper clearfix">
        <div class="card px-3 py-2">
            <div>
                <h2>Danh sách phiếu chấm điểm</h2>
                <?php if (!is_admin()): ?>
                    <a href="<?= get_uri('evaluation_criteria') ?>" class="btn btn-info">Tạo phiếu chấm điểm</a>
                <?php endif; ?>
                <button type="button" class="btn btn-info" id="showRulesBtn">Luật chấm điểm</button>
            </div>
            <form method="GET" action="<?= get_uri('phieu_cham_cong') ?>" class="search-form">
                <!-- <input type="hidden" name="page" value="<?= esc($page ?? 1) ?>"> -->
                <input type="text" name="search" placeholder="Tìm theo tên người tạo..." value="<?= esc($search ?? '') ?>">
                <input type="date" name="date" value="<?= esc($date ?? '') ?>">
                <select style="max-width: 200px;" name="trang_thai" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1" <?= ($trang_thai ?? '') === '1' ? 'selected' : '' ?>>Chờ duyệt</option>
                    <option value="2" <?= ($trang_thai ?? '') === '2' ? 'selected' : '' ?>>Đã duyệt</option>
                    <option value="3" <?= ($trang_thai ?? '') === '3' ? 'selected' : '' ?>>Từ chối</option>
                </select>
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                <?php if (isset($search) || isset($date) || isset($trang_thai)): ?>
                    <a href="<?= get_uri('phieu_cham_cong') ?>" class="btn btn-info">Xóa bộ lọc</a>
                <?php endif; ?>
            </form>

            <?php if (isset($phieu_cham_cong) && !empty($phieu_cham_cong)): ?>
                <table>
                    <thead>
                        <tr>
                            <th class="text-center">ID Phiếu</th>
                            <th class="text-center">Tên người tạo</th>
                            <th class="text-center">Tên người duyệt</th>
                            <!-- <th>ID Người tạo</th> -->
                            <th class="text-center">Thời gian tạo</th>
                            <!-- <th>ID Người duyệt</th> -->
                            <th class="text-center">Thời gian duyệt</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Tổng điểm</th>

                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($phieu_cham_cong as $attendance): ?>
                            <tr>
                                <td><a href="<?= get_uri("chi_tiet_phieu_cham_cong/" . $attendance['id']); ?>"><?= esc($attendance['id']) ?></a></td>
                                <td><strong><?= esc($attendance['created_name']) ?></strong></td>
                                <td><strong><?= esc($attendance['approved_name'] ?? 'Chờ Duyệt') ?></strong></td>
                                <!-- <td><?= esc($attendance['created_id']) ?></td> -->
                                <td><?= esc($attendance['created_at'] ? date('d/m/Y', strtotime($attendance['created_at'])) : 'Chưa có') ?></td>
                                <!-- <td><?= esc($attendance['approve_id'] ?? 'Chưa có') ?></td> -->
                                <td><?= esc($attendance['approve_at'] ? date('d/m/Y', strtotime($attendance['approve_at'])) : 'Chưa có') ?></td>
                                <td>
                                    <?php
                                    switch ($attendance['trang_thai']) {
                                        case 1:
                                            echo '<span style="color: orange; font-weight: bold;">Chờ duyệt</span>';;
                                            break;
                                        case 2:
                                            echo '<span style="color: green; font-weight: bold;">Đã duyệt</span>';
                                            break;
                                        case 3:
                                            echo '<span style="color: red; font-weight: bold;">Từ chối</span>';
                                            break;
                                        default:
                                            echo '<span style="color: orange; font-weight: bold;">Chưa xác định</span>';
                                    }
                                    ?>
                                </td>
                                <td><?= esc($attendance['tong_diem'] ?? '0') ?></td>
                                <td class="no-wrap">
                                    <?php if (is_admin()): ?>
                                        <a href="<?= get_uri("chi_tiet_phieu_cham_cong/" . $attendance['id']); ?>" class="btn btn-primary">Xem</a>

                                        <?php if ($attendance['trang_thai'] == 1): ?>
                                            <a href="<?= get_uri("phieu_cham_cong/edit/" . $attendance['id']); ?>" class="btn btn-info">Cập nhật</a>
                                            <a href="#" class="btn btn-success approve-btn" data-id="<?= esc($attendance['id']) ?>">Duyệt</a>
                                            <a href="#" class="btn btn-warning reject-btn" data-id="<?= esc($attendance['id']) ?>">Từ chối</a>
                                        <?php endif; ?>
                                        <button class="btn btn-danger delete-btn" data-id="<?= esc(data: $attendance['id']) ?>">Xóa</button>

                                    <?php else: ?>
                                        <?php if ($attendance['trang_thai'] == 1): ?>
                                            <a href="<?= get_uri("phieu_cham_cong/edit/" . $attendance['id']); ?>" class="btn btn-info">Cập nhật</a>
                                            <button class="btn btn-danger delete-btn" data-id="<?= esc(data: $attendance['id']) ?>">Xóa</button>
                                        <?php elseif ($attendance['trang_thai'] == 2): ?>
                                            <a href="<?= get_uri("chi_tiet_phieu_cham_cong/" . $attendance['id']); ?>" class="btn btn-primary">Xem</a>
                                            <button class="btn btn-danger delete-btn" data-id="<?= esc(data: $attendance['id']) ?>">Xóa</button>
                                            <!-- <button class="btn btn-primary">Xem</button> -->
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Hiển thị phân trang -->
                <div class="pagination-container d-flex justify-content-center mt-3">
                    <?php if ($pager['totalPages'] > 1): ?>
                        <nav>
                            <ul class="pagination">
                                <!-- Nút Previous -->
                                <li class="page-item <?= ($pager['currentPage'] == 1) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= get_uri("phieu_cham_cong?page=" . ($pager['currentPage'] - 1) . "&search=" . urlencode($search ?? '') . "&date=" . urlencode($date ?? '') . "&trang_thai=" . urlencode($trang_thai ?? '')) ?>">Previous</a>
                                </li>

                                <!-- Số trang -->
                                <?php for ($i = 1; $i <= $pager['totalPages']; $i++): ?>
                                    <li class="page-item <?= ($i == $pager['currentPage']) ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= get_uri("phieu_cham_cong?page=$i&search=" . urlencode($search ?? '') . "&date=" . urlencode($date ?? '') . "&trang_thai=" . urlencode($trang_thai ?? '')) ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Nút Next -->
                                <li class="page-item <?= ($pager['currentPage'] == $pager['totalPages']) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= get_uri("phieu_cham_cong?page=" . ($pager['currentPage'] + 1) . "&search=" . urlencode($search ?? '') . "&date=" . urlencode($date ?? '') . "&trang_thai=" . urlencode($trang_thai ?? '')) ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p>Không có phiếu chấm điểm nào để hiển thị.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Popup thông báo từ session -->
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
    <!-- Import component rating_rules.js -->
    <script src="<?= base_url('plugins/Rating/assets/js/rating_rules.js') ?>"></script>
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

        // Xử lý xóa phiếu chấm công (không dùng AJAX)
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Xác nhận xóa',
                    text: 'Bạn có chắc chắn muốn xóa phiếu chấm công này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Chuyển hướng đến URL delete
                        window.location.href = '<?= get_uri("phieu_cham_cong/delete/") ?>' + id;
                    }
                });
            });
        });
        document.getElementById('showRulesBtn').addEventListener('click', function() {
            showRatingRules();
        });
    </script>

</body>

</html>