---
description: "Gói Tcl chứa Tool Command Language, một ngôn ngữ script đa dụng mạnh mẽ. Gói Expect được viết bằng Tcl (đọc là \"tickle\")."
---

# 8.16. Tcl-8.6.16

Gói `Tcl` chứa Tool Command Language, một ngôn ngữ script đa dụng mạnh mẽ. Gói `Expect` được viết bằng `Tcl` (đọc là "tickle").

* **Thời gian dựng ước tính:** 3.0 SBU
* **Dung lượng đĩa cần:** 91 MB

## 8.16.1. Cài đặt Tcl

Gói này và hai gói tiếp theo (Expect và DejaGNU) được cài để hỗ trợ chạy các bộ kiểm thử của Binutils, GCC và những gói khác. Cài ba gói chỉ để phục vụ kiểm thử nghe có vẻ thừa, nhưng biết chắc các công cụ quan trọng nhất hoạt động đúng thì rất yên tâm, nếu không muốn nói là thiết yếu.

Chuẩn bị biên dịch Tcl:

```bash
SRCDIR=$(pwd)
cd unix
./configure --prefix=/usr           \
            --mandir=/usr/share/man \
            --disable-rpath
```

**Ý nghĩa của các tham số configure mới:**

**`--disable-rpath`**

> Tham số này ngăn việc ghi cứng đường dẫn tìm kiếm thư viện (rpath) vào các tệp thực thi và thư viện dùng chung. Gói này không cần rpath khi cài vào vị trí chuẩn, và rpath đôi khi gây ra tác dụng ngoài ý muốn, thậm chí là vấn đề bảo mật.

Dựng gói:

```bash
make

sed -e "s|$SRCDIR/unix|/usr/lib|" \
    -e "s|$SRCDIR|/usr/include|"  \
    -i tclConfig.sh

sed -e "s|$SRCDIR/unix/pkgs/tdbc1.1.10|/usr/lib/tdbc1.1.10|" \
    -e "s|$SRCDIR/pkgs/tdbc1.1.10/generic|/usr/include|"     \
    -e "s|$SRCDIR/pkgs/tdbc1.1.10/library|/usr/lib/tcl8.6|"  \
    -e "s|$SRCDIR/pkgs/tdbc1.1.10|/usr/include|"             \
    -i pkgs/tdbc1.1.10/tdbcConfig.sh

sed -e "s|$SRCDIR/unix/pkgs/itcl4.3.2|/usr/lib/itcl4.3.2|" \
    -e "s|$SRCDIR/pkgs/itcl4.3.2/generic|/usr/include|"    \
    -e "s|$SRCDIR/pkgs/itcl4.3.2|/usr/include|"            \
    -i pkgs/itcl4.3.2/itclConfig.sh

unset SRCDIR
```

Các lệnh “sed” sau lệnh “make” sẽ xóa các tham chiếu tới thư mục dựng khỏi các tệp cấu hình và thay bằng thư mục cài đặt. Việc này không bắt buộc cho phần còn lại của LFS, nhưng có thể cần nếu một gói dựng sau đó dùng Tcl.

Để kiểm thử kết quả, chạy:

```bash
make test
```

Cài đặt gói:

```bash
make install 
chmod 644 /usr/lib/libtclstub8.6.a
```

Làm cho thư viện đã cài có thể ghi được để sau này có thể xóa các ký hiệu gỡ lỗi:

```bash
chmod -v u+w /usr/lib/libtcl8.6.so
```

Cài các tệp header của Tcl. Gói kế tiếp, Expect, cần đến chúng.

```bash
make install-private-headers
```

Bây giờ tạo một liên kết mềm cần thiết:

```bash
ln -sfv tclsh8.6 /usr/bin/tclsh
```

Đổi tên một trang man xung đột với trang man của Perl:

```bash
mv /usr/share/man/man3/{Thread,Tcl_Thread}.3
```

Tùy chọn, cài tài liệu bằng cách chạy các lệnh sau:

```bash
cd ..
tar -xf ../tcl8.6.16-html.tar.gz --strip-components=1
mkdir -v -p /usr/share/doc/tcl-8.6.16
cp -v -r  ./html/* /usr/share/doc/tcl-8.6.16
```

## 8.16.2. Nội dung của Tcl

* **Chương trình được cài:** tclsh (liên kết tới tclsh8.6) và tclsh8.6
* **Thư viện được cài:** libtcl8.6.so và libtclstub8.6.a

### Mô tả ngắn

* `tclsh8.6` — Shell lệnh Tcl
* `tclsh` — Một liên kết tới tclsh8.6
* `libtcl8.6.so` — Thư viện Tcl
* `libtclstub8.6.a` — Thư viện Tcl Stub

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/tcl.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/tcl.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/tcl.html)
