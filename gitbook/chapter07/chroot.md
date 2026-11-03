---
description: "Giờ đây mọi gói cần thiết để dựng phần công cụ còn lại đã có trên hệ thống, đã đến lúc vào môi trường chroot và hoàn tất việc cài các công cụ tạm. Môi trườ"
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

# 7.4. Vào môi trường chroot

Giờ đây mọi gói cần thiết để dựng phần công cụ còn lại đã có trên hệ thống, đã đến lúc vào môi trường chroot và hoàn tất việc cài các công cụ tạm. Môi trường này cũng sẽ được dùng để cài hệ thống cuối cùng. Bằng người dùng `root`, chạy lệnh sau để vào môi trường mà hiện tại chưa có gì ngoài các công cụ tạm:

```bash
chroot "$LFS" /usr/bin/env -i   \
    HOME=/root                  \
    TERM="$TERM"                \
    PS1='(lfs chroot) \u:\w\$ ' \
    PATH=/usr/bin:/usr/sbin     \
    MAKEFLAGS="-j$(nproc)"      \
    TESTSUITEFLAGS="-j$(nproc)" \
    /bin/bash --login
```

Nếu không muốn dùng hết các nhân logic hiện có, hãy thay `$(nproc)` bằng số nhân logic bạn muốn dùng để dựng các gói trong chương này và các chương sau. Bộ kiểm thử của một số gói (đáng chú ý là Autoconf, Libtool và Tar) trong [Chương 8](../chapter08/chapter08.md) không bị ảnh hưởng bởi `MAKEFLAGS`, mà dùng biến môi trường `TESTSUITEFLAGS`. Ở đây ta cũng đặt biến đó để chạy các bộ kiểm thử này với nhiều nhân.

Tùy chọn `-i` truyền cho lệnh `env` sẽ xóa mọi biến trong môi trường chroot. Sau đó chỉ các biến `HOME`, `TERM`, `PS1` và `PATH` được đặt lại. Cấu trúc `TERM=$TERM` đặt biến `TERM` bên trong chroot giống giá trị bên ngoài chroot. Biến này cần để các chương trình như `vim` và `less` hoạt động đúng. Nếu muốn đặt thêm biến khác, như `CFLAGS` hay `CXXFLAGS`, đây là chỗ thích hợp.

Từ giờ trở đi, bạn không cần dùng biến `LFS` nữa vì mọi công việc đều giới hạn trong hệ thống tệp LFS; lệnh `chroot` chạy shell Bash với thư mục gốc (`/`) đặt là `$LFS`.

Lưu ý rằng `/tools/bin` không nằm trong `PATH`. Nghĩa là cross toolchain sẽ không còn được dùng nữa.

Cũng lưu ý rằng dấu nhắc của `bash` sẽ hiện `I have no name!` Điều này bình thường vì tệp `/etc/passwd` chưa được tạo.

{% hint style="info" %}
**Ghi chú**

Điều quan trọng là mọi lệnh trong phần còn lại của chương này và các chương sau phải chạy bên trong môi trường chroot. Nếu vì lý do nào đó (ví dụ khởi động lại máy) bạn thoát khỏi môi trường này, hãy chắc chắn các hệ thống tệp ảo của kernel đã được mount như giải thích trong [Mục 7.3.1, “Mount và tạo nội dung cho /dev”](kernfs.md#ch-tools-bindmount) và [Mục 7.3.2, “Mount các hệ thống tệp ảo của kernel”](kernfs.md#ch-tools-kernfsmount), rồi vào lại chroot trước khi tiếp tục cài đặt.
{% endhint %}

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/chroot.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/chroot.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/chroot.html)
