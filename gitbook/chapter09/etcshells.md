---
description: "Tệp shells chứa danh sách các shell đăng nhập trên hệ thống. Các ứng dụng dùng tệp này để xác định một shell có hợp lệ hay không. Mỗi shell cần có một dòng"
---

# 9.9. Creating the /etc/shells File

Tệp `shells` chứa danh sách các shell đăng nhập trên hệ thống. Các ứng dụng dùng tệp này để xác định một shell có hợp lệ hay không. Mỗi shell cần có một dòng riêng, gồm đường dẫn của shell tính từ gốc cây thư mục (/).

Ví dụ, `chsh` tra cứu tệp này để xác định người dùng không có đặc quyền có được đổi shell đăng nhập của tài khoản mình hay không. Nếu tên lệnh không có trong danh sách, người dùng sẽ không được phép đổi shell.

Tệp này là yêu cầu bắt buộc với những ứng dụng như `GDM`, vốn không hiển thị danh sách khuôn mặt người dùng nếu không tìm thấy `/etc/shells`, hoặc các daemon FTP, vốn theo truyền thống từ chối truy cập của người dùng có shell không nằm trong tệp này.

```text
cat > /etc/shells << "EOF"
# Begin /etc/shells

/bin/sh
/bin/bash

# End /etc/shells
EOF
```

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter09/etcshells.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter09/etcshells.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter09/etcshells.html)
