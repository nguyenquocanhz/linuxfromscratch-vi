---
description: "Giờ toàn bộ phần mềm đã được cài, đã đến lúc khởi động lại máy tính. Tuy nhiên, vẫn còn vài thứ cần kiểm tra. Sau đây là một số gợi ý:"
---

<details>

<summary>Trick lỏ: Boot thử bằng QEMU trước khi đụng tới GRUB</summary>

Cài GRUB sai có thể làm hệ thống chủ không boot được. Nếu bạn làm LFS trên file ảnh đĩa (trick ở Chương 2), boot thử thẳng kernel bằng QEMU, không cần GRUB:

```bash
qemu-system-x86_64 -enable-kvm -m 2G -smp 2 \
  -kernel $LFS/boot/vmlinuz-6.16.1-lfs-12.4 \
  -append "root=/dev/vda1 ro console=ttyS0" \
  -drive file=$HOME/lfs.img,format=raw,if=virtio \
  -nographic
```

Kernel cần bật sẵn (built-in) `CONFIG_VIRTIO_BLK`, `CONFIG_VIRTIO_PCI` và `CONFIG_SERIAL_8250_CONSOLE`. Thoát QEMU: `Ctrl+A` rồi `X`. Boot được rồi mới cài GRUB thật.

[Tất cả trick lỏ →](../trick-lo.md#boot-qemu)

</details>

# 11.3. Khởi động lại hệ thống

Giờ toàn bộ phần mềm đã được cài, đã đến lúc khởi động lại máy tính. Tuy nhiên, vẫn còn vài thứ cần kiểm tra. Sau đây là một số gợi ý:

* Cài mọi [firmware](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/firmware.html) cần thiết nếu driver kernel cho phần cứng của bạn cần một số tệp firmware để hoạt động đúng.
* Đảm bảo người dùng `root` đã được đặt mật khẩu.
* Lúc này cũng nên xem lại các tệp cấu hình sau.

  * /etc/fstab
  * /etc/hosts
  * /etc/inputrc
  * /etc/profile
  * /etc/resolv.conf
  * /etc/vimrc
  * /etc/sysconfig/ifconfig.eth0

Nói vậy là đủ rồi, giờ hãy khởi động hệ thống LFS mới tinh của chúng ta lần đầu tiên! *Trước hết hãy thoát khỏi môi trường chroot*:

```bash
logout
```

Sau đó umount các hệ thống tệp ảo:

```bash
umount -v $LFS/dev/pts
mountpoint -q $LFS/dev/shm && umount -v $LFS/dev/shm
umount -v $LFS/dev
umount -v $LFS/run
umount -v $LFS/proc
umount -v $LFS/sys
```

Nếu bạn đã tạo nhiều phân vùng, hãy umount các phân vùng khác trước khi umount phân vùng chính, như sau:

```bash
umount -v $LFS/home
umount -v $LFS
```

Umount chính hệ thống tệp LFS:

```bash
umount -v $LFS
```

Bây giờ, hãy khởi động lại hệ thống.

Giả sử trình nạp khởi động GRUB đã được thiết lập như đã nêu ở trên, menu sẽ được đặt để tự động khởi động *LFS 12.4*.

Khi khởi động lại xong, hệ thống LFS đã sẵn sàng sử dụng. Bạn sẽ thấy một dấu nhắc đơn giản “login: ”. Đến đây, bạn có thể chuyển sang [sách BLFS](https://www.linuxfromscratch.org/blfs/view/12.4/) để thêm phần mềm theo nhu cầu của mình.

Nếu lần khởi động lại của bạn **không** thành công, đã đến lúc xử lý sự cố. Để tìm gợi ý giải quyết các vấn đề khởi động ban đầu, xem [https://www.linuxfromscratch.org/lfs/troubleshooting.html](https://www.linuxfromscratch.org/lfs/troubleshooting.html).

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter11/reboot.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter11/reboot.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter11/reboot.html)
