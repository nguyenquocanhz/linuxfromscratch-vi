---
description: "Làm tốt lắm! Hệ thống LFS mới đã được cài đặt! Chúc bạn thật nhiều thành công với hệ thống Linux tự tay dựng nên của mình."
---

# 11.1. Kết thúc

Làm tốt lắm! Hệ thống LFS mới đã được cài đặt! Chúc bạn thật nhiều thành công với hệ thống Linux tự tay dựng nên của mình.

Bạn nên tạo tệp `/etc/lfs-release`. Có tệp này, bạn (và cả chúng tôi, nếu bạn cần hỏi xin trợ giúp lúc nào đó) sẽ dễ dàng biết hệ thống đang cài phiên bản LFS nào. Hãy tạo tệp này bằng cách chạy:

```bash
echo 12.4 > /etc/lfs-release
```

Hai tệp mô tả hệ thống đã cài có thể được dùng bởi các gói cài thêm sau này, dù ở dạng nhị phân hay tự dựng.

Tệp thứ nhất cho biết trạng thái của hệ thống mới theo Linux Standards Base (LSB). Để tạo tệp này, chạy:

```bash
cat > /etc/lsb-release << "EOF"
DISTRIB_ID="Linux From Scratch"
DISTRIB_RELEASE="12.4"
DISTRIB_CODENAME="<your name here>"
DISTRIB_DESCRIPTION="Linux From Scratch"
EOF
```

Tệp thứ hai chứa gần như cùng thông tin, và được systemd cũng như một số môi trường desktop đồ họa sử dụng. Để tạo tệp này, chạy:

```bash
cat > /etc/os-release << "EOF"
NAME="Linux From Scratch"
VERSION="12.4"
ID=lfs
PRETTY_NAME="Linux From Scratch 12.4"
VERSION_CODENAME="<your name here>"
HOME_URL="https://www.linuxfromscratch.org/lfs/"
RELEASE_TYPE="stable"
EOF
```

Hãy nhớ tùy chỉnh các trường 'DISTRIB\_CODENAME' và 'VERSION\_CODENAME' để biến hệ thống thành của riêng bạn.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter11/theend.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter11/theend.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter11/theend.html)
