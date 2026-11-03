---
description: "Phiên bản LFS này dùng một cơ chế khởi động đặc biệt tên SysVinit, dựa trên một loạt run level (mức chạy). Quy trình khởi động có thể khác nhau khá nhiều g"
---

# 9.6. Sử dụng và cấu hình bootscript System V

## 9.6.1. Bootscript System V hoạt động như thế nào?

Phiên bản LFS này dùng một cơ chế khởi động đặc biệt tên SysVinit, dựa trên một loạt *run level* (mức chạy). Quy trình khởi động có thể khác nhau khá nhiều giữa các hệ thống; việc một bản phân phối Linux nào đó làm theo cách này không đảm bảo LFS cũng sẽ làm y như vậy. LFS có cách làm riêng, nhưng vẫn tuân theo các chuẩn được chấp nhận rộng rãi.

Có một quy trình khởi động thay thế là `systemd`. Chúng ta sẽ không bàn thêm về quy trình đó ở đây. Muốn xem mô tả chi tiết, hãy truy cập [https://www.linux.com/training-tutorials/understanding-and-using-systemd/](https://www.linux.com/training-tutorials/understanding-and-using-systemd/).

SysVinit (từ đây gọi là “init”) dùng cơ chế run level. Có bảy run level, đánh số từ 0 đến 6. (Thật ra còn nhiều run level khác, nhưng chúng dành cho các trường hợp đặc biệt và thường không dùng. Xem [init(8)](https://man.archlinux.org/man/init.8) để biết thêm.) Mỗi run level trong bảy mức này tương ứng với những việc máy tính phải làm khi khởi động hoặc tắt máy. Run level mặc định là 3. Sau đây là mô tả các run level theo cách LFS triển khai:

0: tắt máy (halt) 
 1: chế độ một người dùng 
 2: dành riêng để tùy biến, nếu không thì giống mức 3 
 3: chế độ nhiều người dùng có mạng 
 4: dành riêng để tùy biến, nếu không thì giống mức 3 
 5: giống mức 4, thường dùng cho đăng nhập đồ họa (như `gdm` của GNOME hoặc `lxdm` của LXDE) 
 6: khởi động lại máy tính

{% hint style="info" %}
**Ghi chú**

Theo truyền thống, run level 2 ở trên được định nghĩa là “chế độ nhiều người dùng không có mạng,” nhưng đó chỉ là chuyện của nhiều năm trước, khi nhiều người có thể kết nối vào một hệ thống qua cổng serial. Trong môi trường ngày nay, điều đó không còn ý nghĩa, và giờ ta nói mức này là “dành riêng.”
{% endhint %}

## 9.6.2. Cấu hình SysVinit

Trong quá trình khởi tạo kernel, chương trình đầu tiên được chạy (nếu không bị ghi đè trên dòng lệnh) là `init`. Chương trình này đọc tệp khởi tạo `/etc/inittab`. Hãy tạo tệp này bằng:

```bash
cat > /etc/inittab << "EOF"
# Begin /etc/inittab

id:3:initdefault:

si::sysinit:/etc/rc.d/init.d/rc S

l0:0:wait:/etc/rc.d/init.d/rc 0
l1:S1:wait:/etc/rc.d/init.d/rc 1
l2:2:wait:/etc/rc.d/init.d/rc 2
l3:3:wait:/etc/rc.d/init.d/rc 3
l4:4:wait:/etc/rc.d/init.d/rc 4
l5:5:wait:/etc/rc.d/init.d/rc 5
l6:6:wait:/etc/rc.d/init.d/rc 6

ca:12345:ctrlaltdel:/sbin/shutdown -t1 -a -r now

su:S06:once:/sbin/sulogin
s1:1:respawn:/sbin/sulogin

1:2345:respawn:/sbin/agetty --noclear tty1 9600
2:2345:respawn:/sbin/agetty tty2 9600
3:2345:respawn:/sbin/agetty tty3 9600
4:2345:respawn:/sbin/agetty tty4 9600
5:2345:respawn:/sbin/agetty tty5 9600
6:2345:respawn:/sbin/agetty tty6 9600

# End /etc/inittab
EOF
```

Phần giải thích về tệp khởi tạo này có trong trang man của *inittab*. Trong LFS, lệnh then chốt là `rc`. Tệp khởi tạo ở trên chỉ thị `rc` chạy tất cả script bắt đầu bằng chữ S trong thư mục `/etc/rc.d/rcS.d`, rồi đến tất cả script bắt đầu bằng chữ S trong thư mục `/etc/rc.d/rc?.d`, trong đó dấu hỏi được xác định bởi giá trị initdefault.

Để tiện lợi, script `rc` đọc một thư viện hàm trong `/lib/lsb/init-functions`. Thư viện này cũng đọc một tệp cấu hình tùy chọn, `/etc/sysconfig/rc.site`. Mọi tham số cấu hình hệ thống được mô tả ở các mục sau đều có thể đặt trong tệp này, giúp gom tất cả tham số hệ thống vào một nơi.

Để thuận tiện cho việc gỡ lỗi, script functions cũng ghi toàn bộ đầu ra vào `/run/var/bootlog`. Vì thư mục `/run` là tmpfs nên tệp này không còn sau khi khởi động lại; tuy nhiên nó được nối thêm vào tệp bền vững hơn `/var/log/boot.log` khi quá trình khởi động kết thúc.

### 9.6.2.1. Đổi run level

Bạn đổi run level bằng `init <runlevel>`, trong đó `<runlevel>` là run level đích. Ví dụ, để khởi động lại máy, người dùng có thể gõ lệnh `init 6`, vốn là bí danh của lệnh `reboot`. Tương tự, `init 0` là bí danh của lệnh `halt`.

Dưới `/etc/rc.d` có một số thư mục dạng `rc?.d` (với ? là số của run level) và `rcS.d`, tất cả đều chứa nhiều liên kết mềm (symlink). Một số liên kết bắt đầu bằng *K*; số còn lại bắt đầu bằng *S*, và tất cả đều có hai chữ số theo sau chữ cái đầu. K nghĩa là dừng (kill) một dịch vụ còn S nghĩa là khởi động một dịch vụ. Các con số quyết định thứ tự chạy script, từ 00 đến 99 — số càng nhỏ thì script chạy càng sớm. Khi `init` chuyển sang run level khác, các dịch vụ tương ứng sẽ được khởi động hoặc dừng, tùy run level được chọn.

Các script thật nằm trong `/etc/rc.d/init.d`. Chúng làm công việc thực sự, còn các symlink đều trỏ tới chúng. Liên kết K và S đều trỏ tới cùng một script trong `/etc/rc.d/init.d`, vì script có thể được gọi với các tham số khác nhau như `start`, `stop`, `restart`, `reload` và `status`. Khi gặp liên kết K, script tương ứng được chạy với đối số `stop`. Khi gặp liên kết S, script tương ứng được chạy với đối số `start`.

Sau đây là mô tả tác dụng của các đối số đối với script:

**`start`**

> Dịch vụ được khởi động.

**`stop`**

> Dịch vụ được dừng.

**`restart`**

> Dịch vụ được dừng rồi khởi động lại.

**`reload`**

> Cấu hình của dịch vụ được cập nhật. Dùng sau khi tệp cấu hình của dịch vụ bị sửa, khi dịch vụ không cần khởi động lại.

**`status`**

> Cho biết dịch vụ có đang chạy không và với những PID nào.

Bạn cứ thoải mái thay đổi cách quá trình khởi động hoạt động (suy cho cùng đây là hệ thống LFS của bạn). Các tệp ở đây chỉ là một ví dụ về cách có thể làm.

## 9.6.3. Bootscript Udev

Initscript `/etc/rc.d/init.d/udev` khởi động `udevd`, kích hoạt mọi thiết bị "coldplug" đã được kernel tạo sẵn, và chờ mọi quy tắc hoàn tất. Script này cũng bỏ thiết lập trình xử lý uevent khỏi giá trị mặc định `/sbin/hotplug`. Lý do là kernel không còn cần gọi một tệp thực thi bên ngoài. Thay vào đó, `udevd` sẽ lắng nghe trên một netlink socket để nhận các uevent do kernel phát ra.

Script `/etc/rc.d/init.d/udev_retry` lo việc kích hoạt lại sự kiện cho các subsystem có quy tắc phụ thuộc vào hệ thống tệp chưa được mount cho đến khi script `mountfs` chạy (đặc biệt `/usr` và `/var` có thể gây ra tình trạng này). Script này chạy sau script `mountfs`, nên các quy tắc đó (nếu được kích hoạt lại) sẽ thành công ở lần thứ hai. Nó được cấu hình bằng tệp `/etc/sysconfig/udev_retry`; mọi từ trong tệp này ngoài phần chú thích đều được coi là tên subsystem cần kích hoạt khi thử lại. Để tìm subsystem của một thiết bị, dùng `udevadm info --attribute-walk <device>` với &lt;device&gt; là đường dẫn tuyệt đối trong /dev hoặc /sys, như /dev/sr0 hay /sys/class/rtc.

Về việc nạp module kernel và udev, xem [Mục 9.3.2.3, “Module Loading.”](udev.md#module-loading)

## 9.6.4. Cấu hình đồng hồ hệ thống

Script `setclock` đọc thời gian từ đồng hồ phần cứng, còn gọi là đồng hồ BIOS hoặc Complementary Metal Oxide Semiconductor (CMOS). Nếu đồng hồ phần cứng được đặt theo UTC, script này sẽ đổi thời gian của đồng hồ phần cứng sang giờ địa phương bằng tệp `/etc/localtime` (tệp cho chương trình `hwclock` biết dùng múi giờ nào). Không có cách nào phát hiện đồng hồ phần cứng có đặt theo UTC hay không, nên bạn phải cấu hình thủ công.

Chương trình `setclock` được chạy thông qua `udev` khi kernel phát hiện khả năng phần cứng lúc khởi động. Bạn cũng có thể chạy thủ công với tham số stop để lưu giờ hệ thống vào đồng hồ CMOS.

Nếu bạn không nhớ đồng hồ phần cứng có đặt theo UTC hay không, hãy chạy lệnh `hwclock --localtime --show` để biết. Lệnh này hiển thị giờ hiện tại theo đồng hồ phần cứng. Nếu giờ này khớp với đồng hồ đeo tay của bạn, đồng hồ phần cứng đang đặt theo giờ địa phương. Nếu kết quả của `hwclock` không phải giờ địa phương, nhiều khả năng nó đang đặt theo UTC. Hãy kiểm chứng bằng cách cộng hoặc trừ số giờ tương ứng với múi giờ của bạn vào giờ do `hwclock` hiển thị. Ví dụ, nếu bạn đang ở múi giờ MST, còn gọi là GMT -0700, hãy cộng bảy giờ vào giờ địa phương.

Hãy đổi giá trị biến `UTC` bên dưới thành `0` (không) nếu đồng hồ phần cứng *KHÔNG* đặt theo giờ UTC.

Tạo tệp mới `/etc/sysconfig/clock` bằng cách chạy:

```bash
cat > /etc/sysconfig/clock << "EOF"
# Begin /etc/sysconfig/clock

UTC=1

# Set this to any options you might need to give to hwclock,
# such as machine hardware clock type for Alphas.
CLOCKPARAMS=

# End /etc/sysconfig/clock
EOF
```

Có một hint hay giải thích cách xử lý thời gian trên LFS tại [https://www.linuxfromscratch.org/hints/downloads/files/time.txt](https://www.linuxfromscratch.org/hints/downloads/files/time.txt). Nó giải thích các vấn đề như múi giờ, UTC và biến môi trường `TZ`.

{% hint style="info" %}
**Ghi chú**

Các tham số CLOCKPARAMS và UTC cũng có thể đặt trong tệp `/etc/sysconfig/rc.site`.
{% endhint %}

## 9.6.5. Cấu hình console Linux

Mục này bàn về cách cấu hình bootscript `console`, script thiết lập bản đồ bàn phím, phông chữ console và mức log kernel trên console. Nếu bạn không dùng ký tự ngoài ASCII (ví dụ ký hiệu bản quyền, ký hiệu bảng Anh và ký hiệu Euro) và dùng bàn phím Mỹ, bạn có thể bỏ qua phần lớn mục này. Nếu không có tệp cấu hình (hoặc thiết lập tương đương trong `rc.site`), bootscript `console` sẽ không làm gì cả.

Script `console` đọc tệp `/etc/sysconfig/console` để lấy thông tin cấu hình. Hãy quyết định dùng keymap và phông chữ màn hình nào. Các HOWTO theo từng ngôn ngữ cũng có thể giúp ích; xem [https://tldp.org/HOWTO/HOWTO-INDEX/other-lang.html](https://tldp.org/HOWTO/HOWTO-INDEX/other-lang.html). Nếu vẫn phân vân, hãy xem các thư mục `/usr/share/keymaps` và `/usr/share/consolefonts` để biết keymap và phông chữ màn hình hợp lệ. Đọc các trang man [loadkeys(1)](https://man.archlinux.org/man/loadkeys.1) và [setfont(8)](https://man.archlinux.org/man/setfont.8) để biết đối số đúng cho các chương trình này.

Tệp `/etc/sysconfig/console` nên chứa các dòng có dạng: `VARIABLE=value`. Các biến sau được nhận diện:

**LOGLEVEL**

> Biến này chỉ định mức log của các thông điệp kernel gửi tới console, như đặt bằng `dmesg -n`. Các mức hợp lệ từ `1` (không có thông điệp) đến `8`. Mức mặc định là `7`, khá dài dòng.

**KEYMAP**

> Biến này chỉ định các đối số cho chương trình `loadkeys`, thường là tên keymap cần nạp, ví dụ `it`. Nếu biến này không được đặt, bootscript sẽ không chạy `loadkeys` và keymap mặc định của kernel sẽ được dùng. Lưu ý một vài keymap có nhiều phiên bản trùng tên (cz và các biến thể trong qwerty/ và qwertz/, es trong olpc/ và qwerty/, và trf trong fgGIod/ và qwerty/). Trong các trường hợp này nên chỉ rõ cả thư mục cha (ví dụ qwerty/es) để đảm bảo nạp đúng keymap.

**KEYMAP\_CORRECTIONS**

> Biến (hiếm dùng) này chỉ định các đối số cho lần gọi `loadkeys` thứ hai. Nó hữu ích khi keymap có sẵn chưa hoàn toàn vừa ý và cần chỉnh chút ít. Ví dụ, để thêm ký hiệu Euro vào keymap vốn không có nó, hãy đặt biến này là `euro2`.

**FONT**

> Biến này chỉ định các đối số cho chương trình `setfont`. Thường gồm tên phông, `-m` và tên bảng ánh xạ ký tự ứng dụng cần nạp. Ví dụ, để nạp phông “lat1-16” cùng bảng ánh xạ ký tự ứng dụng “8859-1” (phù hợp với Mỹ), hãy đặt biến này là `lat1-16 -m 8859-1`. Trong chế độ UTF-8, kernel dùng bảng ánh xạ ký tự ứng dụng để chuyển mã phím 8-bit sang UTF-8. Vì vậy, đối số của tham số "-m" nên đặt theo bảng mã của các mã phím tổ hợp trong keymap.

**UNICODE**

> Đặt biến này là `1`, `yes` hoặc `true` để chuyển console sang chế độ UTF-8. Điều này hữu ích với locale dựa trên UTF-8 và có hại trong các trường hợp khác.

**LEGACY\_CHARSET**

> Với nhiều bố cục bàn phím, gói Kbd không có sẵn keymap Unicode. Bootscript `console` sẽ chuyển một keymap có sẵn sang UTF-8 ngay khi chạy nếu biến này được đặt là bảng mã của keymap không phải UTF-8 đó.

Một vài ví dụ:

* Chúng ta sẽ dùng `C.UTF-8` làm locale cho các phiên tương tác trên console Linux ở [Mục 9.7, “Configuring the System Locale,”](locale.md) nên cần đặt `UNICODE` là `1`. Các phông console do gói `Kbd` cung cấp có glyph cho mọi ký tự trong thông điệp chương trình ở locale `C.UTF-8` là `LatArCyrHeb*.psfu.gz`, `LatGrkCyr*.psfu.gz`, `Lat2-Terminus16.psfu.gz` và `pancyrillic.f16.psfu.gz` trong `/usr/share/consolefonts` (các phông console còn lại thiếu glyph của một số ký tự như dấu ngoặc kép trái/phải Unicode và dấu gạch ngang tiếng Anh Unicode). Vì vậy hãy chọn một trong số đó, ví dụ `Lat2-Terminus16.psfu.gz`, làm phông console mặc định:

  ```bash
  cat > /etc/sysconfig/console << "EOF"
  # Begin /etc/sysconfig/console

  UNICODE="1"
  FONT="Lat2-Terminus16"

  # End /etc/sysconfig/console
  EOF
  ```
* Với thiết lập không dùng Unicode, thường chỉ cần các biến KEYMAP và FONT. Ví dụ, với thiết lập tiếng Ba Lan, bạn sẽ dùng:

  ```bash
  cat > /etc/sysconfig/console << "EOF"
  # Begin /etc/sysconfig/console

  KEYMAP="pl2"
  FONT="lat2a-16 -m 8859-2"

  # End /etc/sysconfig/console
  EOF
  ```
* Như đã nói ở trên, đôi khi cần chỉnh nhẹ một keymap có sẵn. Ví dụ sau thêm ký hiệu Euro vào keymap tiếng Đức:

  ```bash
  cat > /etc/sysconfig/console << "EOF"
  # Begin /etc/sysconfig/console

  KEYMAP="de-latin1"
  KEYMAP_CORRECTIONS="euro2"
  FONT="lat0-16 -m 8859-15"
  UNICODE="1"

  # End /etc/sysconfig/console
  EOF
  ```
* Sau đây là ví dụ bật Unicode cho tiếng Bulgaria, nơi có sẵn keymap UTF-8:

  ```bash
  cat > /etc/sysconfig/console << "EOF"
  # Begin /etc/sysconfig/console

  UNICODE="1"
  KEYMAP="bg_bds-utf8"
  FONT="LatArCyrHeb-16"

  # End /etc/sysconfig/console
  EOF
  ```
* Do dùng phông LatArCyrHeb-16 với 512 glyph trong ví dụ trước, màu sáng không còn dùng được trên console Linux trừ khi dùng framebuffer. Nếu muốn có màu sáng mà không dùng framebuffer, và chấp nhận không có các ký tự không thuộc ngôn ngữ của mình, bạn vẫn có thể dùng phông 256 glyph riêng cho ngôn ngữ, như minh họa dưới đây:

  ```bash
  cat > /etc/sysconfig/console << "EOF"
  # Begin /etc/sysconfig/console

  UNICODE="1"
  KEYMAP="bg_bds-utf8"
  FONT="cyr-sun16"

  # End /etc/sysconfig/console
  EOF
  ```
* Ví dụ sau minh họa việc tự động chuyển keymap từ ISO-8859-15 sang UTF-8 và bật phím chết (dead key) trong chế độ Unicode:

  ```bash
  cat > /etc/sysconfig/console << "EOF"
  # Begin /etc/sysconfig/console

  UNICODE="1"
  KEYMAP="de-latin1"
  KEYMAP_CORRECTIONS="euro2"
  LEGACY_CHARSET="iso-8859-15"
  FONT="LatArCyrHeb-16 -m 8859-15"

  # End /etc/sysconfig/console
  EOF
  ```
* Một số keymap có phím chết (tức phím không tự tạo ra ký tự, mà đặt dấu lên ký tự do phím kế tiếp tạo ra) hoặc định nghĩa quy tắc tổ hợp (chẳng hạn: “nhấn Ctrl+. A E để ra Æ” trong keymap mặc định). Linux-6.16.1 chỉ diễn giải đúng phím chết và quy tắc tổ hợp trong keymap khi các ký tự nguồn cần ghép không phải đa byte. Thiếu sót này không ảnh hưởng đến keymap của các ngôn ngữ châu Âu, vì ở đó dấu được thêm vào ký tự ASCII không dấu, hoặc hai ký tự ASCII được ghép với nhau. Tuy nhiên, trong chế độ UTF-8 đó là một vấn đề; ví dụ với tiếng Hy Lạp, đôi khi cần đặt dấu lên chữ α. Giải pháp là tránh dùng UTF-8, hoặc cài X window system, vốn không có giới hạn này khi xử lý đầu vào.
* Với tiếng Trung, Nhật, Hàn và một số ngôn ngữ khác, console Linux không thể cấu hình để hiển thị các ký tự cần thiết. Người dùng cần các ngôn ngữ này nên cài X Window System, phông chữ bao phủ các dải ký tự cần thiết, và bộ gõ phù hợp (ví dụ SCIM hỗ trợ rất nhiều ngôn ngữ).

{% hint style="info" %}
**Ghi chú**

Tệp `/etc/sysconfig/console` chỉ điều khiển việc bản địa hóa console văn bản Linux. Nó không liên quan đến việc thiết lập bố cục bàn phím và phông terminal đúng trong X Window System, trong phiên ssh hay trên console serial. Trong những tình huống đó, các giới hạn nêu ở hai mục cuối của danh sách trên không áp dụng.
{% endhint %}

## 9.6.6. Tạo tệp khi khởi động

Đôi khi cần tạo tệp ngay khi khởi động. Chẳng hạn, thư mục `/tmp/.ICE-unix` thường được cần đến. Bạn có thể làm việc này bằng cách thêm một mục vào script cấu hình `/etc/sysconfig/createfiles`. Định dạng của tệp này được ghi trong phần chú thích của tệp cấu hình mặc định.

## 9.6.7. Cấu hình script Sysklogd

Script `sysklogd` gọi chương trình `syslogd` như một phần của quá trình khởi tạo System V. Tùy chọn `-m 0` tắt dấu mốc thời gian định kỳ mà `syslogd` mặc định ghi vào tệp log mỗi 20 phút. Nếu muốn bật dấu mốc thời gian định kỳ này, hãy sửa `/etc/sysconfig/rc.site` và đặt biến SYSKLOGD\_PARMS theo giá trị mong muốn. Ví dụ, để bỏ mọi tham số, hãy đặt biến là giá trị rỗng:

```text
SYSKLOGD_PARMS=
```

Xem `man syslogd` để biết thêm tùy chọn.

## 9.6.8. Tệp rc.site

Tệp tùy chọn `/etc/sysconfig/rc.site` chứa các thiết lập được tự động đặt cho mỗi script khởi động SystemV. Nó cũng có thể đặt các giá trị được chỉ định trong các tệp `hostname`, `console` và `clock` trong thư mục `/etc/sysconfig/`. Nếu các biến liên quan có mặt ở cả các tệp riêng lẻ này lẫn `rc.site`, giá trị trong tệp riêng của từng script sẽ có hiệu lực.

`rc.site` cũng chứa các tham số có thể tùy biến những khía cạnh khác của quá trình khởi động. Đặt biến IPROMPT sẽ cho phép chạy bootscript có chọn lọc. Các tùy chọn khác được mô tả trong chú thích của tệp. Phiên bản mặc định của tệp như sau:

```text
# rc.site
# Optional parameters for boot scripts.

# Distro Information
# These values, if specified here, override the defaults
#DISTRO="Linux From Scratch" # The distro name
#DISTRO_CONTACT="lfs-dev@lists.linuxfromscratch.org" # Bug report address
#DISTRO_MINI="LFS" # Short name used in filenames for distro config

# Define custom colors used in messages printed to the screen

# Please consult `man console_codes` for more information
# under the "ECMA-48 Set Graphics Rendition" section
#
# Warning: when switching from a 8bit to a 9bit font,
# the linux console will reinterpret the bold (1;) to
# the top 256 glyphs of the 9bit font.  This does
# not affect framebuffer consoles

# These values, if specified here, override the defaults
#BRACKET="\\033[1;34m" # Blue
#FAILURE="\\033[1;31m" # Red
#INFO="\\033[1;36m"    # Cyan
#NORMAL="\\033[0;39m"  # Grey
#SUCCESS="\\033[1;32m" # Green
#WARNING="\\033[1;33m" # Yellow

# Use a colored prefix
# These values, if specified here, override the defaults
#BMPREFIX="      "
#SUCCESS_PREFIX="${SUCCESS}  *  ${NORMAL} "
#FAILURE_PREFIX="${FAILURE}*****${NORMAL} "
#WARNING_PREFIX="${WARNING} *** ${NORMAL} "

# Manually set the right edge of message output (characters)
# Useful when resetting console font during boot to override
# automatic screen width detection
#COLUMNS=120

# Interactive startup
#IPROMPT="yes" # Whether to display the interactive boot prompt
#itime="3"    # The amount of time (in seconds) to display the prompt

# The total length of the distro welcome string, without escape codes
#wlen=$(echo "Welcome to ${DISTRO}" | wc -c )
#welcome_message="Welcome to ${INFO}${DISTRO}${NORMAL}"

# The total length of the interactive string, without escape codes
#ilen=$(echo "Press 'I' to enter interactive startup" | wc -c )
#i_message="Press '${FAILURE}I${NORMAL}' to enter interactive startup"

# Set scripts to skip the file system check on reboot
#FASTBOOT=yes

# Skip reading from the console
#HEADLESS=yes

# Write out fsck progress if yes
#VERBOSE_FSCK=no

# Speed up boot without waiting for settle in udev
#OMIT_UDEV_SETTLE=y

# Speed up boot without waiting for settle in udev_retry
#OMIT_UDEV_RETRY_SETTLE=yes

# Skip cleaning /tmp if yes
#SKIPTMPCLEAN=no

# For setclock
#UTC=1
#CLOCKPARAMS=

# For consolelog (Note that the default, 7=debug, is noisy)
#LOGLEVEL=7

# For network
#HOSTNAME=mylfs

# Delay between TERM and KILL signals at shutdown
#KILLDELAY=3

# Optional sysklogd parameters
#SYSKLOGD_PARMS="-m 0"

# Console parameters
#UNICODE=1
#KEYMAP="de-latin1"
#KEYMAP_CORRECTIONS="euro2"
#FONT="lat0-16 -m 8859-15"
#LEGACY_CHARSET=
```

### 9.6.8.1. Tùy biến script khởi động và tắt máy

Các script khởi động của LFS khởi động và tắt hệ thống khá hiệu quả, nhưng bạn có thể tinh chỉnh vài chỗ trong rc.site để nhanh hơn nữa và điều chỉnh thông điệp theo ý thích. Để làm vậy, hãy chỉnh các thiết lập trong tệp `/etc/sysconfig/rc.site` ở trên.

* Trong script khởi động `udev` có một lời gọi `udev settle` cần một lúc mới xong. Thời gian này có thể cần hoặc không, tùy thiết bị trong hệ thống. Nếu bạn chỉ có các phân vùng đơn giản và một card ethernet, quá trình khởi động có lẽ không cần chờ lệnh này. Để bỏ qua, hãy đặt biến OMIT\_UDEV\_SETTLE=y.
* Script khởi động `udev_retry` cũng chạy `udev settle` theo mặc định. Lệnh này chỉ cần nếu thư mục `/var` được mount riêng, vì đồng hồ cần tệp `/var/lib/hwclock/adjtime`. Các tùy biến khác cũng có thể cần chờ udev hoàn tất, nhưng ở nhiều bản cài đặt thì không cần. Hãy bỏ qua lệnh này bằng cách đặt biến OMIT\_UDEV\_RETRY\_SETTLE=y.
* Mặc định, việc kiểm tra hệ thống tệp diễn ra im lặng. Điều này có thể trông như một độ trễ trong quá trình khởi động. Để bật đầu ra của `fsck`, hãy đặt biến VERBOSE\_FSCK=y.
* Khi khởi động lại, bạn có thể muốn bỏ qua hoàn toàn bước kiểm tra hệ thống tệp `fsck`. Để làm vậy, hãy tạo tệp `/fastboot` hoặc khởi động lại hệ thống bằng lệnh `/sbin/shutdown -f -r now`. Ngược lại, bạn có thể ép kiểm tra mọi hệ thống tệp bằng cách tạo `/forcefsck` hoặc chạy `shutdown` với tham số `-F` thay cho `-f`.

  Đặt biến FASTBOOT=y sẽ tắt `fsck` trong quá trình khởi động cho đến khi bạn gỡ nó. Không nên làm vậy lâu dài.
* Thông thường, mọi tệp trong thư mục `/tmp` bị xóa khi khởi động. Tùy số tệp hoặc thư mục hiện có, việc này có thể gây độ trễ đáng kể cho quá trình khởi động. Để bỏ qua việc xóa các tệp này, hãy đặt biến SKIPTMPCLEAN=y.
* Khi tắt máy, chương trình `init` gửi tín hiệu TERM tới từng chương trình nó đã khởi động (ví dụ agetty), chờ một khoảng thời gian định sẵn (mặc định 3 giây), rồi gửi tín hiệu KILL tới từng tiến trình và chờ tiếp. Quy trình này được lặp lại trong script `sendsignals` cho các tiến trình chưa được script riêng của chúng tắt. Độ trễ của `init` có thể đặt bằng cách truyền tham số. Ví dụ, để bỏ độ trễ trong `init`, hãy truyền tham số -t0 khi tắt hoặc khởi động lại (ví dụ `/sbin/shutdown -t0 -r now`). Có thể bỏ độ trễ của script `sendsignals` bằng cách đặt tham số KILLDELAY=0.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter09/usage.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter09/usage.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter09/usage.html)
