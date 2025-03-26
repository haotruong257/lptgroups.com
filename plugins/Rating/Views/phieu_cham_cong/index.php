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
    </style>
</head>

<body>
    <h2>Danh sách phiếu chấm công</h2>
    <?php if (isset($phieu_cham_cong) && !empty($phieu_cham_cong)): ?>
        <table>
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
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($phieu_cham_cong as $attendance): ?>
                    <tr>
                        <td><a href="<?= get_uri("chi_tiet_phieu_cham_cong/" . $attendance['id']); ?>"><?= esc($attendance['id']) ?></a></td>
                        <td><?= esc($attendance['created_id']) ?></td>
                        <td><?= esc($attendance['created_at'] ?? 'Chưa có') ?></td>
                        <td><?= esc($attendance['approve_id'] ?? 'Chưa có') ?></td>
                        <td><?= esc($attendance['approve_at'] ?? 'Chưa có') ?></td>
                        <td><?= esc($attendance['trang_thai'] ?: 'Chưa xác định') ?></td>
                        <td><?= esc($attendance['tong_diem'] ?? '0') ?></td>
                        <td><?= esc($attendance['created_name']) ?></td>
                        <td>
                            <button class="btn btn-info">Cập nhật</button>

                            <button class="btn btn-danger">Xóa</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có phiếu chấm công nào để hiển thị.</p>
    <?php endif; ?>
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