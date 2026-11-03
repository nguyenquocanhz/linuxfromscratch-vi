---
description: "Gói OpenSSL chứa các công cụ quản lý và thư viện liên quan đến mật mã. Chúng hữu ích để cung cấp chức năng mật mã cho các gói khác, như OpenSSH, ứng dụng e"
---

# 8.48. OpenSSL-3.5.2

Gói OpenSSL chứa các công cụ quản lý và thư viện liên quan đến mật mã. Chúng hữu ích để cung cấp chức năng mật mã cho các gói khác, như OpenSSH, ứng dụng email và trình duyệt web (để truy cập các trang HTTPS).

* **Thời gian dựng ước tính:** 1.9 SBU
* **Dung lượng đĩa cần:** 1.1 GB

## 8.48.1. Cài đặt OpenSSL

Chuẩn bị biên dịch OpenSSL:

```bash
./config --prefix=/usr         \
         --openssldir=/etc/ssl \
         --libdir=lib          \
         shared                \
         zlib-dynamic
```

Biên dịch gói:

```bash
make
```

Để kiểm thử kết quả, chạy:

```bash
HARNESS_JOBS=$(nproc) make test
```

Có một bài kiểm thử, 30-test\_afalg.t, được biết là sẽ thất bại nếu kernel của máy host không bật `CONFIG_CRYPTO_USER_API_SKCIPHER`, hoặc không bật tùy chọn nào cung cấp AES với CBC (ví dụ tổ hợp `CONFIG_CRYPTO_AES` và `CONFIG_CRYPTO_CBC`, hoặc `CONFIG_CRYPTO_AES_NI_INTEL` nếu CPU hỗ trợ AES-NI). Nếu thất bại, bạn có thể yên tâm bỏ qua.

Cài đặt gói:

```bash
sed -i '/INSTALL_LIBS/s/libcrypto.a libssl.a//' Makefile
make MANSUFFIX=ssl install
```

Thêm số phiên bản vào tên thư mục tài liệu để nhất quán với các gói khác:

```bash
mv -v /usr/share/doc/openssl /usr/share/doc/openssl-3.5.2
```

Nếu muốn, cài thêm một số tài liệu bổ sung:

```bash
cp -vfr doc/* /usr/share/doc/openssl-3.5.2
```

{% hint style="info" %}
**Ghi chú**

Bạn nên cập nhật OpenSSL khi có phiên bản mới vá các lỗ hổng bảo mật được công bố. Từ OpenSSL 3.0.0, cách đánh số phiên bản của OpenSSL theo định dạng MAJOR.MINOR.PATCH. Khả năng tương thích API/ABI được đảm bảo với cùng số phiên bản MAJOR. Vì LFS chỉ cài các thư viện dùng chung, bạn không cần biên dịch lại các gói liên kết với `libcrypto.so` hay `libssl.so` *khi nâng cấp lên phiên bản có cùng số phiên bản MAJOR*.

Tuy nhiên, mọi chương trình đang chạy mà liên kết với các thư viện đó đều cần được dừng và khởi động lại. Đọc các mục liên quan trong [Mục 8.2.1, “Upgrade Issues”](pkgmgt.md#pkgmgmt-upgrade-issues) để biết chi tiết.
{% endhint %}

## 8.48.2. Nội dung của OpenSSL

* **Chương trình được cài:** c\_rehash và openssl
* **Thư viện được cài:** libcrypto.so và libssl.so
* **Thư mục được cài:** /etc/ssl, /usr/include/openssl, /usr/lib/engines và /usr/share/doc/openssl-3.5.2

### Mô tả ngắn

* `c_rehash` — là một script `Perl` quét mọi tệp trong một thư mục và thêm các liên kết mềm theo giá trị băm của chúng. Việc dùng `c_rehash` được xem là lỗi thời và nên thay bằng lệnh `openssl rehash`
* `openssl` — là công cụ dòng lệnh để dùng các chức năng mật mã khác nhau của thư viện crypto trong `OpenSSL` từ shell. Nó có thể dùng cho nhiều chức năng được mô tả trong [openssl(1)](https://man.archlinux.org/man/openssl.1)
* `libcrypto.so` — cài đặt nhiều thuật toán mật mã được dùng trong các chuẩn Internet khác nhau. Các dịch vụ của thư viện này được các bản cài đặt SSL, TLS và S/MIME của `OpenSSL` sử dụng, và cũng được dùng để cài đặt `OpenSSH`, `OpenPGP` cùng các chuẩn mật mã khác
* `libssl.so` — cài đặt giao thức Transport Layer Security (TLS v1). Nó cung cấp một API phong phú, tài liệu có trong [ssl(7)](https://man.archlinux.org/man/ssl.7)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/openssl.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/openssl.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/openssl.html)
