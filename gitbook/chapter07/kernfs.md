---
description: "Các ứng dụng chạy trong userspace dùng nhiều hệ thống tệp do kernel tạo ra để giao tiếp với chính kernel. Các hệ thống tệp này là ảo: chúng không dùng dung"
---

<details>

<summary>Trick lỏ: Tắt máy giữa chừng? Checklist vào lại chroot</summary>

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

[Tất cả trick lỏ →](../trick-lo.md#vao-lai-chroot)

</details>

# 7.3. Chuẩn bị các hệ thống tệp ảo của kernel

Các ứng dụng chạy trong userspace dùng nhiều hệ thống tệp do kernel tạo ra để giao tiếp với chính kernel. Các hệ thống tệp này là ảo: chúng không dùng dung lượng đĩa. Nội dung của chúng nằm trong bộ nhớ. Các hệ thống tệp này phải được mount trong cây thư mục $LFS để ứng dụng tìm thấy chúng trong môi trường chroot.

Bắt đầu bằng việc tạo các thư mục nơi những hệ thống tệp ảo này sẽ được mount:

```bash
mkdir -pv $LFS/{dev,proc,sys,run}
```

## 7.3.1. Mount và tạo nội dung cho /dev

Khi một hệ thống LFS khởi động bình thường, kernel tự động mount hệ thống tệp `devtmpfs` lên thư mục `/dev`; kernel tạo các device node trên hệ thống tệp ảo đó trong quá trình khởi động, hoặc khi một thiết bị lần đầu được phát hiện hay truy cập. Daemon udev có thể thay đổi chủ sở hữu hoặc quyền của các device node do kernel tạo, đồng thời tạo device node hoặc symlink mới, để giúp người bảo trì distro và quản trị viên hệ thống đỡ vất vả. (Xem [Mục 9.3.2.2, “Tạo device node”](../chapter09/udev.md#ch-config-udev-device-node-creation) để biết chi tiết.) Nếu kernel của host hỗ trợ `devtmpfs`, ta chỉ cần mount một `devtmpfs` tại `$LFS/dev` và để kernel tự điền nội dung.

Nhưng một số kernel host không hỗ trợ `devtmpfs`; các distro host đó dùng phương pháp khác để tạo nội dung `/dev`. Vì vậy cách duy nhất không phụ thuộc host để điền nội dung thư mục `$LFS/dev` là bind mount thư mục `/dev` của hệ thống host. Bind mount là một kiểu mount đặc biệt giúp một cây thư mục con hoặc một tệp hiện ra ở vị trí khác. Dùng lệnh sau để làm việc này.

```bash
mount -v --bind /dev $LFS/dev
```

## 7.3.2. Mount các hệ thống tệp ảo của kernel

Bây giờ mount các hệ thống tệp ảo còn lại của kernel:

```bash
mount -vt devpts devpts -o gid=5,mode=0620 $LFS/dev/pts
mount -vt proc proc $LFS/proc
mount -vt sysfs sysfs $LFS/sys
mount -vt tmpfs tmpfs $LFS/run
```

**Ý nghĩa của các tùy chọn mount cho devpts:**

**`gid=5`**

> Đảm bảo mọi device node do devpts tạo đều thuộc nhóm có ID 5. Đây là ID chúng ta sẽ dùng sau này cho nhóm `tty`. Ta dùng ID nhóm thay vì tên, vì hệ thống host có thể dùng ID khác cho nhóm `tty` của nó.

**`mode=0620`**

> Đảm bảo mọi device node do devpts tạo có chế độ 0620 (người dùng đọc và ghi được, nhóm ghi được). Kết hợp với tùy chọn trên, điều này đảm bảo devpts tạo ra các device node đáp ứng yêu cầu của grantpt(), nghĩa là chương trình hỗ trợ `pt_chown` của Glibc (không được cài mặc định) là không cần thiết.

Trên một số hệ thống host, `/dev/shm` là symlink tới một thư mục, thường là `/run/shm`. tmpfs /run đã được mount ở trên nên trong trường hợp này chỉ cần tạo một thư mục với quyền đúng.

Trên các hệ thống host khác, `/dev/shm` là điểm mount của một tmpfs. Khi đó, việc mount /dev ở trên chỉ tạo /dev/shm như một thư mục trong môi trường chroot. Trong tình huống này ta phải mount tmpfs một cách tường minh:

```bash
if [ -h $LFS/dev/shm ]; then
  install -v -d -m 1777 $LFS$(realpath /dev/shm)
else
  mount -vt tmpfs -o nosuid,nodev tmpfs $LFS/dev/shm
fi
```

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/kernfs.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/kernfs.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/kernfs.html)
