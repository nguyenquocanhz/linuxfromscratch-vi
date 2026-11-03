---
title: Boot thử bằng QEMU trước khi đụng tới GRUB
pages: chapter10/grub.html, chapter11/reboot.html
tags: kernel, máy ảo
---
Cài GRUB sai có thể làm hệ thống chủ không boot được. Nếu bạn làm LFS trên file ảnh đĩa (trick ở Chương 2), boot thử thẳng kernel bằng QEMU, không cần GRUB:

```bash
qemu-system-x86_64 -enable-kvm -m 2G -smp 2 \
  -kernel $LFS/boot/vmlinuz-6.16.1-lfs-12.4 \
  -append "root=/dev/vda1 ro console=ttyS0" \
  -drive file=$HOME/lfs.img,format=raw,if=virtio \
  -nographic
```

Kernel cần bật sẵn (built-in) `CONFIG_VIRTIO_BLK`, `CONFIG_VIRTIO_PCI` và `CONFIG_SERIAL_8250_CONSOLE`. Thoát QEMU: `Ctrl+A` rồi `X`. Boot được rồi mới cài GRUB thật.
