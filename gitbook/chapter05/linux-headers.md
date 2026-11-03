---
description: "Các header API của Linux (nằm trong linux-6.16.1.tar.xz) phơi bày API của kernel cho Glibc sử dụng."
---

# 5.4. Header API của Linux-6.16.1

Các header API của Linux (nằm trong linux-6.16.1.tar.xz) phơi bày API của kernel cho Glibc sử dụng.

* **Thời gian dựng ước tính:** ít hơn 0,1 SBU
* **Dung lượng đĩa cần:** 1.7 GB

## 5.4.1. Cài đặt các header API của Linux

Kernel Linux cần phơi bày một Giao diện lập trình ứng dụng (API) cho thư viện C của hệ thống (Glibc trong LFS) sử dụng. Việc này được thực hiện bằng cách làm sạch (sanitize) nhiều tệp header C đi kèm trong tarball mã nguồn kernel Linux.

Đảm bảo không còn tệp cũ nào lẫn trong gói:

```bash
make mrproper
```

Bây giờ hãy trích xuất các header kernel dành cho người dùng từ mã nguồn. Không dùng được make target khuyến nghị “headers\_install” vì nó cần `rsync`, thứ có thể không có sẵn. Các header trước tiên được đặt vào `./usr`, rồi được sao chép tới vị trí cần thiết.

```bash
make headers
find usr/include -type f ! -name '*.h' -delete
cp -rv usr/include $LFS/usr
```

## 5.4.2. Nội dung của các header API Linux

* **Header được cài:** /usr/include/asm/\*.h, /usr/include/asm-generic/\*.h, /usr/include/drm/\*.h, /usr/include/linux/\*.h, /usr/include/misc/\*.h, /usr/include/mtd/\*.h, /usr/include/rdma/\*.h, /usr/include/scsi/\*.h, /usr/include/sound/\*.h, /usr/include/video/\*.h, and /usr/include/xen/\*.h
* **Thư mục được cài:** /usr/include/asm, /usr/include/asm-generic, /usr/include/drm, /usr/include/linux, /usr/include/misc, /usr/include/mtd, /usr/include/rdma, /usr/include/scsi, /usr/include/sound, /usr/include/video, and /usr/include/xen

### Mô tả ngắn

* `/usr/include/asm/*.h` — Các header ASM của Linux API
* `/usr/include/asm-generic/*.h` — Các header ASM Generic của Linux API
* `/usr/include/drm/*.h` — Các header DRM của Linux API
* `/usr/include/linux/*.h` — Các header Linux của Linux API
* `/usr/include/misc/*.h` — Các header Miscellaneous (linh tinh) của Linux API
* `/usr/include/mtd/*.h` — Các header MTD của Linux API
* `/usr/include/rdma/*.h` — Các header RDMA của Linux API
* `/usr/include/scsi/*.h` — Các header SCSI của Linux API
* `/usr/include/sound/*.h` — Các header Sound (âm thanh) của Linux API
* `/usr/include/video/*.h` — Các header Video của Linux API
* `/usr/include/xen/*.h` — Các header Xen của Linux API

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter05/linux-headers.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter05/linux-headers.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter05/linux-headers.html)
