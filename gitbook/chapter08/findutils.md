---
description: "Gói Findutils chứa các chương trình để tìm tệp. Có chương trình để quét toàn bộ tệp trong một cây thư mục, và để tạo, duy trì và tìm kiếm trong một cơ sở d"
---

# 8.62. Findutils-4.10.0

Gói Findutils chứa các chương trình để tìm tệp. Có chương trình để quét toàn bộ tệp trong một cây thư mục, và để tạo, duy trì và tìm kiếm trong một cơ sở dữ liệu (thường nhanh hơn lệnh find đệ quy, nhưng không đáng tin nếu cơ sở dữ liệu chưa được cập nhật gần đây). Findutils cũng cung cấp chương trình `xargs`, dùng để chạy một lệnh chỉ định trên từng tệp được chọn qua tìm kiếm.

* **Thời gian dựng ước tính:** 0.7 SBU
* **Dung lượng đĩa cần:** 61 MB

## 8.62.1. Cài đặt Findutils

Chuẩn bị biên dịch Findutils:

```bash
./configure --prefix=/usr --localstatedir=/var/lib/locate
```

**Ý nghĩa các tùy chọn configure:**

**`--localstatedir`**

> Tùy chọn này chuyển cơ sở dữ liệu của `locate` sang `/var/lib/locate`, là vị trí tuân thủ FHS.

Biên dịch gói:

```bash
make
```

Để kiểm thử kết quả, chạy:

```bash
chown -R tester .
su tester -c "PATH=$PATH make check"
```

Cài đặt gói:

```bash
make install
```

## 8.62.2. Nội dung của Findutils

* **Chương trình được cài:** find, locate, updatedb, và xargs
* **Thư mục được cài:** /var/lib/locate

### Mô tả ngắn

* `find` — Tìm trong các cây thư mục đã cho những tệp khớp với tiêu chí chỉ định
* `locate` — Tìm trong cơ sở dữ liệu tên tệp và báo những tên chứa một chuỗi cho trước hoặc khớp một mẫu cho trước
* `updatedb` — Cập nhật cơ sở dữ liệu của `locate`; nó quét toàn bộ hệ thống tệp (kể cả các hệ thống tệp khác đang được mount, trừ khi được yêu cầu bỏ qua) và đưa mọi tên tệp tìm thấy vào cơ sở dữ liệu
* `xargs` — Dùng để áp dụng một lệnh cho một danh sách tệp

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/findutils.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/findutils.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/findutils.html)
