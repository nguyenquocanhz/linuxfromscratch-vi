---
description: Mẹo thực chiến khi làm Linux From Scratch — của cộng đồng, không thuộc sách gốc.
---

# Trick lỏ

Mẹo "lỏ" nhưng chạy được: đường tắt, thói quen an toàn và những lỗi kinh điển mà người làm LFS hay gặp. Đây là mẹo của cộng đồng, **không phải nội dung sách gốc** — đọc hiểu trước khi dùng.

## [Đừng làm trên máy thật — dựng LFS trong máy ảo hoặc file ảnh đĩa](#chay-trong-may-ao)

Lần đầu làm LFS, gõ nhầm một lệnh với quyền root là đủ hỏng hệ thống chủ. Cách an toàn nhất:

* Cài một distro nhẹ (Debian, Ubuntu Server, Fedora...) trong **VirtualBox/QEMU/VMware** rồi làm LFS trong đó. Snapshot máy ảo trước mỗi chương lớn.
* Không muốn chia lại ổ cứng? Dùng **file ảnh đĩa** thay cho phân vùng thật:

```bash
truncate -s 30G ~/lfs.img                       # file thưa, chỉ tốn chỗ khi ghi thật
sudo losetup -fP --show ~/lfs.img               # in ra ví dụ /dev/loop0
sudo fdisk /dev/loop0                           # tạo phân vùng như sách hướng dẫn
sudo mkfs -v -t ext4 /dev/loop0p1
```

Sau này file `lfs.img` boot thẳng được bằng QEMU (xem trick ở Chương 10). Gỡ bằng `sudo losetup -d /dev/loop0`.

Dùng ở: [2.2. Yêu cầu đối với hệ thống host](chapter02/hostreqs.md), [2.4. Tạo phân vùng mới](chapter02/creatingpartition.md)

## [Luôn kiểm tra $LFS trước khi chạy lệnh nguy hiểm](#kiem-tra-bien-lfs)

Lỗi kinh điển nhất của LFS: mở terminal mới, quên `export LFS=/mnt/lfs`, rồi chạy `chown -R root:root $LFS/...` hoặc `rm -rf $LFS/...`. Khi `$LFS` rỗng, lệnh đó chạy thẳng trên **thư mục gốc của máy chủ**.

Thói quen nên có:

```bash
echo "LFS=$LFS"                 # nhìn bằng mắt trước mỗi phiên
set -u                          # biến chưa đặt -> shell báo lỗi thay vì coi là chuỗi rỗng
alias lfscheck='[ "$LFS" = /mnt/lfs ] && echo OK || echo "LFS SAI: [$LFS]"'
```

Ghi `export LFS=/mnt/lfs` vào `~/.bash_profile` của **cả root lẫn lfs** để khỏi quên.

Dùng ở: [2.6. Đặt biến $LFS và umask](chapter02/aboutlfs.md), [4.3. Thêm người dùng LFS](chapter04/addinguser.md), [7.2. Đổi chủ sở hữu](chapter07/changingowner.md)

## [Tải toàn bộ mã nguồn nhanh và kiểm tra một lần](#tai-nguon-nhanh)

Sách cho sẵn file `wget-list-sysv` và `md5sums`. Tải song song cho nhanh (cần gói `aria2`):

```bash
cd $LFS/sources
wget https://www.linuxfromscratch.org/lfs/view/12.4/wget-list-sysv
wget https://www.linuxfromscratch.org/lfs/view/12.4/md5sums
aria2c -x4 -j8 -c -i wget-list-sysv     # -c: tải tiếp nếu đứt mạng
md5sum -c md5sums | grep -v ': OK$'     # chỉ in file lỗi; không in gì = ngon
```

Có file tải hỏng từ server gốc? Mỗi gói thường có mirror khác trên trang dự án; tải tay rồi chạy lại `md5sum -c`. Mẹo thêm: nén cả thư mục `sources` lại cất đi — lần làm LFS thứ hai khỏi tải lại.

Dùng ở: [3.1. Giới thiệu](chapter03/introduction.md), [3.2. Tất cả các gói](chapter03/packages.md)

## [Dùng tmux và ghi log để không mất công khi rớt SSH](#tmux-va-log)

GCC hay Glibc dựng mất hàng chục phút. SSH rớt giữa chừng là mất luôn tiến trình và phải làm lại. Chạy mọi thứ trong `tmux`:

```bash
tmux new -s lfs        # tạo phiên
# ... rớt mạng ...
tmux attach -t lfs     # vào lại, mọi thứ vẫn chạy
```

Ghi log từng gói để khi lỗi còn có cái mà đọc (và đo luôn SBU):

```bash
mkdir -p $LFS/logs
{ time { ../configure --prefix=/usr && make && make install; } ; } 2>&1 | tee $LFS/logs/tengoi.log
```

Lưu ý: `tee` nuốt mã lỗi của `make`. Muốn dừng khi lỗi thì thêm `set -o pipefail` vào shell.

Dùng ở: [4.5. Về SBU](chapter04/aboutsbus.md), [Hướng dẫn biên dịch chung](partintro/generalinstructions.md)

## [Viết một hàm nhỏ để giải nén – dựng – dọn, khỏi quên bước](#ham-build)

Quy trình cho mỗi gói luôn là: giải nén → `cd` vào → làm theo sách → quay ra → **xóa thư mục nguồn**. Quên bước xóa là lần dựng sau dùng nhầm thư mục cũ. Đặt hàm này vào `~/.bashrc`:

```bash
pkg() {   # dùng: pkg gcc-15.2.0.tar.xz
  cd $LFS/sources || return
  local dir; dir=$(tar -tf "$1" | head -1 | cut -d/ -f1)
  rm -rf "$dir" && tar -xf "$1" && cd "$dir" && echo ">>> Đang ở $(pwd)"
}
done_pkg() { local d; d=$(basename "$PWD"); cd $LFS/sources && rm -rf "$d" && echo ">>> Đã dọn $d"; }
```

Trong chroot (Chương 7 trở đi) `$LFS` không còn — dùng `/sources` thay cho `$LFS/sources`. Đừng tự động hoá hết từ lần đầu: gõ tay từng lệnh mới hiểu được LFS, đó mới là mục đích.

Dùng ở: [Hướng dẫn biên dịch chung](partintro/generalinstructions.md), [5.1. Giới thiệu](chapter05/introduction.md)

## [Alias kiểm tra nhanh toolchain sau mỗi gói quan trọng](#kiem-tra-toolchain)

Sách có bước "sanity check" sau Glibc. Gói nó thành alias để chạy lại bất cứ lúc nào (ví dụ sau khi dựng libstdc++ hoặc khi nghi toolchain hỏng):

```bash
alias lfstc='echo "int main(){}" | $LFS_TGT-gcc -x c - -o /tmp/lfstc && readelf -l /tmp/lfstc | grep ld-linux; rm -f /tmp/lfstc'
```

Kết quả đúng phải có `[Requesting program interpreter: /lib64/ld-linux-x86-64.so.2]`. Không ra dòng nào, hoặc ra đường dẫn của hệ thống chủ → **dừng lại**, đừng làm tiếp, quay lại kiểm tra từng bước trước. Trong chroot ở Chương 8 thì dùng `gcc` thay cho `$LFS_TGT-gcc`.

Dùng ở: [5.5. Glibc-2.42](chapter05/glibc.md), [5.6. Libstdc++ từ GCC-15.2.0](chapter05/gcc-libstdc++.md), [8.29. GCC-15.2.0](chapter08/gcc.md)

## [Sao lưu sau Chương 7 bằng zstd — nhanh hơn xz rất nhiều](#backup-zstd)

Sách gợi ý nén `$LFS` bằng `xz`, khá chậm trên máy yếu. `zstd` nén gần tốt bằng mà nhanh gấp nhiều lần (nhớ thoát chroot và umount các hệ thống file ảo trước, đúng như sách dặn):

```bash
cd $LFS
tar --exclude=./sources -cf - . | zstd -T0 -10 > $HOME/lfs-ch7.tar.zst
# khôi phục:
cd $LFS && rm -rf ./* && zstd -dc $HOME/lfs-ch7.tar.zst | tar -xpf -
```

Làm trong máy ảo thì còn nhàn hơn: chụp **snapshot** máy ảo ở mốc này, hỏng gì ở Chương 8 thì quay lại trong vài giây.

Dùng ở: [7.13. Dọn dẹp và lưu lại hệ thống tạm](chapter07/cleanup.md)

## [Tắt máy giữa chừng? Checklist vào lại chroot](#vao-lai-chroot)

Tắt máy rồi bật lại, mọi mount đều mất. Lưu đoạn này thành `~/vao-lfs.sh` rồi chạy bằng root (đổi `/dev/sdb2` thành phân vùng của bạn):

```bash
#!/bin/bash
set -e
export LFS=/mnt/lfs
mountpoint -q $LFS || mount -v -t ext4 /dev/sdb2 $LFS
mountpoint -q $LFS/dev || mount -v --bind /dev $LFS/dev
mountpoint -q $LFS/dev/pts || mount -vt devpts devpts -o gid=5,mode=0620 $LFS/dev/pts
mountpoint -q $LFS/proc || mount -vt proc proc $LFS/proc
mountpoint -q $LFS/sys || mount -vt sysfs sysfs $LFS/sys
mountpoint -q $LFS/run || mount -vt tmpfs tmpfs $LFS/run
if [ -h $LFS/dev/shm ]; then install -v -d -m 1777 $LFS$(realpath /dev/shm); else mountpoint -q $LFS/dev/shm || mount -vt tmpfs -o nosuid,nodev tmpfs $LFS/dev/shm; fi
chroot "$LFS" /usr/bin/env -i HOME=/root TERM="$TERM" PS1='(lfs chroot) \u:\w\$ ' \
  PATH=/usr/bin:/usr/sbin MAKEFLAGS="-j$(nproc)" TESTSUITEFLAGS="-j$(nproc)" /bin/bash --login
```

Đây đúng là các lệnh trong Mục 7.3 và 7.4, chỉ thêm `mountpoint -q` để chạy lại nhiều lần không bị mount chồng.

Dùng ở: [7.3. Chuẩn bị các hệ thống tệp ảo của kernel](chapter07/kernfs.md), [7.4. Vào môi trường chroot](chapter07/chroot.md), [8.1. Giới thiệu](chapter08/introduction.md)

## [Máy ít RAM bị "Killed" khi dựng GCC? Giảm -j và thêm swap](#it-ram)

`MAKEFLAGS=-j$(nproc)` rất tốt, nhưng mỗi tiến trình biên dịch C++ của GCC có thể ăn cả GB RAM. Máy 4 nhân, 4 GB RAM chạy `-j4` rất dễ bị OOM killer giết, báo lỗi kiểu `g++: fatal error: Killed signal terminated program cc1plus`.

Quy tắc thô: **mỗi luồng khoảng 1,5–2 GB RAM** cho GCC. Không đủ thì thêm swap file trên hệ thống chủ:

```bash
sudo fallocate -l 8G /swapfile && sudo chmod 600 /swapfile
sudo mkswap /swapfile && sudo swapon /swapfile
```

Hoặc chỉ hạ số luồng cho riêng gói nặng: `make -j2` thay vì `make`.

Dùng ở: [4.4. Thiết lập môi trường](chapter04/settingenvironment.md), [8.29. GCC-15.2.0](chapter08/gcc.md)

## [Bộ kiểm thử — chỗ nào được lười, chỗ nào tuyệt đối không](#kiem-thu)

Chạy hết test ở Chương 8 có thể mất lâu hơn cả thời gian dựng. Ưu tiên thế này:

* **Bắt buộc chạy**: Glibc, GCC, Binutils (và GMP, MPFR như sách nhấn mạnh). Toolchain hỏng thì mọi gói sau đều hỏng theo.
* **Có vài test lỗi là bình thường**: sách luôn liệt kê các test "known to fail". So kết quả của bạn với danh sách đó trước khi hoảng.
* Gói nhỏ (ví dụ man-pages, less) mà bạn vội thì bỏ test cũng chấp nhận được ở lần dựng đầu tiên.

So kết quả với người khác: `../contrib/test_summary | grep -A7 Summ` (GCC) rồi đối chiếu tại trang [buildlogs của LFS](https://www.linuxfromscratch.org/lfs/build-logs/).

Dùng ở: [4.6. Về các bộ kiểm thử](chapter04/abouttestsuites.md), [8.29. GCC-15.2.0](chapter08/gcc.md), [8.5. Glibc-2.42](chapter08/glibc.md)

## [Cho LFS nói tiếng Việt và chạy giờ Việt Nam](#tieng-viet-gio-vn)

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

Dùng ở: [8.5. Glibc-2.42](chapter08/glibc.md), [9.7. Configuring the System Locale](chapter09/locale.md)

## [Biết gói vừa cài những file gì bằng mẹo "dấu thời gian"](#theo-doi-file-cai)

LFS không có trình quản lý gói. Cách đơn giản nhất để biết `make install` rải file đi đâu:

```bash
touch /tmp/truoc-cai
make install
find / -xdev -newer /tmp/truoc-cai -not -path '/proc/*' -not -path '/sys/*' \
     -not -path '/sources/*' -type f > /var/log/pkg-tengoi.list
```

Sau này muốn gỡ gói thì xem file `.list` đó. Nhược điểm: không chính xác nếu có tiến trình khác ghi file cùng lúc. Muốn bài bản hơn, đọc mục "DESTDIR" trong chính trang này.

Dùng ở: [8.2. Quản lý gói](chapter08/pkgmgt.md)

## [Cấu hình kernel không mất cả buổi chiều](#kernel-config)

`make menuconfig` từ đầu với hàng nghìn tùy chọn là cực hình. Hai đường tắt:

* **Máy ảo QEMU/KVM**: `make defconfig` rồi `make kvm_guest.config`, sau đó vào `menuconfig` bật thêm những mục sách yêu cầu (ví dụ `CONFIG_DEVTMPFS`, ext4 dựng sẵn, không làm module).
* **Máy thật**: lấy cấu hình của distro đang chạy rồi thu gọn theo những module đang dùng:

```bash
cp /boot/config-$(uname -r) .config     # chạy trên hệ thống chủ, trước khi chroot
make olddefconfig
make localmodconfig                     # chỉ giữ module đang được nạp
```

Driver ổ đĩa và hệ thống file của phân vùng root phải là `*` (built-in), **không phải** `M`. Nếu không kernel sẽ panic với lỗi `VFS: Unable to mount root fs` vì LFS không có initramfs.

Dùng ở: [10.3. Linux-6.16.1](chapter10/kernel.md)

## [Boot thử bằng QEMU trước khi đụng tới GRUB](#boot-qemu)

Cài GRUB sai có thể làm hệ thống chủ không boot được. Nếu bạn làm LFS trên file ảnh đĩa (trick ở Chương 2), boot thử thẳng kernel bằng QEMU, không cần GRUB:

```bash
qemu-system-x86_64 -enable-kvm -m 2G -smp 2 \
  -kernel $LFS/boot/vmlinuz-6.16.1-lfs-12.4 \
  -append "root=/dev/vda1 ro console=ttyS0" \
  -drive file=$HOME/lfs.img,format=raw,if=virtio \
  -nographic
```

Kernel cần bật sẵn (built-in) `CONFIG_VIRTIO_BLK`, `CONFIG_VIRTIO_PCI` và `CONFIG_SERIAL_8250_CONSOLE`. Thoát QEMU: `Ctrl+A` rồi `X`. Boot được rồi mới cài GRUB thật.

Dùng ở: [10.4. Dùng GRUB để thiết lập quá trình khởi động](chapter10/grub.md), [11.3. Khởi động lại hệ thống](chapter11/reboot.md)

## [Không biết card mạng tên gì? Giữ kiểu eth0 cho d�](#ten-card-mang)

Udev đặt tên card mạng kiểu `enp0s3`, `ens33`... và tên có thể khác giữa máy ảo và máy thật, làm file `/etc/sysconfig/ifconfig.*` của bạn trỏ sai. Hai cách:

* Xem tên thật sau khi boot: `ip link`.
* Hoặc tắt tên "dự đoán được" bằng cách thêm `net.ifnames=0` vào dòng `linux` trong `grub.cfg` → card đầu tiên luôn là `eth0`, và file cấu hình đặt là `/etc/sysconfig/ifconfig.eth0`.

Mạng vẫn không lên? Kiểm tra kernel đã có driver card mạng chưa (`dmesg | grep -i eth`) — máy ảo VirtualBox thường cần `e1000`, QEMU cần `virtio_net`.

Dùng ở: [9.5. General Network Configuration](chapter09/network.md), [9.3. Tổng quan về xử lý thiết bị và module](chapter09/udev.md)

## [Năm lỗi ai làm LFS cũng từng dính](#loi-kinh-dien)

1. **Dựng Chương 5–6 bằng root** thay vì user `lfs` → file cài nhầm vào hệ thống chủ. Gõ `whoami` trước mỗi gói.
2. **Môi trường của user `lfs` không sạch**: file `/etc/bash.bashrc` của hệ thống chủ (Ubuntu, Debian có) chen biến vào. Sách đã bảo đổi tên nó đi — hãy làm thật.
3. **Không xóa thư mục nguồn** sau khi dựng → lần dựng pass 2 dùng lại bản pass 1 đã cấu hình.
4. **Quên `cd build`** với các gói dựng trong thư mục riêng (Binutils, GCC, Glibc) → `configure` chạy sai chỗ, lỗi khó hiểu.
5. **Copy lệnh thiếu dòng** khi lệnh có `\` xuống dòng. Dùng nút "Sao chép" trên trang này để chép trọn khối lệnh.

Hỏi cộng đồng thì gửi kèm: chương/mục, lệnh đã chạy, **20 dòng log cuối** và output của `version-check.sh`.

Dùng ở: [5.2. Binutils-2.45 - Lượt 1](chapter05/binutils-pass1.md), [4.4. Thiết lập môi trường](chapter04/settingenvironment.md), [6.1. Giới thiệu](chapter06/introduction.md)
