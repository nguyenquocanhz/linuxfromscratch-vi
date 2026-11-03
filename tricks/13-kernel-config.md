---
title: Cấu hình kernel không mất cả buổi chiều
pages: chapter10/kernel.html
tags: kernel
---
`make menuconfig` từ đầu với hàng nghìn tùy chọn là cực hình. Hai đường tắt:

- **Máy ảo QEMU/KVM**: `make defconfig` rồi `make kvm_guest.config`, sau đó vào `menuconfig` bật thêm những mục sách yêu cầu (ví dụ `CONFIG_DEVTMPFS`, ext4 dựng sẵn, không làm module).
- **Máy thật**: lấy cấu hình của distro đang chạy rồi thu gọn theo những module đang dùng:

```bash
cp /boot/config-$(uname -r) .config     # chạy trên hệ thống chủ, trước khi chroot
make olddefconfig
make localmodconfig                     # chỉ giữ module đang được nạp
```

Driver ổ đĩa và hệ thống file của phân vùng root phải là `*` (built-in), **không phải** `M`. Nếu không kernel sẽ panic với lỗi `VFS: Unable to mount root fs` vì LFS không có initramfs.
