---
description: "Gói Bison chứa một trình sinh bộ phân tích cú pháp (parser generator)."
---

# 8.34. Bison-3.8.2

Gói Bison chứa một trình sinh bộ phân tích cú pháp (parser generator).

* **Thời gian dựng ước tính:** 2.1 SBU
* **Dung lượng đĩa cần:** 63 MB

## 8.34.1. Cài đặt Bison

Chuẩn bị biên dịch Bison:

```bash
./configure --prefix=/usr --docdir=/usr/share/doc/bison-3.8.2
```

Biên dịch gói:

```bash
make
```

Để kiểm tra kết quả, chạy:

```bash
make check
```

Cài đặt gói:

```bash
make install
```

## 8.34.2. Nội dung của Bison

* **Chương trình được cài:** bison và yacc
* **Thư viện được cài:** liby.a
* **Thư mục được cài:** /usr/share/bison

### Mô tả ngắn

* `bison` — Từ một loạt quy tắc, sinh ra chương trình phân tích cấu trúc tệp văn bản; Bison là bản thay thế cho Yacc (Yet Another Compiler Compiler)
* `yacc` — Một wrapper cho `bison`, dành cho các chương trình vẫn gọi `yacc` thay vì `bison`; nó gọi `bison` với tùy chọn `-y`
* `liby` — Thư viện Yacc chứa cài đặt các hàm `yyerror` và `main` tương thích Yacc; thư viện này thường không hữu ích lắm, nhưng POSIX yêu cầu có nó

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/bison.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/bison.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/bison.html)
