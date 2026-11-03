---
description: "Nếu hệ thống của bạn hỗ trợ UEFI và bạn muốn khởi động LFS bằng UEFI, bạn cần cài GRUB có hỗ trợ UEFI (cùng các phụ thuộc của nó) theo hướng dẫn trên trang"
---

# 8.64. GRUB-2.12

Gói GRUB chứa GRand Unified Bootloader.

* **Thời gian dựng ước tính:** 0.3 SBU
* **Dung lượng đĩa cần:** 166 MB

## 8.64.1. Cài đặt GRUB

{% hint style="info" %}
**Note**

Nếu hệ thống của bạn hỗ trợ UEFI và bạn muốn khởi động LFS bằng UEFI, bạn cần cài GRUB có hỗ trợ UEFI (cùng các phụ thuộc của nó) theo hướng dẫn trên [trang BLFS](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/grub-efi.html). Bạn có thể bỏ qua gói này, hoặc cài gói này cùng gói GRUB for UEFI của BLFS mà không xung đột (trang BLFS có hướng dẫn cho cả hai trường hợp).
{% endhint %}

{% hint style="danger" %}
**Warning**

Hủy đặt mọi biến môi trường có thể ảnh hưởng đến quá trình dựng:

```bash
unset {C,CPP,CXX,LD}FLAGS
```

Đừng cố “tinh chỉnh” gói này bằng các cờ biên dịch tùy biến. Gói này là một bootloader. Các thao tác mức thấp trong mã nguồn có thể bị hỏng nếu tối ưu hóa quá mạnh tay.
{% endhint %}

Thêm một tệp bị thiếu trong tarball phát hành:

```bash
echo depends bli part_gpt > grub-core/extra_deps.lst
```

Chuẩn bị biên dịch GRUB:

```bash
./configure --prefix=/usr     \
            --sysconfdir=/etc \
            --disable-efiemu  \
            --disable-werror
```

**Ý nghĩa các tùy chọn configure mới:**

**`--disable-werror`**

> Cho phép quá trình dựng hoàn tất dù có các cảnh báo do các phiên bản Flex mới hơn gây ra.

**`--disable-efiemu`**

> Tùy chọn này tối thiểu hóa những gì được dựng bằng cách tắt một tính năng và loại bỏ một số chương trình kiểm thử không cần cho LFS.

Biên dịch gói:

```bash
make
```

Không khuyến nghị chạy bộ kiểm thử của gói này. Phần lớn bài kiểm thử phụ thuộc vào các gói không có sẵn trong môi trường LFS hạn chế. Nếu vẫn muốn chạy, hãy chạy `make check`.

Cài đặt gói, rồi chuyển tệp hỗ trợ Bash completion tới vị trí được những người duy trì Bash completion khuyến nghị:

```bash
make install
mv -v /etc/bash_completion.d/grub /usr/share/bash-completion/completions
```

Cách làm cho hệ thống LFS của bạn khởi động được bằng GRUB sẽ được bàn ở [Mục 10.4, “Using GRUB to Set Up the Boot Process.”](../chapter10/grub.md)

## 8.64.2. Nội dung của GRUB

* **Chương trình được cài:** grub-bios-setup, grub-editenv, grub-file, grub-fstest, grub-glue-efi, grub-install, grub-kbdcomp, grub-macbless, grub-menulst2cfg, grub-mkconfig, grub-mkimage, grub-mklayout, grub-mknetdir, grub-mkpasswd-pbkdf2, grub-mkrelpath, grub-mkrescue, grub-mkstandalone, grub-ofpathname, grub-probe, grub-reboot, grub-render-label, grub-script-check, grub-set-default, grub-sparc64-setup, và grub-syslinux2cfg
* **Thư mục được cài:** /usr/lib/grub, /etc/grub.d, /usr/share/grub và /boot/grub (khi grub-install được chạy lần đầu)

### Mô tả ngắn

* `grub-bios-setup` — Là chương trình trợ giúp cho `grub-install`
* `grub-editenv` — Là công cụ để sửa environment block
* `grub-file` — Kiểm tra xem tệp đã cho có thuộc loại được chỉ định hay không
* `grub-fstest` — Là công cụ để gỡ lỗi trình điều khiển hệ thống tệp
* `grub-glue-efi` — Ghép nhị phân 32-bit và 64-bit thành một tệp duy nhất (cho máy Apple)
* `grub-install` — Cài đặt GRUB lên ổ đĩa của bạn
* `grub-kbdcomp` — Là script chuyển một bố cục xkb thành bố cục mà GRUB nhận ra
* `grub-macbless` — Là lệnh bless kiểu Mac cho hệ thống tệp HFS hoặc HFS+ (`bless` chỉ có trên máy Apple; nó làm cho một thiết bị khởi động được)
* `grub-menulst2cfg` — Chuyển `menu.lst` của GRUB Legacy thành `grub.cfg` để dùng với GRUB 2
* `grub-mkconfig` — Sinh tệp `grub.cfg`
* `grub-mkimage` — Tạo ảnh khởi động được của GRUB
* `grub-mklayout` — Sinh tệp bố cục bàn phím cho GRUB
* `grub-mknetdir` — Chuẩn bị thư mục netboot cho GRUB
* `grub-mkpasswd-pbkdf2` — Sinh mật khẩu PBKDF2 đã mã hóa để dùng trong menu khởi động
* `grub-mkrelpath` — Biến đường dẫn hệ thống thành đường dẫn tương đối so với gốc của nó
* `grub-mkrescue` — Tạo ảnh khởi động được của GRUB phù hợp với đĩa mềm, CDROM/DVD hoặc ổ USB
* `grub-mkstandalone` — Sinh ảnh độc lập (standalone)
* `grub-ofpathname` — Là chương trình trợ giúp in ra đường dẫn tới một thiết bị GRUB
* `grub-probe` — Dò thông tin thiết bị cho một đường dẫn hoặc thiết bị cho trước
* `grub-reboot` — Đặt mục khởi động mặc định của GRUB chỉ cho lần khởi động kế tiếp
* `grub-render-label` — Tạo .disk\_label của Apple cho máy Mac
* `grub-script-check` — Kiểm tra lỗi cú pháp của script cấu hình GRUB
* `grub-set-default` — Đặt mục khởi động mặc định của GRUB
* `grub-sparc64-setup` — Là chương trình trợ giúp cho grub-setup
* `grub-syslinux2cfg` — Chuyển tệp cấu hình syslinux sang định dạng grub.cfg

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/grub.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/grub.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/grub.html)
