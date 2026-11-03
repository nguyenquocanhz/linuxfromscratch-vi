---
description: "Tệp \/etc\/fstab được một số chương trình dùng để xác định hệ thống tệp nào sẽ được mount ở đâu theo mặc định, theo thứ tự nào, và hệ thống tệp nào phải được"
---

# 10.2. Tạo tệp /etc/fstab

Tệp `/etc/fstab` được một số chương trình dùng để xác định hệ thống tệp nào sẽ được mount ở đâu theo mặc định, theo thứ tự nào, và hệ thống tệp nào phải được kiểm tra (lỗi toàn vẹn) trước khi mount. Hãy tạo bảng hệ thống tệp mới như sau:

```bash
cat > /etc/fstab << "EOF"
# Begin /etc/fstab

# file system  mount-point    type     options             dump  fsck
#                                                                order

/dev/<xxx>     /              <fff>    defaults            1     1
/dev/<yyy>     swap           swap     pri=1               0     0
proc           /proc          proc     nosuid,noexec,nodev 0     0
sysfs          /sys           sysfs    nosuid,noexec,nodev 0     0
devpts         /dev/pts       devpts   gid=5,mode=620      0     0
tmpfs          /run           tmpfs    defaults            0     0
devtmpfs       /dev           devtmpfs mode=0755,nosuid    0     0
tmpfs          /dev/shm       tmpfs    nosuid,nodev        0     0
cgroup2        /sys/fs/cgroup cgroup2  nosuid,noexec,nodev 0     0

# End /etc/fstab
EOF
```

Hãy thay `<xxx>`, `<yyy>` và `<fff>` bằng các giá trị phù hợp với hệ thống của bạn, ví dụ `sda2`, `sda5` và `ext4`. Chi tiết về sáu trường trong tệp này có ở [fstab(5)](https://man.archlinux.org/man/fstab.5).

Các hệ thống tệp có nguồn gốc MS-DOS hoặc Windows (tức vfat, ntfs, smbfs, cifs, iso9660, udf) cần một tùy chọn đặc biệt, utf8, để ký tự ngoài ASCII trong tên tệp được diễn giải đúng. Với locale không phải UTF-8, giá trị của `iocharset` nên đặt trùng với bộ ký tự của locale, được điều chỉnh sao cho kernel hiểu được. Cách này hoạt động nếu định nghĩa bộ ký tự tương ứng (nằm ở File systems -&gt; Native Language Support khi cấu hình kernel) đã được biên dịch vào kernel hoặc dựng thành module. Tuy nhiên, nếu bộ ký tự của locale là UTF-8, tùy chọn `iocharset=utf8` tương ứng sẽ khiến hệ thống tệp phân biệt hoa thường. Để khắc phục, với locale UTF-8 hãy dùng tùy chọn đặc biệt `utf8` thay cho `iocharset=utf8`. Tùy chọn “codepage” cũng cần cho hệ thống tệp vfat và smbfs. Nó nên đặt theo số codepage dùng trong MS-DOS ở nước bạn. Ví dụ, để mount USB flash, người dùng ru\_RU.KOI8-R cần đặt những dòng sau trong phần tùy chọn của dòng mount trong `/etc/fstab`:

```text
noauto,user,quiet,showexec,codepage=866,iocharset=koi8r
```

Đoạn tùy chọn tương ứng cho người dùng ru\_RU.UTF-8 là:

```text
noauto,user,quiet,showexec,codepage=866,utf8
```

Lưu ý rằng dùng `iocharset` là mặc định đối với `iso8859-1` (giữ cho hệ thống tệp không phân biệt hoa thường), còn tùy chọn `utf8` bảo kernel chuyển đổi tên tệp bằng UTF-8 để chúng được diễn giải đúng trong locale UTF-8.

Bạn cũng có thể chỉ định giá trị codepage và iocharset mặc định cho một số hệ thống tệp ngay khi cấu hình kernel. Các tham số liên quan có tên “Default NLS Option” (`CONFIG_NLS_DEFAULT)`, “Default Remote NLS Option” (`CONFIG_SMB_NLS_DEFAULT`), “Default codepage for FAT” (`CONFIG_FAT_DEFAULT_CODEPAGE`) và “Default iocharset for FAT” (`CONFIG_FAT_DEFAULT_IOCHARSET`). Không có cách nào chỉ định các thiết lập này cho hệ thống tệp ntfs lúc biên dịch kernel.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter10/fstab.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter10/fstab.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter10/fstab.html)
