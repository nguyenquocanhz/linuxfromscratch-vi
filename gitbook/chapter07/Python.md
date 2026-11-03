---
description: "Gói Python 3 chứa môi trường phát triển Python. Nó hữu ích cho lập trình hướng đối tượng, viết script, tạo mẫu thử chương trình lớn và phát triển cả ứng dụ"
---

# 7.10. Python-3.13.7

Gói Python 3 chứa môi trường phát triển Python. Nó hữu ích cho lập trình hướng đối tượng, viết script, tạo mẫu thử chương trình lớn và phát triển cả ứng dụng hoàn chỉnh. Python là một ngôn ngữ máy tính thông dịch.

* **Thời gian dựng ước tính:** 0.5 SBU
* **Dung lượng đĩa cần:** 546 MB

## 7.10.1. Cài đặt Python

{% hint style="info" %}
**Ghi chú**

Có hai tệp gói có tên bắt đầu bằng tiền tố “python”. Tệp cần giải nén là `Python-3.13.7.tar.xz` (chú ý chữ cái đầu viết hoa).
{% endhint %}

Chuẩn bị biên dịch Python:

```bash
./configure --prefix=/usr       \
            --enable-shared     \
            --without-ensurepip \
            --without-static-libpython
```

**Ý nghĩa của tùy chọn configure:**

**`--enable-shared`**

> Tùy chọn này ngăn cài đặt các thư viện tĩnh.

**`--without-ensurepip`**

> Tùy chọn này tắt trình cài gói của Python, thứ chưa cần ở giai đoạn này.

**`--without-static-libpython`**

> Tùy chọn này ngăn dựng một thư viện tĩnh lớn nhưng không cần thiết.

Biên dịch gói:

```bash
make
```

{% hint style="info" %}
**Ghi chú**

Một số module Python 3 chưa dựng được lúc này vì các phụ thuộc chưa được cài. Với module `ssl`, sẽ có thông báo `Python requires a OpenSSL 1.1.1 or newer`. Hãy bỏ qua thông báo này. Chỉ cần chắc rằng lệnh `make` cấp cao nhất không thất bại. Các module tùy chọn chưa cần ngay và sẽ được dựng ở [Chương 8](../chapter08/chapter08.md).
{% endhint %}

Cài đặt gói:

```bash
make install
```

Chi tiết về gói này nằm trong [Mục 8.51.2, “Nội dung của Python 3.”](../chapter08/Python.md#contents-python)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/Python.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/Python.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/Python.html)
