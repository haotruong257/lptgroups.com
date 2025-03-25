<?php

namespace Rating\Models;

use App\Models\Crud_model;

class EvaluationCriteriaModel extends Crud_model
{
    protected $table = 'evaluation_criteria';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_tieu_chi', 'noi_dung', 'thu_tu_sap_xep'];

    public function __construct()
    {
        parent::__construct();
    }

    // Get all criteria
    public function get_all_criteria()
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria');
        $db_builder->orderBy('id', 'asc');
        $criteria = $db_builder->get()->getResultArray();
        return $criteria;
    }

    // Get criteria by category ID
    public function get_criteria_by_category($id_tieu_chi)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria');
        $db_builder->where('id_tieu_chi', $id_tieu_chi);
        $db_builder->orderBy('thu_tu_sap_xep', 'asc');
        return $db_builder->get()->getResultArray();
    }

    // Get criteria by ID
    public function get_criteria($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria');
        $db_builder->where('id', $id);
        return $db_builder->get()->getResultArray();
    }

    // Add new criteria
    public function add_criteria($data)
    {
        if (!isset($data['noi_dung']) || empty($data['noi_dung'])) {
            return false; // Nếu không có nội dung thì trả về false
        }

        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria');
        $db_builder->insert($data);

        return $this->db->insertID() ?: false;
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

    // Get all criteria with category (join with evaluation_criteria_categories)
    public function get_all_criteria_with_category()
    {
        $db_builder = $this->db->table(get_db_prefix() . 'evaluation_criteria');
        $db_builder->select('evaluation_criteria.*, evaluation_criteria_categories.name as category_name');
        $db_builder->join(get_db_prefix() . 'evaluation_criteria_categories', 'evaluation_criteria_categories.id = evaluation_criteria.id_tieu_chi');
        $db_builder->orderBy('evaluation_criteria.id_tieu_chi', 'asc');
        $db_builder->orderBy('evaluation_criteria.thu_tu_sap_xep', 'asc');
        return $db_builder->get()->getResultArray();
    }
}
