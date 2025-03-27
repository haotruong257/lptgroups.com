<?php

namespace Rating\Models;

use App\Models\Crud_model;
use CodeIgniter\Model;

class PhieuChamCongModel extends Model
{
    protected $table = 'phieu_cham_cong';
    protected $primaryKey = 'id';
    protected $allowedFields = ['created_id', 'created_at', 'approve_id', 'approve_at', 'trang_thai', 'tong_diem'];

    protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect('default');
    }

    // // Get all phieu_cham_cong
    // public function get_all_phieu_cham_cong()
    // {
    //     $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
    //     $db_builder->orderBy('id', 'asc');
    //     $phieu_cham_cong = $db_builder->get()->getResultArray();
    //     return $phieu_cham_cong;
    // }

    // // Get phieu_cham_cong by ID
    // public function get_phieu_cham_cong($id)
    // {
    //     $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
    //     $db_builder->where('id', $id);
    //     return $db_builder->get()->getResultArray();
    // }

    // // Add new phieu_cham_cong
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

    // // Update phieu_cham_cong
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

    // // Delete phieu_cham_cong
    // public function delete_phieu_cham_cong($id)
    // {
    //     $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
    //     $db_builder->where('id', $id);
    //     $db_builder->delete();

    //     if ($this->db->affectedRows() > 0) {
    //         return true;
    //     }

    //     return false;
    // }

    // Get all phieu_cham_cong with user info (join with user table)
    // public function get_all_phieu_cham_cong_with_users(bool $is_admin = false)
    // {
    //     // echo "<pre> Response : <br/>";
    //     // var_dump($response);
    //     // echo "</pre>";
    //     // die();

    //     if (!$is_admin) {
    //         $db_builder->where('pcc.created_id', $this->login_user_id());
    //     }
    //     $db_builder->orderBy('pcc.id', 'desc');
    //     $response = $db_builder->get()->getResultArray();
    //     return $response;
    // }
    public function getPhieuChamCong(int $userID = 0)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong ');
        $db_builder->select(get_db_prefix() . "phieu_cham_cong.*, CONCAT(u.first_name , ' ',u.last_name) as created_name")
            ->join(get_db_prefix() . 'users as u', 'u.id = phieu_cham_cong.created_id', 'left');

        if ($userID > 0) {
            $db_builder->where('phieu_cham_cong.created_id', $userID);
        }

        $db_builder->orderBy('phieu_cham_cong.id', 'desc');
        $response = $db_builder->get()->getResultArray();
        log_message('debug', 'Không tìm thấy phiếu chấm công nào cho userID: ' . $userID);
        return $response;
    }

    public function searchPhieuChamCong(string $searchName = '', string $searchDate = '', int $userID = 0)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
        $db_builder->select(get_db_prefix() . "phieu_cham_cong.*, CONCAT(u.first_name, ' ', u.last_name) as created_name")
            ->join(get_db_prefix() . 'users as u', 'u.id = phieu_cham_cong.created_id', 'left');

        if ($userID > 0) {
            $db_builder->where('phieu_cham_cong.created_id', $userID);
        }

        // Tìm kiếm theo tên
        if (!empty($searchName)) {
            $db_builder->groupStart()
                ->like('u.first_name', $searchName)
                ->orLike('u.last_name', $searchName)
                ->orLike("CONCAT(u.first_name, ' ', u.last_name)", $searchName)
                ->groupEnd();
        }

        // Tìm kiếm theo ngày (created_at)
        if (!empty($searchDate)) {
            // Lấy phần YYYY-MM từ searchDate
            $yearMonth = substr($searchDate, 0, 7); // Ví dụ: '2025-03'
            $db_builder->like('phieu_cham_cong.created_at', $yearMonth);
            // Loại bỏ các bản ghi có created_at rỗng hoặc null
            $db_builder->where('phieu_cham_cong.created_at IS NOT NULL');
        }
        $db_builder->orderBy('phieu_cham_cong.id', 'desc');
        $response = $db_builder->get()->getResultArray();

        if (empty($response)) {
            log_message('debug', 'Không tìm thấy phiếu chấm công nào cho userID: ' . $userID . ' với tên: ' . $searchName . ' và ngày: ' . $searchDate);
        }

        return $response;
    }
}
