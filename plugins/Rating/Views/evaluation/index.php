<h2>Chấm điểm nhân viên</h2>
<a href="<?= site_url('category') ?>">
    <button> Quản Lý Danh Mục Tiêu Chí Đánh Giá</button>
</a>

<h2>Danh sách tiêu chí đánh giá</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <!-- <th>Category ID</th> -->
                    <th>Danh mục</th>
                    <th>Nội dung</th>
                    <th>Điểm</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($criteria)) : ?>
                    <?php foreach ($criteria as $row) : ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['category_name'] ?></td> <!-- Hiển thị tên danh mục -->
                            <!-- <td><?= $row['category_id'] ?></td> -->
                            <td><?= $row['noi_dung'] ?></td>
                            <td><?= $row['diem'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center">Không có dữ liệu.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>


<form action="" method="post">
    
</form>

