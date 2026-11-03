---
description: "Tùy chọn này báo Bash dùng thư viện readline đã cài sẵn trên hệ thống thay vì dùng bản readline riêng của nó."
---

# 8.36. Bash-5.3

Gói Bash chứa Bourne-Again Shell.

* **Thời gian dựng ước tính:** 1.5 SBU
* **Dung lượng đĩa cần:** 56 MB

## 8.36.1. Cài đặt Bash

Chuẩn bị biên dịch Bash:

```bash
./configure --prefix=/usr             \
            --without-bash-malloc     \
            --with-installed-readline \
            --docdir=/usr/share/doc/bash-5.3
```

**Ý nghĩa của tùy chọn configure mới:**

**`--with-installed-readline`**

> Tùy chọn này báo Bash dùng thư viện `readline` đã cài sẵn trên hệ thống thay vì dùng bản readline riêng của nó.

Biên dịch gói:

```bash
make
```

Nếu không chạy bộ kiểm thử, hãy nhảy tới “Cài đặt gói”.

Để chuẩn bị chạy kiểm thử, đảm bảo người dùng `tester` ghi được vào cây mã nguồn:

```bash
chown -R tester .
```

Bộ kiểm thử của gói này được thiết kế để chạy bằng người dùng không phải `root` và sở hữu terminal nối với đầu vào chuẩn. Để thỏa yêu cầu này, hãy tạo một pseudo terminal mới bằng `Expect` và chạy kiểm thử bằng người dùng `tester`:

```bash
LC_ALL=C.UTF-8 su -s /usr/bin/expect tester << "EOF"
set timeout -1
spawn make tests
expect eof
lassign [wait] _ _ _ value
exit $value
EOF
```

Bộ kiểm thử dùng `diff` để phát hiện sự khác nhau giữa kết quả của script kiểm thử và kết quả mong đợi. Mọi kết quả xuất ra từ `diff` (có tiền tố `<` và `>`) cho thấy bài kiểm thử thất bại, trừ khi có thông báo nói rằng sự khác biệt có thể bỏ qua. Bài tên `run-builtins` được biết là thất bại trên một số distro host với sự khác biệt ở dòng 479 và 480 của kết quả. Một số bài khác cần locale `zh_TW.BIG5` và `ja_JP.SJIS`, chúng sẽ thất bại nếu hai locale này chưa được cài.

Cài đặt gói:

```bash
make install
```

Chạy chương trình `bash` vừa biên dịch (thay thế bản đang chạy):

```bash
exec /usr/bin/bash --login
```

## 8.36.2. Nội dung của Bash

* **Chương trình được cài:** bash, bashbug và sh (liên kết tới bash)
* **Thư mục được cài:** /usr/include/bash, /usr/lib/bash và /usr/share/doc/bash-5.3

### Mô tả ngắn

* `bash` — Trình thông dịch lệnh được dùng rộng rãi; nó thực hiện nhiều kiểu khai triển và thay thế trên dòng lệnh trước khi chạy, nhờ đó trở thành một công cụ mạnh
* `bashbug` — Một shell script giúp người dùng soạn và gửi thư báo lỗi theo định dạng chuẩn liên quan đến `bash`
* `sh` — Một symlink tới chương trình `bash`; khi được gọi là `sh`, `bash` cố bắt chước hành vi khởi động của các phiên bản `sh` trước đây sát nhất có thể, đồng thời vẫn tuân thủ chuẩn POSIX

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/bash.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/bash.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/bash.html)
