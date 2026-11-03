---
description: "Tùy chọn này tắt việc dùng hàm cấp phát bộ nhớ (malloc) riêng của Bash, vốn được biết là gây lỗi segmentation fault. Khi tắt tùy chọn này, Bash sẽ dùng các"
---

# 6.4. Bash-5.3

Gói Bash chứa Bourne-Again Shell.

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 72 MB

## 6.4.1. Cài đặt Bash

Chuẩn bị biên dịch Bash:

```bash
./configure --prefix=/usr                      \
            --build=$(sh support/config.guess) \
            --host=$LFS_TGT                    \
            --without-bash-malloc
```

**Ý nghĩa các tùy chọn configure:**

**`--without-bash-malloc`**

> Tùy chọn này tắt việc dùng hàm cấp phát bộ nhớ (`malloc`) riêng của Bash, vốn được biết là gây lỗi segmentation fault. Khi tắt tùy chọn này, Bash sẽ dùng các hàm `malloc` của Glibc ổn định hơn.

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make DESTDIR=$LFS install
```

Tạo liên kết cho các chương trình dùng `sh` làm shell:

```bash
ln -sv bash $LFS/bin/sh
```

Chi tiết về gói này có ở [Mục 8.36.2, “Contents of Bash.”](../chapter08/bash.md#contents-bash)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/bash.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/bash.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/bash.html)
