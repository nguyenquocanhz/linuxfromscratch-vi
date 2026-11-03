---
description: "Gói GCC chứa bộ trình biên dịch GNU, bao gồm trình biên dịch C và C++."
---

# 6.18. GCC-15.2.0 - Lượt 2

Gói GCC chứa bộ trình biên dịch GNU, bao gồm trình biên dịch C và C++.

* **Thời gian dựng ước tính:** 4.5 SBU
* **Dung lượng đĩa cần:** 6.0 GB

## 6.18.1. Cài đặt GCC

Giống lần dựng GCC đầu tiên, các gói GMP, MPFR và MPC là bắt buộc. Giải nén các tarball và di chuyển chúng vào các thư mục cần thiết:

```bash
tar -xf ../mpfr-4.2.2.tar.xz
mv -v mpfr-4.2.2 mpfr
tar -xf ../gmp-6.3.0.tar.xz
mv -v gmp-6.3.0 gmp
tar -xf ../mpc-1.3.1.tar.gz
mv -v mpc-1.3.1 mpc
```

Nếu bạn đang dựng trên x86\_64, hãy đổi tên thư mục mặc định cho thư viện 64-bit thành “lib”:

```bash
case $(uname -m) in
  x86_64)
    sed -e '/m64=/s/lib64/lib/' \
        -i.orig gcc/config/i386/t-linux64
  ;;
esac
```

Ghi đè các quy tắc dựng của header libgcc và libstdc++ để cho phép dựng các thư viện này với hỗ trợ luồng POSIX:

```bash
sed '/thread_header =/s/@.*@/gthr-posix.h/' \
    -i libgcc/Makefile.in libstdc++-v3/include/Makefile.in
```

Một lần nữa, tạo một thư mục build riêng:

```bash
mkdir -v build
cd       build
```

Trước khi bắt đầu dựng GCC, nhớ bỏ đặt (unset) mọi biến môi trường ghi đè các cờ tối ưu hóa mặc định.

Bây giờ chuẩn bị biên dịch GCC:

```bash
../configure                   \
    --build=$(../config.guess) \
    --host=$LFS_TGT            \
    --target=$LFS_TGT          \
    --prefix=/usr              \
    --with-build-sysroot=$LFS  \
    --enable-default-pie       \
    --enable-default-ssp       \
    --disable-nls              \
    --disable-multilib         \
    --disable-libatomic        \
    --disable-libgomp          \
    --disable-libquadmath      \
    --disable-libsanitizer     \
    --disable-libssp           \
    --disable-libvtv           \
    --enable-languages=c,c++   \
    LDFLAGS_FOR_TARGET=-L$PWD/$LFS_TGT/libgcc
```

**Ý nghĩa của các tùy chọn configure mới:**

**`--with-build-sysroot=$LFS`**

> Thông thường, `--host` đảm bảo một trình biên dịch chéo được dùng để dựng GCC, và trình biên dịch đó biết phải tìm header và thư viện trong `$LFS`. Tuy nhiên, hệ thống build của GCC còn dùng thêm một số công cụ không biết về vị trí này. Tùy chọn này cần thiết để các công cụ đó tìm được tệp cần thiết trong `$LFS`, chứ không phải trên host.

**`--target=$LFS_TGT`**

> Vì chúng ta biên dịch chéo GCC, không thể dựng các thư viện target (`libgcc` và `libstdc++`) bằng các tệp nhị phân GCC được biên dịch ở lượt này, bởi chúng không chạy được trên host. Theo mặc định, hệ thống build của GCC sẽ thử dùng trình biên dịch C và C++ của host làm giải pháp thay thế. Việc dựng thư viện target của GCC bằng một phiên bản GCC khác không được hỗ trợ, nên dùng trình biên dịch của host có thể khiến quá trình dựng thất bại. Tham số này đảm bảo các thư viện được dựng bởi GCC lượt 1.

**`LDFLAGS_FOR_TARGET=...`**

> Cho phép `libstdc++` dùng `libgcc` đang được dựng ở lượt này, thay vì phiên bản trước đó dựng trong [gcc-pass1](../chapter05/gcc-pass1.md). Phiên bản trước không hỗ trợ đúng việc xử lý ngoại lệ C++ vì được dựng khi chưa có libc.

**`--disable-libsanitizer`**

> Tắt các thư viện runtime sanitizer của GCC. Chúng không cần cho bản cài đặt tạm. Trong [gcc-pass1](../chapter05/gcc-pass1.md) điều này được ngầm hiểu qua `--disable-libstdcxx`, còn bây giờ ta có thể truyền tường minh.

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make DESTDIR=$LFS install
```

Bước hoàn thiện, tạo một symlink tiện ích. Nhiều chương trình và script chạy `cc` thay vì `gcc`, nhằm giữ cho chương trình mang tính tổng quát, dùng được trên mọi loại hệ UNIX nơi trình biên dịch C của GNU không phải lúc nào cũng được cài. Chạy `cc` để quản trị viên hệ thống tự do quyết định cài trình biên dịch C nào:

```bash
ln -sv gcc $LFS/usr/bin/cc
```

Chi tiết về gói này nằm trong [Mục 8.29.2, “Nội dung của GCC.”](../chapter08/gcc.md#contents-gcc)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/gcc-pass2.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/gcc-pass2.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/gcc-pass2.html)
