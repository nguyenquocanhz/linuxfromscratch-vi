---
description: "Gói Coreutils chứa các chương trình tiện ích cơ bản mà hệ điều hành nào cũng cần."
---

# 6.5. Coreutils-9.7

Gói Coreutils chứa các chương trình tiện ích cơ bản mà hệ điều hành nào cũng cần.

* **Thời gian dựng ước tính:** 0.3 SBU
* **Dung lượng đĩa cần:** 181 MB

## 6.5.1. Cài đặt Coreutils

Chuẩn bị biên dịch Coreutils:

```bash
./configure --prefix=/usr                     \
            --host=$LFS_TGT                   \
            --build=$(build-aux/config.guess) \
            --enable-install-program=hostname \
            --enable-no-install-program=kill,uptime
```

**Ý nghĩa các tùy chọn configure:**

**`--enable-install-program=hostname`**

> Cho phép dựng và cài tệp nhị phân `hostname` – mặc định nó bị tắt nhưng bộ kiểm thử của Perl lại cần đến.

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make DESTDIR=$LFS install
```

Di chuyển các chương trình tới vị trí cuối cùng mà hệ thống mong đợi. Dù trong môi trường tạm này việc đó không cần thiết, ta vẫn phải làm vì một số chương trình mã hóa cứng vị trí của các tệp thực thi:

```bash
mv -v $LFS/usr/bin/chroot              $LFS/usr/sbin
mkdir -pv $LFS/usr/share/man/man8
mv -v $LFS/usr/share/man/man1/chroot.1 $LFS/usr/share/man/man8/chroot.8
sed -i 's/"1"/"8"/'                    $LFS/usr/share/man/man8/chroot.8
```

Chi tiết về gói này có ở [Mục 8.59.2, “Contents of Coreutils.”](../chapter08/coreutils.md#contents-coreutils)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/coreutils.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/coreutils.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/coreutils.html)
