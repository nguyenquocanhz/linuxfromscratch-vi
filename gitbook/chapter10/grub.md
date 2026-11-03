---
description: "Nếu hệ thống của bạn hỗ trợ UEFI và bạn muốn khởi động LFS bằng UEFI, hãy bỏ qua các hướng dẫn trên trang này, nhưng vẫn nên học cú pháp của grub.cfg và cá"
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

# 10.4. Dùng GRUB để thiết lập quá trình khởi động

{% hint style="info" %}
**Ghi chú**

Nếu hệ thống của bạn hỗ trợ UEFI và bạn muốn khởi động LFS bằng UEFI, hãy bỏ qua các hướng dẫn trên trang này, nhưng vẫn nên học cú pháp của `grub.cfg` và cách chỉ định một phân vùng trong tệp từ trang này, rồi cấu hình GRUB hỗ trợ UEFI theo hướng dẫn ở [trang BLFS](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/grub-setup.html).
{% endhint %}

## 10.4.1. Giới thiệu

{% hint style="danger" %}
**Cảnh báo**

Cấu hình GRUB sai có thể khiến hệ thống của bạn không dùng được nếu không có thiết bị khởi động dự phòng như CD-ROM hoặc USB khởi động. Mục này không bắt buộc để khởi động hệ thống LFS. Bạn có thể chỉ cần chỉnh trình nạp khởi động hiện tại, ví dụ Grub-Legacy, GRUB2 hoặc LILO.
{% endhint %}

Hãy chuẩn bị sẵn một đĩa khởi động khẩn cấp để “cứu” máy tính nếu nó không dùng được (không khởi động được). Nếu chưa có thiết bị khởi động, bạn có thể tự tạo. Để quy trình bên dưới hoạt động, bạn cần nhảy sang BLFS và cài `xorriso` từ gói [libisoburn](https://www.linuxfromscratch.org/blfs/view/12.4/multimedia/libisoburn.html).

```bash
cd /tmp
grub-mkrescue --output=grub-img.iso
xorriso -as cdrecord -v dev=/dev/cdrw blank=as_needed grub-img.iso
```

## 10.4.2. Quy ước đặt tên của GRUB

GRUB dùng cách đặt tên riêng cho ổ đĩa và phân vùng, có dạng *(hdn,m)*, trong đó *n* là số thứ tự ổ cứng và *m* là số thứ tự phân vùng. Số ổ cứng bắt đầu từ không, còn số phân vùng bắt đầu từ một với phân vùng thường (từ năm với phân vùng mở rộng). Lưu ý điều này khác với các phiên bản trước, khi cả hai số đều bắt đầu từ không. Ví dụ, phân vùng `sda1` là *(hd0,1)* theo GRUB còn `sdb3` là *(hd1,3)*. Khác với Linux, GRUB không coi ổ CD-ROM là ổ cứng. Ví dụ, nếu dùng CD ở `hdb` và ổ cứng thứ hai ở `hdc`, ổ cứng thứ hai đó vẫn là *(hd1)*.

## 10.4.3. Thiết lập cấu hình

GRUB hoạt động bằng cách ghi dữ liệu vào track vật lý đầu tiên của ổ cứng. Vùng này không thuộc hệ thống tệp nào. Các chương trình ở đó truy cập module GRUB trong phân vùng boot. Vị trí mặc định là /boot/grub/.

Vị trí của phân vùng boot do người dùng chọn và ảnh hưởng đến cấu hình. Một khuyến nghị là dùng một phân vùng nhỏ riêng (kích thước đề xuất 200 MB) chỉ để chứa thông tin khởi động. Nhờ vậy mỗi bản dựng, dù là LFS hay một distro thương mại, đều truy cập được cùng các tệp boot và có thể truy cập từ bất kỳ hệ thống nào đã khởi động. Nếu chọn cách này, bạn cần mount phân vùng riêng đó, chuyển tất cả tệp trong thư mục `/boot` hiện tại (ví dụ kernel Linux bạn vừa dựng ở mục trước) sang phân vùng mới. Sau đó bạn cần umount phân vùng và mount lại thành `/boot`. Nếu làm vậy, nhớ cập nhật `/etc/fstab`.

Để nguyên `/boot` trên phân vùng LFS hiện tại cũng được, nhưng cấu hình cho nhiều hệ thống sẽ khó hơn.

Dựa vào thông tin trên, hãy xác định ký hiệu phù hợp cho phân vùng gốc (hoặc phân vùng boot, nếu dùng phân vùng riêng). Trong ví dụ dưới đây, giả định phân vùng gốc (hoặc phân vùng boot riêng) là `sda2`.

Cài các tệp GRUB vào `/boot/grub` và thiết lập track khởi động:

{% hint style="danger" %}
**Cảnh báo**

Lệnh sau sẽ ghi đè trình nạp khởi động hiện tại. Đừng chạy lệnh này nếu bạn không muốn vậy, ví dụ khi đang dùng một trình quản lý khởi động của bên thứ ba để quản lý Master Boot Record (MBR).
{% endhint %}

```bash
grub-install /dev/sda
```

{% hint style="info" %}
**Ghi chú**

Nếu hệ thống đã được khởi động bằng UEFI, `grub-install` sẽ cố cài các tệp cho đích *x86\_64-efi*, nhưng các tệp đó chưa được cài ở [Chương 8](../chapter08/chapter08.md). Nếu gặp trường hợp này, hãy thêm `--target i386-pc` vào lệnh trên.
{% endhint %}

## 10.4.4. Tạo tệp cấu hình GRUB

Tạo `/boot/grub/grub.cfg`:

```bash
cat > /boot/grub/grub.cfg << "EOF"
# Begin /boot/grub/grub.cfg
set default=0
set timeout=5

insmod part_gpt
insmod ext2
set root=(hd0,2)
set gfxpayload=1024x768x32

menuentry "GNU/Linux, Linux 6.16.1-lfs-12.4" {
        linux   /boot/vmlinuz-6.16.1-lfs-12.4 root=/dev/sda2 ro
}
EOF
```

Các lệnh `insmod` nạp các module `GRUB` tên `part_gpt` và `ext2`. Dù tên là vậy, `ext2` thực ra hỗ trợ các hệ thống tệp `ext2`, `ext3` và `ext4`. Lệnh `grub-install` đã nhúng sẵn một số module vào ảnh `GRUB` chính (cài vào MBR hoặc phân vùng GRUB BIOS) để truy cập các module khác (trong `/boot/grub/i386-pc`) mà không gặp vấn đề con gà–quả trứng, nên với cấu hình thông thường hai module này đã được nhúng sẵn và hai lệnh `insmod` đó sẽ không làm gì. Nhưng chúng cũng không gây hại, và có thể cần với một số cấu hình hiếm gặp.

Lệnh `set gfxpayload=1024x768x32` đặt độ phân giải và độ sâu màu của framebuffer VESA sẽ được chuyển cho kernel. Điều này cần thiết để driver SimpleDRM của kernel dùng được framebuffer VESA. Bạn có thể dùng độ phân giải hoặc độ sâu màu khác phù hợp hơn với màn hình của mình.

{% hint style="info" %}
**Ghi chú**

Theo góc nhìn của `GRUB`, các tệp kernel được tính tương đối so với phân vùng đang dùng. Nếu bạn dùng phân vùng /boot riêng, hãy bỏ /boot khỏi dòng *linux* ở trên. Bạn cũng cần đổi dòng *set root* để trỏ tới phân vùng boot.
{% endhint %}

{% hint style="info" %}
**Ghi chú**

Ký hiệu GRUB của một phân vùng có thể thay đổi nếu bạn thêm hoặc bớt đĩa (kể cả đĩa rời như USB). Sự thay đổi này có thể gây lỗi khởi động vì `grub.cfg` tham chiếu đến các ký hiệu “cũ”. Nếu muốn tránh vấn đề này, bạn có thể dùng UUID của phân vùng và UUID của hệ thống tệp thay cho ký hiệu GRUB để chỉ định thiết bị. Chạy `lsblk -o UUID,PARTUUID,PATH,MOUNTPOINT` để xem UUID của các hệ thống tệp (ở cột `UUID`) và phân vùng (ở cột `PARTUUID`). Sau đó thay `set root=(hdx,y)` bằng `search --set=root --fs-uuid <UUID of the filesystem where the kernel is installed>`, và thay `root=/dev/sda2` bằng `root=PARTUUID=<UUID of the partition where LFS is built>`.

Lưu ý UUID của một phân vùng hoàn toàn khác với UUID của hệ thống tệp trong phân vùng đó. Một số tài liệu trực tuyến có thể hướng dẫn dùng `root=UUID=<filesystem UUID>` thay cho `root=PARTUUID=<partition UUID>`, nhưng làm vậy sẽ cần initramfs, nằm ngoài phạm vi của LFS.

Tên device node của một phân vùng trong `/dev` cũng có thể thay đổi (ít khả năng hơn so với thay đổi ký hiệu GRUB). Bạn cũng có thể thay đường dẫn tới device node như `/dev/sda1` bằng `PARTUUID=<partition UUID>` trong `/etc/fstab`, để tránh lỗi khởi động tiềm ẩn nếu tên device node đã đổi.
{% endhint %}

GRUB là một chương trình cực kỳ mạnh và cung cấp vô số tùy chọn để khởi động từ nhiều loại thiết bị, hệ điều hành và kiểu phân vùng. Cũng có nhiều tùy chọn tùy biến như màn hình chào đồ họa, phát âm thanh, nhập liệu bằng chuột, v.v. Chi tiết các tùy chọn này nằm ngoài phạm vi của phần giới thiệu này.

{% hint style="danger" %}
**Thận trọng**

Có một lệnh, `grub-mkconfig`, có thể tự động viết tệp cấu hình. Nó dùng một bộ script trong /etc/grub.d/ và sẽ phá hủy mọi tùy biến bạn đã làm. Các script này chủ yếu được thiết kế cho các distro không dựng từ mã nguồn và không được khuyến nghị cho LFS. Nếu bạn cài một bản phân phối Linux thương mại, rất có thể chương trình này sẽ được chạy. Hãy nhớ sao lưu tệp grub.cfg của bạn.
{% endhint %}

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter10/grub.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter10/grub.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter10/grub.html)
