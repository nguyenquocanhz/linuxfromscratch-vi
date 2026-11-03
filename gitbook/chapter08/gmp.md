---
description: "Gói GMP chứa các thư viện toán học. Chúng có các hàm hữu ích cho số học với độ chính xác tùy ý."
---

# 8.21. GMP-6.3.0

Gói GMP chứa các thư viện toán học. Chúng có các hàm hữu ích cho số học với độ chính xác tùy ý.

* **Thời gian dựng ước tính:** 0.3 SBU
* **Dung lượng đĩa cần:** 54 MB

## 8.21.1. Cài đặt GMP

{% hint style="info" %}
**Note**

Nếu bạn đang dựng cho x86 32-bit, nhưng CPU của bạn có khả năng chạy mã 64-bit *và* bạn đã đặt `CFLAGS` trong môi trường, script configure sẽ cố cấu hình cho 64-bit và thất bại. Hãy tránh điều này bằng cách chạy lệnh configure bên dưới với

```bash
ABI=32 ./configure ...
```
{% endhint %}

{% hint style="info" %}
**Note**

Cài đặt mặc định của GMP tạo ra các thư viện tối ưu cho bộ xử lý của máy host. Nếu muốn có thư viện phù hợp với các bộ xử lý yếu hơn CPU của host, có thể tạo các thư viện generic bằng cách thêm tùy chọn `--host=none-linux-gnu` vào lệnh `configure`.
{% endhint %}

Trước tiên, hãy điều chỉnh để tương thích với gcc-15 trở lên:

```bash
sed -i '/long long t1;/,+1s/()/(...)/' configure
```

Chuẩn bị biên dịch GMP:

```bash
./configure --prefix=/usr    \
            --enable-cxx     \
            --disable-static \
            --docdir=/usr/share/doc/gmp-6.3.0
```

**Ý nghĩa các tùy chọn configure mới:**

**`--enable-cxx`**

> Tham số này bật hỗ trợ C++

**`--docdir=/usr/share/doc/gmp-6.3.0`**

> Biến này chỉ định đúng nơi đặt tài liệu.

Biên dịch gói và sinh tài liệu HTML:

```bash
make
make html
```

{% hint style="warning" %}
**Important**

Bộ kiểm thử của GMP trong mục này được xem là then chốt. Không được bỏ qua trong bất kỳ trường hợp nào.
{% endhint %}

Kiểm thử kết quả:

```bash
make check 2>&1 | tee gmp-check-log
```

{% hint style="danger" %}
**Caution**

Mã trong gmp được tối ưu rất cao cho bộ xử lý nơi nó được dựng. Đôi khi, mã phát hiện bộ xử lý nhận diện sai khả năng của hệ thống, dẫn đến lỗi trong các bài kiểm thử hoặc trong các ứng dụng khác dùng thư viện gmp, kèm thông báo `Illegal instruction`. Trong trường hợp này, nên cấu hình lại gmp với tùy chọn `--host=none-linux-gnu` và dựng lại.
{% endhint %}

Đảm bảo có ít nhất 199 bài kiểm thử trong bộ kiểm thử đạt. Kiểm tra kết quả bằng lệnh sau:

```bash
awk '/# PASS:/{total+=$3} ; END{print total}' gmp-check-log
```

Cài đặt gói và tài liệu của nó:

```bash
make install
make install-html
```

## 8.21.2. Nội dung của GMP

* **Thư viện được cài:** libgmp.so và libgmpxx.so
* **Thư mục được cài:** /usr/share/doc/gmp-6.3.0

### Mô tả ngắn

* `libgmp` — Chứa các hàm toán học độ chính xác cao
* `libgmpxx` — Chứa các hàm toán học độ chính xác cao cho C++

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/gmp.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/gmp.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/gmp.html)
