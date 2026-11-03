---
description: "Gói Patch chứa chương trình để sửa đổi hoặc tạo tệp bằng cách áp dụng một tệp “patch” (bản vá), thường được tạo bởi chương trình diff."
---

# 8.70. Patch-2.8

Gói Patch chứa chương trình để sửa đổi hoặc tạo tệp bằng cách áp dụng một tệp “patch” (bản vá), thường được tạo bởi chương trình `diff`.

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 13 MB

## 8.70.1. Cài đặt Patch

Chuẩn bị biên dịch Patch:

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

## 8.70.2. Nội dung của Patch

* **Chương trình được cài:** patch

### Mô tả ngắn

* `patch` — Sửa đổi các tệp theo một tệp patch (tệp patch thường là danh sách khác biệt do chương trình `diff` tạo ra. Bằng cách áp dụng các khác biệt này lên tệp gốc, `patch` tạo ra các phiên bản đã được vá.)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/patch.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/patch.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/patch.html)
