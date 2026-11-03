---
title: Không biết card mạng tên gì? Giữ kiểu eth0 cho dễ
pages: chapter09/network.html, chapter09/udev.html
tags: mạng
---
Udev đặt tên card mạng kiểu `enp0s3`, `ens33`... và tên có thể khác giữa máy ảo và máy thật, làm file `/etc/sysconfig/ifconfig.*` của bạn trỏ sai. Hai cách:

- Xem tên thật sau khi boot: `ip link`.
- Hoặc tắt tên "dự đoán được" bằng cách thêm `net.ifnames=0` vào dòng `linux` trong `grub.cfg` → card đầu tiên luôn là `eth0`, và file cấu hình đặt là `/etc/sysconfig/ifconfig.eth0`.

Mạng vẫn không lên? Kiểm tra kernel đã có driver card mạng chưa (`dmesg | grep -i eth`) — máy ảo VirtualBox thường cần `e1000`, QEMU cần `virtio_net`.
