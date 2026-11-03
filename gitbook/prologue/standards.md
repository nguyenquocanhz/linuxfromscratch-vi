---
description: "Cấu trúc của LFS bám sát các tiêu chuẩn Linux ở mức cao nhất có thể. Các tiêu chuẩn chính là:"
---

# v. LFS và các tiêu chuẩn

Cấu trúc của LFS bám sát các tiêu chuẩn Linux ở mức cao nhất có thể. Các tiêu chuẩn chính là:

* [POSIX.1-2008](https://pubs.opengroup.org/onlinepubs/9699919799/).
* [Filesystem Hierarchy Standard (FHS) Version 3.0](https://refspecs.linuxfoundation.org/FHS_3.0/fhs/index.html)
* [Linux Standard Base (LSB) Version 5.0 (2015)](https://refspecs.linuxfoundation.org/lsb.shtml)

  LSB gồm bốn đặc tả riêng biệt: Core, Desktop, Languages và Imaging. Một số phần của đặc tả Core và Desktop phụ thuộc vào kiến trúc. Ngoài ra còn có hai đặc tả thử nghiệm: Gtk3 và Graphics. LFS cố gắng tuân thủ các đặc tả LSB cho kiến trúc IA32 (x86 32-bit) hoặc AMD64 (x86\_64) đã nói ở mục trước.

  {% hint style="info" %}
  **Ghi chú**

  Nhiều người không đồng tình với các yêu cầu này. Mục đích chính của LSB là bảo đảm phần mềm độc quyền có thể được cài và chạy trên một hệ thống tuân thủ. Vì LFS dựa trên mã nguồn, người dùng có toàn quyền quyết định muốn có những gói nào; bạn có thể chọn không cài một số gói mà LSB quy định.
  {% endhint %}

Dù có thể tạo một hệ thống hoàn chỉnh vượt qua các bài kiểm tra chứng nhận LSB “từ đầu,” việc này không thể làm được nếu thiếu nhiều gói bổ sung nằm ngoài phạm vi của sách LFS. Hướng dẫn cài đặt một số gói bổ sung này có trong BLFS.

### Các gói do LFS cung cấp để đáp ứng yêu cầu LSB

* *LSB Core:* — Bash, Bc, Binutils, Coreutils, Diffutils, File, Findutils, Gawk, GCC, Gettext, Glibc, Grep, Gzip, M4, Man-DB, Procps, Psmisc, Sed, Shadow, SysVinit, Tar, Util-linux, Zlib
* *LSB Desktop:* — Không có
* *LSB Languages:* — Perl
* *LSB Imaging:* — Không có
* *LSB Gtk3 và LSB Graphics (dùng thử):* — Không có

### Các gói do BLFS cung cấp để đáp ứng yêu cầu LSB

* *LSB Core:* — At, Batch (một phần của At), BLFS Bash Startup Files, Cpio, Ed, Fcrontab, LSB-Tools, NSPR, NSS, Linux-PAM, Pax, Sendmail (hoặc Postfix hoặc Exim), Time
* *LSB Desktop:* — Alsa, ATK, Cairo, Desktop-file-utils, Freetype, Fontconfig, Gdk-pixbuf, Glib2, GLU, Icon-naming-utils, Libjpeg-turbo, Libxml2, Mesa, Pango, Xdg-utils, Xorg
* *LSB Languages:* — Libxml2, Libxslt
* *LSB Imaging:* — CUPS, Cups-filters, Ghostscript, SANE
* *LSB Gtk3 và LSB Graphics (dùng thử):* — GTK+3

### Các thành phần LFS hoặc BLFS không cung cấp, hoặc chỉ cung cấp tùy chọn, nhưng cần để đáp ứng yêu cầu LSB

* *LSB Core:* — `install_initd`, `libcrypt.so.1` (có thể có nhờ hướng dẫn tùy chọn cho gói Libxcrypt của LFS), `libncurses.so.5` (có thể có nhờ hướng dẫn tùy chọn cho gói Ncurses của LFS), `libncursesw.so.5` (nhưng `libncursesw.so.6` do gói Ncurses của LFS cung cấp)
* *LSB Desktop:* — `libgdk-x11-2.0.so` (nhưng `libgdk-3.so` do gói GTK+-3 của BLFS cung cấp), `libgtk-x11-2.0.so` (nhưng `libgtk-3.so` và `libgtk-4.so` do các gói GTK+-3 và GTK-4 của BLFS cung cấp), `libpng12.so` (nhưng `libpng16.so` do gói Libpng của BLFS cung cấp), `libQt*.so.4` (nhưng `libQt6*.so.6` do gói Qt6 của BLFS cung cấp), `libtiff.so.4` (nhưng `libtiff.so.6` do gói Libtiff của BLFS cung cấp)
* *LSB Languages:* — `/usr/bin/python` (LSB yêu cầu Python2 nhưng LFS và BLFS chỉ cung cấp Python3)
* *LSB Imaging:* — Không có
* *LSB Gtk3 và LSB Graphics (dùng thử):* — `libpng15.so` (nhưng `libpng16.so` do gói Libpng của BLFS cung cấp)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/prologue/standards.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/prologue/standards.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/prologue/standards.html)
