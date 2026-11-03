---
description: "Intltool là công cụ quốc tế hóa dùng để trích xuất các chuỗi cần dịch từ mã nguồn."
---

# 8.45. Intltool-0.51.0

Intltool là công cụ quốc tế hóa dùng để trích xuất các chuỗi cần dịch từ mã nguồn.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 1.5 MB

## 8.45.1. Cài đặt Intltool

Trước tiên, sửa một cảnh báo do perl-5.22 trở lên gây ra:

```bash
sed -i 's:\\\${:\\\$\\{:' intltool-update.in
```

{% hint style="info" %}
**Ghi chú**

Biểu thức chính quy ở trên trông lạ vì có nhiều dấu gạch chéo ngược. Thực chất nó chỉ thêm một dấu gạch chéo ngược trước ký tự ngoặc nhọn đóng trong chuỗi '\\${', cho ra '\\$\\{'.
{% endhint %}

Chuẩn bị biên dịch Intltool:

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
install -v -Dm644 doc/I18N-HOWTO /usr/share/doc/intltool-0.51.0/I18N-HOWTO
```

## 8.45.2. Nội dung của Intltool

* **Chương trình được cài:** intltool-extract, intltool-merge, intltool-prepare, intltool-update và intltoolize
* **Thư mục được cài:** /usr/share/doc/intltool-0.51.0 và /usr/share/intltool

### Mô tả ngắn

* `intltoolize` — Chuẩn bị một gói để dùng intltool
* `intltool-extract` — Tạo các tệp header mà `gettext` có thể đọc
* `intltool-merge` — Gộp các chuỗi đã dịch vào nhiều loại tệp khác nhau
* `intltool-prepare` — Cập nhật các tệp pot và gộp chúng với các tệp dịch
* `intltool-update` — Cập nhật các tệp mẫu po và gộp chúng với bản dịch

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/intltool.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/intltool.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/intltool.html)
