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

    // // Add new phieu_cham_cong
    public function add_phieu_cham_cong($data)
    {
        if (!isset($data['created_id']) || empty($data['created_id'])) {
            return false; // Nếu không có created_id thì trả về false
        }
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        // $data['approve_at'] = isset($data['approve_at']) ? $data['approve_at'] : date('Y-m-d H:i:s');
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
        return $this->db->affectedRows() > 0;
    }

    // Lấy phiếu chấm công theo ID
    public function getPhieuChamCongById($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
        $db_builder->select(get_db_prefix() . "phieu_cham_cong.*, CONCAT(u.first_name, ' ', u.last_name) as created_name")
            ->join(get_db_prefix() . 'users as u', 'u.id = phieu_cham_cong.created_id', 'left')
            ->where('phieu_cham_cong.id', $id);
        return $db_builder->get()->getRowArray();
    }

    // Lấy chi tiết phiếu chấm công theo ID phiếu
    public function getChiTietByPhieuId($phieuId)
    {
        $chiTietModel = new ChiTietPhieuChamCongModel();
        $chiTiet = $chiTietModel->where('id_phieu_cham_cong', $phieuId)->findAll();
        return array_column($chiTiet, 'diem_so', 'id_noi_dung_danh_gia');
    }

    // Cập nhật chi tiết và tổng điểm phiếu chấm công
    public function updateChiTietPhieu($phieuId, $scores)
    {
        $chiTietModel = new ChiTietPhieuChamCongModel();

        // Xóa chi tiết cũ
        $chiTietModel->where('id_phieu_cham_cong', $phieuId)->delete();

        // Thêm chi tiết mới
        $tongDiem = 0;
        foreach ($scores as $idNoiDung => $diemSo) {
            if (!is_numeric($diemSo) || $diemSo < 1 || $diemSo > 5) {
                continue;
            }
            $chiTietData = [
                'id_phieu_cham_cong' => $phieuId,
                'id_noi_dung_danh_gia' => $idNoiDung,
                'diem_so' => $diemSo
            ];
            if (!$chiTietModel->insert($chiTietData)) {
                return false;
            }
            $tongDiem += (int)$diemSo;
        }

        // Cập nhật tổng điểm
        return $this->update_phieu_cham_cong(['tong_diem' => $tongDiem], $phieuId);
    }
//     public function getPhieuChamCong(int $limit = 10, int $offset = 0, string $searchName = '', string $searchDate = '', string $trangThai = '', int $userID = 0)
// {
//     $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
    
//     $db_builder->select(get_db_prefix() . "phieu_cham_cong.*, 
//         CONCAT(creator.first_name, ' ', creator.last_name) as created_name, 
//         CONCAT(approver.first_name, ' ', approver.last_name) as approved_name")
//         ->join(get_db_prefix() . 'users as creator', 'creator.id = phieu_cham_cong.created_id', 'left')
//         ->join(get_db_prefix() . 'users as approver', 'approver.id = phieu_cham_cong.approve_id', 'left');

//     // Lọc theo userID (nếu có)
//     if ($userID > 0) {
//         $db_builder->where('phieu_cham_cong.created_id', value: $userID);
//     }

//     // Tìm kiếm theo tên người tạo
//     if (!empty($searchName)) {
//         $db_builder->groupStart()
//             ->like('creator.first_name', $searchName)
//             ->orLike('creator.last_name', $searchName)
//             ->orLike("CONCAT(creator.first_name, ' ', creator.last_name)", $searchName)
//             ->groupEnd();
//     }

//     // Tìm kiếm theo ngày (created_at)
//     if (!empty($searchDate)) {
//         $yearMonth = substr($searchDate, 0, 7); // Chỉ lấy YYYY-MM
//         $db_builder->like('phieu_cham_cong.created_at', $yearMonth);
//         $db_builder->where('phieu_cham_cong.created_at IS NOT NULL');
//     }

//     // Lọc theo trạng thái (trang_thai)
//     if (!empty($trangThai)) {
//         $db_builder->where('phieu_cham_cong.trang_thai', (int)$trangThai);
//     }

//     // Sắp xếp và phân trang
//     $db_builder->orderBy('phieu_cham_cong.id', 'desc');
//     $db_builder->limit($limit, $offset);

//     $response = $db_builder->get()->getResultArray();

//     // Ghi log nếu không có kết quả
//     if (empty($response)) {
//         log_message('debug', "Không tìm thấy phiếu chấm công với userID: $userID, searchName: $searchName, searchDate: $searchDate, trạng thái: $trangThai");
//     }

//     return $response;
// }

    public function getPhieuChamCong(int $userID = 0,int $limit = 10, int $offset = 0)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
        $db_builder->select(get_db_prefix() . "phieu_cham_cong.*, 
        CONCAT(creator.first_name, ' ', creator.last_name) as created_name, 
        CONCAT(approver.first_name, ' ', approver.last_name) as approved_name")
            ->join(get_db_prefix() . 'users as creator', 'creator.id = phieu_cham_cong.created_id', 'left')
            ->join(get_db_prefix() . 'users as approver', 'approver.id = phieu_cham_cong.approve_id', 'left');
        if ($userID > 0) {
            $db_builder->where('phieu_cham_cong.created_id', $userID);
        }

        $db_builder->orderBy('phieu_cham_cong.id', 'desc');
        $db_builder->limit($limit, $offset);
        $response = $db_builder->get()->getResultArray();
        log_message('debug', 'Không tìm thấy phiếu chấm công nào cho userID: ' . $userID);
        return $response;
    }
    // Đếm tổng số phiếu chấm công (dùng cho pagination)
    public function countPhieuChamCong(string $searchName = '', string $searchDate = '', string $trangThai = '', int $userID = 0)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong')
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
        
        // // Tìm kiếm theo ngày (created_at)
        // if (!empty($searchDate)) {
        //     $yearMonth = date('Y-m', strtotime($searchDate)); // Chuyển sang YYYY-MM
        //     $db_builder->where("DATE_FORMAT(phieu_cham_cong.created_at, '%Y-%m')", $yearMonth);
        // }
        if (!empty($trangThai)) {
            $db_builder->where('phieu_cham_cong.trang_thai', (int)$trangThai); // Ép kiểu sang số nguyên
        }

    
        return $db_builder->countAllResults();
    }

    public function searchPhieuChamCong(string $searchName = '', string $searchDate = '', string $trangThai = '', int $userID = 0,int $limit = 10, int $offset = 0)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
        $db_builder->select(get_db_prefix() . "phieu_cham_cong.*, 
        CONCAT(creator.first_name, ' ', creator.last_name) as created_name, 
        CONCAT(approver.first_name, ' ', approver.last_name) as approved_name")
            ->join(get_db_prefix() . 'users as creator', 'creator.id = phieu_cham_cong.created_id', 'left')
            ->join(get_db_prefix() . 'users as approver', 'approver.id = phieu_cham_cong.approve_id', 'left');

        if ($userID > 0) {
            $db_builder->where('phieu_cham_cong.created_id', $userID);
        }
    
        // Tìm kiếm theo tên
        if (!empty($searchName)) {
            $db_builder->groupStart()
                        ->like('creator.first_name', $searchName)
                        ->orLike('creator.last_name', $searchName)
                        ->orLike("CONCAT(creator.first_name, ' ', creator.last_name)", $searchName)
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

        if (!empty($trangThai)) {
            $db_builder->where('phieu_cham_cong.trang_thai', (int)$trangThai); // Ép kiểu sang số nguyên
        }


        $db_builder->orderBy('phieu_cham_cong.id', 'desc');
        
        $db_builder->limit($limit, $offset);
        $response = $db_builder->get()->getResultArray();
        
        // ...

        if (empty($response)) {
            log_message('debug', 'Không tìm thấy phiếu chấm công nào cho userID: ' . $userID . ' với tên: ' . $searchName . ' và ngày: ' . $searchDate);
        }
        return $response;
    }
    public function deletePhieuChamCong($id)
    {
        // // Xóa chi tiết phiếu chấm công trước
        // $chiTietModel = new ChiTietPhieuChamCongModel();
        // $chiTietModel->where('id_phieu_cham_cong', $id)->delete();

        // Xóa phiếu chấm công
        $db_builder = $this->db->table(get_db_prefix() . 'phieu_cham_cong');
        $db_builder->where('id', $id);
        $db_builder->delete();

        return $this->db->affectedRows() > 0;
    }
}
