---
title: Tắt máy giữa chừng? Checklist vào lại chroot
pages: chapter07/kernfs.html, chapter07/chroot.html, chapter08/introduction.html
tags: chroot
---
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
