---
description: "Gói Automake chứa các chương trình để sinh Makefile dùng với Autoconf."
---

# 8.47. Automake-1.18.1

Gói Automake chứa các chương trình để sinh Makefile dùng với Autoconf.

* **Thời gian dựng ước tính:** dưới 0.1 SBU (khoảng 1.1 SBU kèm kiểm thử)
* **Dung lượng đĩa cần:** 123 MB

## 8.47.1. Cài đặt Automake

Chuẩn bị biên dịch Automake:

```bash
./configure --prefix=/usr --docdir=/usr/share/doc/automake-1.18.1
```

Biên dịch gói:

```bash
make
```

Dùng bốn tác vụ song song giúp tăng tốc các bài kiểm thử, kể cả trên hệ thống có ít nhân logic hơn, do độ trễ nội bộ trong từng bài. Để kiểm tra kết quả, chạy:

```bash
make -j$(($(nproc)>4?$(nproc):4)) check
```

Thay `$((...))` bằng số nhân logic bạn muốn dùng nếu không muốn dùng hết.

Cài đặt gói:

```bash
make install
```

## 8.47.2. Nội dung của Automake

* **Chương trình được cài:** aclocal, aclocal-1.18 (hard link với aclocal), automake và automake-1.18 (hard link với automake)
* **Thư mục được cài:** /usr/share/aclocal-1.18, /usr/share/automake-1.18 và /usr/share/doc/automake-1.18.1

### Mô tả ngắn

* `aclocal` — Sinh các tệp `aclocal.m4` dựa trên nội dung các tệp `configure.in`
* `aclocal-1.18` — Một hard link tới `aclocal`
* `automake` — Công cụ tự động sinh các tệp `Makefile.in` từ các tệp `Makefile.am` \[Để tạo mọi tệp `Makefile.in` cho một gói, chạy chương trình này ở thư mục cấp cao nhất. Bằng cách quét tệp `configure.in`, nó tự tìm từng tệp `Makefile.am` phù hợp và sinh tệp `Makefile.in` tương ứng.\]
* `automake-1.18` — Một hard link tới `automake`

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/automake.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/automake.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/automake.html)
