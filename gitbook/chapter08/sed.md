---
description: "Bản dịch tiếng Việt của sách Linux From Scratch, kèm mẹo thực chiến từ cộng đồng."
---

# 8.31. Sed-4.9

Gói Sed chứa một trình soạn thảo luồng (stream editor).

* **Thời gian dựng ước tính:** 0.3 SBU
* **Dung lượng đĩa cần:** 30 MB

## 8.31.1. Cài đặt Sed

Chuẩn bị biên dịch Sed:

```bash
./configure --prefix=/usr
```

Biên dịch gói và tạo tài liệu HTML:

```bash
make
make html
```

Để kiểm thử kết quả, chạy:

```bash
chown -R tester .
su tester -c "PATH=$PATH make check"
```

Cài đặt gói cùng tài liệu của nó:

```bash
make install
install -d -m755           /usr/share/doc/sed-4.9
install -m644 doc/sed.html /usr/share/doc/sed-4.9
```

## 8.31.2. Nội dung của Sed

* **Chương trình được cài:** sed
* **Thư mục được cài:** /usr/share/doc/sed-4.9

### Mô tả ngắn

* `sed` — Lọc và biến đổi các tệp văn bản chỉ trong một lượt

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/sed.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/sed.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/sed.html)
