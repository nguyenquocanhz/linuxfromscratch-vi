---
description: "Gói Glibc chứa thư viện C chính. Thư viện này cung cấp các routine cơ bản để cấp phát bộ nhớ, tìm kiếm thư mục, mở và đóng tệp, đọc và ghi tệp, xử lý chuỗi"
---

<details>

<summary>Trick lỏ: Bộ kiểm thử — chỗ nào được lười, chỗ nào tuyệt đối không</summary>

Chạy hết test ở Chương 8 có thể mất lâu hơn cả thời gian dựng. Ưu tiên thế này:

* **Bắt buộc chạy**: Glibc, GCC, Binutils (và GMP, MPFR như sách nhấn mạnh). Toolchain hỏng thì mọi gói sau đều hỏng theo.
* **Có vài test lỗi là bình thường**: sách luôn liệt kê các test "known to fail". So kết quả của bạn với danh sách đó trước khi hoảng.
* Gói nhỏ (ví dụ man-pages, less) mà bạn vội thì bỏ test cũng chấp nhận được ở lần dựng đầu tiên.

So kết quả với người khác: `../contrib/test_summary | grep -A7 Summ` (GCC) rồi đối chiếu tại trang [buildlogs của LFS](https://www.linuxfromscratch.org/lfs/build-logs/).

[Tất cả trick lỏ →](../trick-lo.md#kiem-thu)

</details>

<details>

<summary>Trick lỏ: Cho LFS nói tiếng Việt và chạy giờ Việt Nam</summary>

Khi cài locale ở bước Glibc, thêm locale tiếng Việt:

```bash
localedef -i vi_VN -f UTF-8 vi_VN.UTF-8
```

Múi giờ: thay vì chạy `tzselect` dò từng bước, đặt thẳng:

```bash
ln -sfv /usr/share/zoneinfo/Asia/Ho_Chi_Minh /etc/localtime
```

Ở Mục 9.7, muốn giao diện vẫn tiếng Anh (dễ tra lỗi trên mạng) nhưng ngày giờ, tiền tệ kiểu Việt:

```bash
cat > /etc/profile.d/i18n.sh << "EOF2"
export LANG=en_US.UTF-8
export LC_TIME=vi_VN.UTF-8
EOF2
```

Gõ tiếng Việt có dấu trên console thô không được — đợi lên BLFS, cài môi trường đồ họa và IBus/Fcitx5 với bộ gõ Unikey/Bamboo.

[Tất cả trick lỏ →](../trick-lo.md#tieng-viet-gio-vn)

</details>

# 8.5. Glibc-2.42

Gói Glibc chứa thư viện C chính. Thư viện này cung cấp các routine cơ bản để cấp phát bộ nhớ, tìm kiếm thư mục, mở và đóng tệp, đọc và ghi tệp, xử lý chuỗi, so khớp mẫu, số học, v.v.

* **Thời gian dựng ước tính:** 12 SBU
* **Dung lượng đĩa cần:** 3.3 GB

## 8.5.1. Cài đặt Glibc

Một số chương trình của Glibc dùng thư mục `/var/db` (không tuân thủ FHS) để lưu dữ liệu runtime. Hãy áp dụng bản vá sau để các chương trình đó lưu dữ liệu runtime ở những vị trí tuân thủ FHS:

```bash
patch -Np1 -i ../glibc-2.42-fhs-1.patch
```

Bây giờ sửa một vấn đề có thể làm hỏng Valgrind trong BLFS:

```bash
sed -e '/unistd.h/i #include <string.h>' \
    -e '/libc_rwlock_init/c\
  __libc_rwlock_define_initialized (, reset_lock);\
  memcpy (&lock, &reset_lock, sizeof (lock));' \
    -i stdlib/abort.c
```

Tài liệu Glibc khuyến nghị dựng Glibc trong một thư mục build riêng:

```bash
mkdir -v build
cd       build
```

Đảm bảo các tiện ích `ldconfig` và `sln` sẽ được cài vào `/usr/sbin`:

```bash
echo "rootsbindir=/usr/sbin" > configparms
```

Chuẩn bị biên dịch Glibc:

```bash
../configure --prefix=/usr                   \
             --disable-werror                \
             --disable-nscd                  \
             libc_cv_slibdir=/usr/lib        \
             --enable-stack-protector=strong \
             --enable-kernel=5.4
```

**Ý nghĩa các tùy chọn configure:**

**`--disable-werror`**

> Tùy chọn này tắt tùy chọn -Werror truyền cho GCC. Điều này cần thiết để chạy bộ kiểm thử.

**`--enable-kernel=5.4`**

> Tùy chọn này báo cho hệ thống build biết rằng bản Glibc này có thể được dùng với kernel cũ đến 5.4. Nghĩa là sẽ sinh ra các giải pháp tạm (workaround) phòng khi không dùng được một system call được thêm ở phiên bản sau.

**`--enable-stack-protector=strong`**

> Tùy chọn này tăng cường bảo mật hệ thống bằng cách thêm mã kiểm tra tràn bộ đệm, chẳng hạn các cuộc tấn công phá ngăn xếp. Lưu ý Glibc luôn ghi đè mặc định của GCC một cách tường minh, nên tùy chọn này vẫn cần dù ta đã chỉ định `--enable-default-ssp` cho GCC.

**`--disable-nscd`**

> Không dựng daemon name service cache vốn không còn được dùng.

**`libc_cv_slibdir=/usr/lib`**

> Biến này đặt đúng thư viện cho mọi hệ thống. Chúng ta không muốn dùng lib64.

Biên dịch gói:

```bash
make
```

{% hint style="warning" %}
**Important**

Trong mục này, bộ kiểm thử của Glibc được xem là then chốt. Không được bỏ qua trong bất kỳ trường hợp nào.
{% endhint %}

Nhìn chung sẽ có vài bài kiểm thử không đạt. Các lỗi kiểm thử liệt kê dưới đây thường có thể bỏ qua an toàn.

```bash
make check
```

Bạn có thể thấy một số bài kiểm thử thất bại. Bộ kiểm thử của Glibc phần nào phụ thuộc vào hệ thống host. Một vài lỗi trong hơn 6000 bài kiểm thử nhìn chung có thể bỏ qua. Đây là danh sách các vấn đề thường gặp nhất ở các phiên bản LFS gần đây:

* *io/tst-lchmod* được biết là thất bại trong môi trường chroot của LFS.
* *misc/tst-preadvwritev2* và *misc/tst-preadvwritev64v2* được biết là thất bại nếu kernel của host là Linux-6.14 trở lên.
* Một số bài kiểm thử, ví dụ *nss/tst-nss-files-hosts-multi* và *nptl/tst-thread-affinity\**, được biết là thất bại do hết thời gian chờ (timeout), nhất là khi hệ thống tương đối chậm và/hoặc chạy bộ kiểm thử với nhiều job make song song. Có thể nhận diện các bài này bằng:

  ```bash
  grep "Timed out" $(find -name \*.out)
  ```

  Bạn có thể chạy lại một bài kiểm thử riêng với timeout lớn hơn bằng `TIMEOUTFACTOR=<factor> make test t=<test name>`. Ví dụ, `TIMEOUTFACTOR=10 make test t=nss/tst-nss-files-hosts-multi` sẽ chạy lại *nss/tst-nss-files-hosts-multi* với timeout gấp mười lần ban đầu.
* Ngoài ra, một số bài kiểm thử có thể thất bại với mẫu CPU khá cũ (ví dụ *elf/tst-cpu-features-cpuinfo*) hoặc phiên bản kernel của host cũ (ví dụ *stdlib/tst-arc4random-thread*).

Dù chỉ là một thông báo vô hại, giai đoạn cài đặt của Glibc sẽ phàn nàn về việc thiếu `/etc/ld.so.conf`. Hãy ngăn cảnh báo này bằng:

```bash
touch /etc/ld.so.conf
```

Sửa Makefile để bỏ qua một bước kiểm tra cũ không còn phù hợp, vốn thất bại với cấu hình Glibc hiện đại:

```bash
sed '/test-installation/s@$(PERL)@echo not running@' -i ../Makefile
```

{% hint style="warning" %}
**Important**

Nếu nâng cấp Glibc lên một phiên bản phụ mới (ví dụ từ Glibc-2.36 lên Glibc-2.42) trên một hệ thống LFS đang chạy, bạn cần thêm một số biện pháp phòng ngừa để không làm hỏng hệ thống:

* Không hỗ trợ nâng cấp Glibc trên hệ thống LFS trước 11.0 (không tính 11.0). Hãy dựng lại LFS nếu bạn đang chạy một hệ thống LFS cũ như vậy mà cần Glibc mới hơn.
* Nếu nâng cấp trên hệ thống LFS trước 12.0 (không tính 12.0), hãy cài `Libxcrypt` theo [Mục 8.27, “Libxcrypt-4.4.38.”](libxcrypt.md) Ngoài việc cài `Libxcrypt` thông thường, **bạn PHẢI làm theo ghi chú trong mục Libxcrypt để cài `libcrypt.so.1*` (thay thế `libcrypt.so.1` từ bản Glibc cũ)**.
* Nếu nâng cấp trên hệ thống LFS trước 12.1 (không tính 12.1), hãy xóa chương trình `nscd`:

  ```bash
  rm -f /usr/sbin/nscd
  ```
* Nâng cấp kernel và khởi động lại nếu nó cũ hơn 5.4 (kiểm tra phiên bản hiện tại bằng `uname -r`) hoặc nếu bạn muốn nâng cấp dù sao, theo [Mục 10.3, “Linux-6.16.1.”](../chapter10/kernel.md)
* Nâng cấp các header API của kernel nếu chúng cũ hơn 5.4 (kiểm tra phiên bản hiện tại bằng `cat /usr/include/linux/version.h`) hoặc nếu bạn muốn nâng cấp dù sao, theo [Mục 5.4, “Linux-6.16.1 API Headers”](../chapter05/linux-headers.md) (nhưng bỏ `$LFS` khỏi lệnh `cp`).
* Thực hiện cài đặt vào `DESTDIR` và nâng cấp các thư viện chia sẻ Glibc trên hệ thống chỉ bằng một lệnh `install` duy nhất:

  ```bash
  make DESTDIR=$PWD/dest install
  install -vm755 dest/usr/lib/*.so.* /usr/lib
  ```

Bắt buộc phải làm đúng từng bước ở trên, trừ khi bạn hiểu hoàn toàn mình đang làm gì. **Bất kỳ sai lệch bất ngờ nào cũng có thể khiến hệ thống hoàn toàn không dùng được. BẠN ĐÃ ĐƯỢC CẢNH BÁO.**

Sau đó tiếp tục chạy lệnh `make install`, lệnh `sed` trên `/usr/bin/ldd` và các lệnh cài đặt locale. Khi xong, hãy khởi động lại hệ thống ngay lập tức.

Khi hệ thống đã khởi động lại thành công, nếu bạn đang chạy hệ thống LFS trước 12.0 (không tính 12.0), trong đó GCC không được dựng với tùy chọn `--disable-fixincludes`, hãy chuyển hai header của GCC sang vị trí tốt hơn và xóa các bản sao “đã sửa” cũ của header Glibc:

```bash
DIR=$(dirname $(gcc -print-libgcc-file-name))
[ -e $DIR/include/limits.h ]    || mv $DIR/include{-fixed,}/limits.h
[ -e $DIR/include/syslimits.h ] || mv $DIR/include{-fixed,}/syslimits.h
rm -rfv $DIR/include-fixed/*
unset DIR
```
{% endhint %}

Cài đặt gói:

```bash
make install
```

Sửa một đường dẫn cố định tới trình nạp thực thi (executable loader) trong script `ldd`:

```bash
sed '/RTLDLIST=/s@/usr@@g' -i /usr/bin/ldd
```

Tiếp theo, cài các locale giúp hệ thống phản hồi bằng ngôn ngữ khác. Không locale nào trong số này là bắt buộc, nhưng nếu thiếu một vài cái, bộ kiểm thử của một số gói sẽ bỏ qua các trường hợp kiểm thử quan trọng.

Có thể cài từng locale riêng lẻ bằng chương trình `localedef`. Ví dụ, lệnh `localedef` thứ hai bên dưới kết hợp định nghĩa locale độc lập bảng mã `/usr/share/i18n/locales/cs_CZ` với định nghĩa charmap `/usr/share/i18n/charmaps/UTF-8.gz` rồi nối kết quả vào tệp `/usr/lib/locale/locale-archive`. Các lệnh sau sẽ cài bộ locale tối thiểu cần thiết để bao phủ tối ưu các bài kiểm thử:

```bash
localedef -i C -f UTF-8 C.UTF-8
localedef -i cs_CZ -f UTF-8 cs_CZ.UTF-8
localedef -i de_DE -f ISO-8859-1 de_DE
localedef -i de_DE@euro -f ISO-8859-15 de_DE@euro
localedef -i de_DE -f UTF-8 de_DE.UTF-8
localedef -i el_GR -f ISO-8859-7 el_GR
localedef -i en_GB -f ISO-8859-1 en_GB
localedef -i en_GB -f UTF-8 en_GB.UTF-8
localedef -i en_HK -f ISO-8859-1 en_HK
localedef -i en_PH -f ISO-8859-1 en_PH
localedef -i en_US -f ISO-8859-1 en_US
localedef -i en_US -f UTF-8 en_US.UTF-8
localedef -i es_ES -f ISO-8859-15 es_ES@euro
localedef -i es_MX -f ISO-8859-1 es_MX
localedef -i fa_IR -f UTF-8 fa_IR
localedef -i fr_FR -f ISO-8859-1 fr_FR
localedef -i fr_FR@euro -f ISO-8859-15 fr_FR@euro
localedef -i fr_FR -f UTF-8 fr_FR.UTF-8
localedef -i is_IS -f ISO-8859-1 is_IS
localedef -i is_IS -f UTF-8 is_IS.UTF-8
localedef -i it_IT -f ISO-8859-1 it_IT
localedef -i it_IT -f ISO-8859-15 it_IT@euro
localedef -i it_IT -f UTF-8 it_IT.UTF-8
localedef -i ja_JP -f EUC-JP ja_JP
localedef -i ja_JP -f UTF-8 ja_JP.UTF-8
localedef -i nl_NL@euro -f ISO-8859-15 nl_NL@euro
localedef -i ru_RU -f KOI8-R ru_RU.KOI8-R
localedef -i ru_RU -f UTF-8 ru_RU.UTF-8
localedef -i se_NO -f UTF-8 se_NO.UTF-8
localedef -i ta_IN -f UTF-8 ta_IN.UTF-8
localedef -i tr_TR -f UTF-8 tr_TR.UTF-8
localedef -i zh_CN -f GB18030 zh_CN.GB18030
localedef -i zh_HK -f BIG5-HKSCS zh_HK.BIG5-HKSCS
localedef -i zh_TW -f UTF-8 zh_TW.UTF-8
```

Ngoài ra, hãy cài locale cho quốc gia, ngôn ngữ và bảng mã của riêng bạn.

Hoặc, cài một lần tất cả các locale liệt kê trong tệp `glibc-2.42/localedata/SUPPORTED` (gồm mọi locale ở trên và nhiều locale khác) bằng lệnh tốn thời gian sau:

```bash
make localedata/install-locales
```

{% hint style="info" %}
**Note**

Glibc hiện dùng libidn2 khi phân giải tên miền quốc tế hóa. Đây là phụ thuộc lúc chạy (run time). Nếu cần khả năng này, hướng dẫn cài libidn2 có ở [trang libidn2 của BLFS](https://www.linuxfromscratch.org/blfs/view/12.4/general/libidn2.html).
{% endhint %}

## 8.5.2. Cấu hình Glibc

### 8.5.2.1. Thêm nsswitch.conf

Cần tạo tệp `/etc/nsswitch.conf` vì các mặc định của Glibc hoạt động không tốt trong môi trường mạng.

Tạo tệp mới `/etc/nsswitch.conf` bằng cách chạy:

```bash
cat > /etc/nsswitch.conf << "EOF"
# Begin /etc/nsswitch.conf

passwd: files
group: files
shadow: files

hosts: files dns
networks: files

protocols: files
services: files
ethers: files
rpc: files

# End /etc/nsswitch.conf
EOF
```

### 8.5.2.2. Thêm dữ liệu múi giờ

Cài đặt và thiết lập dữ liệu múi giờ bằng các lệnh sau:

```bash
tar -xf ../../tzdata2025b.tar.gz

ZONEINFO=/usr/share/zoneinfo
mkdir -pv $ZONEINFO/{posix,right}

for tz in etcetera southamerica northamerica europe africa antarctica  \
          asia australasia backward; do
    zic -L /dev/null   -d $ZONEINFO       ${tz}
    zic -L /dev/null   -d $ZONEINFO/posix ${tz}
    zic -L leapseconds -d $ZONEINFO/right ${tz}
done

cp -v zone.tab zone1970.tab iso3166.tab $ZONEINFO
zic -d $ZONEINFO -p America/New_York
unset ZONEINFO tz
```

**Ý nghĩa của các lệnh zic:**

**`zic -L /dev/null ...`**

> Lệnh này tạo các múi giờ posix không có giây nhuận (leap second). Theo thông lệ, chúng được đặt ở cả `zoneinfo` và `zoneinfo/posix`. Cần đặt các múi giờ POSIX trong `zoneinfo`, nếu không nhiều bộ kiểm thử sẽ báo lỗi. Trên hệ thống nhúng, nơi dung lượng eo hẹp và bạn không định cập nhật múi giờ, bạn có thể tiết kiệm 1.9 MB bằng cách không dùng thư mục `posix`, nhưng một số ứng dụng hoặc bộ kiểm thử có thể gặp lỗi.

**`zic -L leapseconds ...`**

> Lệnh này tạo các múi giờ right, có tính giây nhuận. Trên hệ thống nhúng, nơi dung lượng eo hẹp và bạn không định cập nhật múi giờ hay không quan tâm đến giờ chính xác, bạn có thể tiết kiệm 1.9MB bằng cách bỏ thư mục `right`.

**`zic ... -p ...`**

> Lệnh này tạo tệp `posixrules`. Chúng ta dùng New York vì POSIX yêu cầu quy tắc giờ mùa hè (daylight saving time) phải theo quy tắc của Hoa Kỳ.

Một cách để xác định múi giờ địa phương là chạy script sau:

```bash
tzselect
```

Sau khi trả lời vài câu hỏi về vị trí, script sẽ xuất tên múi giờ (ví dụ *America/Edmonton*). Trong `/usr/share/zoneinfo` còn có một số múi giờ khác như *Canada/Eastern* hoặc *EST5EDT* mà script không nhận diện nhưng vẫn dùng được.

Sau đó tạo tệp `/etc/localtime` bằng cách chạy:

```bash
ln -sfv /usr/share/zoneinfo/<xxx> /etc/localtime
```

Thay `<xxx>` bằng tên múi giờ đã chọn (ví dụ Canada/Eastern).

### 8.5.2.3. Cấu hình trình nạp động (Dynamic Loader)

Theo mặc định, trình nạp động (`/lib/ld-linux.so.2`) tìm trong `/usr/lib` các thư viện động mà chương trình cần khi chạy. Tuy nhiên, nếu có thư viện nằm ở thư mục khác `/usr/lib`, bạn cần thêm chúng vào tệp `/etc/ld.so.conf` để trình nạp động tìm thấy. Hai thư mục thường chứa thư viện bổ sung là `/usr/local/lib` và `/opt/lib`, nên hãy thêm chúng vào đường dẫn tìm kiếm của trình nạp động.

Tạo tệp mới `/etc/ld.so.conf` bằng cách chạy:

```bash
cat > /etc/ld.so.conf << "EOF"
# Begin /etc/ld.so.conf
/usr/local/lib
/opt/lib

EOF
```

Nếu muốn, trình nạp động cũng có thể tìm trong một thư mục và include nội dung các tệp ở đó. Thông thường các tệp trong thư mục include này chỉ có một dòng chỉ định đường dẫn thư viện mong muốn. Để thêm khả năng này, chạy các lệnh sau:

```bash
cat >> /etc/ld.so.conf << "EOF"
# Add an include directory
include /etc/ld.so.conf.d/*.conf

EOF
mkdir -pv /etc/ld.so.conf.d
```

## 8.5.3. Nội dung của Glibc

* **Chương trình được cài:** gencat, getconf, getent, iconv, iconvconfig, ldconfig, ldd, lddlibc4, ld.so (symlink tới ld-linux-x86-64.so.2 hoặc ld-linux.so.2), locale, localedef, makedb, mtrace, pcprofiledump, pldd, sln, sotruss, sprof, tzselect, xtrace, zdump và zic
* **Thư viện được cài:** ld-linux-x86-64.so.2, ld-linux.so.2, libBrokenLocale.{a,so}, libanl.{a,so}, libc.{a,so}, libc\_nonshared.a, libc\_malloc\_debug.so, libdl.{a,so.2}, libg.a, libm.{a,so}, libmcheck.a, libmemusage.so, libmvec.{a,so}, libnsl.so.1, libnss\_compat.so, libnss\_dns.so, libnss\_files.so, libnss\_hesiod.so, libpcprofile.so, libpthread.{a,so.0}, libresolv.{a,so}, librt.{a,so.1}, libthread\_db.so và libutil.{a,so.1}
* **Thư mục được cài:** /usr/include/arpa, /usr/include/bits, /usr/include/gnu, /usr/include/net, /usr/include/netash, /usr/include/netatalk, /usr/include/netax25, /usr/include/neteconet, /usr/include/netinet, /usr/include/netipx, /usr/include/netiucv, /usr/include/netpacket, /usr/include/netrom, /usr/include/netrose, /usr/include/nfs, /usr/include/protocols, /usr/include/rpc, /usr/include/sys, /usr/lib/audit, /usr/lib/gconv, /usr/lib/locale, /usr/libexec/getconf, /usr/share/i18n, /usr/share/zoneinfo, và /var/lib/nss\_db

### Mô tả ngắn

* `gencat` — Sinh các message catalogue
* `getconf` — Hiển thị giá trị cấu hình hệ thống cho các biến riêng của từng hệ thống tệp
* `getent` — Lấy các mục từ một cơ sở dữ liệu quản trị
* `iconv` — Chuyển đổi bảng mã ký tự
* `iconvconfig` — Tạo các tệp cấu hình module `iconv` nạp nhanh
* `ldconfig` — Cấu hình các liên kết runtime của trình liên kết động
* `ldd` — Báo cáo những thư viện chia sẻ nào được mỗi chương trình hoặc thư viện chia sẻ đã cho yêu cầu
* `lddlibc4` — Hỗ trợ `ldd` với các tệp đối tượng. Không có trên các kiến trúc mới như x86\_64
* `locale` — In nhiều thông tin về locale hiện tại
* `localedef` — Biên dịch các đặc tả locale
* `makedb` — Tạo một cơ sở dữ liệu đơn giản từ đầu vào dạng văn bản
* `mtrace` — Đọc và diễn giải tệp vết bộ nhớ (memory trace) rồi hiển thị bản tóm tắt dễ đọc
* `pcprofiledump` — Dump thông tin do PC profiling sinh ra
* `pldd` — Liệt kê các đối tượng chia sẻ động mà các tiến trình đang chạy sử dụng
* `sln` — Một chương trình `ln` liên kết tĩnh
* `sotruss` — Theo dõi các lời gọi thủ tục thư viện chia sẻ của một lệnh chỉ định
* `sprof` — Đọc và hiển thị dữ liệu profiling của đối tượng chia sẻ
* `tzselect` — Hỏi người dùng về vị trí của hệ thống và báo mô tả múi giờ tương ứng
* `xtrace` — Theo dõi quá trình thực thi của chương trình bằng cách in ra hàm đang được thực thi
* `zdump` — Công cụ dump múi giờ
* `zic` — Trình biên dịch múi giờ
* `ld-*.so` — Chương trình trợ giúp cho các tệp thực thi dùng thư viện chia sẻ
* `libBrokenLocale` — Được Glibc dùng nội bộ như một thủ thuật tạm bợ để chạy các chương trình lỗi (ví dụ một số ứng dụng Motif). Xem chú thích trong `glibc-2.42/locale/broken_cur_max.c` để biết thêm
* `libanl` — Thư viện giả (dummy) không chứa hàm nào. Trước đây là thư viện tra cứu tên bất đồng bộ, các hàm của nó nay nằm trong `libc`
* `libc` — Thư viện C chính
* `libc_malloc_debug` — Bật kiểm tra cấp phát bộ nhớ khi được preload
* `libdl` — Thư viện giả (dummy) không chứa hàm nào. Trước đây là thư viện giao diện liên kết động, các hàm của nó nay nằm trong `libc`
* `libg` — Thư viện giả (dummy) không chứa hàm nào. Trước đây là thư viện runtime cho `g++`
* `libm` — Thư viện toán học
* `libmvec` — Thư viện toán vector, được liên kết khi cần lúc dùng `libm`
* `libmcheck` — Bật kiểm tra cấp phát bộ nhớ khi được liên kết
* `libmemusage` — Được `memusage` dùng để thu thập thông tin về mức sử dụng bộ nhớ của chương trình
* `libnsl` — Thư viện dịch vụ mạng, hiện đã lỗi thời
* `libnss_*` — Các module Name Service Switch, chứa các hàm phân giải tên host, tên người dùng, tên nhóm, bí danh, dịch vụ, giao thức, v.v. Được `libc` nạp theo cấu hình trong `/etc/nsswitch.conf`
* `libpcprofile` — Có thể preload để PC profile một tệp thực thi
* `libpthread` — Thư viện giả (dummy) không chứa hàm nào. Trước đây chứa các hàm cung cấp phần lớn giao diện do POSIX.1c Threads Extensions chỉ định và giao diện semaphore do POSIX.1b Real-time Extensions chỉ định; nay các hàm đó nằm trong `libc`
* `libresolv` — Chứa các hàm tạo, gửi và diễn giải gói tin tới các máy chủ tên miền Internet (DNS)
* `librt` — Chứa các hàm cung cấp phần lớn giao diện do POSIX.1b Real-time Extensions chỉ định
* `libthread_db` — Chứa các hàm hữu ích để xây dựng trình gỡ lỗi cho chương trình đa luồng
* `libutil` — Thư viện giả (dummy) không chứa hàm nào. Trước đây chứa mã cho các hàm “chuẩn” dùng trong nhiều tiện ích Unix. Các hàm này nay nằm trong `libc`

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/glibc.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/glibc.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/glibc.html)
