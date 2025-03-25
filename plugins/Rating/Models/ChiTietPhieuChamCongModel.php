<?php

namespace Rating\Models;

use App\Models\Crud_model;

class ChiTietPhieuChamCongModel extends Crud_model
{
    protected $table = 'chi_tiet_phieu_cham_cong';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_noi_dung_danh_gia', 'diem_so', 'id_phieu_cham_cong'];

    public function __construct()
    {
        parent::__construct();
    }

    // Get all chi_tiet_phieu_cham_cong

    // File: Rating/Models/ChiTietPhieuChamCongModel.php

    public function get_all_chi_tiet_phieu_cham_cong($limit = 10, $offset = 0)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'chi_tiet_phieu_cham_cong');
        $db_builder->select('chi_tiet_phieu_cham_cong.*, 
            evaluation_criteria.noi_dung, 
            evaluation_criteria.id_tieu_chi, 
            evaluation_criteria.thu_tu_sap_xep, 
            evaluation_criteria_categories.name as category_name, 
            phieu_cham_cong.created_id, 
            phieu_cham_cong.created_at, 
            users.first_name as employee_name');
        $db_builder->join(get_db_prefix() . 'evaluation_criteria', 'evaluation_criteria.id = chi_tiet_phieu_cham_cong.id_noi_dung_danh_gia', 'left');
        $db_builder->join(get_db_prefix() . 'evaluation_criteria_categories', 'evaluation_criteria_categories.id = evaluation_criteria.id_tieu_chi', 'left');
        $db_builder->join(get_db_prefix() . 'phieu_cham_cong', 'phieu_cham_cong.id = chi_tiet_phieu_cham_cong.id_phieu_cham_cong', 'left');
        $db_builder->join(get_db_prefix() . 'users', 'users.id = phieu_cham_cong.created_id', 'left');
        $db_builder->orderBy('chi_tiet_phieu_cham_cong.id', 'asc');
        $db_builder->limit($limit, $offset);
        $details = $db_builder->get()->getResultArray();
        return $details;
    }
    // Get chi_tiet_phieu_cham_cong by phieu_cham_cong ID
    public function get_details_by_phieu_cham_cong($id_phieu_cham_cong)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'chi_tiet_phieu_cham_cong');
        $db_builder->where('id_phieu_cham_cong', $id_phieu_cham_cong);
        return $db_builder->get()->getResultArray();
    }

    public function is_criteria_already_scored($id_phieu_cham_cong, $id_noi_dung_danh_gia)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'chi_tiet_phieu_cham_cong');
        $db_builder->where('id_phieu_cham_cong', $id_phieu_cham_cong);
        $db_builder->where('id_noi_dung_danh_gia', $id_noi_dung_danh_gia);
        return $db_builder->countAllResults() > 0;
    }


    // Get chi_tiet_phieu_cham_cong by ID
    public function get_chi_tiet_phieu_cham_cong($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'chi_tiet_phieu_cham_cong');
        $db_builder->where('id', $id);
        return $db_builder->get()->getResultArray();
    }

    // Add new chi_tiet_phieu_cham_cong
    public function add_chi_tiet_phieu_cham_cong($data)
    {
        if (
            !isset($data['id_noi_dung_danh_gia']) || empty($data['id_noi_dung_danh_gia']) ||
            !isset($data['id_phieu_cham_cong']) || empty($data['id_phieu_cham_cong']) ||
            !isset($data['diem_so']) || !is_numeric($data['diem_so']) || $data['diem_so'] < 1 || $data['diem_so'] > 5
        ) {
            return false; // Trả về false nếu dữ liệu không hợp lệ
        }

        $db_builder = $this->db->table(get_db_prefix() . 'chi_tiet_phieu_cham_cong');
        $db_builder->insert($data);

        return $this->db->insertID() ?: false;
    }
    public function calculate_total_score($id_phieu_cham_cong)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'chi_tiet_phieu_cham_cong');
        $db_builder->selectSum('diem_so', 'total_score');
        $db_builder->where('id_phieu_cham_cong', $id_phieu_cham_cong);
        $result = $db_builder->get()->getRowArray();

        return $result['total_score'] ?? 0;
    }
    // Update chi_tiet_phieu_cham_cong
    public function update_chi_tiet_phieu_cham_cong($data, $id)
    {
        if (isset($data['diem_so']) && (!is_numeric($data['diem_so']) || $data['diem_so'] < 1 || $data['diem_so'] > 5)) {
            return false; // Trả về false nếu diem_so không hợp lệ
        }

        $db_builder = $this->db->table(get_db_prefix() . 'chi_tiet_phieu_cham_cong');
        $db_builder->where('id', $id);
        $db_builder->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }
    // Delete chi_tiet_phieu_cham_cong
    public function delete_chi_tiet_phieu_cham_cong($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'chi_tiet_phieu_cham_cong');
        $db_builder->where('id', $id);
        $db_builder->delete();

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }

    // Get chi_tiet_phieu_cham_cong with criteria (join with evaluation_criteria)
    public function get_details_with_criteria($id_phieu_cham_cong)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'chi_tiet_phieu_cham_cong');
        $db_builder->select('chi_tiet_phieu_cham_cong.*, 
            evaluation_criteria.noi_dung, 
            evaluation_criteria.thu_tu_sap_xep, 
            evaluation_criteria.id_tieu_chi, 
            evaluation_criteria_categories.name as category_name, 
            phieu_cham_cong.created_at, 
            users.first_name as employee_name');
        $db_builder->join(get_db_prefix() . 'evaluation_criteria', 'evaluation_criteria.id = chi_tiet_phieu_cham_cong.id_noi_dung_danh_gia');
        $db_builder->join(get_db_prefix() . 'evaluation_criteria_categories', 'evaluation_criteria_categories.id = evaluation_criteria.id_tieu_chi', 'left');
        $db_builder->join(get_db_prefix() . 'phieu_cham_cong', 'phieu_cham_cong.id = chi_tiet_phieu_cham_cong.id_phieu_cham_cong', 'left');
        $db_builder->join(get_db_prefix() . 'users', 'users.id = phieu_cham_cong.created_id', 'left');
        $db_builder->where('chi_tiet_phieu_cham_cong.id_phieu_cham_cong', $id_phieu_cham_cong);
        $db_builder->orderBy('evaluation_criteria.thu_tu_sap_xep', 'asc');
        return $db_builder->get()->getResultArray();
    }
}
