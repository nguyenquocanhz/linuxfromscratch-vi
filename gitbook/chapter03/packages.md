---
description: "Hãy đọc thông báo bảo mật trước khi tải các gói để biết có gói nào nên dùng phiên bản mới hơn nhằm tránh các lỗ hổng bảo mật hay không."
---

<details>

<summary>Trick lỏ: Tải toàn bộ mã nguồn nhanh và kiểm tra một lần</summary>

Sách cho sẵn file `wget-list-sysv` và `md5sums`. Tải song song cho nhanh (cần gói `aria2`):

```bash
cd $LFS/sources
wget https://www.linuxfromscratch.org/lfs/view/12.4/wget-list-sysv
wget https://www.linuxfromscratch.org/lfs/view/12.4/md5sums
aria2c -x4 -j8 -c -i wget-list-sysv     # -c: tải tiếp nếu đứt mạng
md5sum -c md5sums | grep -v ': OK$'     # chỉ in file lỗi; không in gì = ngon
```

Có file tải hỏng từ server gốc? Mỗi gói thường có mirror khác trên trang dự án; tải tay rồi chạy lại `md5sum -c`. Mẹo thêm: nén cả thư mục `sources` lại cất đi — lần làm LFS thứ hai khỏi tải lại.

[Tất cả trick lỏ →](../trick-lo.md#tai-nguon-nhanh)

</details>

# 3.2. Tất cả các gói

{% hint style="info" %}
**Ghi chú**

Hãy đọc [thông báo bảo mật](https://www.linuxfromscratch.org/lfs/advisories/) trước khi tải các gói để biết có gói nào nên dùng phiên bản mới hơn nhằm tránh các lỗ hổng bảo mật hay không.

Nhà phát triển gốc (upstream) có thể gỡ các bản phát hành cũ, nhất là khi những bản đó có lỗ hổng bảo mật. Nếu một URL bên dưới không truy cập được, trước hết bạn nên đọc các thông báo bảo mật để xem có cần dùng phiên bản mới hơn (đã vá lỗ hổng) hay không. Nếu không cần, hãy thử tải gói đã bị gỡ từ một mirror. Dù vẫn có thể tải bản cũ từ mirror ngay cả khi nó đã bị gỡ vì lỗ hổng, bạn cũng không nên dùng một bản đã biết là có lỗ hổng để dựng hệ thống của mình.
{% endhint %}

Hãy tải về hoặc bằng cách nào đó lấy các gói sau:

**Acl (2.3.2) - 363 KB:**

> Trang chủ: [https://savannah.nongnu.org/projects/acl](https://savannah.nongnu.org/projects/acl)

> Tải về: [https://download.savannah.gnu.org/releases/acl/acl-2.3.2.tar.xz](https://download.savannah.gnu.org/releases/acl/acl-2.3.2.tar.xz)

> Tổng kiểm MD5: `590765dee95907dbc3c856f7255bd669`

**Attr (2.5.2) - 484 KB:**

> Trang chủ: [https://savannah.nongnu.org/projects/attr](https://savannah.nongnu.org/projects/attr)

> Tải về: [https://download.savannah.gnu.org/releases/attr/attr-2.5.2.tar.gz](https://download.savannah.gnu.org/releases/attr/attr-2.5.2.tar.gz)

> Tổng kiểm MD5: `227043ec2f6ca03c0948df5517f9c927`

**Autoconf (2.72) - 1,360 KB:**

> Trang chủ: [https://www.gnu.org/software/autoconf/](https://www.gnu.org/software/autoconf/)

> Tải về: [https://ftp.gnu.org/gnu/autoconf/autoconf-2.72.tar.xz](https://ftp.gnu.org/gnu/autoconf/autoconf-2.72.tar.xz)

> Tổng kiểm MD5: `1be79f7106ab6767f18391c5e22be701`

**Automake (1.18.1) - 1,614 KB:**

> Trang chủ: [https://www.gnu.org/software/automake/](https://www.gnu.org/software/automake/)

> Tải về: [https://ftp.gnu.org/gnu/automake/automake-1.18.1.tar.xz](https://ftp.gnu.org/gnu/automake/automake-1.18.1.tar.xz)

> Tổng kiểm MD5: `cea31dbf1120f890cbf2a3032cfb9a68`

**Bash (5.3) - 11,089 KB:**

> Trang chủ: [https://www.gnu.org/software/bash/](https://www.gnu.org/software/bash/)

> Tải về: [https://ftp.gnu.org/gnu/bash/bash-5.3.tar.gz](https://ftp.gnu.org/gnu/bash/bash-5.3.tar.gz)

> Tổng kiểm MD5: `977c8c0c5ae6309191e7768e28ebc951`

**Bc (7.0.3) - 464 KB:**

> Trang chủ: [https://github.com/gavinhoward](https://github.com/gavinhoward)

> Tải về: [https://github.com/gavinhoward/bc/releases/download/7.0.3/bc-7.0.3.tar.xz](https://github.com/gavinhoward/bc/releases/download/7.0.3/bc-7.0.3.tar.xz)

> Tổng kiểm MD5: `ad4db5a0eb4fdbb3f6813be4b6b3da74`

**Binutils (2.45) - 27,216 KB:**

> Trang chủ: [https://www.gnu.org/software/binutils/](https://www.gnu.org/software/binutils/)

> Tải về: [https://sourceware.org/pub/binutils/releases/binutils-2.45.tar.xz](https://sourceware.org/pub/binutils/releases/binutils-2.45.tar.xz)

> Tổng kiểm MD5: `dee5b4267e0305a99a3c9d6131f45759`

**Bison (3.8.2) - 2,752 KB:**

> Trang chủ: [https://www.gnu.org/software/bison/](https://www.gnu.org/software/bison/)

> Tải về: [https://ftp.gnu.org/gnu/bison/bison-3.8.2.tar.xz](https://ftp.gnu.org/gnu/bison/bison-3.8.2.tar.xz)

> Tổng kiểm MD5: `c28f119f405a2304ff0a7ccdcc629713`

**Bzip2 (1.0.8) - 792 KB:**

> Tải về: [https://www.sourceware.org/pub/bzip2/bzip2-1.0.8.tar.gz](https://www.sourceware.org/pub/bzip2/bzip2-1.0.8.tar.gz)

> Tổng kiểm MD5: `67e051268d0c475ea773822f7500d0e5`

**Coreutils (9.7) - 6,015 KB:**

> Trang chủ: [https://www.gnu.org/software/coreutils/](https://www.gnu.org/software/coreutils/)

> Tải về: [https://ftp.gnu.org/gnu/coreutils/coreutils-9.7.tar.xz](https://ftp.gnu.org/gnu/coreutils/coreutils-9.7.tar.xz)

> Tổng kiểm MD5: `6b7285faf7d5eb91592bdd689270d3f1`

**DejaGNU (1.6.3) - 608 KB:**

> Trang chủ: [https://www.gnu.org/software/dejagnu/](https://www.gnu.org/software/dejagnu/)

> Tải về: [https://ftp.gnu.org/gnu/dejagnu/dejagnu-1.6.3.tar.gz](https://ftp.gnu.org/gnu/dejagnu/dejagnu-1.6.3.tar.gz)

> Tổng kiểm MD5: `68c5208c58236eba447d7d6d1326b821`

**Diffutils (3.12) - 1,894 KB:**

> Trang chủ: [https://www.gnu.org/software/diffutils/](https://www.gnu.org/software/diffutils/)

> Tải về: [https://ftp.gnu.org/gnu/diffutils/diffutils-3.12.tar.xz](https://ftp.gnu.org/gnu/diffutils/diffutils-3.12.tar.xz)

> Tổng kiểm MD5: `d1b18b20868fb561f77861cd90b05de4`

**E2fsprogs (1.47.3) - 9,851 KB:**

> Trang chủ: [https://e2fsprogs.sourceforge.net/](https://e2fsprogs.sourceforge.net/)

> Tải về: [https://downloads.sourceforge.net/project/e2fsprogs/e2fsprogs/v1.47.3/e2fsprogs-1.47.3.tar.gz](https://downloads.sourceforge.net/project/e2fsprogs/e2fsprogs/v1.47.3/e2fsprogs-1.47.3.tar.gz)

> Tổng kiểm MD5: `113d7a7ee0710d2a670a44692a35fd2e`

**Elfutils (0.193) - 11,695 KB:**

> Trang chủ: [https://sourceware.org/elfutils/](https://sourceware.org/elfutils/)

> Tải về: [https://sourceware.org/ftp/elfutils/0.193/elfutils-0.193.tar.bz2](https://sourceware.org/ftp/elfutils/0.193/elfutils-0.193.tar.bz2)

> Tổng kiểm MD5: `ceefa052ded950a4c523688799193a44`

**Expat (2.7.1) - 485 KB:**

> Trang chủ: [https://libexpat.github.io/](https://libexpat.github.io/)

> Tải về: [https://github.com/libexpat/libexpat/releases/download/R\_2\_7\_1/expat-2.7.1.tar.xz](https://github.com/libexpat/libexpat/releases/download/R_2_7_1/expat-2.7.1.tar.xz)

> Tổng kiểm MD5: `9f0c266ff4b9720beae0c6bd53ae4469`

**Expect (5.45.4) - 618 KB:**

> Trang chủ: [https://core.tcl.tk/expect/](https://core.tcl.tk/expect/)

> Tải về: [https://prdownloads.sourceforge.net/expect/expect5.45.4.tar.gz](https://prdownloads.sourceforge.net/expect/expect5.45.4.tar.gz)

> Tổng kiểm MD5: `00fce8de158422f5ccd2666512329bd2`

**File (5.46) - 1,283 KB:**

> Trang chủ: [https://www.darwinsys.com/file/](https://www.darwinsys.com/file/)

> Tải về: [https://astron.com/pub/file/file-5.46.tar.gz](https://astron.com/pub/file/file-5.46.tar.gz)

> Tổng kiểm MD5: `459da2d4b534801e2e2861611d823864`

**Findutils (4.10.0) - 2,189 KB:**

> Trang chủ: [https://www.gnu.org/software/findutils/](https://www.gnu.org/software/findutils/)

> Tải về: [https://ftp.gnu.org/gnu/findutils/findutils-4.10.0.tar.xz](https://ftp.gnu.org/gnu/findutils/findutils-4.10.0.tar.xz)

> Tổng kiểm MD5: `870cfd71c07d37ebe56f9f4aaf4ad872`

**Flex (2.6.4) - 1,386 KB:**

> Trang chủ: [https://github.com/westes/flex](https://github.com/westes/flex)

> Tải về: [https://github.com/westes/flex/releases/download/v2.6.4/flex-2.6.4.tar.gz](https://github.com/westes/flex/releases/download/v2.6.4/flex-2.6.4.tar.gz)

> Tổng kiểm MD5: `2882e3179748cc9f9c23ec593d6adc8d`

**Flit-core (3.12.0) - 53 KB:**

> Trang chủ: [https://pypi.org/project/flit-core/](https://pypi.org/project/flit-core/)

> Tải về: [https://pypi.org/packages/source/f/flit-core/flit\_core-3.12.0.tar.gz](https://pypi.org/packages/source/f/flit-core/flit_core-3.12.0.tar.gz)

> Tổng kiểm MD5: `c538415c1f27bd69cbbbf3cdd5135d39`

**Gawk (5.3.2) - 3,662 KB:**

> Trang chủ: [https://www.gnu.org/software/gawk/](https://www.gnu.org/software/gawk/)

> Tải về: [https://ftp.gnu.org/gnu/gawk/gawk-5.3.2.tar.xz](https://ftp.gnu.org/gnu/gawk/gawk-5.3.2.tar.xz)

> Tổng kiểm MD5: `b7014650c5f45e5d4837c31209dc0037`

**GCC (15.2.0) - 98,688 KB:**

> Trang chủ: [https://gcc.gnu.org/](https://gcc.gnu.org/)

> Tải về: [https://ftp.gnu.org/gnu/gcc/gcc-15.2.0/gcc-15.2.0.tar.xz](https://ftp.gnu.org/gnu/gcc/gcc-15.2.0/gcc-15.2.0.tar.xz)

> Tổng kiểm MD5: `b861b092bf1af683c46a8aa2e689a6fd`

**GDBM (1.26) - 1,198 KB:**

> Trang chủ: [https://www.gnu.org/software/gdbm/](https://www.gnu.org/software/gdbm/)

> Tải về: [https://ftp.gnu.org/gnu/gdbm/gdbm-1.26.tar.gz](https://ftp.gnu.org/gnu/gdbm/gdbm-1.26.tar.gz)

> Tổng kiểm MD5: `aaa600665bc89e2febb3c7bd90679115`

**Gettext (0.26) - 9,926 KB:**

> Trang chủ: [https://www.gnu.org/software/gettext/](https://www.gnu.org/software/gettext/)

> Tải về: [https://ftp.gnu.org/gnu/gettext/gettext-0.26.tar.xz](https://ftp.gnu.org/gnu/gettext/gettext-0.26.tar.xz)

> Tổng kiểm MD5: `8e14e926f088e292f5f2bce95b81d10e`

**Glibc (2.42) - 19,464 KB:**

> Trang chủ: [https://www.gnu.org/software/libc/](https://www.gnu.org/software/libc/)

> Tải về: [https://ftp.gnu.org/gnu/glibc/glibc-2.42.tar.xz](https://ftp.gnu.org/gnu/glibc/glibc-2.42.tar.xz)

> Tổng kiểm MD5: `23c6f5a27932b435cae94e087cb8b1f5`

> {% hint style="info" %}
> **Ghi chú**

> Các nhà phát triển Glibc duy trì một [nhánh Git](https://sourceware.org/git/?p=glibc.git;a=shortlog;h=refs/heads/release/2.42/master) chứa những bản vá đáng đưa vào Glibc-2.42 nhưng tiếc là được phát triển sau khi Glibc-2.42 phát hành. Các biên tập viên LFS sẽ phát hành thông báo bảo mật nếu có bản sửa lỗi bảo mật nào được thêm vào nhánh này, còn các bản vá mới khác thì sẽ không có hành động gì. Bạn có thể tự xem xét các bản vá và đưa vào một số bản nếu thấy quan trọng.
> {% endhint %}

**GMP (6.3.0) - 2,046 KB:**

> Trang chủ: [https://www.gnu.org/software/gmp/](https://www.gnu.org/software/gmp/)

> Tải về: [https://ftp.gnu.org/gnu/gmp/gmp-6.3.0.tar.xz](https://ftp.gnu.org/gnu/gmp/gmp-6.3.0.tar.xz)

> Tổng kiểm MD5: `956dc04e864001a9c22429f761f2c283`

**Gperf (3.3) - 1,789 KB:**

> Trang chủ: [https://www.gnu.org/software/gperf/](https://www.gnu.org/software/gperf/)

> Tải về: [https://ftp.gnu.org/gnu/gperf/gperf-3.3.tar.gz](https://ftp.gnu.org/gnu/gperf/gperf-3.3.tar.gz)

> Tổng kiểm MD5: `31753b021ea78a21f154bf9eecb8b079`

**Grep (3.12) - 1,874 KB:**

> Trang chủ: [https://www.gnu.org/software/grep/](https://www.gnu.org/software/grep/)

> Tải về: [https://ftp.gnu.org/gnu/grep/grep-3.12.tar.xz](https://ftp.gnu.org/gnu/grep/grep-3.12.tar.xz)

> Tổng kiểm MD5: `5d9301ed9d209c4a88c8d3a6fd08b9ac`

**Groff (1.23.0) - 7,259 KB:**

> Trang chủ: [https://www.gnu.org/software/groff/](https://www.gnu.org/software/groff/)

> Tải về: [https://ftp.gnu.org/gnu/groff/groff-1.23.0.tar.gz](https://ftp.gnu.org/gnu/groff/groff-1.23.0.tar.gz)

> Tổng kiểm MD5: `5e4f40315a22bb8a158748e7d5094c7d`

**GRUB (2.12) - 6,524 KB:**

> Trang chủ: [https://www.gnu.org/software/grub/](https://www.gnu.org/software/grub/)

> Tải về: [https://ftp.gnu.org/gnu/grub/grub-2.12.tar.xz](https://ftp.gnu.org/gnu/grub/grub-2.12.tar.xz)

> Tổng kiểm MD5: `60c564b1bdc39d8e43b3aab4bc0fb140`

**Gzip (1.14) - 865 KB:**

> Trang chủ: [https://www.gnu.org/software/gzip/](https://www.gnu.org/software/gzip/)

> Tải về: [https://ftp.gnu.org/gnu/gzip/gzip-1.14.tar.xz](https://ftp.gnu.org/gnu/gzip/gzip-1.14.tar.xz)

> Tổng kiểm MD5: `4bf5a10f287501ee8e8ebe00ef62b2c2`

**Iana-Etc (20250807) - 592 KB:**

> Trang chủ: [https://www.iana.org/protocols](https://www.iana.org/protocols)

> Tải về: [https://github.com/Mic92/iana-etc/releases/download/20250807/iana-etc-20250807.tar.gz](https://github.com/Mic92/iana-etc/releases/download/20250807/iana-etc-20250807.tar.gz)

> Tổng kiểm MD5: `de0a909103d4ff59d1424c5ec7ac9e4a`

**Inetutils (2.6) - 1,724 KB:**

> Trang chủ: [https://www.gnu.org/software/inetutils/](https://www.gnu.org/software/inetutils/)

> Tải về: [https://ftp.gnu.org/gnu/inetutils/inetutils-2.6.tar.xz](https://ftp.gnu.org/gnu/inetutils/inetutils-2.6.tar.xz)

> Tổng kiểm MD5: `401d7d07682a193960bcdecafd03de94`

**Intltool (0.51.0) - 159 KB:**

> Trang chủ: [https://freedesktop.org/wiki/Software/intltool](https://freedesktop.org/wiki/Software/intltool)

> Tải về: [https://launchpad.net/intltool/trunk/0.51.0/+download/intltool-0.51.0.tar.gz](https://launchpad.net/intltool/trunk/0.51.0/+download/intltool-0.51.0.tar.gz)

> Tổng kiểm MD5: `12e517cac2b57a0121cda351570f1e63`

**IPRoute2 (6.16.0) - 910 KB:**

> Trang chủ: [https://www.kernel.org/pub/linux/utils/net/iproute2/](https://www.kernel.org/pub/linux/utils/net/iproute2/)

> Tải về: [https://www.kernel.org/pub/linux/utils/net/iproute2/iproute2-6.16.0.tar.xz](https://www.kernel.org/pub/linux/utils/net/iproute2/iproute2-6.16.0.tar.xz)

> Tổng kiểm MD5: `80e1f91bf59d572acc15d5c6eb4f3e7c`

**Jinja2 (3.1.6) - 240 KB:**

> Trang chủ: [https://jinja.palletsprojects.com/en/3.1.x/](https://jinja.palletsprojects.com/en/3.1.x/)

> Tải về: [https://pypi.org/packages/source/J/Jinja2/jinja2-3.1.6.tar.gz](https://pypi.org/packages/source/J/Jinja2/jinja2-3.1.6.tar.gz)

> Tổng kiểm MD5: `66d4c25ff43d1deaf9637ccda523dec8`

**Kbd (2.8.0) - 1,448 KB:**

> Trang chủ: [https://kbd-project.org/](https://kbd-project.org/)

> Tải về: [https://www.kernel.org/pub/linux/utils/kbd/kbd-2.8.0.tar.xz](https://www.kernel.org/pub/linux/utils/kbd/kbd-2.8.0.tar.xz)

> Tổng kiểm MD5: `24b5d24f7483726b88f214dc6c77aa41`

**Kmod (34.2) - 434 KB:**

> Trang chủ: [https://github.com/kmod-project/kmod](https://github.com/kmod-project/kmod)

> Tải về: [https://www.kernel.org/pub/linux/utils/kernel/kmod/kmod-34.2.tar.xz](https://www.kernel.org/pub/linux/utils/kernel/kmod/kmod-34.2.tar.xz)

> Tổng kiểm MD5: `36f2cc483745e81ede3406fa55e1065a`

**Less (679) - 857 KB:**

> Trang chủ: [https://www.greenwoodsoftware.com/less/](https://www.greenwoodsoftware.com/less/)

> Tải về: [https://www.greenwoodsoftware.com/less/less-679.tar.gz](https://www.greenwoodsoftware.com/less/less-679.tar.gz)

> Tổng kiểm MD5: `0386dc14f6a081a94dfb4c2413864eed`

**LFS-Bootscripts (20250827) - 34 KB:**

> Tải về: [https://www.linuxfromscratch.org/lfs/downloads/12.4/lfs-bootscripts-20250827.tar.xz](https://www.linuxfromscratch.org/lfs/downloads/12.4/lfs-bootscripts-20250827.tar.xz)

> Tổng kiểm MD5: `3f661c64c2dfb55025767ed56074d059`

**Libcap (2.76) - 195 KB:**

> Trang chủ: [https://sites.google.com/site/fullycapable/](https://sites.google.com/site/fullycapable/)

> Tải về: [https://www.kernel.org/pub/linux/libs/security/linux-privs/libcap2/libcap-2.76.tar.xz](https://www.kernel.org/pub/linux/libs/security/linux-privs/libcap2/libcap-2.76.tar.xz)

> Tổng kiểm MD5: `449ade7d620b5c4eeb15a632fbaa4f74`

**Libffi (3.5.2) - 1,390 KB:**

> Trang chủ: [https://sourceware.org/libffi/](https://sourceware.org/libffi/)

> Tải về: [https://github.com/libffi/libffi/releases/download/v3.5.2/libffi-3.5.2.tar.gz](https://github.com/libffi/libffi/releases/download/v3.5.2/libffi-3.5.2.tar.gz)

> Tổng kiểm MD5: `92af9efad4ba398995abf44835c5d9e9`

**Libpipeline (1.5.8) - 1046 KB:**

> Trang chủ: [https://libpipeline.nongnu.org/](https://libpipeline.nongnu.org/)

> Tải về: [https://download.savannah.gnu.org/releases/libpipeline/libpipeline-1.5.8.tar.gz](https://download.savannah.gnu.org/releases/libpipeline/libpipeline-1.5.8.tar.gz)

> Tổng kiểm MD5: `17ac6969b2015386bcb5d278a08a40b5`

**Libtool (2.5.4) - 1,033 KB:**

> Trang chủ: [https://www.gnu.org/software/libtool/](https://www.gnu.org/software/libtool/)

> Tải về: [https://ftp.gnu.org/gnu/libtool/libtool-2.5.4.tar.xz](https://ftp.gnu.org/gnu/libtool/libtool-2.5.4.tar.xz)

> Tổng kiểm MD5: `22e0a29df8af5fdde276ea3a7d351d30`

**Libxcrypt (4.4.38) - 612 KB:**

> Trang chủ: [https://github.com/besser82/libxcrypt/](https://github.com/besser82/libxcrypt/)

> Tải về: [https://github.com/besser82/libxcrypt/releases/download/v4.4.38/libxcrypt-4.4.38.tar.xz](https://github.com/besser82/libxcrypt/releases/download/v4.4.38/libxcrypt-4.4.38.tar.xz)

> Tổng kiểm MD5: `1796a5d20098e9dd9e3f576803c83000`

**Linux (6.16.1) - 149,042 KB:**

> Trang chủ: [https://www.kernel.org/](https://www.kernel.org/)

> Tải về: [https://www.kernel.org/pub/linux/kernel/v6.x/linux-6.16.1.tar.xz](https://www.kernel.org/pub/linux/kernel/v6.x/linux-6.16.1.tar.xz)

> Tổng kiểm MD5: `32d45755e4b39d06e9be58f6817445ee`

> {% hint style="info" %}
> **Ghi chú**

> Kernel (nhân) Linux được cập nhật khá thường xuyên, nhiều lần là do phát hiện lỗ hổng bảo mật. Bạn có thể dùng phiên bản kernel ổn định mới nhất hiện có, trừ khi trang errata (đính chính) nói khác.

> Với người dùng có tốc độ mạng hạn chế hoặc băng thông đắt đỏ muốn cập nhật kernel Linux, có thể tải riêng phiên bản gốc của gói và các bản vá. Cách này giúp tiết kiệm thời gian hoặc chi phí cho những lần nâng cấp mức patch tiếp theo trong cùng một bản phát hành phụ.
> {% endhint %}

**Lz4 (1.10.0) - 379 KB:**

> Trang chủ: [https://lz4.org/](https://lz4.org/)

> Tải về: [https://github.com/lz4/lz4/releases/download/v1.10.0/lz4-1.10.0.tar.gz](https://github.com/lz4/lz4/releases/download/v1.10.0/lz4-1.10.0.tar.gz)

> Tổng kiểm MD5: `dead9f5f1966d9ae56e1e32761e4e675`

**M4 (1.4.20) - 1,997 KB:**

> Trang chủ: [https://www.gnu.org/software/m4/](https://www.gnu.org/software/m4/)

> Tải về: [https://ftp.gnu.org/gnu/m4/m4-1.4.20.tar.xz](https://ftp.gnu.org/gnu/m4/m4-1.4.20.tar.xz)

> Tổng kiểm MD5: `6eb2ebed5b24e74b6e890919331d2132`

**Make (4.4.1) - 2,300 KB:**

> Trang chủ: [https://www.gnu.org/software/make/](https://www.gnu.org/software/make/)

> Tải về: [https://ftp.gnu.org/gnu/make/make-4.4.1.tar.gz](https://ftp.gnu.org/gnu/make/make-4.4.1.tar.gz)

> Tổng kiểm MD5: `c8469a3713cbbe04d955d4ae4be23eeb`

**Man-DB (2.13.1) - 2,061 KB:**

> Trang chủ: [https://www.nongnu.org/man-db/](https://www.nongnu.org/man-db/)

> Tải về: [https://download.savannah.gnu.org/releases/man-db/man-db-2.13.1.tar.xz](https://download.savannah.gnu.org/releases/man-db/man-db-2.13.1.tar.xz)

> Tổng kiểm MD5: `b6335533cbeac3b24cd7be31fdee8c83`

**Man-pages (6.15) - 1,817 KB:**

> Trang chủ: [https://www.kernel.org/doc/man-pages/](https://www.kernel.org/doc/man-pages/)

> Tải về: [https://www.kernel.org/pub/linux/docs/man-pages/man-pages-6.15.tar.xz](https://www.kernel.org/pub/linux/docs/man-pages/man-pages-6.15.tar.xz)

> Tổng kiểm MD5: `16f68d70139dd2bbcae4102be4705753`

**MarkupSafe (3.0.2) - 21 KB:**

> Trang chủ: [https://palletsprojects.com/p/markupsafe/](https://palletsprojects.com/p/markupsafe/)

> Tải về: [https://pypi.org/packages/source/M/MarkupSafe/markupsafe-3.0.2.tar.gz](https://pypi.org/packages/source/M/MarkupSafe/markupsafe-3.0.2.tar.gz)

> Tổng kiểm MD5: `cb0071711b573b155cc8f86e1de72167`

**Meson (1.8.3) - 2,282:**

> Trang chủ: [https://mesonbuild.com](https://mesonbuild.com)

> Tải về: [https://github.com/mesonbuild/meson/releases/download/1.8.3/meson-1.8.3.tar.gz](https://github.com/mesonbuild/meson/releases/download/1.8.3/meson-1.8.3.tar.gz)

> Tổng kiểm MD5: `08221d2f515e759686f666ff6409a903`

**MPC (1.3.1) - 756 KB:**

> Trang chủ: [https://www.multiprecision.org/](https://www.multiprecision.org/)

> Tải về: [https://ftp.gnu.org/gnu/mpc/mpc-1.3.1.tar.gz](https://ftp.gnu.org/gnu/mpc/mpc-1.3.1.tar.gz)

> Tổng kiểm MD5: `5c9bc658c9fd0f940e8e3e0f09530c62`

**MPFR (4.2.2) - 1,471 KB:**

> Trang chủ: [https://www.mpfr.org/](https://www.mpfr.org/)

> Tải về: [https://ftp.gnu.org/gnu/mpfr/mpfr-4.2.2.tar.xz](https://ftp.gnu.org/gnu/mpfr/mpfr-4.2.2.tar.xz)

> Tổng kiểm MD5: `7c32c39b8b6e3ae85f25156228156061`

**Ncurses (6.5-20250809) - 3,703 KB:**

> Trang chủ: [https://www.gnu.org/software/ncurses/](https://www.gnu.org/software/ncurses/)

> Tải về: [https://invisible-mirror.net/archives/ncurses/current/ncurses-6.5-20250809.tgz](https://invisible-mirror.net/archives/ncurses/current/ncurses-6.5-20250809.tgz)

> Tổng kiểm MD5: `679987405412f970561cc85e1e6428a2`

**Ninja (1.13.1) - 286 KB:**

> Trang chủ: [https://ninja-build.org/](https://ninja-build.org/)

> Tải về: [https://github.com/ninja-build/ninja/archive/v1.13.1/ninja-1.13.1.tar.gz](https://github.com/ninja-build/ninja/archive/v1.13.1/ninja-1.13.1.tar.gz)

> Tổng kiểm MD5: `c35f8f55f4cf60f1a916068d8f45a0f8`

**OpenSSL (3.5.2) - 51,934 KB:**

> Trang chủ: [https://www.openssl-library.org/](https://www.openssl-library.org/)

> Tải về: [https://github.com/openssl/openssl/releases/download/openssl-3.5.2/openssl-3.5.2.tar.gz](https://github.com/openssl/openssl/releases/download/openssl-3.5.2/openssl-3.5.2.tar.gz)

> Tổng kiểm MD5: `890fc59f86fc21b5e4d1c031a698dbde`

**Packaging (25.0) - 162 KB:**

> Trang chủ: [https://pypi.org/project/packaging/](https://pypi.org/project/packaging/)

> Tải về: [https://files.pythonhosted.org/packages/source/p/packaging/packaging-25.0.tar.gz](https://files.pythonhosted.org/packages/source/p/packaging/packaging-25.0.tar.gz)

> Tổng kiểm MD5: `ab0ef21ddebe09d1803575120d3f99f8`

**Patch (2.8) - 886 KB:**

> Trang chủ: [https://savannah.gnu.org/projects/patch/](https://savannah.gnu.org/projects/patch/)

> Tải về: [https://ftp.gnu.org/gnu/patch/patch-2.8.tar.xz](https://ftp.gnu.org/gnu/patch/patch-2.8.tar.xz)

> Tổng kiểm MD5: `149327a021d41c8f88d034eab41c039f`

**Perl (5.42.0) - 14,084 KB:**

> Trang chủ: [https://www.perl.org/](https://www.perl.org/)

> Tải về: [https://www.cpan.org/src/5.0/perl-5.42.0.tar.xz](https://www.cpan.org/src/5.0/perl-5.42.0.tar.xz)

> Tổng kiểm MD5: `7a6950a9f12d01eb96a9d2ed2f4e0072`

**Pkgconf (2.5.1) - 321 KB:**

> Trang chủ: [https://github.com/pkgconf/pkgconf](https://github.com/pkgconf/pkgconf)

> Tải về: [https://distfiles.ariadne.space/pkgconf/pkgconf-2.5.1.tar.xz](https://distfiles.ariadne.space/pkgconf/pkgconf-2.5.1.tar.xz)

> Tổng kiểm MD5: `3291128c917fdb8fccd8c9e7784b643b`

**Procps (4.0.5) - 1,483 KB:**

> Trang chủ: [https://gitlab.com/procps-ng/procps/](https://gitlab.com/procps-ng/procps/)

> Tải về: [https://sourceforge.net/projects/procps-ng/files/Production/procps-ng-4.0.5.tar.xz](https://sourceforge.net/projects/procps-ng/files/Production/procps-ng-4.0.5.tar.xz)

> Tổng kiểm MD5: `90803e64f51f192f3325d25c3335d057`

**Psmisc (23.7) - 423 KB:**

> Trang chủ: [https://gitlab.com/psmisc/psmisc](https://gitlab.com/psmisc/psmisc)

> Tải về: [https://sourceforge.net/projects/psmisc/files/psmisc/psmisc-23.7.tar.xz](https://sourceforge.net/projects/psmisc/files/psmisc/psmisc-23.7.tar.xz)

> Tổng kiểm MD5: `53eae841735189a896d614cba440eb10`

**Python (3.13.7) - 22,236 KB:**

> Trang chủ: [https://www.python.org/](https://www.python.org/)

> Tải về: [https://www.python.org/ftp/python/3.13.7/Python-3.13.7.tar.xz](https://www.python.org/ftp/python/3.13.7/Python-3.13.7.tar.xz)

> Tổng kiểm MD5: `256cdb3bbf45cdce7499e52ba6c36ea3`

**Python Documentation (3.13.7) - 10,183 KB:**

> Tải về: [https://www.python.org/ftp/python/doc/3.13.7/python-3.13.7-docs-html.tar.bz2](https://www.python.org/ftp/python/doc/3.13.7/python-3.13.7-docs-html.tar.bz2)

> Tổng kiểm MD5: `b84c0d81b2758398bb7f5b7411d3d908`

**Readline (8.3) - 3,340 KB:**

> Trang chủ: [https://tiswww.case.edu/php/chet/readline/rltop.html](https://tiswww.case.edu/php/chet/readline/rltop.html)

> Tải về: [https://ftp.gnu.org/gnu/readline/readline-8.3.tar.gz](https://ftp.gnu.org/gnu/readline/readline-8.3.tar.gz)

> Tổng kiểm MD5: `25a73bfb2a3ad7146c5e9d4408d9f6cd`

**Sed (4.9) - 1,365 KB:**

> Trang chủ: [https://www.gnu.org/software/sed/](https://www.gnu.org/software/sed/)

> Tải về: [https://ftp.gnu.org/gnu/sed/sed-4.9.tar.xz](https://ftp.gnu.org/gnu/sed/sed-4.9.tar.xz)

> Tổng kiểm MD5: `6aac9b2dbafcd5b7a67a8a9bcb8036c3`

**Setuptools (80.9.0) - 1,290 KB:**

> Trang chủ: [https://pypi.org/project/setuptools/](https://pypi.org/project/setuptools/)

> Tải về: [https://pypi.org/packages/source/s/setuptools/setuptools-80.9.0.tar.gz](https://pypi.org/packages/source/s/setuptools/setuptools-80.9.0.tar.gz)

> Tổng kiểm MD5: `82e1d67883b713f9493659b50d13b436`

**Shadow (4.18.0) - 2,293 KB:**

> Trang chủ: [https://github.com/shadow-maint/shadow/](https://github.com/shadow-maint/shadow/)

> Tải về: [https://github.com/shadow-maint/shadow/releases/download/4.18.0/shadow-4.18.0.tar.xz](https://github.com/shadow-maint/shadow/releases/download/4.18.0/shadow-4.18.0.tar.xz)

> Tổng kiểm MD5: `30ef46f54363db1d624587be68794ef2`

**Sysklogd (2.7.2) - 474 KB:**

> Trang chủ: [https://www.infodrom.org/projects/sysklogd/](https://www.infodrom.org/projects/sysklogd/)

> Tải về: [https://github.com/troglobit/sysklogd/releases/download/v2.7.2/sysklogd-2.7.2.tar.gz](https://github.com/troglobit/sysklogd/releases/download/v2.7.2/sysklogd-2.7.2.tar.gz)

> Tổng kiểm MD5: `af60786956a2dc84054fbf46652e515e`

**Systemd (257.8) - 16,002 KB:**

> Trang chủ: [https://www.freedesktop.org/wiki/Software/systemd/](https://www.freedesktop.org/wiki/Software/systemd/)

> Tải về: [https://github.com/systemd/systemd/archive/v257.8/systemd-257.8.tar.gz](https://github.com/systemd/systemd/archive/v257.8/systemd-257.8.tar.gz)

> Tổng kiểm MD5: `25fe5d328e22641254761f1baa74cee0`

**Systemd Man Pages (257.8) - 736 KB:**

> Trang chủ: [https://www.freedesktop.org/wiki/Software/systemd/](https://www.freedesktop.org/wiki/Software/systemd/)

> Tải về: [https://anduin.linuxfromscratch.org/LFS/systemd-man-pages-257.8.tar.xz](https://anduin.linuxfromscratch.org/LFS/systemd-man-pages-257.8.tar.xz)

> Tổng kiểm MD5: `a44063e2ec0cf4adfd2ed5c9e9e095c5`

> {% hint style="info" %}
> **Ghi chú**

> Nhóm Linux From Scratch tự tạo tarball các trang man từ mã nguồn systemd để tránh những phụ thuộc không cần thiết.
> {% endhint %}

**SysVinit (3.14) - 236 KB:**

> Trang chủ: [https://savannah.nongnu.org/projects/sysvinit](https://savannah.nongnu.org/projects/sysvinit)

> Tải về: [https://github.com/slicer69/sysvinit/releases/download/3.14/sysvinit-3.14.tar.xz](https://github.com/slicer69/sysvinit/releases/download/3.14/sysvinit-3.14.tar.xz)

> Tổng kiểm MD5: `bc6890b975d19dc9db42d0c7364dd092`

**Tar (1.35) - 2,263 KB:**

> Trang chủ: [https://www.gnu.org/software/tar/](https://www.gnu.org/software/tar/)

> Tải về: [https://ftp.gnu.org/gnu/tar/tar-1.35.tar.xz](https://ftp.gnu.org/gnu/tar/tar-1.35.tar.xz)

> Tổng kiểm MD5: `a2d8042658cfd8ea939e6d911eaf4152`

**Tcl (8.6.16) - 11,406 KB:**

> Trang chủ: [https://tcl.sourceforge.net/](https://tcl.sourceforge.net/)

> Tải về: [https://downloads.sourceforge.net/tcl/tcl8.6.16-src.tar.gz](https://downloads.sourceforge.net/tcl/tcl8.6.16-src.tar.gz)

> Tổng kiểm MD5: `eaef5d0a27239fb840f04af8ec608242`

**Tcl Documentation (8.6.16) - 1,169 KB:**

> Tải về: [https://downloads.sourceforge.net/tcl/tcl8.6.16-html.tar.gz](https://downloads.sourceforge.net/tcl/tcl8.6.16-html.tar.gz)

> Tổng kiểm MD5: `750c221bcb6f8737a6791c1fbe98b684`

**Texinfo (7.2) - 6,259 KB:**

> Trang chủ: [https://www.gnu.org/software/texinfo/](https://www.gnu.org/software/texinfo/)

> Tải về: [https://ftp.gnu.org/gnu/texinfo/texinfo-7.2.tar.xz](https://ftp.gnu.org/gnu/texinfo/texinfo-7.2.tar.xz)

> Tổng kiểm MD5: `11939a7624572814912a18e76c8d8972`

**Time Zone Data (2025b) - 454 KB:**

> Trang chủ: [https://www.iana.org/time-zones](https://www.iana.org/time-zones)

> Tải về: [https://www.iana.org/time-zones/repository/releases/tzdata2025b.tar.gz](https://www.iana.org/time-zones/repository/releases/tzdata2025b.tar.gz)

> Tổng kiểm MD5: `ad65154c48c74a9b311fe84778c5434f`

**Udev-lfs Tarball (udev-lfs-20230818) - 10 KB:**

> Tải về: [https://anduin.linuxfromscratch.org/LFS/udev-lfs-20230818.tar.xz](https://anduin.linuxfromscratch.org/LFS/udev-lfs-20230818.tar.xz)

> Tổng kiểm MD5: `acd4360d8a5c3ef320b9db88d275dae6`

**Util-linux (2.41.1) - 9,382 KB:**

> Trang chủ: [https://git.kernel.org/pub/scm/utils/util-linux/util-linux.git/](https://git.kernel.org/pub/scm/utils/util-linux/util-linux.git/)

> Tải về: [https://www.kernel.org/pub/linux/utils/util-linux/v2.41/util-linux-2.41.1.tar.xz](https://www.kernel.org/pub/linux/utils/util-linux/v2.41/util-linux-2.41.1.tar.xz)

> Tổng kiểm MD5: `7e5e68845e2f347cf96f5448165f1764`

**Vim (9.1.1629) - 18,317 KB:**

> Trang chủ: [https://www.vim.org](https://www.vim.org)

> Tải về: [https://github.com/vim/vim/archive/v9.1.1629/vim-9.1.1629.tar.gz](https://github.com/vim/vim/archive/v9.1.1629/vim-9.1.1629.tar.gz)

> Tổng kiểm MD5: `4f856c3233c1c4570bc17572e4f9e8e4`

> {% hint style="info" %}
> **Ghi chú**

> Phiên bản vim thay đổi hằng ngày. Để lấy bản mới nhất, hãy vào [https://github.com/vim/vim/tags](https://github.com/vim/vim/tags).
> {% endhint %}

**Wheel (0.46.1) - 54 KB:**

> Trang chủ: [https://pypi.org/project/wheel/](https://pypi.org/project/wheel/)

> Tải về: [https://pypi.org/packages/source/w/wheel/wheel-0.46.1.tar.gz](https://pypi.org/packages/source/w/wheel/wheel-0.46.1.tar.gz)

> Tổng kiểm MD5: `65e09ee84af36821e3b1e9564aa91bd5`

**XML::Parser (2.47) - 276 KB:**

> Trang chủ: [https://github.com/chorny/XML-Parser](https://github.com/chorny/XML-Parser)

> Tải về: [https://cpan.metacpan.org/authors/id/T/TO/TODDR/XML-Parser-2.47.tar.gz](https://cpan.metacpan.org/authors/id/T/TO/TODDR/XML-Parser-2.47.tar.gz)

> Tổng kiểm MD5: `89a8e82cfd2ad948b349c0a69c494463`

**Xz Utils (5.8.1) - 1,428 KB:**

> Trang chủ: [https://tukaani.org/xz](https://tukaani.org/xz)

> Tải về: [https://github.com//tukaani-project/xz/releases/download/v5.8.1/xz-5.8.1.tar.xz](https://github.com//tukaani-project/xz/releases/download/v5.8.1/xz-5.8.1.tar.xz)

> Tổng kiểm MD5: `cf5e1feb023d22c6bdaa30e84ef3abe3`

**Zlib (1.3.1) - 1,478 KB:**

> Trang chủ: [https://zlib.net/](https://zlib.net/)

> Tải về: [https://zlib.net/fossils/zlib-1.3.1.tar.gz](https://zlib.net/fossils/zlib-1.3.1.tar.gz)

> Tổng kiểm MD5: `9855b6d802d7fe5b7bd5b196a2271655`

**Zstd (1.5.7) - 2,378 KB:**

> Trang chủ: [https://facebook.github.io/zstd/](https://facebook.github.io/zstd/)

> Tải về: [https://github.com/facebook/zstd/releases/download/v1.5.7/zstd-1.5.7.tar.gz](https://github.com/facebook/zstd/releases/download/v1.5.7/zstd-1.5.7.tar.gz)

> Tổng kiểm MD5: `780fc1896922b1bc52a4e90980cdda48`

Tổng dung lượng các gói này: khoảng NaN MB

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter03/packages.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter03/packages.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter03/packages.html)
