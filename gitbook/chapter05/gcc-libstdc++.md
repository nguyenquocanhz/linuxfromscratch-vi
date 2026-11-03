---
description: "Libstdc++ là thư viện C++ chuẩn. Nó cần thiết để biên dịch mã C++ (một phần GCC được viết bằng C++), nhưng chúng ta phải hoãn việc cài nó khi dựng gcc-pass"
---

<details>

<summary>Trick lỏ: Alias kiểm tra nhanh toolchain sau mỗi gói quan trọng</summary>

Sách có bước "sanity check" sau Glibc. Gói nó thành alias để chạy lại bất cứ lúc nào (ví dụ sau khi dựng libstdc++ hoặc khi nghi toolchain hỏng):

```bash
alias lfstc='echo "int main(){}" | $LFS_TGT-gcc -x c - -o /tmp/lfstc && readelf -l /tmp/lfstc | grep ld-linux; rm -f /tmp/lfstc'
```

Kết quả đúng phải có `[Requesting program interpreter: /lib64/ld-linux-x86-64.so.2]`. Không ra dòng nào, hoặc ra đường dẫn của hệ thống chủ → **dừng lại**, đừng làm tiếp, quay lại kiểm tra từng bước trước. Trong chroot ở Chương 8 thì dùng `gcc` thay cho `$LFS_TGT-gcc`.

[Tất cả trick lỏ →](../trick-lo.md#kiem-tra-toolchain)

</details>

# 5.6. Libstdc++ từ GCC-15.2.0

Libstdc++ là thư viện C++ chuẩn. Nó cần thiết để biên dịch mã C++ (một phần GCC được viết bằng C++), nhưng chúng ta phải hoãn việc cài nó khi dựng [gcc-pass1](gcc-pass1.md), vì Libstdc++ phụ thuộc vào Glibc mà lúc đó chưa có trong thư mục target.

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 1.3 GB

## 5.6.1. Cài đặt Libstdc++ cho target

{% hint style="info" %}
**Ghi chú**

`Libstdc++` là một phần của mã nguồn GCC. Trước hết bạn nên giải nén tarball GCC và chuyển vào thư mục `gcc-15.2.0`.
{% endhint %}

Tạo một thư mục dựng riêng cho Libstdc++ và chuyển vào đó:

```bash
mkdir -v build
cd       build
```

Chuẩn bị biên dịch Libstdc++:

```bash
../libstdc++-v3/configure      \
    --host=$LFS_TGT            \
    --build=$(../config.guess) \
    --prefix=/usr              \
    --disable-multilib         \
    --disable-nls              \
    --disable-libstdcxx-pch    \
    --with-gxx-include-dir=/tools/$LFS_TGT/include/c++/15.2.0
```

**Ý nghĩa các tùy chọn configure:**

**`--host=...`**

> Chỉ định dùng trình biên dịch chéo vừa dựng thay cho trình biên dịch trong `/usr/bin`.

**`--disable-libstdcxx-pch`**

> Tùy chọn này ngăn việc cài các tệp include biên dịch sẵn, vốn không cần ở giai đoạn này.

**`--with-gxx-include-dir=/tools/$LFS_TGT/include/c++/15.2.0`**

> Chỉ định thư mục cài các tệp include. Vì Libstdc++ là thư viện C++ chuẩn của LFS, thư mục này phải khớp với nơi trình biên dịch C++ (`$LFS_TGT-g++`) sẽ tìm các tệp include C++ chuẩn. Trong một lần dựng thông thường, thông tin này được tự động truyền từ thư mục cấp cao nhất xuống các tùy chọn `configure` của Libstdc++. Ở đây, ta phải đưa nó vào một cách tường minh. Trình biên dịch C++ sẽ thêm đường dẫn sysroot `$LFS` (chỉ định khi dựng GCC-pass1) vào đầu đường dẫn tìm tệp include, nên thực tế nó sẽ tìm trong `$LFS/tools/$LFS_TGT/include/c++/15.2.0`. Sự kết hợp giữa biến `DESTDIR` (trong lệnh `make install` bên dưới) và tùy chọn này khiến các header được cài vào đó.

Biên dịch Libstdc++ bằng cách chạy:

```bash
make
```

Cài đặt thư viện:

```bash
make DESTDIR=$LFS install
```

Xóa các tệp lưu trữ libtool vì chúng gây hại cho biên dịch chéo:

```bash
rm -v $LFS/usr/lib/lib{stdc++{,exp,fs},supc++}.la
```

Chi tiết về gói này có ở [Mục 8.29.2, “Contents of GCC.”](../chapter08/gcc.md#contents-gcc)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter05/gcc-libstdc++.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter05/gcc-libstdc++.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter05/gcc-libstdc++.html)
