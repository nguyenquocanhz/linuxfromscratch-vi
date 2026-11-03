---
description: "Khởi động một hệ thống Linux gồm nhiều tác vụ. Quá trình này phải mount cả hệ thống tệp ảo lẫn thật, khởi tạo thiết bị, kiểm tra tính toàn vẹn của hệ thống"
---

# 9.1. Introduction

Khởi động một hệ thống Linux gồm nhiều tác vụ. Quá trình này phải mount cả hệ thống tệp ảo lẫn thật, khởi tạo thiết bị, kiểm tra tính toàn vẹn của hệ thống tệp, mount và kích hoạt các phân vùng hoặc tệp swap, đặt đồng hồ hệ thống, bật mạng, khởi chạy các daemon mà hệ thống cần, và hoàn thành mọi tác vụ tùy chỉnh khác do người dùng chỉ định. Quá trình này phải được tổ chức để các tác vụ chạy đúng thứ tự và nhanh nhất có thể.

## 9.1.1. System V

System V là quy trình khởi động cổ điển, được dùng trong Unix và các hệ thống giống Unix như Linux từ khoảng năm 1983. Nó gồm một chương trình nhỏ, `init`, thiết lập các tiến trình cơ bản như `login` (qua getty) và chạy một script. Script này, thường tên là `rc`, điều khiển việc chạy một loạt script bổ sung thực hiện các tác vụ cần thiết để khởi tạo hệ thống.

Chương trình `init` được điều khiển bởi tệp `/etc/inittab` và được tổ chức thành các run level để người dùng chọn. Trong LFS, chúng được dùng như sau:

0 — dừng 
 1 — Chế độ một người dùng 
 2 — Người dùng tự định nghĩa 
 3 — Chế độ đa người dùng đầy đủ 
 4 — Người dùng tự định nghĩa 
 5 — Chế độ đa người dùng đầy đủ kèm trình quản lý đăng nhập đồ họa 
 6 — khởi động lại

Run level mặc định thường là 3 hoặc 5.

### Advantages

* Hệ thống đã được kiểm chứng, được hiểu rõ.
* Dễ tùy biến.

### Disadvantages

* Có thể khởi động chậm hơn. Một hệ thống LFS cơ bản có tốc độ trung bình mất 8-12 giây, tính từ thông điệp kernel đầu tiên đến lúc hiện dấu nhắc đăng nhập. Kết nối mạng thường được thiết lập khoảng 2 giây sau dấu nhắc đăng nhập.
* Xử lý tuần tự các tác vụ khởi động. Điều này liên quan đến điểm trước: chỉ cần một tiến trình bị chậm, chẳng hạn kiểm tra hệ thống tệp, là toàn bộ quá trình khởi động bị chậm theo.
* Không hỗ trợ trực tiếp các tính năng nâng cao như control group (cgroups) và chia sẻ công bằng theo từng người dùng (per-user fair share scheduling).
* Thêm script đòi hỏi phải tự quyết định thứ tự chạy một cách thủ công, cố định.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter09/introduction.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter09/introduction.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter09/introduction.html)
