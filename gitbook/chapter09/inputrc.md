---
description: "Tệp inputrc là tệp cấu hình của thư viện readline, thư viện cung cấp khả năng chỉnh sửa khi người dùng nhập một dòng từ terminal. Nó hoạt động bằng cách ch"
---

# 9.8. Creating the /etc/inputrc File

Tệp `inputrc` là tệp cấu hình của thư viện readline, thư viện cung cấp khả năng chỉnh sửa khi người dùng nhập một dòng từ terminal. Nó hoạt động bằng cách chuyển các phím bấm thành những hành động cụ thể. Readline được bash và hầu hết các shell khác, cũng như nhiều ứng dụng khác, sử dụng.

Hầu hết mọi người không cần tùy chỉnh riêng cho từng người dùng, nên lệnh dưới đây tạo một tệp `/etc/inputrc` toàn cục cho mọi người đăng nhập. Nếu sau này bạn muốn ghi đè mặc định cho từng người dùng, hãy tạo tệp `.inputrc` trong thư mục chủ của người dùng đó với các ánh xạ đã sửa.

Để biết thêm cách chỉnh sửa tệp `inputrc`, xem `info bash` ở phần *Readline Init File*. `info readline` cũng là nguồn thông tin tốt.

Dưới đây là một tệp `inputrc` toàn cục chung kèm chú thích giải thích các tùy chọn. Lưu ý chú thích không được nằm cùng dòng với lệnh. Tạo tệp bằng lệnh sau:

```bash
cat > /etc/inputrc << "EOF"
# Begin /etc/inputrc
# Modified by Chris Lynn <roryo@roryo.dynup.net>

# Allow the command prompt to wrap to the next line
set horizontal-scroll-mode Off

# Enable 8-bit input
set meta-flag On
set input-meta On

# Turns off 8th bit stripping
set convert-meta Off

# Keep the 8th bit for display
set output-meta On

# none, visible or audible
set bell-style none

# All of the following map the escape sequence of the value
# contained in the 1st argument to the readline specific functions
"\eOd": backward-word
"\eOc": forward-word

# for linux console
"\e[1~": beginning-of-line
"\e[4~": end-of-line
"\e[5~": beginning-of-history
"\e[6~": end-of-history
"\e[3~": delete-char
"\e[2~": quoted-insert

# for xterm
"\eOH": beginning-of-line
"\eOF": end-of-line

# for Konsole
"\e[H": beginning-of-line
"\e[F": end-of-line

# End /etc/inputrc
EOF
```

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter09/inputrc.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter09/inputrc.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter09/inputrc.html)
