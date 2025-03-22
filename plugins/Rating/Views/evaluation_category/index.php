<h2>Danh sách tiêu chí đánh giá</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= esc($category['id']) ?></td>
                        <td><?= esc($category['name']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    
<!-- 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<button type="button" data-bs-toggle="modal" data-bs-target="#createModal">
    Thêm Tiêu Chí Đánh Giá 
</button>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tạo Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('rating/store'); ?>" method="post">
                    <label for="name">Tên tiêu chí:</label>
                    <input type="text" name="name" required>
                    <button type="submit">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div> -->