<h2>Thêm Tiêu Chí Đánh Giá</h2>

<form action="<?= site_url('rating/createCategory') ?>" method="post">
    <label for="category_id">Danh mục:</label>
    <select name="category_id" id="category_id" required>
        <option value="">Chọn danh mục</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label for="noi_dung">Nội dung:</label>
    <textarea name="noi_dung" id="noi_dung" required></textarea>
    <br><br>

    <label for="diem">Điểm:</label>
    <input type="number" name="diem" id="diem" min="1" max="5" required>
    <br><br>

    <button type="submit">Lưu</button>
    <a href="<?= site_url('rating') ?>"><button type="button">Hủy</button></a>
</form>
