---
description: "Gói MPFR chứa các hàm toán học với độ chính xác đa mức (multiple precision)."
---

# 8.22. MPFR-4.2.2

Gói MPFR chứa các hàm toán học với độ chính xác đa mức (multiple precision).

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 43 MB

## 8.22.1. Cài đặt MPFR

Chuẩn bị biên dịch MPFR:

```bash
./configure --prefix=/usr        \
            --disable-static     \
            --enable-thread-safe \
            --docdir=/usr/share/doc/mpfr-4.2.2
```

Biên dịch gói và tạo tài liệu HTML:

```bash
make
make html
```

{% hint style="warning" %}
**Quan trọng**

Bộ kiểm thử của MPFR trong mục này được coi là rất quan trọng. Đừng bỏ qua nó trong bất kỳ hoàn cảnh nào.
{% endhint %}

Kiểm thử kết quả và đảm bảo cả 198 bài kiểm thử đều đạt:

```bash
make check
```

Cài đặt gói cùng tài liệu của nó:

```bash
make install
make install-html
```

## 8.22.2. Nội dung của MPFR

* **Thư viện được cài:** libmpfr.so
* **Thư mục được cài:** /usr/share/doc/mpfr-4.2.2

### Mô tả ngắn

* `libmpfr` — Chứa các hàm toán học độ chính xác đa mức

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/mpfr.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/mpfr.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/mpfr.html)
