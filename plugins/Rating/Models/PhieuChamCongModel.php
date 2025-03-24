<?php

namespace Rating\Models;

use App\Models\Crud_model;

class PhieuChamCongModel extends Crud_model
{
    protected $table = 'phieu_cham_cong';
    protected $primaryKey = 'id';
    protected $allowedFields = ['created_id', 'approve_id', 'approve_at', 'trang_thai', 'tong_diem'];

    public function __construct()
    {
        parent::__construct();
    }

    // Get all phieu_cham_cong
    public function get_all_phieu_cham_cong()
    {
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
        $db_builder->orderBy('id', 'asc');
        $phieu_cham_cong = $db_builder->get()->getResultArray();
        return $phieu_cham_cong;
    }

    // Get phieu_cham_cong by ID
    public function get_phieu_cham_cong($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
        $db_builder->where('id', $id);
        return $db_builder->get()->getResultArray();
    }

    // Add new phieu_cham_cong
    public function add_phieu_cham_cong($data)
    {
        if (!isset($data['created_id']) || empty($data['created_id'])) {
            return false; // Nếu không có created_id thì trả về false
        }

        $data['approve_at'] = isset($data['approve_at']) ? $data['approve_at'] : date('Y-m-d H:i:s');
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
        $db_builder->insert($data);

        return $this->db->insertID() ?: false;
    }

    // Update phieu_cham_cong
    public function update_phieu_cham_cong($data, $id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
        $db_builder->where('id', $id);
        $db_builder->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }

    // Delete phieu_cham_cong
    public function delete_phieu_cham_cong($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
        $db_builder->where('id', $id);
        $db_builder->delete();

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }

    // Get all phieu_cham_cong with user info (join with user table)
    public function get_all_phieu_cham_cong_with_users()
    {
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
        $db_builder->select('phieu_cham_cong.*, creator.id as creator_id, approver.id as approver_id');
        $db_builder->join(get_db_prefix() . 'user as creator', 'creator.id = phieu_cham_cong.created_id', 'left');
        $db_builder->join(get_db_prefix() . 'user as approver', 'approver.id = phieu_cham_cong.approve_id', 'left');
        $db_builder->orderBy('phieu_cham_cong.id', 'asc');
        return $db_builder->get()->getResultArray();
    }
}
