---
description: "Gói MPC chứa một thư viện cho số học số phức với độ chính xác cao tùy ý và làm tròn kết quả đúng."
---

# 8.23. MPC-1.3.1

Gói MPC chứa một thư viện cho số học số phức với độ chính xác cao tùy ý và làm tròn kết quả đúng.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 22 MB

## 8.23.1. Cài đặt MPC

Chuẩn bị biên dịch MPC:

```bash
./configure --prefix=/usr    \
            --disable-static \
            --docdir=/usr/share/doc/mpc-1.3.1
```

Biên dịch gói và tạo tài liệu HTML:

```bash
make
make html
```

Để kiểm thử kết quả, chạy:

```bash
make check
```

Cài đặt gói cùng tài liệu của nó:

```bash
make install
make install-html
```

## 8.23.2. Nội dung của MPC

* **Thư viện được cài:** libmpc.so
* **Thư mục được cài:** /usr/share/doc/mpc-1.3.1

### Mô tả ngắn

* `libmpc` — Chứa các hàm toán học số phức

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/mpc.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/mpc.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/mpc.html)
