---
description: "Tùy chọn này bảo các chương trình do gói tạo ra tìm tệp cấu hình trong \/etc."
---

# 8.42. Less-679

Gói Less chứa một trình xem tệp văn bản.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 16 MB

## 8.42.1. Cài đặt Less

Chuẩn bị biên dịch Less:

```bash
./configure --prefix=/usr --sysconfdir=/etc
```

**Ý nghĩa các tùy chọn configure:**

**`--sysconfdir=/etc`**

> Tùy chọn này bảo các chương trình do gói tạo ra tìm tệp cấu hình trong `/etc`.

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

## 8.42.2. Nội dung của Less

* **Chương trình được cài:** less, lessecho và lesskey

### Mô tả ngắn

* `less` — Trình xem tệp (pager); hiển thị nội dung tệp được chỉ định, cho phép người dùng cuộn, tìm chuỗi và nhảy đến các dấu đánh dấu (mark)
* `lessecho` — Cần thiết để mở rộng các ký tự đặc biệt, như *\** và *?*, trong tên tệp trên hệ thống Unix
* `lesskey` — Dùng để chỉ định các phím tắt cho `less`

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/less.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/less.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/less.html)
