---
description: "Gói Sysklogd chứa các chương trình ghi nhật ký thông điệp hệ thống, chẳng hạn những thông điệp kernel phát ra khi có sự cố bất thường."
---

# 8.81. Sysklogd-2.7.2

Gói Sysklogd chứa các chương trình ghi nhật ký thông điệp hệ thống, chẳng hạn những thông điệp kernel phát ra khi có sự cố bất thường.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 3.9 MB

## 8.81.1. Cài đặt Sysklogd

Chuẩn bị biên dịch the package:

```bash
./configure --prefix=/usr      \
            --sysconfdir=/etc  \
            --runstatedir=/run \
            --without-logger   \
            --disable-static   \
            --docdir=/usr/share/doc/sysklogd-2.7.2
```

Biên dịch gói:

```bash
make
```

Gói này không đi kèm bộ kiểm thử.

Cài đặt gói:

```bash
make install
```

## 8.81.2. Configuring Sysklogd

Tạo tệp `/etc/syslog.conf` mới bằng cách chạy:

```bash
cat > /etc/syslog.conf << "EOF"
# Begin /etc/syslog.conf

auth,authpriv.* -/var/log/auth.log
*.*;auth,authpriv.none -/var/log/sys.log
daemon.* -/var/log/daemon.log
kern.* -/var/log/kern.log
mail.* -/var/log/mail.log
user.* -/var/log/user.log
*.emerg *

# Do not open any internet ports.
secure_mode 2

# End /etc/syslog.conf
EOF
```

## 8.81.3. Nội dung của Sysklogd

* **Chương trình được cài:** syslogd

### Mô tả ngắn

* `syslogd` — Ghi lại các thông điệp mà chương trình hệ thống gửi để ghi nhật ký \[Mỗi thông điệp được ghi đều có ít nhất dấu thời gian và tên máy, thường kèm cả tên chương trình, nhưng điều đó tùy vào mức độ tin cậy mà daemon ghi nhật ký được cấu hình\].

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/sysklogd.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/sysklogd.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/sysklogd.html)
