---
description: "Mỗi gói được dựng trong LFS đều dựa vào một hoặc nhiều gói khác để dựng và cài đặt đúng cách. Một số gói thậm chí còn phụ thuộc vòng tròn: gói thứ nhất phụ"
---

# C. Các phụ thuộc

Mỗi gói được dựng trong LFS đều dựa vào một hoặc nhiều gói khác để dựng và cài đặt đúng cách. Một số gói thậm chí còn phụ thuộc vòng tròn: gói thứ nhất phụ thuộc gói thứ hai, và gói thứ hai lại phụ thuộc gói thứ nhất. Vì những phụ thuộc này, thứ tự dựng các gói trong LFS rất quan trọng. Trang này ghi lại các phụ thuộc của từng gói được dựng trong LFS.

Với mỗi gói được dựng, bên dưới liệt kê ba, đôi khi tới năm loại phụ thuộc. Danh sách thứ nhất nêu những gói khác cần có sẵn để biên dịch và cài đặt gói đang xét. Danh sách thứ hai nêu những gói phải có khi chạy bất kỳ chương trình hay thư viện nào của gói này. Danh sách thứ ba nêu những gói cần có thêm, ngoài các gói ở danh sách thứ nhất, để chạy bộ kiểm thử. Danh sách thứ tư gồm các gói đòi hỏi gói này phải được dựng và cài đặt vào vị trí cuối cùng trước khi chính chúng được dựng và cài đặt.

Danh sách cuối cùng gồm các gói tùy chọn không được đề cập trong LFS nhưng có thể hữu ích cho bạn. Những gói này có thể có thêm các phụ thuộc bắt buộc hoặc tùy chọn riêng. Với các phụ thuộc đó, cách làm được khuyến nghị là cài chúng sau khi hoàn tất sách LFS rồi quay lại dựng lại gói LFS. Trong nhiều trường hợp, việc cài lại được hướng dẫn trong BLFS.

## Acl

* **Cài đặt phụ thuộc vào:** Attr, Bash, Binutils, Coreutils, GCC, Gettext, Grep, M4, Make, Perl, Sed và Texinfo

* **Cần khi chạy:** Attr và Glibc

* **Bộ kiểm thử phụ thuộc vào:** Automake, Diffutils, Findutils và Libtool

* **Phải được cài trước:** Coreutils, Sed, Tar và Vim

* **Phụ thuộc tùy chọn:** Không có

## Attr

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Gettext, Glibc, Grep, M4, Make, Perl, Sed và Texinfo

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Automake, Diffutils, Findutils và Libtool

* **Phải được cài trước:** Acl, Libcap và Patch

* **Phụ thuộc tùy chọn:** Không có

## Autoconf

* **Cài đặt phụ thuộc vào:** Bash, Coreutils, Grep, M4, Make, Perl, Sed và Texinfo

* **Cần khi chạy:** Bash, Coreutils, Grep, M4, Make, Sed và Texinfo

* **Bộ kiểm thử phụ thuộc vào:** Automake, Diffutils, Findutils, GCC và Libtool

* **Phải được cài trước:** Automake và Coreutils

* **Phụ thuộc tùy chọn:** [Emacs](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/emacs.html)

## Automake

* **Cài đặt phụ thuộc vào:** Autoconf, Bash, Coreutils, Gettext, Grep, M4, Make, Perl, Sed và Texinfo

* **Cần khi chạy:** Bash, Coreutils, Grep, M4, Sed và Texinfo

* **Bộ kiểm thử phụ thuộc vào:** Binutils, Bison, Bzip2, DejaGNU, Diffutils, Expect, Findutils, Flex, GCC, Gettext, Gzip, Libtool và Tar

* **Phải được cài trước:** Coreutils

* **Phụ thuộc tùy chọn:** Không có

## Bash

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Bison, Coreutils, Diffutils, Gawk, GCC, Glibc, Grep, Make, Ncurses, Patch, Readline, Sed và Texinfo

* **Cần khi chạy:** Glibc, Ncurses và Readline

* **Bộ kiểm thử phụ thuộc vào:** Expect và Shadow

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [Xorg](https://www.linuxfromscratch.org/blfs/view/12.4/x/installing.html)

## Bc

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Glibc, Grep, Make và Readline

* **Cần khi chạy:** Glibc, Ncurses và Readline

* **Bộ kiểm thử phụ thuộc vào:** Gawk

* **Phải được cài trước:** Linux

* **Phụ thuộc tùy chọn:** Không có

## Binutils

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, File, Flex, Gawk, GCC, Glibc, Grep, Make, Perl, Pkgconf, Sed, Texinfo, Zlib và Zstd

* **Cần khi chạy:** Glibc, Zlib và Zstd

* **Bộ kiểm thử phụ thuộc vào:** DejaGNU và Expect

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [Elfutils](https://sourceware.org/elfutils/) và [Jansson](https://www.linuxfromscratch.org/blfs/view/12.4/general/jansson.html)

## Bison

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, GCC, Gettext, Glibc, Grep, M4, Make, Perl và Sed

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Diffutils, Findutils và Flex

* **Phải được cài trước:** Kbd và Tar

* **Phụ thuộc tùy chọn:** [Doxygen](https://www.linuxfromscratch.org/blfs/view/12.4/general/doxygen.html)

## Bzip2

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, GCC, Glibc, Make và Patch

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** File và Libelf

* **Phụ thuộc tùy chọn:** Không có

## Coreutils

* **Cài đặt phụ thuộc vào:** Autoconf, Automake, Bash, Binutils, Coreutils, GCC, Gettext, Glibc, GMP, Grep, Libcap, Make, OpenSSL, Patch, Perl, Sed và Texinfo

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Diffutils, E2fsprogs, Findutils, Shadow và Util-linux

* **Phải được cài trước:** Bash, Diffutils, Findutils, Man-DB và Udev

* **Phụ thuộc tùy chọn:** [Expect.pm](https://metacpan.org/pod/Expect) và [IO::Tty](https://metacpan.org/pod/IO::Tty)

## DejaGNU

* **Cài đặt phụ thuộc vào:** Bash, Coreutils, Diffutils, Expect, GCC, Grep, Make, Sed và Texinfo

* **Cần khi chạy:** Expect và Bash

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Diffutils

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Gawk, GCC, Gettext, Glibc, Grep, Make, Sed và Texinfo

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Perl

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## E2fsprogs

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, Gawk, GCC, Glibc, Grep, Gzip, Make, Pkgconf, Sed, Texinfo và Util-linux

* **Cần khi chạy:** Glibc và Util-linux

* **Bộ kiểm thử phụ thuộc vào:** Procps-ng và Psmisc

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Expat

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Gawk, GCC, Glibc, Grep, Make và Sed

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Python và XML::Parser

* **Phụ thuộc tùy chọn:** Không có

## Expect

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, GCC, Glibc, Grep, Make, Patch, Sed và Tcl

* **Cần khi chạy:** Glibc và Tcl

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [Tk](https://www.linuxfromscratch.org/blfs/view/12.4/general/tk.html)

## File

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Bzip2, Coreutils, Diffutils, Gawk, GCC, Glibc, Grep, Make, Sed, Xz và Zlib

* **Cần khi chạy:** Glibc, Bzip2, Xz và Zlib

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [libseccomp](https://www.linuxfromscratch.org/blfs/view/12.4/general/libseccomp.html)

## Findutils

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Gettext, Glibc, Grep, Make, Sed và Texinfo

* **Cần khi chạy:** Bash và Glibc

* **Bộ kiểm thử phụ thuộc vào:** DejaGNU, Diffutils và Expect

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Flex

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Gettext, Glibc, Grep, M4, Make, Patch, Sed và Texinfo

* **Cần khi chạy:** Bash, Glibc và M4

* **Bộ kiểm thử phụ thuộc vào:** Bison và Gawk

* **Phải được cài trước:** Binutils, IProute2, Kbd, Kmod và Man-DB

* **Phụ thuộc tùy chọn:** Không có

## Flit-Core

* **Cài đặt phụ thuộc vào:** Python

* **Cần khi chạy:** Python

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Packaging và Wheel

* **Phụ thuộc tùy chọn:** [pytest](https://www.linuxfromscratch.org/blfs/view/12.4/general/python-modules.html#pytest) và [testpath](https://pypi.org/project/testpath)

## Gawk

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Gettext, Glibc, GMP, Grep, Make, MPFR, Patch, Readline, Sed và Texinfo

* **Cần khi chạy:** Bash, Glibc và Mpfr

* **Bộ kiểm thử phụ thuộc vào:** Diffutils

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [libsigsegv](https://www.linuxfromscratch.org/blfs/view/12.4/general/libsigsegv.html)

## GCC

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, Findutils, Gawk, GCC, Gettext, Glibc, GMP, Grep, M4, Make, MPC, MPFR, Patch, Perl, Sed, Tar, Texinfo và Zstd

* **Cần khi chạy:** Bash, Binutils, Glibc, Mpc và Python

* **Bộ kiểm thử phụ thuộc vào:** DejaGNU, Expect và Shadow

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [GDC](https://www.gdcproject.org/), [GNAT](https://gcc.gnu.org/wiki/GNAT) và [ISL](https://repo.or.cz/isl.git)

## GDBM

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, GCC, Grep, Make và Sed

* **Cần khi chạy:** Bash, Glibc và Readline

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Gettext

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Gawk, GCC, Glibc, Grep, Make, Ncurses, Sed và Texinfo

* **Cần khi chạy:** Acl, Bash, Gcc và Glibc

* **Bộ kiểm thử phụ thuộc vào:** Diffutils, Perl và Tcl

* **Phải được cài trước:** Automake và Bison

* **Phụ thuộc tùy chọn:** [libunistring](https://www.linuxfromscratch.org/blfs/view/12.4/general/libunistring.html) và [libxml2](https://www.linuxfromscratch.org/blfs/view/12.4/general/libxml2.html)

## Glibc

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Bison, Coreutils, Diffutils, Gawk, GCC, Gettext, Grep, Gzip, Linux API Headers, Make, Perl, Python, Sed và Texinfo

* **Cần khi chạy:** Không có

* **Bộ kiểm thử phụ thuộc vào:** File

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## GMP

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, Gawk, GCC, Glibc, Grep, M4, Make, Sed và Texinfo

* **Cần khi chạy:** GCC và Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** MPFR và GCC

* **Phụ thuộc tùy chọn:** Không có

## Gperf

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Glibc và Make

* **Cần khi chạy:** GCC và Glibc

* **Bộ kiểm thử phụ thuộc vào:** Diffutils và Expect

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Grep

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, GCC, Gettext, Glibc, Grep, Make, Patch, Sed và Texinfo

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Gawk

* **Phải được cài trước:** Man-DB

* **Phụ thuộc tùy chọn:** [PCRE2](https://www.linuxfromscratch.org/blfs/view/12.4/general/pcre2.html) và [libsigsegv](https://www.linuxfromscratch.org/blfs/view/12.4/general/libsigsegv.html)

## Groff

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Bison, Coreutils, Gawk, GCC, Glibc, Grep, Make, Patch, Sed và Texinfo

* **Cần khi chạy:** GCC, Glibc và Perl

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Man-DB

* **Phụ thuộc tùy chọn:** [ghostscript](https://www.linuxfromscratch.org/blfs/view/12.4/pst/gs.html) và [Uchardet](https://www.linuxfromscratch.org/blfs/view/12.4/general/uchardet.html)

## GRUB

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Bison, Coreutils, Diffutils, GCC, Gettext, Glibc, Grep, Make, Ncurses, Sed, Texinfo và Xz

* **Cần khi chạy:** Bash, GCC, Gettext, Glibc, Xz và Sed

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Gzip

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Glibc, Grep, Make, Sed và Texinfo

* **Cần khi chạy:** Bash và Glibc

* **Bộ kiểm thử phụ thuộc vào:** Diffutils và Less

* **Phải được cài trước:** Man-DB

* **Phụ thuộc tùy chọn:** Không có

## Iana-Etc

* **Cài đặt phụ thuộc vào:** Coreutils

* **Cần khi chạy:** Không có

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Perl

* **Phụ thuộc tùy chọn:** Không có

## Inetutils

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Glibc, Grep, Make, Ncurses, Patch, Sed, Texinfo và Zlib

* **Cần khi chạy:** GCC, Glibc, Ncurses và Readline

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Tar

* **Phụ thuộc tùy chọn:** Không có

## Intltool

* **Cài đặt phụ thuộc vào:** Bash, Gawk, Glibc, Make, Perl, Sed và XML::Parser

* **Cần khi chạy:** Autoconf, Automake, Bash, Glibc, Grep, Perl và Sed

* **Bộ kiểm thử phụ thuộc vào:** Perl

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## IProute2

* **Cài đặt phụ thuộc vào:** Bash, Bison, Coreutils, Flex, GCC, Glibc, Make, Libcap, Libelf, Linux API Headers, Pkgconf và Zlib

* **Cần khi chạy:** Bash, Coreutils, Glibc, Libcap, Libelf và Zlib

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [Berkeley DB](https://www.oracle.com/database/technologies/related/berkeleydb.html), [iptables](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/iptables.html), [libbpf](https://github.com/libbpf/libbpf), [libmnl](https://www.linuxfromscratch.org/blfs/view/12.4/basicnet/libmnl.html) và [libtirpc](https://www.linuxfromscratch.org/blfs/view/12.4/basicnet/libtirpc.html)

## Jinja2

* **Cài đặt phụ thuộc vào:** MarkupSafe, Python, Setuptools và Wheel

* **Cần khi chạy:** MarkupSafe và Python

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Udev

* **Phụ thuộc tùy chọn:** Không có

## Kbd

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Bison, Coreutils, Flex, GCC, Gettext, Glibc, Gzip, Make, Patch và Sed

* **Cần khi chạy:** Bash, Coreutils và Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [Linux-PAM](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/linux-pam.html)

## Kmod

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Bison, Coreutils, Flex, GCC, Gettext, Glibc, Gzip, Make, OpenSSL, Pkgconf, Sed, Xz và Zlib

* **Cần khi chạy:** Glibc, Xz và Zlib

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Udev

* **Phụ thuộc tùy chọn:** [scdoc](https://git.sr.ht/~sircmpwn/scdoc/) (cho man page)

## Less

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, GCC, Glibc, Grep, Make, Ncurses và Sed

* **Cần khi chạy:** Glibc và Ncurses

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Gzip

* **Phụ thuộc tùy chọn:** [PCRE2](https://www.linuxfromscratch.org/blfs/view/12.4/general/pcre2.html) hoặc [PCRE](https://www.linuxfromscratch.org/blfs/view/12.4/general/pcre.html)

## Libcap

* **Cài đặt phụ thuộc vào:** Attr, Bash, Binutils, Coreutils, GCC, Glibc, Perl, Make và Sed

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** IProute2 và Shadow

* **Phụ thuộc tùy chọn:** [Linux-PAM](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/linux-pam.html)

## Libelf

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Bzip2, Coreutils, GCC, Glibc, Make, Xz, Zlib và Zstd

* **Cần khi chạy:** Bzip2, Glibc, Xz, Zlib và Zstd

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** IProute2 và Linux

* **Phụ thuộc tùy chọn:** Không có

## Libffi

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Glibc, Make và Sed

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** DejaGnu

* **Phải được cài trước:** Python

* **Phụ thuộc tùy chọn:** Không có

## Libpipeline

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, Gawk, GCC, Glibc, Grep, Make, Sed và Texinfo

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Check và Pkgconf

* **Phải được cài trước:** Man-DB

* **Phụ thuộc tùy chọn:** Không có

## Libtool

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, Gawk, GCC, Glibc, Grep, Make, Sed và Texinfo

* **Cần khi chạy:** Autoconf, Automake, Bash, Binutils, Coreutils, File, GCC, Glibc, Grep, Make và Sed

* **Bộ kiểm thử phụ thuộc vào:** Autoconf, Automake và Findutils

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Libxcrypt

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, Gawk, GCC, Glibc, Grep, Make, Perl và Sed

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Perl, Python, Shadow và Udev

* **Phụ thuộc tùy chọn:** Không có

## Linux

* **Cài đặt phụ thuộc vào:** Bash, Bc, Binutils, Coreutils, Diffutils, Findutils, GCC, Glibc, Grep, Gzip, Kmod, Libelf, Make, Ncurses, OpenSSL, Perl và Sed

* **Cần khi chạy:** Không có

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [cpio](https://www.linuxfromscratch.org/blfs/view/12.4/general/cpio.html), [LLVM](https://www.linuxfromscratch.org/blfs/view/12.4/general/llvm.html) (kèm Clang) và [Rust-bindgen](https://www.linuxfromscratch.org/blfs/view/12.4/general/rust-bindgen.html)

## Linux API Headers

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Findutils, GCC, Glibc, Grep, Gzip, Make, Perl và Sed

* **Cần khi chạy:** Không có

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Lz4

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Glibc và Make

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Python

* **Phải được cài trước:** Zstd

* **Phụ thuộc tùy chọn:** Không có

## M4

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Glibc, Grep, Make, Sed và Texinfo

* **Cần khi chạy:** Bash và Glibc

* **Bộ kiểm thử phụ thuộc vào:** Diffutils

* **Phải được cài trước:** Autoconf và Bison

* **Phụ thuộc tùy chọn:** [libsigsegv](https://www.linuxfromscratch.org/blfs/view/12.4/general/libsigsegv.html)

## Make

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Gettext, Glibc, Grep, Make, Sed và Texinfo

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Perl và Procps-ng

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [Guile](https://www.linuxfromscratch.org/blfs/view/12.4/general/guile.html)

## Man-DB

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Bzip2, Coreutils, Flex, GCC, GDBM, Gettext, Glibc, Grep, Groff, Gzip, Less, Libpipeline, Make, Pkgconf, Sed và Xz

* **Cần khi chạy:** Bash, GDBM, Groff, Glibc, Gzip, Less, Libpipeline và Zlib

* **Bộ kiểm thử phụ thuộc vào:** Util-linux

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [libseccomp](https://www.linuxfromscratch.org/blfs/view/12.4/general/libseccomp.html) và [po4a](https://po4a.org/index.php.en)

## Man-Pages

* **Cài đặt phụ thuộc vào:** Bash, Coreutils, Make và Sed

* **Cần khi chạy:** Không có

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## MarkupSafe

* **Cài đặt phụ thuộc vào:** Python, Setuptools và Wheel

* **Cần khi chạy:** Python

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Jinja2

* **Phụ thuộc tùy chọn:** Không có

## Meson

* **Cài đặt phụ thuộc vào:** Ninja, Python, Setuptools và Wheel

* **Cần khi chạy:** Python

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Udev

* **Phụ thuộc tùy chọn:** Không có

## MPC

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, Gawk, GCC, Glibc, Grep, GMP, Make, MPFR, Sed và Texinfo

* **Cần khi chạy:** Glibc, GMP và MPFR

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** GCC

* **Phụ thuộc tùy chọn:** Không có

## MPFR

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, Gawk, GCC, Glibc, Grep, GMP, Make, Sed và Texinfo

* **Cần khi chạy:** Glibc và GMP

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Gawk và GCC

* **Phụ thuộc tùy chọn:** Không có

## Ncurses

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, Gawk, GCC, Glibc, Grep, Make, Patch và Sed

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Bash, GRUB, Inetutils, Less, Procps-ng, Psmisc, Readline, Texinfo, Util-linux và Vim

* **Phụ thuộc tùy chọn:** Không có

## Ninja

* **Cài đặt phụ thuộc vào:** Binutils, Coreutils, GCC và Python

* **Cần khi chạy:** GCC và Glibc

* **Bộ kiểm thử phụ thuộc vào:** [cmake](https://www.linuxfromscratch.org/blfs/view/12.4/general/cmake.html)

* **Phải được cài trước:** Meson

* **Phụ thuộc tùy chọn:** [Asciidoc](https://www.linuxfromscratch.org/blfs/view/12.4/general/asciidoc.html), [Doxygen](https://www.linuxfromscratch.org/blfs/view/12.4/general/doxygen.html), [Emacs](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/emacs.html) và [re2c](https://re2c.org/)

## OpenSSL

* **Cài đặt phụ thuộc vào:** Binutils, Coreutils, GCC, Make và Perl

* **Cần khi chạy:** Glibc và Perl

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Coreutils, Kmod, Linux và Udev

* **Phụ thuộc tùy chọn:** Không có

## Packaging

* **Cài đặt phụ thuộc vào:** Flit-core và Python

* **Cần khi chạy:** Python

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Wheel

* **Phụ thuộc tùy chọn:** [pytest](https://www.linuxfromscratch.org/blfs/view/12.4/general/python-modules.html#pytest)

## Patch

* **Cài đặt phụ thuộc vào:** Attr, Bash, Binutils, Coreutils, GCC, Glibc, Grep, Make và Sed

* **Cần khi chạy:** Attr và Glibc

* **Bộ kiểm thử phụ thuộc vào:** Diffutils

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [Ed](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/ed.html)

## Perl

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Gawk, GCC, GDBM, Glibc, Grep, Libxcrypt, Make, Sed và Zlib

* **Cần khi chạy:** GDBM, Glibc và Libxcrypt

* **Bộ kiểm thử phụ thuộc vào:** Iana-Etc, Less và Procps-ng

* **Phải được cài trước:** Autoconf

* **Phụ thuộc tùy chọn:** [Berkeley DB](https://www.oracle.com/database/technologies/related/berkeleydb.html)

## Pkgconf

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Gawk, GCC, Glibc, Grep, Make và Sed

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Binutils, E2fsprogs, IProute2, Kmod, Man-DB, Procps-ng, Python, Udev và Util-linux

* **Phụ thuộc tùy chọn:** Không có

## Procps-ng

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Glibc, Make, Ncurses, và Pkgconf

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** DejaGNU

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [elogind](https://www.linuxfromscratch.org/blfs/view/12.4/general/elogind.html)

## Psmisc

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Gettext, Glibc, Grep, Make, Ncurses và Sed

* **Cần khi chạy:** Glibc và Ncurses

* **Bộ kiểm thử phụ thuộc vào:** Expect

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Python

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Expat, GCC, Gdbm, Gettext, Glibc, Grep, Libffi, Libxcrypt, Make, Ncurses, OpenSSL, Pkgconf, Sed và Util-linux

* **Cần khi chạy:** Bzip2, Expat, Gdbm, Glibc, Libffi, Libxcrypt, Ncurses, OpenSSL và Zlib

* **Bộ kiểm thử phụ thuộc vào:** GDB và Valgrind

* **Phải được cài trước:** Ninja

* **Phụ thuộc tùy chọn:** [Berkeley DB](https://www.oracle.com/database/technologies/related/berkeleydb.html), [libnsl](https://www.linuxfromscratch.org/blfs/view/12.4/basicnet/libnsl.html), [SQLite](https://www.linuxfromscratch.org/blfs/view/12.4/server/sqlite.html) và [Tk](https://www.linuxfromscratch.org/blfs/view/12.4/general/tk.html)

## Readline

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Gawk, GCC, Glibc, Grep, Make, Ncurses, Patch, Sed và Texinfo

* **Cần khi chạy:** Glibc và Ncurses

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Bash, Bc và Gawk

* **Phụ thuộc tùy chọn:** Không có

## Sed

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Gettext, Glibc, Grep, Make, Sed và Texinfo

* **Cần khi chạy:** Acl, Attr và Glibc

* **Bộ kiểm thử phụ thuộc vào:** Diffutils và Gawk

* **Phải được cài trước:** E2fsprogs, File, Libtool và Shadow

* **Phụ thuộc tùy chọn:** Không có

## Setuptools

* **Cài đặt phụ thuộc vào:** Python và Wheel

* **Cần khi chạy:** Python

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Jinja2, MarkupSafe và Meson

* **Phụ thuộc tùy chọn:** Không có

## Shadow

* **Cài đặt phụ thuộc vào:** Acl, Attr, Bash, Binutils, Coreutils, Diffutils, Findutils, Gawk, GCC, Gettext, Glibc, Grep, Libcap, Libxcrypt, Make và Sed

* **Cần khi chạy:** Glibc và Libxcrypt

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Coreutils

* **Phụ thuộc tùy chọn:** [CrackLib](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/cracklib.html) và [Linux-PAM](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/linux-pam.html)

## Sysklogd

* **Cài đặt phụ thuộc vào:** Binutils, Coreutils, GCC, Glibc, Make và Patch

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## SysVinit

* **Cài đặt phụ thuộc vào:** Binutils, Coreutils, GCC, Glibc, Make và Sed

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Tar

* **Cài đặt phụ thuộc vào:** Acl, Attr, Bash, Binutils, Bison, Coreutils, GCC, Gettext, Glibc, Grep, Inetutils, Make, Sed và Texinfo

* **Cần khi chạy:** Acl, Attr, Bzip2, Glibc, Gzip và Xz

* **Bộ kiểm thử phụ thuộc vào:** Autoconf, Diffutils, Findutils, Gawk và Gzip

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Tcl

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, GCC, Glibc, Grep, Make và Sed

* **Cần khi chạy:** Glibc và Zlib

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Texinfo

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Gettext, Glibc, Grep, Make, Ncurses, Patch và Sed

* **Cần khi chạy:** Glibc và Ncurses

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** Không có

## Udev

* **Cài đặt phụ thuộc vào:** Acl, Bash, Binutils, Coreutils, Diffutils, Gawk, GCC, Glibc, Gperf, Grep, Jinja2, Libcap, Libxcrypt, Meson, OpenSSL, Pkgconf, Sed, Util-linux và Zstd

* **Cần khi chạy:** Acl, Glibc, Libcap, OpenSSL và Util-linux

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Util-linux

* **Phụ thuộc tùy chọn:** Không có

## Util-linux

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, File, Findutils, Gawk, GCC, Gettext, Glibc, Grep, Make, Ncurses, Pkgconf, Sed, Udev và Zlib

* **Cần khi chạy:** Glibc, Ncurses, Readline, Udev và Zlib

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [Asciidoctor](https://www.linuxfromscratch.org/blfs/view/12.4/general/asciidoctor.html), [Libcap-NG](https://people.redhat.com/sgrubb/libcap-ng/), [libeconf](https://github.com/openSUSE/libeconf), [libuser](https://pagure.io/libuser/), [libutempter](https://github.com/altlinux/libutempter), [Linux-PAM](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/linux-pam.html), [smartmontools](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/smartmontools.html), [po4a](https://po4a.org/index.php.en) và [slang](https://www.linuxfromscratch.org/blfs/view/12.4/general/slang.html)

## Vim

* **Cài đặt phụ thuộc vào:** Acl, Attr, Bash, Binutils, Coreutils, Diffutils, GCC, Glibc, Grep, Make, Ncurses và Sed

* **Cần khi chạy:** Acl, Attr, Glibc, Python, Ncurses và Tcl

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Không có

* **Phụ thuộc tùy chọn:** [Xorg](https://www.linuxfromscratch.org/blfs/view/12.4/x/installing.html), [GTK+2](https://www.linuxfromscratch.org/blfs/view/12.4/x/gtk2.html), [LessTif](https://lesstif.sourceforge.net/), [Ruby](https://www.linuxfromscratch.org/blfs/view/12.4/general/ruby.html) và [GPM](https://www.linuxfromscratch.org/blfs/view/12.4/general/gpm.html)

## Wheel

* **Cài đặt phụ thuộc vào:** Python, Flit-core và packaging

* **Cần khi chạy:** Python

* **Bộ kiểm thử phụ thuộc vào:** Không có bộ kiểm thử

* **Phải được cài trước:** Jinja2, MarkupSafe, Meson và Setuptools

* **Phụ thuộc tùy chọn:** Không có

## XML::Parser

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Expat, GCC, Glibc, Make và Perl

* **Cần khi chạy:** Expat, Glibc và Perl

* **Bộ kiểm thử phụ thuộc vào:** Perl

* **Phải được cài trước:** Intltool

* **Phụ thuộc tùy chọn:** [LWP::UserAgent](https://metacpan.org/pod/LWP::UserAgent)

## Xz

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, Diffutils, GCC, Glibc và Make

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** File, GRUB, Kmod, Libelf, Man-DB và Udev

* **Phụ thuộc tùy chọn:** Không có

## Zlib

* **Cài đặt phụ thuộc vào:** Bash, Binutils, Coreutils, GCC, Glibc, Make và Sed

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** File, Kmod, Libelf, Perl và Util-linux

* **Phụ thuộc tùy chọn:** Không có

## Zstd

* **Cài đặt phụ thuộc vào:** Binutils, Coreutils, GCC, Glibc, Gzip, Lz4, Make, Xz và Zlib

* **Cần khi chạy:** Glibc

* **Bộ kiểm thử phụ thuộc vào:** Không có

* **Phải được cài trước:** Binutils, GCC, Libelf và Udev

* **Phụ thuộc tùy chọn:** Không có

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/appendices/dependencies.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/appendices/dependencies.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/appendices/dependencies.html)
