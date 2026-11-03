---
description: "Thư viện Libffi cung cấp một giao diện lập trình cấp cao, di động cho nhiều quy ước gọi hàm (calling convention). Nhờ đó lập trình viên có thể gọi bất kỳ h"
---

# 8.50. Libffi-3.5.2

Thư viện Libffi cung cấp một giao diện lập trình cấp cao, di động cho nhiều quy ước gọi hàm (calling convention). Nhờ đó lập trình viên có thể gọi bất kỳ hàm nào được mô tả bởi một calling interface tại thời điểm chạy.

FFI là viết tắt của Foreign Function Interface (giao diện hàm ngoại lai). FFI cho phép một chương trình viết bằng ngôn ngữ này gọi chương trình viết bằng ngôn ngữ khác. Cụ thể, Libffi có thể làm cầu nối giữa một trình thông dịch như Perl hay Python với các hàm của thư viện chia sẻ viết bằng C hoặc C++.

* **Thời gian dựng ước tính:** 1.7 SBU
* **Dung lượng đĩa cần:** 10 MB

## 8.50.1. Cài đặt Libffi

{% hint style="info" %}
**Ghi chú**

Giống GMP, Libffi được dựng với các tối ưu hóa dành riêng cho bộ xử lý đang dùng. Nếu bạn dựng cho một hệ thống khác, hãy đổi giá trị tham số `--with-gcc-arch=` trong lệnh dưới đây thành tên kiến trúc được hỗ trợ đầy đủ bởi **cả** CPU của máy host lẫn CPU của hệ thống đó. Nếu không, mọi ứng dụng liên kết với `libffi` sẽ gây lỗi Illegal Operation. Nếu không tìm được giá trị an toàn cho cả hai CPU, hãy thay tham số bằng `--without-gcc-arch` để tạo ra một thư viện tổng quát.
{% endhint %}

Chuẩn bị biên dịch Libffi:

```bash
./configure --prefix=/usr    \
            --disable-static \
            --with-gcc-arch=native
```

**Ý nghĩa của tùy chọn configure:**

**`--with-gcc-arch=native`**

> Đảm bảo GCC tối ưu cho hệ thống hiện tại. Nếu không chỉ định, hệ thống sẽ bị đoán và mã sinh ra có thể không đúng. Nếu mã sinh ra sẽ được sao chép từ hệ thống gốc sang một hệ thống yếu hơn, hãy dùng hệ thống yếu hơn đó làm tham số. Chi tiết về các loại hệ thống khác, xem [các tùy chọn x86 trong sách hướng dẫn GCC](https://gcc.gnu.org/onlinedocs/gcc-15.2.0/gcc/x86-Options.html).

Biên dịch gói:

```bash
make
```

Để kiểm thử kết quả, chạy:

```bash
make check
```

Cài đặt gói:

```bash
make install
```

## 8.50.2. Nội dung của Libffi

* **Thư viện được cài:** libffi.so

### Mô tả ngắn

* `libffi` — Chứa các hàm API của foreign function interface

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/libffi.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/libffi.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/libffi.html)
