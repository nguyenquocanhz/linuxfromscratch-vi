---
description: "Gói Autoconf chứa các chương trình để tạo shell script có thể tự động cấu hình mã nguồn."
---

# 8.46. Autoconf-2.72

Gói Autoconf chứa các chương trình để tạo shell script có thể tự động cấu hình mã nguồn.

* **Thời gian dựng ước tính:** dưới 0.1 SBU (khoảng 0.4 SBU kèm kiểm thử)
* **Dung lượng đĩa cần:** 25 MB

## 8.46.1. Cài đặt Autoconf

Chuẩn bị biên dịch Autoconf:

```bash
./configure --prefix=/usr
```

Biên dịch gói:

```bash
make
```

Để kiểm tra kết quả, chạy:

```bash
make check
```

Cài đặt gói:

```bash
make install
```

## 8.46.2. Nội dung của Autoconf

* **Chương trình được cài:** autoconf, autoheader, autom4te, autoreconf, autoscan, autoupdate và ifnames
* **Thư mục được cài:** /usr/share/autoconf

### Mô tả ngắn

* `autoconf` — Tạo các shell script tự động cấu hình các gói mã nguồn phần mềm để thích ứng với nhiều loại hệ giống Unix; các script cấu hình do nó tạo ra là độc lập—chạy chúng không cần chương trình `autoconf`
* `autoheader` — Công cụ tạo các tệp mẫu chứa câu lệnh C *\#define* cho configure sử dụng
* `autom4te` — Một wrapper cho bộ xử lý macro M4
* `autoreconf` — Tự động chạy `autoconf`, `autoheader`, `aclocal`, `automake`, `gettextize` và `libtoolize` theo đúng thứ tự để tiết kiệm thời gian khi có thay đổi trong các tệp mẫu của `autoconf` và `automake`
* `autoscan` — Giúp tạo tệp `configure.in` cho một gói phần mềm; nó xem xét các tệp nguồn trong cây thư mục, tìm các vấn đề di động (portability) phổ biến, và tạo tệp `configure.scan` làm tệp `configure.in` sơ bộ cho gói
* `autoupdate` — Sửa tệp `configure.in` vẫn gọi các macro `autoconf` bằng tên cũ để dùng tên macro hiện tại
* `ifnames` — Hỗ trợ khi viết tệp `configure.in` cho một gói phần mềm; nó in ra các định danh mà gói dùng trong các điều kiện của bộ tiền xử lý C \[Nếu một gói đã được thiết lập có tính di động nhất định, chương trình này giúp xác định `configure` cần kiểm tra những gì. Nó cũng có thể điền vào chỗ thiếu trong tệp `configure.in` do `autoscan` tạo ra.\]

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/autoconf.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/autoconf.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/autoconf.html)
