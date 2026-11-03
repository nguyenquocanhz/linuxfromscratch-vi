---
description: "Gói Libxcrypt chứa một thư viện hiện đại để băm một chiều mật khẩu."
---

# 8.27. Libxcrypt-4.4.38

Gói Libxcrypt chứa một thư viện hiện đại để băm một chiều mật khẩu.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 12 MB

## 8.27.1. Cài đặt Libxcrypt

Chuẩn bị biên dịch Libxcrypt:

```bash
./configure --prefix=/usr                \
            --enable-hashes=strong,glibc \
            --enable-obsolete-api=no     \
            --disable-static             \
            --disable-failure-tokens
```

**Ý nghĩa của các tùy chọn configure mới:**

**`--enable-hashes=strong,glibc`**

> Dựng các thuật toán băm mạnh được khuyến nghị cho các trường hợp cần bảo mật, cùng các thuật toán băm do `libcrypt` truyền thống của Glibc cung cấp để tương thích.

**`--enable-obsolete-api=no`**

> Tắt các hàm API lỗi thời. Một hệ thống Linux hiện đại dựng từ mã nguồn không cần chúng.

**`--disable-failure-tokens`**

> Tắt tính năng failure token. Nó cần thiết để tương thích với các thư viện băm truyền thống trên một số nền tảng, nhưng hệ thống Linux dựa trên Glibc không cần đến.

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

{% hint style="info" %}
**Ghi chú**

Các hướng dẫn ở trên đã tắt các hàm API lỗi thời vì không gói nào cài bằng cách biên dịch từ mã nguồn sẽ liên kết với chúng khi chạy. Tuy nhiên, những ứng dụng chỉ có bản nhị phân mà ta biết có liên kết với các hàm này đều đòi hỏi ABI phiên bản 1. Nếu bạn buộc phải có các hàm đó vì một ứng dụng chỉ có bản nhị phân nào đó hoặc để tuân thủ LSB, hãy dựng lại gói bằng các lệnh sau:

```bash
make distclean
./configure --prefix=/usr                \
            --enable-hashes=strong,glibc \
            --enable-obsolete-api=glibc  \
            --disable-static             \
            --disable-failure-tokens
make
cp -av --remove-destination .libs/libcrypt.so.1* /usr/lib
```
{% endhint %}

## 8.27.2. Nội dung của Libxcrypt

* **Thư viện được cài:** libcrypt.so

### Mô tả ngắn

* `libcrypt` — Chứa các hàm để băm mật khẩu

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/libxcrypt.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/libxcrypt.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/libxcrypt.html)
