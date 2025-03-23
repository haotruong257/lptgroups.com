<?php

namespace Rating\Models;

use App\Models\Crud_model;

class EvaluationModel extends Crud_model
{
    protected $table = 'evaluation_criteria';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category_id', 'noi_dung', 'diem'];

    public function __construct()
    {
        parent::__construct();
    }

    // Get criteria by category
    public function getCriteriaByCategory($category_id)
    {
        return $this->where('category_id', $category_id)->findAll();
    }

    // Add new criteria
    public function add_criteria($data)
    {
        $data['datecreated'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = get_staff_user_id();

        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria');
        $db_builder->insert($data);

        $insert_id = $this->db->insertID();

        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    // Update criteria
    public function update_criteria($data, $id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria');
        $db_builder->where('id', $id);
        $db_builder->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }

    // Delete criteria
    public function delete_criteria($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria');
        $db_builder->where('id', $id);
        $db_builder->delete();

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }

    // Get all criteria
    public function get_all_criteria()
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria');
        $db_builder->orderBy('id', 'asc');
        $criteria = $db_builder->get()->getResultArray();
        return $criteria;
    }

    public function get_all_criteria_with_category()
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria ec');
        $db_builder->select('ec.id, ec.category_id, ec.noi_dung, ec.diem, cat.name AS category_name');
        $db_builder->join(get_db_prefix() . 'evaluation_criteria_categories cat', 'cat.id = ec.category_id', 'left');
        $db_builder->orderBy('ec.id', 'asc');
        return $db_builder->get()->getResultArray();
    }

    // Get criteria details by criteria ID
    public function get_criteria_details($criteria_id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_details');
        $db_builder->where('criteria_id', $criteria_id);
        return $db_builder->get()->getResultArray();
    }

    // Add criteria detail
    public function add_criteria_detail($data)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_details');
        $db_builder->insert($data);

        $insert_id = $this->db->insertID();

        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    // Update criteria detail
    public function update_criteria_detail($data, $id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_details');
        $db_builder->where('id', $id);
        $db_builder->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }

    // Delete criteria detail
    public function delete_criteria_detail($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria_details');
        $db_builder->where('id', $id);
        $db_builder->delete();

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }
}
