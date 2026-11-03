---
description: "Gói Make chứa chương trình điều khiển việc tạo ra các tệp thực thi và các tệp không phải mã nguồn khác của một gói từ các tệp nguồn."
---

# 8.69. Make-4.4.1

Gói Make chứa chương trình điều khiển việc tạo ra các tệp thực thi và các tệp không phải mã nguồn khác của một gói từ các tệp nguồn.

* **Thời gian dựng ước tính:** 0.7 SBU
* **Dung lượng đĩa cần:** 13 MB

## 8.69.1. Cài đặt Make

Chuẩn bị biên dịch Make:

```bash
./configure --prefix=/usr
```

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

## 8.69.2. Nội dung của Make

* **Chương trình được cài:** make

### Mô tả ngắn

* `make` — Tự động xác định phần nào của gói cần được biên dịch (lại) rồi chạy các lệnh tương ứng

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/make.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/make.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/make.html)
