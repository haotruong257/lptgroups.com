<?php

namespace Rating\Models;

use App\Models\Crud_model;

class EvaluationCategoryModel extends Crud_model
{
    protected $table = 'evaluation_criteria_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];

    public function __construct()
    {
        parent::__construct();
    }

    // Get all criteriaCategory 
    public function get_all_criteriaCategory()
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_categories');
        $db_builder->orderBy('id', 'asc');
        $category = $db_builder->get()->getResultArray();
        return $category;
    }

    // Get criteria details by criteriaCategory ID
    public function get_criteriaCategory($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_categories');
        $db_builder->where('id', $id);
        return $db_builder->get()->getResultArray();
    }

    // Add new criteriaCategory Model
    public function add_criteriaCategory($data)
    {
        if (!isset($data['name']) || empty($data['name'])) {
            return false; // Nếu không có tên thì trả về false
        }

        // Thêm thông tin ngày tạo & ID người thêm
        // $data['datecreated'] = date('Y-m-d H:i:s');
        // $data['addedfrom'] = get_staff_user_id();

        // Kiểm tra dữ liệu trước khi lưu
        // var_dump($data);
        // die(); // Dừng code để kiểm tra output

        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_categories');
        $db_builder->insert($data);

        return $this->db->insertID() ?: false;
    }


    // Update criteriaCategory
    public function update_criteriaCategory($data, $id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_categories');
        $db_builder->where('id', $id);
        $db_builder->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }

    // Delete criteriaCategory
    public function delete_criteriaCategory($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_categories');
        $db_builder->where('id', $id);
        $db_builder->delete();

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }
}
