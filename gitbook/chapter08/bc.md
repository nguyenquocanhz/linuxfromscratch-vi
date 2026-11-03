---
description: "Bỏ qua các phần của bộ kiểm thử sẽ không chạy được cho đến khi chương trình bc được cài."
---

# 8.14. Bc-7.0.3

Gói Bc chứa một ngôn ngữ xử lý số với độ chính xác tùy ý.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 7.8 MB

## 8.14.1. Cài đặt Bc

Chuẩn bị biên dịch Bc:

```bash
CC='gcc -std=c99' ./configure --prefix=/usr -G -O3 -r
```

**Ý nghĩa các tùy chọn configure:**

**`CC='gcc -std=c99'`**

> Tham số này chỉ định trình biên dịch và chuẩn C sẽ dùng.

**`-G`**

> Bỏ qua các phần của bộ kiểm thử sẽ không chạy được cho đến khi chương trình bc được cài.

**`-O3`**

> Chỉ định mức tối ưu hóa sẽ dùng.

**`-r`**

> Bật dùng `Readline` để cải thiện tính năng chỉnh sửa dòng của bc.

Biên dịch gói:

```bash
make
```

Để kiểm thử bc, chạy:

```bash
make test
```

Cài đặt gói:

```bash
make install
```

## 8.14.2. Nội dung của Bc

* **Chương trình được cài:** bc và dc

### Mô tả ngắn

* `bc` — Máy tính bấm trên dòng lệnh
* `dc` — Máy tính bấm dòng lệnh kiểu ký pháp Ba Lan đảo ngược

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/bc.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/bc.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/bc.html)
