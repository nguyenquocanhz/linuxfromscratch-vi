---
description: "Gói Binutils chứa một trình liên kết (linker), một trình hợp ngữ (assembler) và các công cụ khác để xử lý tệp đối tượng."
---

# 8.20. Binutils-2.45

Gói Binutils chứa một trình liên kết (linker), một trình hợp ngữ (assembler) và các công cụ khác để xử lý tệp đối tượng.

* **Thời gian dựng ước tính:** 1.6 SBU
* **Dung lượng đĩa cần:** 832 MB

## 8.20.1. Cài đặt Binutils

Tài liệu Binutils khuyến nghị dựng Binutils trong một thư mục build riêng:

```bash
mkdir -v build
cd       build
```

Chuẩn bị biên dịch Binutils:

```bash
../configure --prefix=/usr       \
             --sysconfdir=/etc   \
             --enable-ld=default \
             --enable-plugins    \
             --enable-shared     \
             --disable-werror    \
             --enable-64-bit-bfd \
             --enable-new-dtags  \
             --with-system-zlib  \
             --enable-default-hash-style=gnu
```

**Ý nghĩa của các tham số configure mới:**

**`--enable-ld=default`**

> Dựng trình liên kết bfd gốc và cài nó vừa là ld (trình liên kết mặc định) vừa là ld.bfd.

**`--enable-plugins`**

> Bật hỗ trợ plugin cho trình liên kết.

**`--with-system-zlib`**

> Dùng thư viện zlib đã cài thay vì dựng bản đi kèm.

Biên dịch gói:

```bash
make tooldir=/usr
```

**Ý nghĩa của tham số make:**

**`tooldir=/usr`**

> Thông thường, tooldir (thư mục nơi các tệp thực thi cuối cùng được đặt) là `$(exec_prefix)/$(target_alias)`. Ví dụ, máy x86\_64 sẽ khai triển thành `/usr/x86_64-pc-linux-gnu`. Vì đây là hệ thống tùy biến, thư mục riêng cho target này trong `/usr` là không cần thiết. `$(exec_prefix)/$(target_alias)` sẽ được dùng nếu hệ thống dùng để biên dịch chéo (ví dụ biên dịch gói trên máy Intel để sinh mã chạy trên máy PowerPC).

{% hint style="warning" %}
**Quan trọng**

Bộ kiểm thử Binutils trong mục này được coi là quan trọng. Đừng bỏ qua nó trong bất kỳ trường hợp nào.
{% endhint %}

Kiểm tra kết quả:

```bash
make -k check
```

Để xem danh sách các bài kiểm thử thất bại, chạy:

```bash
grep '^FAIL:' $(find -name '*.log')
```

Cài đặt gói:

```bash
make tooldir=/usr install
```

Xóa các thư viện tĩnh vô ích và các tệp khác:

```bash
rm -rfv /usr/lib/lib{bfd,ctf,ctf-nobfd,gprofng,opcodes,sframe}.a \
        /usr/share/doc/gprofng/
```

## 8.20.2. Nội dung của Binutils

* **Chương trình được cài:** addr2line, ar, as, c++filt, dwp, elfedit, gprof, gprofng, ld, ld.bfd, nm, objcopy, objdump, ranlib, readelf, size, strings và strip
* **Thư viện được cài:** libbfd.so, libctf.so, libctf-nobfd.so, libgprofng.so, libopcodes.so và libsframe.so
* **Thư mục được cài:** /usr/lib/ldscripts

### Mô tả ngắn

* `addr2line` — Chuyển địa chỉ chương trình thành tên tệp và số dòng; cho một địa chỉ và tên tệp thực thi, nó dùng thông tin gỡ lỗi trong tệp thực thi để xác định tệp nguồn và số dòng gắn với địa chỉ đó
* `ar` — Tạo, sửa đổi và trích xuất từ các kho lưu trữ (archive)
* `as` — Một trình hợp ngữ dịch kết quả của `gcc` thành các tệp đối tượng
* `c++filt` — Được trình liên kết dùng để giải mã (de-mangle) các ký hiệu C++ và Java, và để các hàm nạp chồng không xung đột nhau
* `dwp` — Tiện ích đóng gói DWARF
* `elfedit` — Cập nhật các header ELF của các tệp ELF
* `gprof` — Hiển thị dữ liệu profile đồ thị gọi hàm (call graph)
* `gprofng` — Thu thập và phân tích dữ liệu hiệu năng
* `ld` — Trình liên kết gộp nhiều tệp đối tượng và tệp lưu trữ thành một tệp duy nhất, định vị lại dữ liệu của chúng và nối các tham chiếu ký hiệu
* `ld.bfd` — Một hard link tới `ld`
* `nm` — Liệt kê các ký hiệu xuất hiện trong một tệp đối tượng
* `objcopy` — Chuyển đổi một loại tệp đối tượng sang loại khác
* `objdump` — Hiển thị thông tin về tệp đối tượng cho trước, với các tùy chọn điều khiển thông tin cụ thể cần hiển thị; thông tin này hữu ích cho lập trình viên làm việc với các công cụ biên dịch
* `ranlib` — Tạo chỉ mục nội dung của một kho lưu trữ và lưu vào kho; chỉ mục liệt kê mọi ký hiệu được định nghĩa bởi các thành viên của kho là tệp đối tượng khả định vị
* `readelf` — Hiển thị thông tin về các tệp nhị phân kiểu ELF
* `size` — Liệt kê kích thước các section và tổng kích thước của các tệp đối tượng cho trước
* `strings` — Với mỗi tệp cho trước, xuất các chuỗi ký tự in được có độ dài tối thiểu theo chỉ định (mặc định là bốn); với tệp đối tượng, mặc định chỉ in các chuỗi từ section khởi tạo và nạp, còn với loại tệp khác nó quét toàn bộ tệp
* `strip` — Loại bỏ các ký hiệu khỏi tệp đối tượng
* `libbfd` — Thư viện Binary File Descriptor
* `libctf` — Thư viện hỗ trợ gỡ lỗi Compat ANSI-C Type Format
* `libctf-nobfd` — Một biến thể của libctf không dùng chức năng của libbfd
* `libgprofng` — Thư viện chứa phần lớn các routine mà `gprofng` dùng
* `libopcodes` — Thư viện để xử lý opcode—dạng “văn bản đọc được” của các lệnh cho bộ xử lý; được dùng để dựng các tiện ích như `objdump`
* `libsframe` — Thư viện hỗ trợ truy vết ngược (backtrace) trực tuyến bằng một bộ unwinder đơn giản

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/binutils.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/binutils.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/binutils.html)
