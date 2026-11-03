---
description: "Gói pkgconf là bản kế nhiệm của pkg-config, chứa công cụ truyền đường dẫn include và\/hoặc đường dẫn thư viện cho các công cụ dựng trong các giai đoạn confi"
---

# 8.19. Pkgconf-2.5.1

Gói pkgconf là bản kế nhiệm của pkg-config, chứa công cụ truyền đường dẫn include và/hoặc đường dẫn thư viện cho các công cụ dựng trong các giai đoạn configure và make khi cài đặt gói.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 5.0 MB

## 8.19.1. Cài đặt Pkgconf

Chuẩn bị biên dịch Pkgconf:

```bash
./configure --prefix=/usr    \
            --disable-static \
            --docdir=/usr/share/doc/pkgconf-2.5.1
```

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make install
```

Để giữ tương thích với Pkg-config gốc, tạo hai liên kết mềm:

```bash
ln -sv pkgconf   /usr/bin/pkg-config
ln -sv pkgconf.1 /usr/share/man/man1/pkg-config.1
```

## 8.19.2. Nội dung của Pkgconf

* **Chương trình được cài:** pkgconf, pkg-config (liên kết tới pkgconf) và bomtool
* **Thư viện được cài:** libpkgconf.so
* **Thư mục được cài:** /usr/share/doc/pkgconf-2.5.1

### Mô tả ngắn

* `pkgconf` — Trả về thông tin meta của thư viện hoặc gói được chỉ định
* `bomtool` — Tạo Software Bill Of Materials từ các tệp .pc của pkg-config
* `libpkgconf` — Chứa phần lớn chức năng của pkgconf, đồng thời cho phép các công cụ khác như IDE và trình biên dịch dùng các framework của nó

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/pkgconf.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/pkgconf.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/pkgconf.html)
