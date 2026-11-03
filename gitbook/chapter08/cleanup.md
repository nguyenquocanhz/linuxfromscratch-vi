---
description: "Cuối cùng, dọn một số tệp thừa còn sót lại sau khi chạy kiểm thử:"
---

# 8.85. Dọn dẹp

Cuối cùng, dọn một số tệp thừa còn sót lại sau khi chạy kiểm thử:

```bash
rm -rf /tmp/{*,.*}
```

Trong các thư mục /usr/lib và /usr/libexec cũng có vài tệp với đuôi .la. Đó là các tệp "libtool archive". Trên hệ thống Linux hiện đại, các tệp .la của libtool chỉ hữu ích cho libltdl. Không thư viện nào trong LFS được dự kiến nạp bằng libltdl, và biết rằng một số tệp .la có thể làm hỏng việc dựng các gói BLFS. Hãy xóa chúng ngay bây giờ:

```bash
find /usr/lib /usr/libexec -name \*.la -delete
```

Để biết thêm về các tệp libtool archive, xem [mục BLFS "About Libtool Archive (.la) files"](https://www.linuxfromscratch.org/blfs/view/12.4/introduction/la-files.html).

Trình biên dịch dựng ở [Chương 6](../chapter06/chapter06.md) và [Chương 7](../chapter07/chapter07.md) vẫn còn được cài một phần và không cần nữa. Xóa nó bằng:

```bash
find /usr -depth -name $(uname -m)-lfs-linux-gnu\* | xargs rm -rf
```

Cuối cùng, xóa tài khoản người dùng 'tester' tạm đã tạo ở đầu chương trước.

```bash
userdel -r tester
```

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/cleanup.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/cleanup.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/cleanup.html)
