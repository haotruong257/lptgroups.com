<?php

namespace Rating\Models;

use App\Models\Crud_model;

class EvaluationModel extends Crud_model
{
    protected $table = 'evaluation';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category', 'noi_dung', 'diem', 'chi_tiet'];

    public function __construct()
    {
        parent::__construct();
    }

    // Lấy tiêu chí theo danh mục
    public function getCriteriaByCategory($category)
    {
        return $this->where('category', $category)->findAll();
    }

    // Thêm tiêu chí mới
    public function add_criteria($data)
    {
        $data['datecreated'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = get_staff_user_id();

        return $this->insert($data);
    }

    // Cập nhật tiêu chí
    public function update_criteria($data, $id)
    {
        return $this->update($id, $data);
    }

    // Xóa tiêu chí
    public function delete_criteria($id)
    {
        return $this->delete($id);
    }

    // Lấy tất cả tiêu chí
    public function get_all_criteria()
    {
        return $this->orderBy('id', 'asc')->findAll();
    }

    // Lấy tất cả tiêu chí kèm danh mục
    public function get_all_criteria_with_category()
    {
        return $this->orderBy('category', 'asc')->orderBy('id', 'asc')->findAll();
    }
}
