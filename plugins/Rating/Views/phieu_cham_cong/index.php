<!DOCTYPE html>
<html>

<head>
    <title>Danh sách phiếu chấm công</title>
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

        input[type="text"],
        input[type="date"] {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <section class="page-wrapper clearfix">
        <div class="card px-3 py-2">
            <h2>Danh sách phiếu chấm công</h2>

            <!-- Form tìm kiếm -->
            <form method="GET" action="<?= get_uri('/phieu_cham_cong') ?>" class="search-form">
                <input type="text" name="search" placeholder="Tìm theo tên người tạo..." value="<?= esc($search ?? '') ?>">
                <input type="date" name="date" value="<?= esc($date ?? '') ?>">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                <?php if (isset($search) || isset($date)): ?>
                    <a href="<?= get_uri('/phieu_cham_cong') ?>" class="btn btn-info">Xóa bộ lọc</a>
                <?php endif; ?>
            </form>
            <a href=" <?= get_uri("phieu_cham_cong/create"); ?>" class="btn btn-secondary mb-3">Thêm danh sách phiếu chấm công</a>
            <?php if (isset($phieu_cham_cong) && !empty($phieu_cham_cong)): ?>
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>ID Phiếu</th>
                            <th>ID Người tạo</th>
                            <th>Thời gian tạo</th>
                            <th>ID Người duyệt</th>
                            <th>Thời gian duyệt</th>
                            <th>Trạng thái</th>
                            <th>Tổng điểm</th>
                            <th>Tên người tạo</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($phieu_cham_cong as $attendance): ?>
                            <tr>
                                <td><a href="<?= get_uri("chi_tiet_phieu_cham_cong/" . $attendance['id']); ?>"><?= esc($attendance['id']) ?></a></td>
                                <td><?= esc($attendance['created_id']) ?></td>
                                <td><?= esc($attendance['created_at'] ? date('d/m/Y H:i:s', strtotime($attendance['created_at'])) : 'Chưa có') ?></td>
                                <td><?= esc($attendance['approve_id'] ?? 'Chưa có') ?></td>
                                <td><?= esc($attendance['approve_at'] ?? 'Chưa có') ?></td>
                                <td><?= esc($attendance['trang_thai'] ?: 'Chưa xác định') ?></td>
                                <td><?= esc($attendance['tong_diem'] ?? '0') ?></td>
                                <td><?= esc($attendance['created_name']) ?></td>
                                <td class="d-flex gap-2 w-100 justify-content-center">
                                    <?php if (is_admin()): ?>
                                        <a href="<?= get_uri("chi_tiet_phieu_cham_cong/" . $attendance['id']); ?>" class="btn btn-primary">Xem</a>
                                        <button class="btn btn-success">Duyệt</button>
                                        <a href="<?= get_uri("chi_tiet_phieu_cham_cong/" . $attendance['id']); ?>" class="btn btn-danger">Từ chối</a>
                                    <?php else: ?>
                                        <?php if ($attendance['trang_thai'] === 'pending'): ?>
                                            <button class="btn btn-info">Cập nhật</button>
                                        <?php elseif ($attendance['trang_thai'] === 'approve'): ?>
                                            <button class="btn btn-primary">Xem</button>
                                        <?php endif; ?>
                                        <button class="btn btn-danger">Xóa</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Không có phiếu chấm công nào để hiển thị.</p>
            <?php endif; ?>
        </div>
    </section>

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