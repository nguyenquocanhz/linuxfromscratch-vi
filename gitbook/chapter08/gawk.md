---
description: "Trước tiên, đảm bảo một số tệp không cần thiết sẽ không được cài:"
---

# 8.61. Gawk-5.3.2

Gói Gawk chứa các chương trình để thao tác với tệp văn bản.

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 45 MB

## 8.61.1. Cài đặt Gawk

Trước tiên, đảm bảo một số tệp không cần thiết sẽ không được cài:

```bash
sed -i 's/extras//' Makefile.in
```

Chuẩn bị biên dịch Gawk:

```bash
./configure --prefix=/usr
```

Biên dịch gói:

```bash
make
```

Để kiểm thử kết quả, chạy:

```bash
chown -R tester .
su tester -c "PATH=$PATH make check"
```

Cài đặt gói:

```bash
rm -f /usr/bin/gawk-5.3.2
make install
```

**Ý nghĩa của lệnh:**

**`rm -f /usr/bin/gawk-5.3.2`**

> Hệ thống build sẽ không tạo lại hard link `gawk-5.3.2` nếu nó đã tồn tại. Hãy xóa nó để đảm bảo hard link cũ cài ở [Mục 6.9, “Gawk-5.3.2”](../chapter06/gawk.md) được cập nhật tại đây.

Quá trình cài đặt đã tạo `awk` làm symlink tới `gawk`; hãy tạo trang man của nó cũng dưới dạng symlink:

```bash
ln -sv gawk.1 /usr/share/man/man1/awk.1
```

Nếu muốn, hãy cài đặt tài liệu:

```bash
install -vDm644 doc/{awkforai.txt,*.{eps,pdf,jpg}} -t /usr/share/doc/gawk-5.3.2
```

## 8.61.2. Nội dung của Gawk

* **Chương trình được cài:** awk (liên kết tới gawk), gawk và gawk-5.3.2
* **Thư viện được cài:** filefuncs.so, fnmatch.so, fork.so, inplace.so, intdiv.so, ordchr.so, readdir.so, readfile.so, revoutput.so, revtwoway.so, rwarray.so và time.so (tất cả nằm trong /usr/lib/gawk)
* **Thư mục được cài:** /usr/lib/gawk, /usr/libexec/awk, /usr/share/awk, và /usr/share/doc/gawk-5.3.2

### Mô tả ngắn

* `awk` — Một liên kết tới `gawk`
* `gawk` — Chương trình thao tác với tệp văn bản; là bản cài đặt GNU của `awk`
* `gawk-5.3.2` — Một hard link tới `gawk`

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/gawk.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/gawk.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/gawk.html)
