---
description: "Dựng kernel gồm vài bước: cấu hình, biên dịch và cài đặt. Hãy đọc tệp README trong cây mã nguồn kernel để biết các cách cấu hình kernel khác ngoài cách sác"
---

<details>

<summary>Trick lỏ: Cấu hình kernel không mất cả buổi chiều</summary>

`make menuconfig` từ đầu với hàng nghìn tùy chọn là cực hình. Hai đường tắt:

* **Máy ảo QEMU/KVM**: `make defconfig` rồi `make kvm_guest.config`, sau đó vào `menuconfig` bật thêm những mục sách yêu cầu (ví dụ `CONFIG_DEVTMPFS`, ext4 dựng sẵn, không làm module).
* **Máy thật**: lấy cấu hình của distro đang chạy rồi thu gọn theo những module đang dùng:

```bash
cp /boot/config-$(uname -r) .config     # chạy trên hệ thống chủ, trước khi chroot
make olddefconfig
make localmodconfig                     # chỉ giữ module đang được nạp
```

Driver ổ đĩa và hệ thống file của phân vùng root phải là `*` (built-in), **không phải** `M`. Nếu không kernel sẽ panic với lỗi `VFS: Unable to mount root fs` vì LFS không có initramfs.

[Tất cả trick lỏ →](../trick-lo.md#kernel-config)

</details>

# 10.3. Linux-6.16.1

Gói Linux chứa kernel Linux.

* **Thời gian dựng ước tính:** 0.4 - 32 SBU (thường khoảng 2.5 SBU)
* **Dung lượng đĩa cần:** 1.7 - 14 GB (thường khoảng 2.3 GB)

## 10.3.1. Cài đặt kernel

Dựng kernel gồm vài bước: cấu hình, biên dịch và cài đặt. Hãy đọc tệp `README` trong cây mã nguồn kernel để biết các cách cấu hình kernel khác ngoài cách sách này dùng.

{% hint style="warning" %}
**Quan trọng**

Dựng kernel Linux lần đầu là một trong những việc thử thách nhất trong LFS. Làm đúng hay không còn tùy vào phần cứng cụ thể của hệ thống đích và nhu cầu riêng của bạn. Kernel có gần 12.000 mục cấu hình, dù hầu hết máy tính chỉ cần khoảng một phần ba trong số đó. Các biên tập viên LFS khuyên người dùng chưa quen quy trình này nên làm theo các bước dưới đây khá sát. Mục tiêu là đưa hệ thống ban đầu đến mức bạn có thể đăng nhập ở dòng lệnh khi khởi động lại ở [Mục 11.3, “Rebooting the System.”](../chapter11/reboot.md) Ở giai đoạn này, tối ưu hóa và tùy biến chưa phải là mục tiêu.

Để biết thông tin chung về cấu hình kernel, xem [https://www.linuxfromscratch.org/hints/downloads/files/kernel-configuration.txt](https://www.linuxfromscratch.org/hints/downloads/files/kernel-configuration.txt). Bạn có thể tìm thêm thông tin về cấu hình và dựng kernel tại [https://anduin.linuxfromscratch.org/LFS/kernel-nutshell/](https://anduin.linuxfromscratch.org/LFS/kernel-nutshell/). Các tài liệu này hơi cũ nhưng vẫn cho cái nhìn tổng quan hợp lý về quy trình.

Nếu mọi cách đều thất bại, bạn có thể nhờ giúp trên danh sách thư [lfs-support](https://www.linuxfromscratch.org/mail.html). Lưu ý bạn phải đăng ký thì mới gửi được, để danh sách tránh thư rác.
{% endhint %}

Chuẩn bị biên dịch bằng cách chạy lệnh sau:

```bash
make mrproper
```

Lệnh này đảm bảo cây kernel hoàn toàn sạch. Nhóm kernel khuyến nghị chạy lệnh này trước mỗi lần biên dịch kernel. Đừng tin rằng cây mã nguồn đã sạch sau khi giải nén.

Có nhiều cách cấu hình các tùy chọn kernel. Thường thì việc này được thực hiện qua giao diện menu, ví dụ:

```bash
make menuconfig
```

**Ý nghĩa của các biến môi trường make tùy chọn:**

**`LANG=<host_LANG_value> LC_ALL=`**

> Lệnh này thiết lập locale theo locale của máy host. Điều này có thể cần để giao diện ncurses của menuconfig vẽ đúng các đường kẻ trên console văn bản Linux dùng UTF-8.

> Nếu dùng, hãy nhớ thay `<host_LANG_value>` bằng giá trị của biến `$LANG` trên máy host. Bạn cũng có thể dùng giá trị `$LC_ALL` hoặc `$LC_CTYPE` của host.

**`make menuconfig`**

> Lệnh này mở giao diện menu ncurses. Với các giao diện khác (đồ họa), hãy gõ `make help`.

{% hint style="info" %}
**Ghi chú**

Một điểm khởi đầu tốt để thiết lập cấu hình kernel là chạy `make defconfig`. Lệnh này đưa cấu hình cơ bản về trạng thái tốt, có tính đến kiến trúc hệ thống hiện tại của bạn.

Hãy bật/tắt/đặt các tính năng sau, nếu không hệ thống có thể hoạt động sai hoặc không khởi động được:

```text
General setup --->
  [ ] Compile the kernel with warnings as errors                        [WERROR]
  CPU/Task time and stats accounting --->
    [*] Pressure stall information tracking                                [PSI]
    [ ]   Require boot parameter to enable pressure stall information tracking
                                                     ...  [PSI_DEFAULT_DISABLED]
  < > Enable kernel headers through /sys/kernel/kheaders.tar.xz      [IKHEADERS]
  [*] Control Group support --->                                       [CGROUPS]
    [*] Memory controller                                                [MEMCG]
  [ ] Configure standard kernel features (expert users) --->            [EXPERT]

Processor type and features --->
  [*] Build a relocatable kernel                                   [RELOCATABLE]
  [*]   Randomize the address of the kernel image (KASLR)       [RANDOMIZE_BASE]

General architecture-dependent options --->
  [*] Stack Protector buffer overflow detection                 [STACKPROTECTOR]
  [*]   Strong Stack Protector                           [STACKPROTECTOR_STRONG]

Device Drivers --->
  Generic Driver Options --->
    [ ] Support for uevent helper                                [UEVENT_HELPER]
    [*] Maintain a devtmpfs filesystem to mount at /dev               [DEVTMPFS]
    [*]   Automount devtmpfs at /dev, after the kernel mounted the rootfs
                                                           ...  [DEVTMPFS_MOUNT]
  Firmware Drivers --->
    [*] Mark VGA/VBE/EFI FB as generic system framebuffer       [SYSFB_SIMPLEFB]
  Graphics support --->
    <*>    Direct Rendering Manager (XFree86 4.1.0 and higher DRI support) --->
                                                                      ...  [DRM]
    [*]    Display a user-friendly message when a kernel panic occurs
                                                                ...  [DRM_PANIC]
    (kmsg)   Panic screen formatter                           [DRM_PANIC_SCREEN]
    Supported DRM clients --->
      [*] Enable legacy fbdev support for your modesetting driver
                                                      ...  [DRM_FBDEV_EMULATION]
    Drivers for system framebuffers --->
      <*> Simple framebuffer driver                              [DRM_SIMPLEDRM]
    Console display driver support --->
      [*] Framebuffer Console support                      [FRAMEBUFFER_CONSOLE]
```

Hãy bật thêm một số tính năng nếu bạn dựng hệ thống 64-bit. Nếu dùng menuconfig, hãy bật theo thứ tự `CONFIG_PCI_MSI` trước, rồi `CONFIG_IRQ_REMAP`, cuối cùng là `CONFIG_X86_X2APIC`, vì một tùy chọn chỉ hiện ra sau khi các phụ thuộc của nó được chọn.

```text
Processor type and features --->
  [*] x2APIC interrupt controller architecture support              [X86_X2APIC]

Device Drivers --->
  [*] PCI support --->                                                     [PCI]
    [*] Message Signaled Interrupts (MSI and MSI-X)                    [PCI_MSI]
  [*] IOMMU Hardware Support --->                                [IOMMU_SUPPORT]
    [*] Support for Interrupt Remapping                              [IRQ_REMAP]
```

Nếu phân vùng của hệ thống LFS nằm trên SSD NVME (tức device node của phân vùng là `/dev/nvme*` thay vì `/dev/sd*`), hãy bật hỗ trợ NVME, nếu không hệ thống LFS sẽ không khởi động được:

```text
Device Drivers --->
  NVME Support --->
    <*> NVM Express block device                                  [BLK_DEV_NVME]
```
{% endhint %}

Tùy yêu cầu của hệ thống, bạn có thể muốn thêm vài tùy chọn khác. Danh sách các tùy chọn cần cho gói BLFS có trong [BLFS Index of Kernel Settings](https://www.linuxfromscratch.org/blfs/view/12.4/longindex.html#kernel-config-index).

{% hint style="info" %}
**Ghi chú**

Nếu phần cứng host của bạn dùng UEFI và bạn muốn khởi động hệ thống LFS bằng UEFI, bạn nên chỉnh một số cấu hình kernel theo [trang BLFS](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/grub-setup.html#uefi-kernel) **ngay cả khi bạn dùng bootloader UEFI của distro host**.
{% endhint %}

**Lý do của các mục cấu hình trên:**

**`Randomize the address of the kernel image (KASLR)`**

> Bật ASLR cho ảnh kernel, nhằm giảm thiểu một số kiểu tấn công dựa trên địa chỉ cố định của dữ liệu hoặc mã nhạy cảm trong kernel.

**`Compile the kernel with warnings as errors`**

> Mục này có thể gây lỗi khi dựng nếu trình biên dịch và/hoặc cấu hình khác với của các nhà phát triển kernel.

**`Enable kernel headers through /sys/kernel/kheaders.tar.xz`**

> Mục này yêu cầu có `cpio` khi dựng kernel. LFS không cài `cpio`.

**`Configure standard kernel features (expert users)`**

> Mục này làm một số tùy chọn hiện ra trong giao diện cấu hình, nhưng thay đổi các tùy chọn đó có thể nguy hiểm. Đừng dùng nếu bạn không biết mình đang làm gì.

**`Strong Stack Protector`**

> Bật SSP cho kernel. Chúng ta đã bật nó cho toàn bộ userspace bằng `--enable-default-ssp` khi cấu hình GCC, nhưng kernel không dùng thiết lập SSP mặc định của GCC. Ở đây ta bật nó một cách tường minh.

**`Support for uevent helper`**

> Bật tùy chọn này có thể gây nhiễu việc quản lý thiết bị khi dùng Udev.

**`Maintain a devtmpfs`**

> Mục này tạo tự động các device node do kernel điền, ngay cả khi Udev không chạy. Udev chạy bên trên đó, quản lý quyền và thêm symlink. Mục cấu hình này bắt buộc với mọi người dùng Udev.

**`Automount devtmpfs at /dev`**

> Mục này mount góc nhìn của kernel về các thiết bị tại /dev khi chuyển sang hệ thống tệp gốc, ngay trước khi chạy init.

**`Display a user-friendly message when a kernel panic occurs`**

> Mục này giúp kernel hiển thị đúng thông điệp khi xảy ra kernel panic và driver DRM đang chạy hỗ trợ việc đó. Nếu không có, việc chẩn đoán panic sẽ khó hơn: nếu không có driver DRM nào chạy, ta sẽ ở console VGA chỉ chứa được 24 dòng và thông điệp kernel liên quan thường bị đẩy mất; nếu có driver DRM đang chạy, màn hình thường bị hỏng hoàn toàn khi panic. Tính đến Linux-6.12, chưa có driver chuyên dụng nào cho các dòng GPU phổ biến thật sự hỗ trợ việc này, nhưng “Simple framebuffer driver” thì có, và nó chạy trên framebuffer VESA (hoặc EFI) trước khi driver GPU chuyên dụng được nạp. Nếu driver GPU chuyên dụng được dựng thành module (thay vì một phần của ảnh kernel) và không dùng initramfs, chức năng này sẽ hoạt động tốt trước khi hệ thống tệp gốc được mount, và như vậy đã đủ để cung cấp thông tin về hầu hết lỗi cấu hình LFS gây panic (ví dụ thiết lập `root=` sai trong [Mục 10.4, “Using GRUB to Set Up the Boot Process”](grub.md)).

**`Panic screen formatter`**

> Đặt mục này là `kmsg` để đảm bảo các dòng thông điệp kernel cuối cùng được hiển thị khi xảy ra kernel panic. Giá trị mặc định, `user`, khiến kernel chỉ hiển thị thông điệp panic “thân thiện với người dùng”, không giúp ích cho việc chẩn đoán. Lựa chọn thứ ba, `qr_code`, khiến kernel nén các dòng thông điệp cuối thành mã QR rồi hiển thị. Mã QR chứa được nhiều dòng hơn văn bản thuần và có thể giải mã bằng thiết bị ngoài (như điện thoại thông minh). Nhưng nó cần trình biên dịch Rust mà LFS không cung cấp.

**`Mark VGA/VBE/EFI FB as generic system framebuffer` and `Simple framebuffer driver`**

> Hai mục này cho phép dùng framebuffer VESA (hoặc framebuffer EFI nếu khởi động hệ thống LFS qua UEFI) như một thiết bị DRM. Framebuffer VESA sẽ được GRUB thiết lập (hoặc framebuffer EFI được firmware UEFI thiết lập), nhờ đó trình xử lý panic của DRM hoạt động được trước khi driver DRM riêng của GPU được nạp.

**`Enable legacy fbdev support for your modesetting driver` and `Framebuffer Console support`**

> Hai mục này cần để hiển thị console Linux trên GPU chạy bằng driver DRI (Direct Rendering Infrastructure). Vì `CONFIG_DRM` (Direct Rendering Manager) đã được bật, ta cũng nên bật hai tùy chọn này, nếu không sẽ thấy màn hình trống khi driver DRI được nạp.

**`Support x2apic`**

> Hỗ trợ chạy bộ điều khiển ngắt của bộ xử lý x86 64-bit ở chế độ x2APIC. Firmware có thể bật x2APIC trên hệ thống x86 64-bit, và kernel không bật tùy chọn này sẽ bị panic khi khởi động nếu firmware bật x2APIC. Tùy chọn này không có tác dụng nhưng cũng không gây hại nếu firmware tắt x2APIC.

Ngoài ra, `make oldconfig` có thể phù hợp hơn trong một số tình huống. Xem tệp `README` để biết thêm.

Nếu muốn, bạn có thể bỏ qua bước cấu hình kernel bằng cách sao chép tệp cấu hình kernel `.config` từ hệ thống host (nếu có) vào thư mục `linux-6.16.1` đã giải nén. Tuy nhiên, chúng tôi không khuyến khích cách này. Thường tốt hơn là duyệt hết các menu cấu hình và tạo cấu hình kernel từ đầu.

Biên dịch ảnh kernel và các module:

```bash
make
```

Nếu dùng module kernel, có thể cần cấu hình module trong `/etc/modprobe.d`. Thông tin về module và cấu hình kernel nằm ở [Mục 9.3, “Overview of Device and Module Handling”](../chapter09/udev.md) và trong tài liệu kernel ở thư mục `linux-6.16.1/Documentation`. Ngoài ra, [modprobe.d(5)](https://man.archlinux.org/man/modprobe.d.5) cũng có thể đáng đọc.

Trừ khi hỗ trợ module đã bị tắt trong cấu hình kernel, hãy cài các module bằng:

```bash
make modules_install
```

Sau khi biên dịch kernel xong, cần thêm vài bước nữa để hoàn tất cài đặt. Một số tệp cần được sao chép vào thư mục `/boot`.

{% hint style="danger" %}
**Thận trọng**

Nếu bạn quyết định dùng phân vùng `/boot` riêng cho hệ thống LFS (có thể dùng chung phân vùng `/boot` với distro host), các tệp sao chép dưới đây phải được đưa vào đó. Cách dễ nhất là tạo mục cho `/boot` trong `/etc/fstab` trước (đọc mục trước để biết chi tiết), rồi chạy lệnh sau bằng người dùng `root` trong *môi trường chroot*:

```bash
mount /boot
```

Đường dẫn tới device node được lược bỏ trong lệnh vì `mount` có thể đọc nó từ `/etc/fstab`.
{% endhint %}

Đường dẫn tới ảnh kernel có thể khác nhau tùy nền tảng. Bạn có thể đổi tên tệp dưới đây theo ý thích, nhưng phần gốc của tên tệp nên là *vmlinuz* để tương thích với việc thiết lập tự động quá trình khởi động mô tả ở mục sau. Lệnh sau giả định kiến trúc x86:

```bash
cp -iv arch/x86/boot/bzImage /boot/vmlinuz-6.16.1-lfs-12.4
```

`System.map` là tệp ký hiệu của kernel. Nó ánh xạ điểm vào của mọi hàm trong API kernel, cũng như địa chỉ của các cấu trúc dữ liệu kernel cho kernel đang chạy. Nó được dùng làm tài liệu tham khảo khi điều tra sự cố kernel. Hãy chạy lệnh sau để cài tệp map:

```bash
cp -iv System.map /boot/System.map-6.16.1
```

Tệp cấu hình kernel `.config` tạo ra ở bước `make menuconfig` phía trên chứa toàn bộ lựa chọn cấu hình cho kernel vừa biên dịch. Nên giữ tệp này để tham khảo sau này:

```bash
cp -iv .config /boot/config-6.16.1
```

Cài tài liệu cho kernel Linux:

```bash
cp -r Documentation -T /usr/share/doc/linux-6.16.1
```

Cần lưu ý rằng các tệp trong thư mục mã nguồn kernel không thuộc sở hữu của *root*. Mỗi khi một gói được giải nén bằng người dùng *root* (như ta đã làm trong chroot), các tệp mang ID người dùng và nhóm của máy người đóng gói. Điều này thường không thành vấn đề với các gói khác vì cây mã nguồn bị xóa sau khi cài đặt. Tuy nhiên, cây mã nguồn Linux thường được giữ lại rất lâu. Vì vậy, có khả năng ID người dùng nào đó của người đóng gói sẽ được gán cho một ai đó trên máy. Người đó khi ấy sẽ có quyền ghi vào mã nguồn kernel.

{% hint style="info" %}
**Ghi chú**

Trong nhiều trường hợp, cấu hình kernel sẽ cần cập nhật cho các gói cài sau này trong BLFS. Khác với các gói khác, không cần xóa cây mã nguồn kernel sau khi cài kernel mới dựng.

Nếu định giữ lại cây mã nguồn kernel, hãy chạy `chown -R 0:0` trên thư mục `linux-6.16.1` để đảm bảo mọi tệp thuộc sở hữu của người dùng *root*.

Nếu bạn cập nhật cấu hình và dựng lại kernel từ cây mã nguồn kernel được giữ lại, thông thường bạn **không** nên chạy lệnh `make mrproper`. Lệnh này sẽ xóa tệp `.config` và mọi tệp `.o` của lần dựng trước. Dù dễ dàng khôi phục `.config` từ bản sao trong `/boot`, việc xóa hết các tệp `.o` vẫn là lãng phí: với một thay đổi cấu hình nhỏ, thường chỉ vài tệp `.o` cần dựng (lại) và hệ thống dựng kernel sẽ bỏ qua đúng các tệp `.o` khác nếu chúng không bị xóa.

Ngược lại, nếu bạn đã nâng cấp GCC, hãy chạy `make clean` để xóa mọi tệp `.o` của lần dựng trước, nếu không lần dựng mới có thể thất bại.
{% endhint %}

{% hint style="danger" %}
**Cảnh báo**

Một số tài liệu kernel khuyên tạo symlink `/usr/src/linux` trỏ tới thư mục mã nguồn kernel. Cách này chỉ dành cho kernel trước dòng 2.6 và *không được* tạo trên hệ thống LFS, vì nó có thể gây vấn đề cho các gói bạn muốn dựng sau khi hệ thống LFS cơ bản hoàn tất.
{% endhint %}

## 10.3.2. Cấu hình thứ tự nạp module Linux

Phần lớn thời gian module Linux được nạp tự động, nhưng đôi khi cần chỉ dẫn cụ thể. Chương trình nạp module, `modprobe` hoặc `insmod`, dùng `/etc/modprobe.d/usb.conf` cho mục đích này. Cần tạo tệp này để nếu các driver USB (ehci\_hcd, ohci\_hcd và uhci\_hcd) được dựng thành module, chúng sẽ được nạp đúng thứ tự; ehci\_hcd cần được nạp trước ohci\_hcd và uhci\_hcd để tránh cảnh báo khi khởi động.

Tạo tệp mới `/etc/modprobe.d/usb.conf` bằng cách chạy:

```bash
install -v -m755 -d /etc/modprobe.d
cat > /etc/modprobe.d/usb.conf << "EOF"
# Begin /etc/modprobe.d/usb.conf

install ohci_hcd /sbin/modprobe ehci_hcd ; /sbin/modprobe -i ohci_hcd ; true
install uhci_hcd /sbin/modprobe ehci_hcd ; /sbin/modprobe -i uhci_hcd ; true

# End /etc/modprobe.d/usb.conf
EOF
```

## 10.3.3. Nội dung của Linux

* **Tệp được cài:** config-6.16.1, vmlinuz-6.16.1-lfs-12.4, and System.map-6.16.1
* **Thư mục được cài:** /lib/modules, /usr/share/doc/linux-6.16.1

### Mô tả ngắn

* `config-6.16.1` — Chứa toàn bộ các lựa chọn cấu hình cho kernel
* `vmlinuz-6.16.1-lfs-12.4` — Động cơ của hệ thống Linux. Khi bật máy, kernel là phần đầu tiên của hệ điều hành được nạp. Nó phát hiện và khởi tạo mọi thành phần phần cứng của máy tính, rồi cung cấp các thành phần đó cho phần mềm dưới dạng một cây tệp, và biến một CPU duy nhất thành máy đa nhiệm có thể chạy hàng chục chương trình dường như cùng lúc
* `System.map-6.16.1` — Danh sách các địa chỉ và ký hiệu; nó ánh xạ điểm vào và địa chỉ của mọi hàm và cấu trúc dữ liệu trong kernel

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter10/kernel.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter10/kernel.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter10/kernel.html)
