---
description: "Gói Ncurses chứa các thư viện để xử lý màn hình ký tự độc lập với loại terminal."
---

# 8.30. Ncurses-6.5-20250809

Gói Ncurses chứa các thư viện để xử lý màn hình ký tự độc lập với loại terminal.

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 46 MB

## 8.30.1. Cài đặt Ncurses

Chuẩn bị biên dịch Ncurses:

```bash
./configure --prefix=/usr           \
            --mandir=/usr/share/man \
            --with-shared           \
            --without-debug         \
            --without-normal        \
            --with-cxx-shared       \
            --enable-pc-files       \
            --with-pkg-config-libdir=/usr/lib/pkgconfig
```

**Ý nghĩa của các tùy chọn configure mới:**

**`--with-shared`**

> Khiến Ncurses dựng và cài các thư viện C dùng chung (shared).

**`--without-normal`**

> Ngăn Ncurses dựng và cài các thư viện C tĩnh.

**`--without-debug`**

> Ngăn Ncurses dựng và cài các thư viện gỡ lỗi (debug).

**`--with-cxx-shared`**

> Khiến Ncurses dựng và cài các binding C++ dùng chung. Đồng thời ngăn nó dựng và cài các binding C++ tĩnh.

**`--enable-pc-files`**

> Tùy chọn này tạo và cài các tệp .pc cho pkg-config.

Biên dịch gói:

```bash
make
```

Gói này có bộ kiểm thử, nhưng chỉ chạy được sau khi gói đã được cài. Các bài kiểm thử nằm trong thư mục `test/`. Xem tệp `README` trong thư mục đó để biết thêm chi tiết.

Việc cài gói này sẽ ghi đè trực tiếp `libncursesw.so.6.5`. Điều đó có thể làm sập tiến trình shell đang dùng mã và dữ liệu từ tệp thư viện này. Hãy cài gói với `DESTDIR`, rồi thay tệp thư viện đúng cách bằng lệnh `install` (header `curses.h` cũng được chỉnh sửa để đảm bảo dùng ABI ký tự rộng, giống như những gì ta đã làm ở [Mục 6.3, “Ncurses-6.5-20250809”](../chapter06/ncurses.md)):

```bash
make DESTDIR=$PWD/dest install
install -vm755 dest/usr/lib/libncursesw.so.6.5 /usr/lib
rm -v  dest/usr/lib/libncursesw.so.6.5
sed -e 's/^#if.*XOPEN.*$/#if 1/' \
    -i dest/usr/include/curses.h
cp -av dest/* /
```

Nhiều ứng dụng vẫn mong linker tìm được các thư viện Ncurses không dùng ký tự rộng. Hãy đánh lừa các ứng dụng đó để chúng liên kết với thư viện ký tự rộng bằng các liên kết mềm (lưu ý các liên kết `.so` chỉ an toàn khi `curses.h` đã được sửa để luôn dùng ABI ký tự rộng):

```bash
for lib in ncurses form panel menu ; do
    ln -sfv lib${lib}w.so /usr/lib/lib${lib}.so
    ln -sfv ${lib}w.pc    /usr/lib/pkgconfig/${lib}.pc
done
```

Cuối cùng, đảm bảo các ứng dụng cũ tìm `-lcurses` lúc dựng vẫn dựng được:

```bash
ln -sfv libncursesw.so /usr/lib/libcurses.so
```

Nếu muốn, cài tài liệu của Ncurses:

```bash
cp -v -R doc -T /usr/share/doc/ncurses-6.5-20250809
```

{% hint style="info" %}
**Ghi chú**

Các hướng dẫn ở trên không tạo thư viện Ncurses không dùng ký tự rộng vì không gói nào cài bằng cách biên dịch từ mã nguồn sẽ liên kết với chúng khi chạy. Tuy nhiên, những ứng dụng chỉ có bản nhị phân mà ta biết có liên kết với thư viện Ncurses không dùng ký tự rộng đều đòi hỏi phiên bản 5. Nếu bạn buộc phải có các thư viện đó vì một ứng dụng chỉ có bản nhị phân nào đó hoặc để tuân thủ LSB, hãy dựng lại gói bằng các lệnh sau:

```bash
make distclean
./configure --prefix=/usr    \
            --with-shared    \
            --without-normal \
            --without-debug  \
            --without-cxx-binding \
            --with-abi-version=5
make sources libs
cp -av lib/lib*.so.5* /usr/lib
```
{% endhint %}

## 8.30.2. Nội dung của Ncurses

* **Chương trình được cài:** captoinfo (liên kết tới tic), clear, infocmp, infotocap (liên kết tới tic), ncursesw6-config, reset (liên kết tới tset), tabs, tic, toe, tput và tset
* **Thư viện được cài:** libcurses.so (liên kết mềm), libform.so (liên kết mềm), libformw.so, libmenu.so (liên kết mềm), libmenuw.so, libncurses.so (liên kết mềm), libncursesw.so, libncurses++w.so, libpanel.so (liên kết mềm) và libpanelw.so,
* **Thư mục được cài:** /usr/share/tabset, /usr/share/terminfo và /usr/share/doc/ncurses-6.5-20250809

### Mô tả ngắn

* `captoinfo` — Chuyển mô tả termcap thành mô tả terminfo
* `clear` — Xóa màn hình, nếu có thể
* `infocmp` — So sánh hoặc in ra các mô tả terminfo
* `infotocap` — Chuyển mô tả terminfo thành mô tả termcap
* `ncursesw6-config` — Cung cấp thông tin cấu hình cho ncurses
* `reset` — Khởi tạo lại terminal về các giá trị mặc định
* `tabs` — Xóa và đặt các điểm dừng tab trên terminal
* `tic` — Trình biên dịch mô tả mục terminfo, dịch tệp terminfo từ dạng nguồn sang dạng nhị phân mà các hàm của thư viện ncurses cần \[Một tệp terminfo chứa thông tin về khả năng của một loại terminal nhất định.\]
* `toe` — Liệt kê mọi loại terminal có sẵn, kèm tên chính và mô tả của mỗi loại
* `tput` — Cung cấp giá trị của các khả năng phụ thuộc terminal cho shell; cũng có thể dùng để đặt lại hoặc khởi tạo terminal, hay báo tên đầy đủ của nó
* `tset` — Có thể dùng để khởi tạo terminal
* `libncursesw` — Chứa các hàm hiển thị văn bản theo nhiều cách phức tạp trên màn hình terminal; một ví dụ điển hình là menu hiển thị khi chạy `make menuconfig` của kernel
* `libncurses++w` — Chứa binding C++ cho các thư viện khác trong gói này
* `libformw` — Chứa các hàm để cài đặt biểu mẫu (form)
* `libmenuw` — Chứa các hàm để cài đặt menu
* `libpanelw` — Chứa các hàm để cài đặt panel

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/ncurses.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/ncurses.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/ncurses.html)
