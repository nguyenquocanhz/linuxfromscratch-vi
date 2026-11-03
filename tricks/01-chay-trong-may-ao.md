---
title: Đừng làm trên máy thật — dựng LFS trong máy ảo hoặc file ảnh đĩa
pages: chapter02/hostreqs.html, chapter02/creatingpartition.html
tags: an toàn, máy ảo
---
Lần đầu làm LFS, gõ nhầm một lệnh với quyền root là đủ hỏng hệ thống chủ. Cách an toàn nhất:

- Cài một distro nhẹ (Debian, Ubuntu Server, Fedora...) trong **VirtualBox/QEMU/VMware** rồi làm LFS trong đó. Snapshot máy ảo trước mỗi chương lớn.
- Không muốn chia lại ổ cứng? Dùng **file ảnh đĩa** thay cho phân vùng thật:

```bash
truncate -s 30G ~/lfs.img                       # file thưa, chỉ tốn chỗ khi ghi thật
sudo losetup -fP --show ~/lfs.img               # in ra ví dụ /dev/loop0
sudo fdisk /dev/loop0                           # tạo phân vùng như sách hướng dẫn
sudo mkfs -v -t ext4 /dev/loop0p1
```

Sau này file `lfs.img` boot thẳng được bằng QEMU (xem trick ở Chương 10). Gỡ bằng `sudo losetup -d /dev/loop0`.
