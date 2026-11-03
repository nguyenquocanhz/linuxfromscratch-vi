---
description: "Gói GCC chứa bộ biên dịch GNU (GNU compiler collection), bao gồm trình biên dịch C và C++."
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

<details>

<summary>Trick lỏ: Máy ít RAM bị &quot;Killed&quot; khi dựng GCC? Giảm -j và thêm swap</summary>

`MAKEFLAGS=-j$(nproc)` rất tốt, nhưng mỗi tiến trình biên dịch C++ của GCC có thể ăn cả GB RAM. Máy 4 nhân, 4 GB RAM chạy `-j4` rất dễ bị OOM killer giết, báo lỗi kiểu `g++: fatal error: Killed signal terminated program cc1plus`.

Quy tắc thô: **mỗi luồng khoảng 1,5–2 GB RAM** cho GCC. Không đủ thì thêm swap file trên hệ thống chủ:

```bash
sudo fallocate -l 8G /swapfile && sudo chmod 600 /swapfile
sudo mkswap /swapfile && sudo swapon /swapfile
```

Hoặc chỉ hạ số luồng cho riêng gói nặng: `make -j2` thay vì `make`.

[Tất cả trick lỏ →](../trick-lo.md#it-ram)

</details>

<details>

<summary>Trick lỏ: Bộ kiểm thử — chỗ nào được lười, chỗ nào tuyệt đối không</summary>

Chạy hết test ở Chương 8 có thể mất lâu hơn cả thời gian dựng. Ưu tiên thế này:

* **Bắt buộc chạy**: Glibc, GCC, Binutils (và GMP, MPFR như sách nhấn mạnh). Toolchain hỏng thì mọi gói sau đều hỏng theo.
* **Có vài test lỗi là bình thường**: sách luôn liệt kê các test "known to fail". So kết quả của bạn với danh sách đó trước khi hoảng.
* Gói nhỏ (ví dụ man-pages, less) mà bạn vội thì bỏ test cũng chấp nhận được ở lần dựng đầu tiên.

So kết quả với người khác: `../contrib/test_summary | grep -A7 Summ` (GCC) rồi đối chiếu tại trang [buildlogs của LFS](https://www.linuxfromscratch.org/lfs/build-logs/).

[Tất cả trick lỏ →](../trick-lo.md#kiem-thu)

</details>

# 8.29. GCC-15.2.0

Gói GCC chứa bộ biên dịch GNU (GNU compiler collection), bao gồm trình biên dịch C và C++.

* **Thời gian dựng ước tính:** 46 SBU (có chạy kiểm thử)
* **Dung lượng đĩa cần:** 6.6 GB

## 8.29.1. Cài đặt GCC

Nếu dựng trên x86\_64, hãy đổi tên thư mục mặc định cho thư viện 64-bit thành “lib”:

```bash
case $(uname -m) in
  x86_64)
    sed -e '/m64=/s/lib64/lib/' \
        -i.orig gcc/config/i386/t-linux64
  ;;
esac
```

Tài liệu GCC khuyến nghị dựng GCC trong một thư mục build riêng:

```bash
mkdir -v build
cd       build
```

Chuẩn bị biên dịch GCC:

```bash
../configure --prefix=/usr            \
             LD=ld                    \
             --enable-languages=c,c++ \
             --enable-default-pie     \
             --enable-default-ssp     \
             --enable-host-pie        \
             --disable-multilib       \
             --disable-bootstrap      \
             --disable-fixincludes    \
             --with-system-zlib
```

GCC hỗ trợ bảy ngôn ngữ lập trình, nhưng các thành phần cần thiết cho hầu hết chúng vẫn chưa được cài. Xem [trang GCC trong sách BLFS](https://www.linuxfromscratch.org/blfs/view/12.4/general/gcc.html) để biết cách dựng toàn bộ các ngôn ngữ mà GCC hỗ trợ.

**Ý nghĩa các tham số configure mới:**

**`LD=ld`**

> Tham số này khiến script configure dùng chương trình ld do gói Binutils (đã dựng ở phần trước của chương này) cài đặt, thay vì bản biên dịch chéo vốn sẽ được dùng nếu không có tham số này.

**`--disable-fixincludes`**

> Theo mặc định, khi cài GCC, một số header hệ thống sẽ được “sửa” để dùng với GCC. Điều này không cần thiết với một hệ thống Linux hiện đại, và có thể gây hại nếu một gói được cài lại sau khi đã cài GCC. Tùy chọn này ngăn GCC “sửa” các header.

**`--with-system-zlib`**

> Tùy chọn này bảo GCC liên kết với bản thư viện Zlib đã cài trên hệ thống, thay vì bản nội bộ đi kèm.

{% hint style="info" %}
**Note**

PIE (position-independent executable, tệp thực thi độc lập vị trí) là các chương trình nhị phân có thể được nạp vào bất kỳ đâu trong bộ nhớ. Nếu không có PIE, tính năng bảo mật ASLR (Address Space Layout Randomization) chỉ áp dụng được cho các thư viện chia sẻ chứ không áp dụng cho chính các tệp thực thi. Bật PIE cho phép ASLR áp dụng cả cho tệp thực thi lẫn thư viện chia sẻ, và giảm thiểu một số kiểu tấn công dựa trên địa chỉ cố định của mã hoặc dữ liệu nhạy cảm trong tệp thực thi.

SSP (Stack Smashing Protection) là kỹ thuật bảo đảm ngăn xếp tham số không bị hỏng. Ngăn xếp bị hỏng có thể, chẳng hạn, làm thay đổi địa chỉ trả về của một hàm con, từ đó chuyển quyền điều khiển sang đoạn mã nguy hiểm (có sẵn trong chương trình hoặc thư viện chia sẻ, hoặc do kẻ tấn công chèn vào bằng cách nào đó).
{% endhint %}

Biên dịch gói:

```bash
make
```

{% hint style="warning" %}
**Important**

Trong mục này, bộ kiểm thử của GCC được coi là quan trọng, nhưng chạy rất lâu. Người dựng lần đầu nên chạy bộ kiểm thử. Có thể giảm đáng kể thời gian chạy bằng cách thêm -jx vào lệnh `make -k check` bên dưới, trong đó x là số nhân CPU của hệ thống bạn.
{% endhint %}

GCC có thể cần nhiều không gian ngăn xếp hơn khi biên dịch một số mẫu mã cực kỳ phức tạp. Để đề phòng với các distro host có giới hạn ngăn xếp chặt, hãy đặt rõ ràng giới hạn cứng của kích thước ngăn xếp là vô hạn. Trên hầu hết distro host (và hệ thống LFS cuối cùng), giới hạn cứng mặc định đã là vô hạn, nhưng đặt rõ ra cũng không sao. Không cần đổi giới hạn mềm vì GCC sẽ tự đặt giá trị thích hợp, miễn là không vượt quá giới hạn cứng:

```bash
ulimit -s -H unlimited
```

Bây giờ hãy loại bỏ một số bài kiểm thử đã biết là thất bại:

```bash
sed -e '/cpython/d' -i ../gcc/testsuite/gcc.dg/plugin/plugin.exp
```

Kiểm thử kết quả bằng người dùng không có đặc quyền, nhưng không dừng khi gặp lỗi:

```bash
chown -R tester .
su tester -c "PATH=$PATH make -k check"
```

Để trích tóm tắt kết quả bộ kiểm thử, chạy:

```bash
../contrib/test_summary
```

Để chỉ lọc ra phần tóm tắt, hãy chuyển đầu ra qua pipe tới `grep -A7 Summ`.

Bạn có thể so sánh kết quả với các kết quả tại [https://www.linuxfromscratch.org/lfs/build-logs/12.4/](https://www.linuxfromscratch.org/lfs/build-logs/12.4/) và [https://gcc.gnu.org/ml/gcc-testresults/](https://gcc.gnu.org/ml/gcc-testresults/).

Các bài kiểm thử liên quan đến `pr90579.c` được biết là thất bại.

Một vài lỗi không mong muốn không phải lúc nào cũng tránh được. Trong một số trường hợp, lỗi kiểm thử phụ thuộc vào phần cứng cụ thể của hệ thống. Trừ khi kết quả khác hẳn so với ở URL trên, bạn có thể yên tâm tiếp tục.

Cài đặt gói:

```bash
make install
```

Thư mục build của GCC hiện thuộc sở hữu của `tester`, và quyền sở hữu của thư mục header đã cài (cùng nội dung bên trong) là không đúng. Hãy đổi chủ sở hữu sang người dùng và nhóm `root`:

```bash
chown -v -R root:root \
    /usr/lib/gcc/$(gcc -dumpmachine)/15.2.0/include{,-fixed}
```

Tạo một symlink theo yêu cầu của [FHS](https://refspecs.linuxfoundation.org/FHS_3.0/fhs/ch03s09.html) vì lý do "lịch sử".

```bash
ln -svr /usr/bin/cpp /usr/lib
```

Nhiều gói dùng tên `cc` để gọi trình biên dịch C. Chúng ta đã tạo `cc` làm symlink ở [gcc-pass2](../chapter06/gcc-pass2.md); hãy tạo cả trang man của nó dưới dạng symlink:

```bash
ln -sv gcc.1 /usr/share/man/man1/cc.1
```

Thêm một symlink tương thích để cho phép dựng chương trình với Link Time Optimization (LTO):

```bash
ln -sfv ../../libexec/gcc/$(gcc -dumpmachine)/15.2.0/liblto_plugin.so \
        /usr/lib/bfd-plugins/
```

Bây giờ toolchain cuối cùng của chúng ta đã sẵn sàng, cần đảm bảo một lần nữa rằng việc biên dịch và liên kết hoạt động như mong đợi. Ta làm việc này bằng một số bước kiểm tra nhanh (sanity check):

```bash
echo 'int main(){}' | cc -x c - -v -Wl,--verbose &> dummy.log
readelf -l a.out | grep ': /lib'
```

Không được có lỗi nào, và kết quả của lệnh cuối cùng sẽ là (có thể khác đôi chút ở tên dynamic linker tùy nền tảng):

```text
[Requesting program interpreter: /lib64/ld-linux-x86-64.so.2]
```

Tiếp theo, đảm bảo rằng ta đã thiết lập để dùng đúng các tệp khởi động (start file):

```bash
grep -E -o '/usr/lib.*/S?crt[1in].*succeeded' dummy.log
```

Kết quả của lệnh cuối cùng phải là:

```text
/usr/lib/gcc/x86_64-pc-linux-gnu/15.2.0/../../../../lib/Scrt1.o succeeded
/usr/lib/gcc/x86_64-pc-linux-gnu/15.2.0/../../../../lib/crti.o succeeded
/usr/lib/gcc/x86_64-pc-linux-gnu/15.2.0/../../../../lib/crtn.o succeeded
```

Tùy kiến trúc máy, kết quả ở trên có thể khác đôi chút. Sự khác biệt sẽ là tên thư mục phía sau `/usr/lib/gcc`. Điều quan trọng cần chú ý ở đây là `gcc` đã tìm thấy cả ba tệp `crt*.o` trong thư mục `/usr/lib`.

Xác minh rằng trình biên dịch đang tìm đúng các tệp header:

```bash
grep -B4 '^ /usr/include' dummy.log
```

Lệnh này phải trả về kết quả sau:

```text
#include <...> search starts here:
 /usr/lib/gcc/x86_64-pc-linux-gnu/15.2.0/include
 /usr/local/include
 /usr/lib/gcc/x86_64-pc-linux-gnu/15.2.0/include-fixed
 /usr/include
```

Một lần nữa, thư mục đặt theo target triplet của bạn có thể khác với ở trên, tùy kiến trúc hệ thống.

Tiếp theo, xác minh rằng trình liên kết (linker) mới đang được dùng với đúng đường dẫn tìm kiếm:

```bash
grep 'SEARCH.*/usr/lib' dummy.log |sed 's|; |\n|g'
```

Các tham chiếu tới đường dẫn có thành phần chứa '-linux-gnu' nên được bỏ qua; ngoài ra, kết quả của lệnh cuối cùng phải là:

```text
SEARCH_DIR("/usr/x86_64-pc-linux-gnu/lib64")
SEARCH_DIR("/usr/local/lib64")
SEARCH_DIR("/lib64")
SEARCH_DIR("/usr/lib64")
SEARCH_DIR("/usr/x86_64-pc-linux-gnu/lib")
SEARCH_DIR("/usr/local/lib")
SEARCH_DIR("/lib")
SEARCH_DIR("/usr/lib");
```

Hệ thống 32-bit có thể dùng thêm vài thư mục khác. Ví dụ, đây là kết quả trên một máy i686:

```text
SEARCH_DIR("/usr/i686-pc-linux-gnu/lib32")
SEARCH_DIR("/usr/local/lib32")
SEARCH_DIR("/lib32")
SEARCH_DIR("/usr/lib32")
SEARCH_DIR("/usr/i686-pc-linux-gnu/lib")
SEARCH_DIR("/usr/local/lib")
SEARCH_DIR("/lib")
SEARCH_DIR("/usr/lib");
```

Tiếp theo, đảm bảo rằng ta đang dùng đúng libc:

```bash
grep "/lib.*/libc.so.6 " dummy.log
```

Kết quả của lệnh cuối cùng phải là:

```text
attempt to open /usr/lib/libc.so.6 succeeded
```

Đảm bảo GCC đang dùng đúng dynamic linker:

```bash
grep found dummy.log
```

Kết quả của lệnh cuối cùng phải là (có thể khác đôi chút ở tên dynamic linker tùy nền tảng):

```text
found ld-linux-x86-64.so.2 at /usr/lib/ld-linux-x86-64.so.2
```

Nếu kết quả không giống như trên hoặc không có kết quả nào, thì có điều gì đó đang sai nghiêm trọng. Hãy điều tra và lần lại các bước để tìm ra chỗ sai rồi sửa. Mọi vấn đề phải được giải quyết trước khi tiếp tục.

Khi mọi thứ đã hoạt động đúng, hãy dọn dẹp các tệp kiểm thử:

```bash
rm -v a.out dummy.log
```

Cuối cùng, di chuyển một tệp nằm sai chỗ:

```bash
mkdir -pv /usr/share/gdb/auto-load/usr/lib
mv -v /usr/lib/*gdb.py /usr/share/gdb/auto-load/usr/lib
```

## 8.29.2. Nội dung của GCC

* **Chương trình được cài:** c++, cc (liên kết tới gcc), cpp, g++, gcc, gcc-ar, gcc-nm, gcc-ranlib, gcov, gcov-dump, gcov-tool và lto-dump
* **Thư viện được cài:** libasan.{a,so}, libatomic.{a,so}, libcc1.so, libgcc.a, libgcc\_eh.a, libgcc\_s.so, libgcov.a, libgomp.{a,so}, libhwasan.{a,so}, libitm.{a,so}, liblsan.{a,so}, liblto\_plugin.so, libquadmath.{a,so}, libssp.{a,so}, libssp\_nonshared.a, libstdc++.{a,so}, libstdc++exp.a, libstdc++fs.a, libsupc++.a, libtsan.{a,so} và libubsan.{a,so}
* **Thư mục được cài:** /usr/include/c++, /usr/lib/gcc, /usr/libexec/gcc, và /usr/share/gcc-15.2.0

### Mô tả ngắn

* `c++` — Trình biên dịch C++
* `cc` — Trình biên dịch C
* `cpp` — Bộ tiền xử lý C; trình biên dịch dùng nó để khai triển các chỉ thị \#include, \#define và tương tự trong tệp nguồn
* `g++` — Trình biên dịch C++
* `gcc` — Trình biên dịch C
* `gcc-ar` — Một wrapper quanh `ar` thêm một plugin vào dòng lệnh. Chương trình này chỉ dùng để bổ sung "link time optimization" và không có ích với các tùy chọn build mặc định.
* `gcc-nm` — Một wrapper quanh `nm` thêm một plugin vào dòng lệnh. Chương trình này chỉ dùng để bổ sung "link time optimization" và không có ích với các tùy chọn build mặc định.
* `gcc-ranlib` — Một wrapper quanh `ranlib` thêm một plugin vào dòng lệnh. Chương trình này chỉ dùng để bổ sung "link time optimization" và không có ích với các tùy chọn build mặc định.
* `gcov` — Công cụ kiểm thử độ phủ (coverage); dùng để phân tích chương trình nhằm xác định chỗ nào tối ưu hóa mang lại hiệu quả lớn nhất
* `gcov-dump` — Công cụ dump hồ sơ gcda và gcno ngoại tuyến (offline)
* `gcov-tool` — Công cụ xử lý hồ sơ gcda ngoại tuyến (offline)
* `lto-dump` — Công cụ dump các tệp đối tượng do GCC tạo ra khi bật LTO
* `libasan` — Thư viện runtime của Address Sanitizer
* `libatomic` — Thư viện runtime cho các hàm atomic dựng sẵn của GCC
* `libcc1` — Thư viện cho phép GDB sử dụng GCC
* `libgcc` — Chứa hỗ trợ run-time cho `gcc`
* `libgcov` — Thư viện này được liên kết vào chương trình khi GCC được yêu cầu bật profiling
* `libgomp` — Bản cài đặt GNU của OpenMP API cho lập trình song song bộ nhớ dùng chung đa nền tảng trong C/C++ và Fortran
* `libhwasan` — Thư viện runtime của Hardware-assisted Address Sanitizer
* `libitm` — Thư viện bộ nhớ giao dịch (transactional memory) của GNU
* `liblsan` — Thư viện runtime của Leak Sanitizer
* `liblto_plugin` — Plugin LTO của GCC cho phép Binutils xử lý các tệp đối tượng do GCC tạo ra khi bật LTO
* `libquadmath` — API thư viện toán học độ chính xác bốn (Quad Precision) của GCC
* `libssp` — Chứa các routine hỗ trợ tính năng chống phá ngăn xếp (stack-smashing protection) của GCC. Thông thường không dùng đến, vì Glibc cũng cung cấp các routine này.
* `libstdc++` — Thư viện chuẩn C++
* `libstdc++exp` — Thư viện Contracts của C++ ở dạng thử nghiệm
* `libstdc++fs` — Thư viện Filesystem theo ISO/IEC TS 18822:2015
* `libsupc++` — Cung cấp các routine hỗ trợ cho ngôn ngữ lập trình C++
* `libtsan` — Thư viện runtime của Thread Sanitizer
* `libubsan` — Thư viện runtime của Undefined Behavior Sanitizer

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/gcc.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/gcc.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/gcc.html)
