---
description: "Gói Glibc chứa thư viện C chính. Thư viện này cung cấp các hàm cơ bản để cấp phát bộ nhớ, tìm kiếm thư mục, mở và đóng tệp, đọc và ghi tệp, xử lý chuỗi, kh"
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

# 5.5. Glibc-2.42

Gói Glibc chứa thư viện C chính. Thư viện này cung cấp các hàm cơ bản để cấp phát bộ nhớ, tìm kiếm thư mục, mở và đóng tệp, đọc và ghi tệp, xử lý chuỗi, khớp mẫu, tính toán số học, v.v.

* **Thời gian dựng ước tính:** 1.4 SBU
* **Dung lượng đĩa cần:** 870 MB

## 5.5.1. Cài đặt Glibc

Trước hết, hãy tạo một liên kết tượng trưng để tuân thủ LSB. Ngoài ra, với x86\_64, hãy tạo thêm một liên kết tượng trưng tương thích cần cho hoạt động đúng của bộ nạp thư viện động:

```bash
case $(uname -m) in
    i?86)   ln -sfv ld-linux.so.2 $LFS/lib/ld-lsb.so.3
    ;;
    x86_64) ln -sfv ../lib/ld-linux-x86-64.so.2 $LFS/lib64
            ln -sfv ../lib/ld-linux-x86-64.so.2 $LFS/lib64/ld-lsb-x86-64.so.3
    ;;
esac
```

{% hint style="info" %}
**Ghi chú**

Lệnh trên là đúng. Lệnh `ln` có nhiều dạng cú pháp, nên hãy kiểm tra `info coreutils ln` và [ln(1)](https://man.archlinux.org/man/ln.1) trước khi báo cáo thứ có vẻ là lỗi.
{% endhint %}

Một số chương trình của Glibc dùng thư mục `/var/db`, không tuân thủ FHS, để lưu dữ liệu lúc chạy. Hãy áp dụng bản vá sau để các chương trình đó lưu dữ liệu lúc chạy ở những vị trí tuân thủ FHS:

```bash
patch -Np1 -i ../glibc-2.42-fhs-1.patch
```

Tài liệu Glibc khuyên nên dựng Glibc trong một thư mục dựng riêng:

```bash
mkdir -v build
cd       build
```

Đảm bảo các tiện ích `ldconfig` và `sln` được cài vào `/usr/sbin`:

```bash
echo "rootsbindir=/usr/sbin" > configparms
```

Tiếp theo, chuẩn bị biên dịch Glibc:

```bash
../configure                             \
      --prefix=/usr                      \
      --host=$LFS_TGT                    \
      --build=$(../scripts/config.guess) \
      --disable-nscd                     \
      libc_cv_slibdir=/usr/lib           \
      --enable-kernel=5.4
```

**Ý nghĩa các tùy chọn configure:**

**`--host=$LFS_TGT, --build=$(../scripts/config.guess)`**

> Tác dụng kết hợp của hai tùy chọn này là hệ thống dựng của Glibc tự cấu hình để được biên dịch chéo, dùng trình liên kết chéo và trình biên dịch chéo trong `$LFS/tools`.

**`--enable-kernel=5.4`**

> Bảo Glibc biên dịch thư viện có hỗ trợ kernel Linux 5.4 trở lên. Các cách xử lý tạm cho kernel cũ hơn không được bật.

**`libc_cv_slibdir=/usr/lib`**

> Đảm bảo thư viện được cài vào /usr/lib thay vì /lib64 mặc định trên máy 64-bit.

**`--disable-nscd`**

> Không dựng name service cache daemon vì nó không còn được dùng.

Trong giai đoạn này có thể xuất hiện cảnh báo sau:

```text
configure: WARNING:
*** These auxiliary programs are missing or
*** incompatible versions: msgfmt
*** some features will be disabled.
*** Check the INSTALL file for required versions.
```

Việc thiếu hoặc không tương thích chương trình `msgfmt` nhìn chung là vô hại. Chương trình `msgfmt` này thuộc gói Gettext, mà distro host lẽ ra phải cung cấp.

{% hint style="info" %}
**Ghi chú**

Đã có báo cáo rằng gói này có thể thất bại khi dựng bằng “make song song.” Nếu gặp tình huống đó, hãy chạy lại lệnh make với tùy chọn `-j1`.
{% endhint %}

Biên dịch gói:

```bash
make
```

Cài đặt gói:

{% hint style="danger" %}
**Cảnh báo**

Nếu `LFS` chưa được đặt đúng, và bất chấp khuyến nghị, bạn đang dựng bằng `root`, thì lệnh tiếp theo sẽ cài Glibc vừa dựng vào hệ thống host của bạn, gần như chắc chắn làm nó không dùng được nữa. Vì vậy hãy kiểm tra lại môi trường đã được đặt đúng và bạn không phải `root` trước khi chạy lệnh sau.
{% endhint %}

```bash
make DESTDIR=$LFS install
```

**Ý nghĩa của tùy chọn trong `make install`:**

**`DESTDIR=$LFS`**

> Biến make `DESTDIR` được hầu hết các gói dùng để xác định nơi gói sẽ được cài. Nếu không đặt, mặc định là thư mục gốc (`/`). Ở đây ta chỉ định gói được cài vào `$LFS`, nơi sẽ trở thành thư mục gốc trong [Mục 7.4, “Entering the Chroot Environment.”](../chapter07/chroot.md)

Sửa đường dẫn được mã hóa cứng tới bộ nạp thực thi trong script `ldd`:

```bash
sed '/RTLDLIST=/s@/usr@@g' -i $LFS/usr/bin/ldd
```

Giờ toolchain chéo của chúng ta đã có, điều quan trọng là phải đảm bảo biên dịch và liên kết hoạt động như mong đợi. Ta làm việc này bằng một vài phép kiểm tra tỉnh táo:

```bash
echo 'int main(){}' | $LFS_TGT-gcc -x c - -v -Wl,--verbose &> dummy.log
readelf -l a.out | grep ': /lib'
```

Không được có lỗi nào, và đầu ra của lệnh cuối sẽ là (có thể khác đôi chút về tên trình liên kết động tùy nền tảng):

```text
[Requesting program interpreter: /lib64/ld-linux-x86-64.so.2]
```

Lưu ý đường dẫn này không được chứa `/mnt/lfs` (hoặc giá trị của biến `LFS` nếu bạn dùng giá trị khác). Đường dẫn được phân giải khi chương trình đã biên dịch được thực thi, và điều đó chỉ nên xảy ra sau khi ta vào môi trường chroot, nơi kernel coi `$LFS` là thư mục gốc (`/`).

Bây giờ hãy chắc chắn rằng ta đang dùng đúng các tệp khởi động (start files):

```bash
grep -E -o "$LFS/lib.*/S?crt[1in].*succeeded" dummy.log
```

Đầu ra của lệnh cuối phải là:

```text
/mnt/lfs/lib/../lib/Scrt1.o succeeded
/mnt/lfs/lib/../lib/crti.o succeeded
/mnt/lfs/lib/../lib/crtn.o succeeded
```

Xác minh rằng trình biên dịch đang tìm đúng các tệp header:

```bash
grep -B3 "^ $LFS/usr/include" dummy.log
```

Lệnh này sẽ trả về đầu ra sau:

```text
#include <...> search starts here:
 /mnt/lfs/tools/lib/gcc/x86_64-lfs-linux-gnu/15.2.0/include
 /mnt/lfs/tools/lib/gcc/x86_64-lfs-linux-gnu/15.2.0/include-fixed
 /mnt/lfs/usr/include
```

Một lần nữa, thư mục đặt theo bộ ba target (triplet) của bạn có thể khác ở trên, tùy kiến trúc hệ thống.

Tiếp theo, xác minh trình liên kết mới đang được dùng với các đường dẫn tìm kiếm đúng:

```bash
grep 'SEARCH.*/usr/lib' dummy.log |sed 's|; |\n|g'
```

Các tham chiếu tới đường dẫn có thành phần '-linux-gnu' có thể bỏ qua, còn lại thì đầu ra của lệnh cuối phải là:

```text
SEARCH_DIR("=/mnt/lfs/tools/x86_64-lfs-linux-gnu/lib64")
SEARCH_DIR("=/usr/local/lib64")
SEARCH_DIR("=/lib64")
SEARCH_DIR("=/usr/lib64")
SEARCH_DIR("=/mnt/lfs/tools/x86_64-lfs-linux-gnu/lib")
SEARCH_DIR("=/usr/local/lib")
SEARCH_DIR("=/lib")
SEARCH_DIR("=/usr/lib");
```

Hệ thống 32-bit có thể dùng thêm vài thư mục khác, nhưng điều quan trọng ở đây là mọi đường dẫn đều phải bắt đầu bằng dấu bằng (`=`), sẽ được thay bằng thư mục sysroot mà ta đã cấu hình cho trình liên kết.

Tiếp theo, hãy chắc chắn ta đang dùng đúng libc:

```bash
grep "/lib.*/libc.so.6 " dummy.log
```

Đầu ra của lệnh cuối phải là:

```text
attempt to open /mnt/lfs/usr/lib/libc.so.6 succeeded
```

Đảm bảo GCC đang dùng đúng trình liên kết động:

```bash
grep found dummy.log
```

Đầu ra của lệnh cuối phải là (có thể khác đôi chút về tên trình liên kết động tùy nền tảng):

```text
found ld-linux-x86-64.so.2 at /mnt/lfs/usr/lib/ld-linux-x86-64.so.2
```

Nếu đầu ra không giống như trên hoặc không có đầu ra nào, thì có điều gì đó đang sai nghiêm trọng. Hãy tìm hiểu và xem lại các bước để biết lỗi ở đâu và sửa nó. Mọi vấn đề phải được giải quyết trước khi tiếp tục.

Khi mọi thứ đã hoạt động đúng, hãy dọn dẹp các tệp kiểm tra:

```bash
rm -v a.out dummy.log
```

{% hint style="info" %}
**Ghi chú**

Việc dựng các gói ở chương sau sẽ là một lần kiểm tra bổ sung xem toolchain đã được dựng đúng chưa. Nếu một gói nào đó, đặc biệt là Binutils-pass2 hoặc GCC-pass2, dựng thất bại, đó là dấu hiệu cho thấy đã có gì đó sai trong các lần cài Binutils, GCC hoặc Glibc trước đó.
{% endhint %}

Chi tiết về gói này có ở [Mục 8.5.3, “Contents of Glibc.”](../chapter08/glibc.md#contents-glibc)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter05/glibc.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter05/glibc.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter05/glibc.html)
