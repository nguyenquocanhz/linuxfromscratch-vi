---
description: "Trước đây, Linux lưu danh sách các hệ thống tệp đã mount trong tệp \/etc\/mtab. Kernel hiện đại tự giữ danh sách này nội bộ và cho người dùng xem qua hệ thốn"
---

# 7.6. Tạo các tệp thiết yếu và symlink

Trước đây, Linux lưu danh sách các hệ thống tệp đã mount trong tệp `/etc/mtab`. Kernel hiện đại tự giữ danh sách này nội bộ và cho người dùng xem qua hệ thống tệp `/proc`. Để đáp ứng các tiện ích mong tìm thấy `/etc/mtab`, hãy tạo liên kết tượng trưng sau:

```bash
ln -sv /proc/self/mounts /etc/mtab
```

Tạo tệp `/etc/hosts` cơ bản để một số bộ kiểm thử và một tệp cấu hình của Perl tham chiếu tới:

```bash
cat > /etc/hosts << EOF
127.0.0.1  localhost $(hostname)
::1        localhost
EOF
```

Để người dùng `root` đăng nhập được và tên “root” được nhận diện, phải có các mục tương ứng trong các tệp `/etc/passwd` và `/etc/group`.

Tạo tệp `/etc/passwd` bằng lệnh sau:

```bash
cat > /etc/passwd << "EOF"
root:x:0:0:root:/root:/bin/bash
bin:x:1:1:bin:/dev/null:/usr/bin/false
daemon:x:6:6:Daemon User:/dev/null:/usr/bin/false
messagebus:x:18:18:D-Bus Message Daemon User:/run/dbus:/usr/bin/false
uuidd:x:80:80:UUID Generation Daemon User:/dev/null:/usr/bin/false
nobody:x:65534:65534:Unprivileged User:/dev/null:/usr/bin/false
EOF
```

Mật khẩu thực sự của `root` sẽ được đặt sau.

Tạo tệp `/etc/group` bằng lệnh sau:

```bash
cat > /etc/group << "EOF"
root:x:0:
bin:x:1:daemon
sys:x:2:
kmem:x:3:
tape:x:4:
tty:x:5:
daemon:x:6:
floppy:x:7:
disk:x:8:
lp:x:9:
dialout:x:10:
audio:x:11:
video:x:12:
utmp:x:13:
cdrom:x:15:
adm:x:16:
messagebus:x:18:
input:x:24:
mail:x:34:
kvm:x:61:
uuidd:x:80:
wheel:x:97:
users:x:999:
nogroup:x:65534:
EOF
```

Các nhóm được tạo không thuộc chuẩn nào—một phần là các nhóm do yêu cầu của cấu hình Udev ở Chương 9 quyết định, một phần theo quy ước chung của nhiều bản phân phối Linux hiện có. Ngoài ra, một số bộ kiểm thử dựa vào các người dùng hoặc nhóm cụ thể. Linux Standard Base (LSB, có tại [https://refspecs.linuxfoundation.org/lsb.shtml](https://refspecs.linuxfoundation.org/lsb.shtml)) chỉ khuyến nghị rằng ngoài nhóm `root` có Group ID (GID) bằng 0, cần có nhóm `bin` với GID bằng 1. GID 5 được dùng rộng rãi cho nhóm `tty`, và số 5 cũng được dùng trong `/etc/fstab` cho hệ thống tệp `devpts`. Mọi tên nhóm và GID khác có thể do quản trị viên tự chọn vì các chương trình viết tốt không phụ thuộc vào số GID mà dùng tên nhóm.

ID 65534 được kernel dùng cho NFS và các user namespace riêng cho những người dùng và nhóm chưa được ánh xạ (tồn tại trên máy chủ NFS hoặc user namespace cha, nhưng “không tồn tại” trên máy cục bộ hoặc trong namespace riêng). Chúng ta gán `nobody` và `nogroup` để tránh ID không có tên. Nhưng các distro khác có thể xử lý ID này khác đi, nên chương trình portable không nên phụ thuộc vào phép gán này.

Một số bài kiểm thử trong [Chương 8](../chapter08/chapter08.md) cần một người dùng thường. Ta thêm người dùng này ở đây và xóa tài khoản vào cuối chương đó.

```bash
echo "tester:x:101:101::/home/tester:/bin/bash" >> /etc/passwd
echo "tester:x:101:" >> /etc/group
install -o tester -d /home/tester
```

Để bỏ dấu nhắc “I have no name!”, hãy mở shell mới. Vì các tệp `/etc/passwd` và `/etc/group` đã được tạo, việc phân giải tên người dùng và tên nhóm giờ sẽ hoạt động:

```bash
exec /usr/bin/bash --login
```

Các chương trình `login`, `agetty` và `init` (cùng vài chương trình khác) dùng một số tệp nhật ký để ghi thông tin như ai đã đăng nhập vào hệ thống và khi nào. Tuy nhiên, các chương trình này sẽ không ghi vào tệp nhật ký nếu chúng chưa tồn tại. Hãy khởi tạo các tệp nhật ký và đặt quyền phù hợp:

```bash
touch /var/log/{btmp,lastlog,faillog,wtmp}
chgrp -v utmp /var/log/lastlog
chmod -v 664  /var/log/lastlog
chmod -v 600  /var/log/btmp
```

Tệp `/var/log/wtmp` ghi mọi lần đăng nhập và đăng xuất. Tệp `/var/log/lastlog` ghi lần đăng nhập gần nhất của từng người dùng. Tệp `/var/log/faillog` ghi các lần đăng nhập thất bại. Tệp `/var/log/btmp` ghi các lần đăng nhập sai.

{% hint style="info" %}
**Ghi chú**

Tệp `/run/utmp` ghi những người dùng đang đăng nhập. Tệp này được tạo động trong các boot script.
{% endhint %}

{% hint style="info" %}
**Ghi chú**

Các tệp `utmp`, `wtmp`, `btmp` và `lastlog` dùng số nguyên 32-bit cho dấu thời gian và sẽ hỏng về cơ bản sau năm 2038. Nhiều gói đã ngừng dùng chúng và sẽ còn nhiều gói khác nữa. Tốt nhất nên coi chúng là đã lỗi thời.
{% endhint %}

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/createfiles.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/createfiles.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/createfiles.html)
