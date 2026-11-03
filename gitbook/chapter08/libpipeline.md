---
description: "Gói Libpipeline chứa một thư viện để thao tác với các pipeline của tiến trình con một cách linh hoạt và thuận tiện."
---

# 8.68. Libpipeline-1.5.8

Gói Libpipeline chứa một thư viện để thao tác với các pipeline của tiến trình con một cách linh hoạt và thuận tiện.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 10 MB

## 8.68.1. Cài đặt Libpipeline

Chuẩn bị biên dịch Libpipeline:

```bash
./configure --prefix=/usr
```

Biên dịch gói:

```bash
make
```

Các bài kiểm thử cần thư viện `Check`, vốn đã bị loại khỏi LFS.

Cài đặt gói:

```bash
make install
```

## 8.68.2. Nội dung của Libpipeline

* **Thư viện được cài:** libpipeline.so

### Mô tả ngắn

* `libpipeline` — Thư viện này dùng để dựng các pipeline giữa các tiến trình con một cách an toàn

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/libpipeline.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/libpipeline.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/libpipeline.html)
