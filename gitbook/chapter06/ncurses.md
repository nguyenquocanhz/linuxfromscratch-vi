---
description: "Gói Ncurses chứa các thư viện để xử lý màn hình ký tự không phụ thuộc loại terminal."
---

# 6.3. Ncurses-6.5-20250809

Gói Ncurses chứa các thư viện để xử lý màn hình ký tự không phụ thuộc loại terminal.

* **Thời gian dựng ước tính:** 0.4 SBU
* **Dung lượng đĩa cần:** 54 MB

## 6.3.1. Cài đặt Ncurses

Trước tiên, chạy các lệnh sau để dựng chương trình `tic` trên máy host build. Chúng ta cài nó vào `$LFS/tools` để khi cần sẽ tìm thấy nó trong `PATH`:

```bash
mkdir build
pushd build
  ../configure --prefix=$LFS/tools AWK=gawk
  make -C include
  make -C progs tic
  install progs/tic $LFS/tools/bin
popd
```

Chuẩn bị biên dịch Ncurses:

```bash
./configure --prefix=/usr                \
            --host=$LFS_TGT              \
            --build=$(./config.guess)    \
            --mandir=/usr/share/man      \
            --with-manpage-format=normal \
            --with-shared                \
            --without-normal             \
            --with-cxx-shared            \
            --without-debug              \
            --without-ada                \
            --disable-stripping          \
            AWK=gawk
```

**Ý nghĩa của các tùy chọn configure mới:**

**`--with-manpage-format=normal`**

> Tùy chọn này ngăn Ncurses cài đặt các trang hướng dẫn (manual page) đã nén, điều có thể xảy ra nếu bản phân phối host tự nó dùng manual page nén.

**`--with-shared`**

> Giúp Ncurses dựng và cài đặt các thư viện C dùng chung (shared).

**`--without-normal`**

> Ngăn Ncurses dựng và cài đặt các thư viện C tĩnh (static).

**`--without-debug`**

> Ngăn Ncurses dựng và cài đặt các thư viện gỡ lỗi (debug).

**`--with-cxx-shared`**

> Giúp Ncurses dựng và cài đặt các binding C++ dùng chung. Đồng thời ngăn nó dựng và cài đặt binding C++ tĩnh.

**`--without-ada`**

> Đảm bảo Ncurses không dựng phần hỗ trợ cho trình biên dịch Ada, thứ có thể có trên host nhưng sẽ không còn sau khi chúng ta vào môi trường `chroot`.

**`--disable-stripping`**

> Tùy chọn này ngăn hệ thống build dùng chương trình `strip` của host. Dùng công cụ của host trên chương trình biên dịch chéo có thể gây lỗi.

**`AWK=gawk`**

> Tùy chọn này ngăn hệ thống build dùng chương trình `mawk` của host. Một số phiên bản `mawk` có thể khiến gói này dựng thất bại.

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make DESTDIR=$LFS install
ln -sv libncursesw.so $LFS/usr/lib/libncurses.so
sed -e 's/^#if.*XOPEN.*$/#if 1/' \
    -i $LFS/usr/include/curses.h
```

**Ý nghĩa của các tùy chọn cài đặt:**

**`ln -sv libncursesw.so $LFS/usr/lib/libncurses.so`**

> Thư viện `libncurses.so` cần cho một vài gói chúng ta sắp dựng. Ta tạo symlink này để dùng `libncursesw.so` thay thế.

**`sed -e 's/^#if.*XOPEN.*$/#if 1/' ...`**

> Tệp header `curses.h` chứa định nghĩa của nhiều cấu trúc dữ liệu Ncurses. Tùy cách định nghĩa macro tiền xử lý, có thể dùng một trong hai bộ định nghĩa cấu trúc dữ liệu: định nghĩa 8-bit tương thích với `libncurses.so` và định nghĩa ký tự rộng (wide-character) tương thích với `libncursesw.so`. Vì chúng ta dùng `libncursesw.so` thay cho `libncurses.so`, hãy sửa tệp header để nó luôn dùng định nghĩa cấu trúc dữ liệu ký tự rộng tương thích với `libncursesw.so`.

Chi tiết về gói này nằm trong [Mục 8.30.2, “Nội dung của Ncurses.”](../chapter08/ncurses.md#contents-ncurses)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/ncurses.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/ncurses.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/ncurses.html)
