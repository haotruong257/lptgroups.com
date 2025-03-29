// app/Assets/js/rating_rules.js

function showRatingRules() {
    Swal.fire({
      title: "CHẤM ĐIỂM NHÂN SỰ",
      html: `
  <div class="text-left">
      <h5>A. Thang điểm được tính theo thang từ 1-5</h5>
      <ul class="text-left">
          <div class="highlight">1: Kém, không đáp ứng</div>
          <div class="highlight">2: Chưa đạt, cần cải thiện</div>
          <div class="highlight">3: Đạt các yêu cầu cơ bản</div>
          <div class="highlight">4: Tốt</div>
          <div class="highlight">5: Xuất sắc</div>
      </ul>
  </div class="d-block gap-2">
    <div class="text-left">
      <h5>B. Tiêu chí</h5>
      <div>Bảng đánh giá: đánh giá theo tháng/ quý/ năm</div>
    </div>
      <div class="table-responsive">
          <table class="table table-bordered border-dark">
              <thead class="table-light">
                  <tr>
                      <th>ĐIỂM</th>
                      <th>NỘI DUNG</th>
                      <th>Nhân viên</th>
                      <th>Leader</th>
                      <th>Trưởng Phòng</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td class="text-left">M1 + M2 > 80đ <br> M3 >= 30đ</td>
                      <td class="highlight text-left text-danger">Hoàn thành 100% mục tiêu trước thời hạn, chất lượng xuất sắc.</td>
                      <td rowspan="2" class="text-left">03 tháng liên tục <br> => Leader dự bị <br> => 02 tháng tiếp theo: Leader chính thức</td>
                      <td rowspan="2" class="text-left">03 tháng liên tục <br> => Trưởng phòng dự bị <br> => 03 tháng tiếp theo: Trưởng Phòng chính thức</td>
                      <td rowspan="2" class="text-left">03 tháng liên tục <br> => GD dự bị <br> => 06 tháng tiếp theo: GD chính thức</td>
                  </tr>
                  <tr>
                      <td class="text-left">
                          <div class ="inline-block" > 50 < M1 + M2 < 80đ</div>
                          <div class ="inline-block"> M3 >= 30đ </div>
                      </td>
                      <td class="highlight text-left text-danger">Hoàn thành 90%-99% mục tiêu, chất lượng tốt.</td>
                  </tr>
                  <tr>
                      <td class="text-left">M1 + M2 >= 50đ</td>
                      <td class="highlight text-left text-danger">Hoàn thành 70%-89% mục tiêu, chất lượng đạt yêu cầu.</td>
                      <td colspan="3"><b>MỨC AN TOÀN - CÁC LEADER CẦN ĐỂ Ý ĐỂ ĐÀO TẠO THÚC ĐẨY NHÂN SỰ PHÁT TRIỂN</b></td>
                  </tr>
                  <tr>
                      <td class="text-left">M1 + M2 < 40đ</td>
                      <td class="highlight text-left text-danger">Hoàn thành dưới 70%, nhiều sai sót.</td>
                      <td colspan="3"></td>
                  </tr>
                  <tr>
                      <td class="text-left">M1 + M2 < 30đ</td>
                      <td class="highlight text-left text-danger">Không hoàn thành nhiệm vụ hoặc gây ảnh hưởng tiêu cực.</td>
                      <td colspan="3"></td>
                  </tr>
              </tbody>
          </table>
      </div>
   <div class="text-left">
      <h5>A. Đối với Mục chuyên cần và tác phong:</h5>
      <ul>
          <div>< 15đ: Biên bản cảnh cáo</li>
          <div>15-20đ: Họp nhắc nhở</div>
          <div>>20đ: An toàn</div>
      </ul>
      <p style="font-style:italic" class="highlight text-danger">* Nhân viên bị Biên Bản – Quản Lý/ Trưởng Nhóm cũng sẽ bị 1 Biên bản nhắc nhở *</p>
  </div>
     <div class="text-left">
      <h5>B. Đối với Mục chuyên môn, hiệu quả công việc và các kỹ năng khác:</h5>
      <ul>
          <div>< 20đ: Biên bản cảnh cáo</li>
          <div>20-30đ: Họp nhắc nhở</div>
          <div>>30đ: An toàn</div>
      </ul>
      <p style="font-style:italic" class="highlight text-danger">* Nhân viên bị Biên Bản – Quản Lý/ Trưởng Nhóm cũng sẽ bị 1 Biên bản nhắc nhở *</p>
  </div>
    <div class="text-left">
      <h5>C. Đối với mục Kỹ Năng Quản Lý:</h5>
      <ul>
          <div>< 20đ: Không Đạt</div>
          <div>20 – 30đ: Xem xét</div>
          <div>>30đ: Cân nhắc</div>
      </ul>
      <p style="font-style:italic" class="highlight">*** Với nhân sự liên tục 03 tháng có mức điểm >30 sẽ được thử thách 01 – 02 tháng ở vị trí <strong> Trưởng Nhóm/ Quản Lý thực tập </strong> trước khi lên chính thức.</p>
  </div>`,
      icon: "info",
      confirmButtonText: "Đóng",
      width: "80%", // Đặt chiều rộng mong muốn (px, %, vw)
    });
  }
  
  // Xuất hàm để dùng ở các file khác
  if (typeof module !== "undefined" && module.exports) {
    module.exports = { showRatingRules };
  } else {
    window.showRatingRules = showRatingRules; // Để dùng trong browser
  }
  