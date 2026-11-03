---
description: "Để bạn dễ theo dõi hơn, cuốn sách dùng một số quy ước trình bày. Mục này có vài ví dụ về định dạng được dùng xuyên suốt Linux From Scratch."
---

# vii. Quy ước trình bày

Để bạn dễ theo dõi hơn, cuốn sách dùng một số quy ước trình bày. Mục này có vài ví dụ về định dạng được dùng xuyên suốt Linux From Scratch.

```bash
./configure --prefix=/usr
```

Kiểu chữ này được thiết kế để gõ đúng như hiển thị, trừ khi phần văn bản xung quanh nói khác. Nó cũng được dùng trong các phần giải thích để chỉ rõ đang nói đến lệnh nào.

Trong một số trường hợp, một dòng lệnh logic được kéo dài thành hai hoặc nhiều dòng vật lý bằng dấu gạch chéo ngược ở cuối dòng.

```bash
CC="gcc -B/usr/bin/" ../binutils-2.18/configure \
  --prefix=/tools --disable-nls --disable-werror
```

Lưu ý rằng sau dấu gạch chéo ngược phải xuống dòng ngay. Các ký tự khoảng trắng khác như dấu cách hay tab sẽ cho kết quả sai.

```text
install-info: unknown option '--dir-file=/mnt/lfs/usr/info/dir'
```

Kiểu chữ này (chữ có độ rộng cố định) hiển thị đầu ra trên màn hình, thường là kết quả của các lệnh đã gõ. Nếu bạn đọc sách ở định dạng HTML (thay vì PDF), chữ sẽ có màu xanh lam.

Chữ có độ rộng cố định cũng được dùng để hiển thị tên tệp, chẳng hạn `/etc/ld.so.conf`.

{% hint style="info" %}
**Ghi chú**

Hãy cấu hình trình duyệt để hiển thị chữ có độ rộng cố định bằng một phông monospace tốt, giúp bạn phân biệt rõ các ký tự `Il1` hay `O0`.
{% endhint %}

*Emphasis*

Kiểu chữ này được dùng cho nhiều mục đích trong sách. Mục đích chính là nhấn mạnh các điểm hoặc mục quan trọng.

[https://www.linuxfromscratch.org/](https://www.linuxfromscratch.org/)

Định dạng này dùng cho các siêu liên kết, cả trong cộng đồng LFS lẫn tới các trang bên ngoài, bao gồm HOWTO, nơi tải về và các website.

```bash
cat > $LFS/etc/group << "EOF"
root:x:0:
bin:x:1:
......
EOF
```

Định dạng này dùng khi tạo các tệp cấu hình. Lệnh đầu tiên bảo hệ thống tạo tệp `$LFS/etc/group` từ mọi thứ gõ ở các dòng sau cho đến khi gặp chuỗi End Of File (EOF). Vì vậy, toàn bộ khối này thường được gõ đúng như hiển thị.

`<REPLACED TEXT>`

Định dạng này dùng để bao quanh phần văn bản không được gõ nguyên như hiển thị, hoặc dùng cho thao tác sao chép-dán.

`[OPTIONAL TEXT]`

Định dạng này dùng để bao quanh phần văn bản là tùy chọn.

[passwd(5)](https://man.archlinux.org/man/passwd.5)

Định dạng này dùng để chỉ một trang hướng dẫn (man page) cụ thể. Số trong ngoặc đơn cho biết mục cụ thể trong bộ sách hướng dẫn. Ví dụ, `passwd` có hai man page. Theo hướng dẫn cài đặt LFS, hai man page đó nằm ở `/usr/share/man/man1/passwd.1` và `/usr/share/man/man5/passwd.5`. Khi sách dùng [passwd(5)](https://man.archlinux.org/man//passwd.5), nghĩa là đang nói riêng đến `/usr/share/man/man5/passwd.5`. Lệnh `man passwd` sẽ in man page đầu tiên tìm được khớp với “passwd,” tức là `/usr/share/man/man1/passwd.1`. Với ví dụ này, bạn cần chạy `man 5 passwd` để đọc đúng trang được chỉ định. Lưu ý rằng hầu hết man page không trùng tên giữa các mục khác nhau. Do đó, `man <program name>` thường là đủ. Trong sách LFS, các tham chiếu tới man page cũng là siêu liên kết, nên bấm vào sẽ mở man page được hiển thị dạng HTML từ [Arch Linux manual pages](https://man.archlinux.org/).

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/prologue/typography.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/prologue/typography.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/prologue/typography.html)
