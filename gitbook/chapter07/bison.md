---
description: "Gói Bison chứa một trình sinh bộ phân tích cú pháp (parser generator)."
---

# 7.8. Bison-3.8.2

Gói Bison chứa một trình sinh bộ phân tích cú pháp (parser generator).

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 58 MB

## 7.8.1. Cài đặt Bison

Chuẩn bị biên dịch Bison:

```bash
./configure --prefix=/usr \
            --docdir=/usr/share/doc/bison-3.8.2
```

**Ý nghĩa của tùy chọn configure mới:**

**`--docdir=/usr/share/doc/bison-3.8.2`**

> Báo cho hệ thống build cài tài liệu của bison vào một thư mục có kèm phiên bản.

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make install
```

Chi tiết về gói này nằm trong [Mục 8.34.2, “Nội dung của Bison.”](../chapter08/bison.md#contents-bison)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/bison.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/bison.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/bison.html)
