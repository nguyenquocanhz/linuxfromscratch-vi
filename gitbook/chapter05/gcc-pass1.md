---
description: "Gói GCC chứa bộ trình biên dịch GNU (GNU compiler collection), gồm các trình biên dịch C và C++."
---

# 5.3. GCC-15.2.0 - Lượt 1

Gói GCC chứa bộ trình biên dịch GNU (GNU compiler collection), gồm các trình biên dịch C và C++.

* **Thời gian dựng ước tính:** 3.8 SBU
* **Dung lượng đĩa cần:** 5.4 GB

## 5.3.1. Cài đặt Cross GCC

GCC yêu cầu các gói GMP, MPFR và MPC. Vì distro host của bạn có thể không có sẵn các gói này, chúng sẽ được dựng cùng GCC. Hãy giải nén từng gói vào thư mục mã nguồn GCC và đổi tên các thư mục kết quả để quy trình dựng GCC tự động dùng chúng:

{% hint style="info" %}
**Ghi chú**

Chương này hay bị hiểu nhầm. Các bước giống hệt mọi chương khác, như đã giải thích ở phần trước ([Hướng dẫn dựng gói](../partintro/generalinstructions.md#buildinstr)). Trước hết, hãy giải nén tarball gcc-15.2.0 từ thư mục sources, rồi chuyển vào thư mục vừa tạo. Chỉ sau đó mới làm theo các hướng dẫn bên dưới.
{% endhint %}

```bash
tar -xf ../mpfr-4.2.2.tar.xz
mv -v mpfr-4.2.2 mpfr
tar -xf ../gmp-6.3.0.tar.xz
mv -v gmp-6.3.0 gmp
tar -xf ../mpc-1.3.1.tar.gz
mv -v mpc-1.3.1 mpc
```

Trên máy host x86\_64, hãy đặt tên thư mục mặc định cho thư viện 64-bit là “lib”:

```bash
case $(uname -m) in
  x86_64)
    sed -e '/m64=/s/lib64/lib/' \
        -i.orig gcc/config/i386/t-linux64
 ;;
esac
```

{% hint style="info" %}
**Ghi chú**

Ví dụ này minh họa cách dùng tùy chọn `-i.orig`. Nó khiến `sed` sao chép tệp `t-linux64` thành `t-linux64.orig`, rồi sửa trực tiếp tệp `t-linux64` gốc. Nhờ đó sau này bạn có thể chạy `diff -u gcc/config/i386/t-linux64{.orig,}` để xem thay đổi mà `sed` đã thực hiện. Với tất cả các gói còn lại trong sách, chúng ta chỉ dùng `-i` (sửa trực tiếp tệp gốc mà không sao chép), nhưng bạn có thể đổi thành `-i.orig` bất cứ khi nào muốn giữ bản sao của tệp gốc.
{% endhint %}

Tài liệu GCC khuyên nên dựng GCC trong một thư mục dựng riêng:

```bash
mkdir -v build
cd       build
```

Chuẩn bị biên dịch GCC:

```bash
../configure                  \
    --target=$LFS_TGT         \
    --prefix=$LFS/tools       \
    --with-glibc-version=2.42 \
    --with-sysroot=$LFS       \
    --with-newlib             \
    --without-headers         \
    --enable-default-pie      \
    --enable-default-ssp      \
    --disable-nls             \
    --disable-shared          \
    --disable-multilib        \
    --disable-threads         \
    --disable-libatomic       \
    --disable-libgomp         \
    --disable-libquadmath     \
    --disable-libssp          \
    --disable-libvtv          \
    --disable-libstdcxx       \
    --enable-languages=c,c++
```

**Ý nghĩa các tùy chọn configure:**

**`--with-glibc-version=2.42`**

> Tùy chọn này chỉ định phiên bản Glibc sẽ dùng trên target. Nó không liên quan đến libc của distro host, vì mọi thứ do GCC lượt 1 biên dịch sẽ chạy trong môi trường chroot, vốn tách biệt với libc của distro host.

**`--with-newlib`**

> Vì chưa có thư viện C nào dùng được, tùy chọn này đảm bảo hằng số inhibit\_libc được định nghĩa khi dựng libgcc. Điều này ngăn việc biên dịch bất kỳ đoạn mã nào cần libc hỗ trợ.

**`--without-headers`**

> Khi tạo một trình biên dịch chéo hoàn chỉnh, GCC cần các header chuẩn tương thích với hệ thống target. Với mục đích của chúng ta, các header này không cần thiết. Tùy chọn này ngăn GCC đi tìm chúng.

**`--enable-default-pie and --enable-default-ssp`**

> Các tùy chọn này cho phép GCC mặc định biên dịch chương trình với một số tính năng bảo mật tăng cường (xem thêm trong [ghi chú về PIE và SSP](../chapter08/gcc.md#pie-ssp-info) ở chương 8). Ở giai đoạn này chúng không thực sự cần, vì trình biên dịch chỉ tạo ra các tệp thực thi tạm. Nhưng sẽ gọn gàng hơn khi các gói tạm càng giống bản cuối cùng càng tốt.

**`--disable-shared`**

> Tùy chọn này buộc GCC liên kết tĩnh các thư viện nội bộ của nó. Ta cần điều này vì các thư viện chia sẻ đòi hỏi Glibc, mà Glibc chưa được cài trên hệ thống target.

**`--disable-multilib`**

> Trên x86\_64, LFS không hỗ trợ cấu hình multilib. Tùy chọn này vô hại với x86.

**`--disable-threads, --disable-libatomic, --disable-libgomp, --disable-libquadmath, --disable-libssp, --disable-libvtv, --disable-libstdcxx`**

> Các tùy chọn này lần lượt tắt hỗ trợ đa luồng (threading), libatomic, libgomp, libquadmath, libssp, libvtv và thư viện chuẩn C++. Các tính năng này có thể biên dịch thất bại khi dựng trình biên dịch chéo và không cần thiết cho việc biên dịch chéo libc tạm.

**`--enable-languages=c,c++`**

> Tùy chọn này đảm bảo chỉ dựng các trình biên dịch C và C++, vì đây là hai ngôn ngữ duy nhất cần lúc này.

Biên dịch GCC bằng cách chạy:

```bash
make
```

Cài đặt gói:

```bash
make install
```

Bản dựng GCC này đã cài một vài header hệ thống nội bộ. Thông thường, một trong số đó là `limits.h` sẽ include header `limits.h` tương ứng của hệ thống, ở đây là `$LFS/usr/include/limits.h`. Tuy nhiên, ở thời điểm dựng GCC này, `$LFS/usr/include/limits.h` chưa tồn tại, nên header nội bộ vừa cài chỉ là một tệp độc lập, không đầy đủ và không có các tính năng mở rộng của header hệ thống. Như vậy là đủ để dựng Glibc, nhưng về sau ta sẽ cần header nội bộ đầy đủ. Hãy tạo phiên bản đầy đủ của header nội bộ bằng lệnh y hệt những gì hệ thống dựng GCC làm trong hoàn cảnh bình thường:

{% hint style="info" %}
**Ghi chú**

Lệnh dưới đây là ví dụ về thay thế lệnh lồng nhau (nested command substitution) bằng hai cách: dấu backquote và cấu trúc `$()`. Có thể viết lại dùng cùng một cách cho cả hai chỗ, nhưng ở đây viết như vậy để minh họa cách trộn chúng. Nói chung nên ưu tiên cách `$()`.
{% endhint %}

```bash
cd ..
cat gcc/limitx.h gcc/glimits.h gcc/limity.h > \
  `dirname $($LFS_TGT-gcc -print-libgcc-file-name)`/include/limits.h
```

Chi tiết về gói này có ở [Mục 8.29.2, “Contents of GCC.”](../chapter08/gcc.md#contents-gcc)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter05/gcc-pass1.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter05/gcc-pass1.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter05/gcc-pass1.html)
