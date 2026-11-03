---
description: "Gói Acl chứa các tiện ích để quản lý Danh sách kiểm soát truy cập (Access Control List), dùng để định nghĩa quyền truy cập tùy ý chi tiết cho tệp và thư mụ"
---

# 8.25. Acl-2.3.2

Gói Acl chứa các tiện ích để quản lý Danh sách kiểm soát truy cập (Access Control List), dùng để định nghĩa quyền truy cập tùy ý chi tiết cho tệp và thư mục.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 6.5 MB

## 8.25.1. Cài đặt Acl

Chuẩn bị biên dịch Acl:

```bash
./configure --prefix=/usr    \
            --disable-static \
            --docdir=/usr/share/doc/acl-2.3.2
```

Biên dịch gói:

```bash
make
```

Các bài kiểm thử Acl phải chạy trên hệ thống tệp hỗ trợ kiểm soát truy cập. Để kiểm tra kết quả, chạy:

```bash
make check
```

Có một bài kiểm thử tên `test/cp.test` được biết là sẽ thất bại vì `Coreutils` chưa được dựng với hỗ trợ `Acl`.

Cài đặt gói:

```bash
make install
```

## 8.25.2. Nội dung của Acl

* **Chương trình được cài:** chacl, getfacl và setfacl
* **Thư viện được cài:** libacl.so
* **Thư mục được cài:** /usr/include/acl và /usr/share/doc/acl-2.3.2

### Mô tả ngắn

* `chacl` — Thay đổi danh sách kiểm soát truy cập của một tệp hoặc thư mục
* `getfacl` — Lấy danh sách kiểm soát truy cập của tệp
* `setfacl` — Đặt danh sách kiểm soát truy cập của tệp
* `libacl` — Chứa các hàm thư viện để thao tác Danh sách kiểm soát truy cập

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/acl.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/acl.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/acl.html)
