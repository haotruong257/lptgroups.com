<?php
 namespace App\Models;
 use App\Models\Crud_model;

 class EvaluationCategoryModel extends Crud_model {
    protected $table = 'evaluation_criteria_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = 'name';
 
    public function __construct() {
        parent::__construct();
    }


// Get all criteriaCategory
public function get_all_criteriaCategory() {
    $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_categories');
    $db_builder->orderBy('id', 'asc');
    return $db_builder->get()->getResultArray();
}

// Get criteria details by criteriaCategory ID
public function get_criteriaCategory($id) {
    $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_categories');
    $db_builder->where('id', $id);
    return $db_builder->get()->getResultArray();
}

    // Add new criteriaCategory Model
    public function add_criteriaCategory($data) {
        $data['datecreated'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = get_staff_user_id();

        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_categories');
        $db_builder->insert($data);

        $insert_id = $this->db->insertID();

        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

     // Update criteriaCategory
     public function update_criteriaCategory($data, $id) {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_categories');
        $db_builder->where('id', $id);
        $db_builder->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }

    // Delete criteriaCategory
    public function delete_criteriaCategory($id) {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_categories');
        $db_builder->where('id', $id);
        $db_builder->delete();

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }

}

