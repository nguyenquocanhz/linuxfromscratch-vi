---
description: "Gói Util-linux chứa nhiều chương trình tiện ích khác nhau, trong đó có các tiện ích xử lý hệ thống tệp, console, phân vùng và thông điệp."
---

# 8.79. Util-linux-2.41.1

Gói Util-linux chứa nhiều chương trình tiện ích khác nhau, trong đó có các tiện ích xử lý hệ thống tệp, console, phân vùng và thông điệp.

* **Thời gian dựng ước tính:** 0.5 SBU
* **Dung lượng đĩa cần:** 346 MB

## 8.79.1. Cài đặt Util-linux

Chuẩn bị biên dịch Util-linux:

```bash
./configure --bindir=/usr/bin     \
            --libdir=/usr/lib     \
            --runstatedir=/run    \
            --sbindir=/usr/sbin   \
            --disable-chfn-chsh   \
            --disable-login       \
            --disable-nologin     \
            --disable-su          \
            --disable-setpriv     \
            --disable-runuser     \
            --disable-pylibmount  \
            --disable-liblastlog2 \
            --disable-static      \
            --without-python      \
            --without-systemd     \
            --without-systemdsystemunitdir        \
            ADJTIME_PATH=/var/lib/hwclock/adjtime \
            --docdir=/usr/share/doc/util-linux-2.41.1
```

Các tùy chọn --disable và --without ngăn các cảnh báo khi dựng những thành phần cần gói không có trong LFS, hoặc xung đột với chương trình do các gói khác cài.

Biên dịch gói:

```bash
make
```

Nếu muốn, tạo một tệp `/etc/fstab` giả để thỏa hai bài kiểm thử, rồi chạy bộ kiểm thử bằng người dùng không phải `root`:

{% hint style="danger" %}
**Warning**

Chạy bộ kiểm thử bằng người dùng `root` có thể gây hại cho hệ thống. Để chạy, tùy chọn kernel CONFIG\_SCSI\_DEBUG phải có trong hệ thống đang chạy và phải được dựng dưới dạng module. Dựng nó thẳng vào kernel sẽ làm hệ thống không khởi động được. Để kiểm thử đầy đủ, cần cài thêm các gói BLFS khác. Nếu muốn, bạn có thể chạy bài kiểm thử này sau khi khởi động vào hệ thống LFS hoàn chỉnh và chạy:

```bash
bash tests/run.sh --srcdir=$PWD --builddir=$PWD
```
{% endhint %}

```bash
touch /etc/fstab
chown -R tester .
su tester -c "make -k check"
```

Các bài kiểm thử *hardlink* sẽ thất bại nếu kernel của máy host không bật tùy chọn `CONFIG_CRYPTO_USER_API_HASH` hoặc không bật tùy chọn nào cung cấp bản cài đặt SHA256 (ví dụ `CONFIG_CRYPTO_SHA256`, hoặc `CONFIG_CRYPTO_SHA256_SSSE3` nếu CPU hỗ trợ Supplemental SSE3). Ngoài ra, bài kiểm thử lsfd: inotify sẽ thất bại nếu không bật tùy chọn kernel `CONFIG_NETLINK_DIAG`.

Có một bài kiểm thử, `kill: decode functions`, được biết là thất bại với bash-5.3-rc1 trở lên.

Cài đặt gói:

```bash
make install
```

## 8.79.2. Nội dung của Util-linux

* **Chương trình được cài:** addpart, agetty, blkdiscard, blkid, blkzone, blockdev, cal, cfdisk, chcpu, chmem, choom, chrt, col, colcrt, colrm, column, ctrlaltdel, delpart, dmesg, eject, fallocate, fdisk, fincore, findfs, findmnt, flock, fsck, fsck.cramfs, fsck.minix, fsfreeze, fstrim, getopt, hardlink, hexdump, hwclock, i386 (liên kết tới setarch), ionice, ipcmk, ipcrm, ipcs, irqtop, isosize, kill, last, lastb (liên kết tới last), ldattach, linux32 (liên kết tới setarch), linux64 (liên kết tới setarch), logger, look, losetup, lsblk, lscpu, lsipc, lsirq, lsfd, lslocks, lslogins, lsmem, lsns, mcookie, mesg, mkfs, mkfs.bfs, mkfs.cramfs, mkfs.minix, mkswap, more, mount, mountpoint, namei, nsenter, partx, pivot\_root, prlimit, readprofile, rename, renice, resizepart, rev, rfkill, rtcwake, script, scriptlive, scriptreplay, setarch, setsid, setterm, sfdisk, sulogin, swaplabel, swapoff, swapon, switch\_root, taskset, uclampset, ul, umount, uname26 (liên kết tới setarch), unshare, utmpdump, uuidd, uuidgen, uuidparse, wall, wdctl, whereis, wipefs, x86\_64 (liên kết tới setarch) và zramctl
* **Thư viện được cài:** libblkid.so, libfdisk.so, libmount.so, libsmartcols.so và libuuid.so
* **Thư mục được cài:** /usr/include/blkid, /usr/include/libfdisk, /usr/include/libmount, /usr/include/libsmartcols, /usr/include/uuid, /usr/share/doc/util-linux-2.41.1 và /var/lib/hwclock

### Mô tả ngắn

* `addpart` — Thông báo cho kernel Linux về các phân vùng mới
* `agetty` — Mở một cổng tty, nhắc nhập tên đăng nhập, rồi gọi chương trình `login`
* `blkdiscard` — Loại bỏ (discard) các sector trên một thiết bị
* `blkid` — Tiện ích dòng lệnh để tìm và in các thuộc tính của thiết bị khối
* `blkzone` — Dùng để quản lý các thiết bị khối zoned storage
* `blockdev` — Cho phép người dùng gọi ioctl của thiết bị khối từ dòng lệnh
* `cal` — Hiển thị một lịch đơn giản
* `cfdisk` — Thao tác với bảng phân vùng của thiết bị cho trước
* `chcpu` — Thay đổi trạng thái của các CPU
* `chmem` — Cấu hình bộ nhớ
* `choom` — Hiển thị và điều chỉnh điểm OOM-killer, dùng để xác định tiến trình nào bị giết trước khi Linux hết bộ nhớ (Out Of Memory)
* `chrt` — Thao tác với các thuộc tính thời gian thực của một tiến trình
* `col` — Lọc bỏ các ký tự xuống dòng ngược
* `colcrt` — Lọc đầu ra của `nroff` cho các terminal thiếu một số khả năng, như gạch đè và nửa dòng
* `colrm` — Lọc bỏ các cột đã cho
* `column` — Định dạng một tệp thành nhiều cột
* `ctrlaltdel` — Đặt chức năng của tổ hợp phím Ctrl+Alt+Del thành khởi động lại cứng hoặc mềm
* `delpart` — Yêu cầu kernel Linux xóa một phân vùng
* `dmesg` — Xuất ra các thông điệp khởi động của kernel
* `eject` — Đẩy phương tiện lưu trữ di động ra
* `fallocate` — Cấp phát trước dung lượng cho một tệp
* `fdisk` — Thao tác với bảng phân vùng của thiết bị cho trước
* `fincore` — Đếm số trang nội dung tệp đang nằm trong bộ nhớ
* `findfs` — Tìm một hệ thống tệp theo nhãn hoặc theo Universally Unique Identifier (UUID)
* `findmnt` — Là giao diện dòng lệnh của thư viện libmount để làm việc với các tệp mountinfo, fstab và mtab
* `flock` — Lấy khóa tệp rồi thực thi một lệnh trong khi giữ khóa đó
* `fsck` — Dùng để kiểm tra và tùy chọn sửa chữa các hệ thống tệp
* `fsck.cramfs` — Kiểm tra tính nhất quán của hệ thống tệp Cramfs trên thiết bị cho trước
* `fsck.minix` — Kiểm tra tính nhất quán của hệ thống tệp Minix trên thiết bị cho trước
* `fsfreeze` — Là một lớp bọc rất đơn giản quanh các thao tác FIFREEZE/FITHAW ioctl của trình điều khiển kernel
* `fstrim` — Loại bỏ (discard) các khối không dùng trên một hệ thống tệp đang mount
* `getopt` — Phân tích các tùy chọn trong dòng lệnh cho trước
* `hardlink` — Gộp các tệp trùng lặp bằng cách tạo liên kết cứng
* `hexdump` — Xuất nội dung tệp cho trước dưới dạng thập lục phân, thập phân, bát phân hoặc ascii
* `hwclock` — Đọc hoặc đặt đồng hồ phần cứng của hệ thống, còn gọi là Real-Time Clock (RTC) hoặc đồng hồ Basic Input-Output System (BIOS)
* `i386` — Một liên kết mềm tới setarch
* `ionice` — Lấy hoặc đặt lớp lập lịch io và mức ưu tiên cho một chương trình
* `ipcmk` — Tạo nhiều tài nguyên IPC khác nhau
* `ipcrm` — Xóa tài nguyên Inter-Process Communication (IPC) cho trước
* `ipcs` — Cung cấp thông tin trạng thái IPC
* `irqtop` — Hiển thị thông tin bộ đếm ngắt của kernel theo kiểu giao diện [top(1)](https://man.archlinux.org/man/top.1)
* `isosize` — Báo kích thước của một hệ thống tệp iso9660
* `kill` — Gửi tín hiệu tới các tiến trình
* `last` — Cho biết những người dùng đăng nhập (và đăng xuất) lần cuối, bằng cách tra ngược trong tệp `/var/log/wtmp`; nó cũng cho biết các lần khởi động, tắt máy và thay đổi run-level của hệ thống
* `lastb` — Cho biết các lần đăng nhập thất bại, theo ghi nhận trong `/var/log/btmp`
* `ldattach` — Gắn một line discipline vào một đường nối tiếp
* `linux32` — Một liên kết mềm tới setarch
* `linux64` — Một liên kết mềm tới setarch
* `logger` — Ghi thông điệp cho trước vào nhật ký hệ thống
* `look` — Hiển thị các dòng bắt đầu bằng chuỗi cho trước
* `losetup` — Thiết lập và điều khiển các thiết bị loop
* `lsblk` — Liệt kê thông tin về tất cả hoặc một số thiết bị khối được chọn theo dạng cây
* `lscpu` — In thông tin về kiến trúc CPU
* `lsfd` — Hiển thị thông tin về các tệp đang mở; thay thế cho `lsof`
* `lsipc` — In thông tin về các cơ sở IPC đang được dùng trong hệ thống
* `lsirq` — Hiển thị thông tin bộ đếm ngắt của kernel
* `lslocks` — Liệt kê các khóa cục bộ của hệ thống
* `lslogins` — Liệt kê thông tin về người dùng, nhóm và tài khoản hệ thống
* `lsmem` — Liệt kê các dải bộ nhớ khả dụng cùng trạng thái online của chúng
* `lsns` — Liệt kê các namespace
* `mcookie` — Tạo magic cookie (số ngẫu nhiên thập lục phân 128-bit) cho `xauth`
* `mesg` — Điều khiển việc những người dùng khác có được gửi thông điệp tới terminal của người dùng hiện tại hay không
* `mkfs` — Tạo hệ thống tệp trên một thiết bị (thường là một phân vùng ổ cứng)
* `mkfs.bfs` — Tạo hệ thống tệp bfs của Santa Cruz Operations (SCO)
* `mkfs.cramfs` — Tạo hệ thống tệp cramfs
* `mkfs.minix` — Tạo hệ thống tệp Minix
* `mkswap` — Khởi tạo thiết bị hoặc tệp cho trước để dùng làm vùng swap
* `more` — Bộ lọc để xem văn bản từng màn hình một
* `mount` — Gắn hệ thống tệp trên thiết bị cho trước vào một thư mục chỉ định trong cây hệ thống tệp
* `mountpoint` — Kiểm tra xem một thư mục có phải là điểm mount hay không
* `namei` — Hiển thị các liên kết mềm trong các đường dẫn cho trước
* `nsenter` — Chạy một chương trình với các namespace của tiến trình khác
* `partx` — Cho kernel biết về sự hiện diện và cách đánh số của các phân vùng trên đĩa
* `pivot_root` — Biến hệ thống tệp cho trước thành hệ thống tệp gốc mới của tiến trình hiện tại
* `prlimit` — Lấy và đặt các giới hạn tài nguyên của một tiến trình
* `readprofile` — Đọc thông tin profiling của kernel
* `rename` — Đổi tên các tệp cho trước, thay một chuỗi bằng chuỗi khác
* `renice` — Thay đổi mức ưu tiên của các tiến trình đang chạy
* `resizepart` — Yêu cầu kernel Linux thay đổi kích thước một phân vùng
* `rev` — Đảo ngược các dòng của một tệp cho trước
* `rfkill` — Công cụ để bật và tắt các thiết bị không dây
* `rtcwake` — Dùng để đưa hệ thống vào trạng thái ngủ cho đến thời điểm đánh thức chỉ định
* `script` — Tạo typescript (bản ghi) của một phiên terminal
* `scriptlive` — Chạy lại các typescript của phiên dựa trên thông tin thời gian
* `scriptreplay` — Phát lại các typescript dựa trên thông tin thời gian
* `setarch` — Thay đổi kiến trúc được báo cáo trong môi trường chương trình mới, và đặt các cờ personality
* `setsid` — Chạy chương trình cho trước trong một phiên mới
* `setterm` — Đặt các thuộc tính của terminal
* `sfdisk` — Một công cụ thao tác bảng phân vùng đĩa
* `sulogin` — Cho phép `root` đăng nhập; thường được `init` gọi khi hệ thống chuyển sang chế độ một người dùng
* `swaplabel` — Thay đổi UUID và nhãn của vùng swap
* `swapoff` — Vô hiệu hóa các thiết bị và tệp dùng cho paging và swapping
* `swapon` — Bật các thiết bị và tệp dùng cho paging và swapping, và liệt kê các thiết bị và tệp đang dùng
* `switch_root` — Chuyển sang một hệ thống tệp khác làm gốc của cây mount
* `taskset` — Lấy hoặc đặt CPU affinity của một tiến trình
* `uclampset` — Thao tác với các thuộc tính utilization clamping của hệ thống hoặc của một tiến trình
* `ul` — Bộ lọc chuyển dấu gạch dưới thành các chuỗi escape biểu thị gạch chân cho terminal đang dùng
* `umount` — Ngắt kết nối một hệ thống tệp khỏi cây tệp của hệ thống
* `uname26` — Một liên kết mềm tới setarch
* `unshare` — Chạy một chương trình với một số namespace không còn chia sẻ với tiến trình cha
* `utmpdump` — Hiển thị nội dung tệp đăng nhập cho trước theo định dạng dễ đọc
* `uuidd` — Một daemon được thư viện UUID dùng để tạo UUID theo thời gian một cách an toàn và đảm bảo duy nhất
* `uuidgen` — Tạo UUID mới. Mỗi UUID mới là một số ngẫu nhiên, với xác suất cực cao là duy nhất trong mọi UUID đã được tạo, trên hệ thống cục bộ lẫn các hệ thống khác, trong quá khứ lẫn tương lai (có thể có 2128 UUID)
* `uuidparse` — Tiện ích để phân tích các mã định danh duy nhất
* `wall` — Hiển thị nội dung của một tệp, hoặc mặc định là đầu vào chuẩn của nó, trên terminal của mọi người dùng đang đăng nhập
* `wdctl` — Hiển thị trạng thái watchdog phần cứng
* `whereis` — Báo vị trí của tệp nhị phân, mã nguồn và trang man cho lệnh cho trước
* `wipefs` — Xóa chữ ký hệ thống tệp khỏi một thiết bị
* `x86_64` — Một liên kết mềm tới setarch
* `zramctl` — Chương trình để thiết lập và điều khiển các thiết bị zram (đĩa RAM nén)
* `libblkid` — Chứa các hàm để nhận dạng thiết bị và trích xuất token
* `libfdisk` — Chứa các hàm để thao tác bảng phân vùng
* `libmount` — Chứa các hàm để mount và umount thiết bị khối
* `libsmartcols` — Chứa các hàm hỗ trợ xuất màn hình dạng bảng
* `libuuid` — Chứa các hàm để tạo mã định danh duy nhất cho các đối tượng có thể truy cập vượt ra ngoài hệ thống cục bộ

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/util-linux.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/util-linux.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/util-linux.html)
