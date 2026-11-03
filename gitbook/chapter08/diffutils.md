---
description: "Gói Diffutils chứa các chương trình hiển thị sự khác biệt giữa các tệp hoặc thư mục."
---

# 8.60. Diffutils-3.12

Gói Diffutils chứa các chương trình hiển thị sự khác biệt giữa các tệp hoặc thư mục.

* **Thời gian dựng ước tính:** 0.5 SBU
* **Dung lượng đĩa cần:** 51 MB

## 8.60.1. Cài đặt Diffutils

Chuẩn bị biên dịch Diffutils:

```bash
./configure --prefix=/usr
```

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

## 8.60.2. Nội dung của Diffutils

* **Chương trình được cài:** cmp, diff, diff3, và sdiff

### Mô tả ngắn

* `cmp` — So sánh hai tệp và báo mọi khác biệt theo từng byte
* `diff` — So sánh hai tệp hoặc thư mục và báo những dòng nào trong các tệp khác nhau
* `diff3` — So sánh ba tệp theo từng dòng
* `sdiff` — Trộn hai tệp và xuất kết quả theo kiểu tương tác

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/diffutils.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/diffutils.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/diffutils.html)
