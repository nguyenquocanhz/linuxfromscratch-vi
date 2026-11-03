---
description: "Gói Bzip2 chứa các chương trình để nén và giải nén tệp. Nén tệp văn bản bằng bzip2 cho tỷ lệ nén tốt hơn nhiều so với gzip truyền thống."
---

# 8.7. Bzip2-1.0.8

Gói Bzip2 chứa các chương trình để nén và giải nén tệp. Nén tệp văn bản bằng `bzip2` cho tỷ lệ nén tốt hơn nhiều so với `gzip` truyền thống.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 7.3 MB

## 8.7.1. Cài đặt Bzip2

Áp dụng một bản vá để cài tài liệu của gói này:

```bash
patch -Np1 -i ../bzip2-1.0.8-install_docs-1.patch
```

Lệnh sau đảm bảo các symlink được cài là đường dẫn tương đối:

```bash
sed -i 's@\(ln -s -f \)$(PREFIX)/bin/@\1@' Makefile
```

Đảm bảo các trang man được cài vào đúng vị trí:

```bash
sed -i "s@(PREFIX)/man@(PREFIX)/share/man@g" Makefile
```

Chuẩn bị biên dịch Bzip2 bằng:

```bash
make -f Makefile-libbz2_so
make clean
```

**Ý nghĩa của tham số make:**

**`-f Makefile-libbz2_so`**

> Tùy chọn này khiến Bzip2 được dựng bằng một tệp `Makefile` khác, ở đây là `Makefile-libbz2_so`, tệp này tạo thư viện động `libbz2.so` và liên kết các tiện ích Bzip2 với nó.

Biên dịch và kiểm thử gói:

```bash
make
```

Cài đặt các chương trình:

```bash
make PREFIX=/usr install
```

Cài đặt thư viện dùng chung:

```bash
cp -av libbz2.so.* /usr/lib
ln -sv libbz2.so.1.0.8 /usr/lib/libbz2.so
```

Cài tệp nhị phân `bzip2` dùng chung vào thư mục `/usr/bin`, và thay hai bản sao của `bzip2` bằng symlink:

```bash
cp -v bzip2-shared /usr/bin/bzip2
for i in /usr/bin/{bzcat,bunzip2}; do
  ln -sfv bzip2 $i
done
```

Xóa một thư viện tĩnh vô ích:

```bash
rm -fv /usr/lib/libbz2.a
```

## 8.7.2. Nội dung của Bzip2

* **Chương trình được cài:** bunzip2 (liên kết tới bzip2), bzcat (liên kết tới bzip2), bzcmp (liên kết tới bzdiff), bzdiff, bzegrep (liên kết tới bzgrep), bzfgrep (liên kết tới bzgrep), bzgrep, bzip2, bzip2recover, bzless (liên kết tới bzmore) và bzmore
* **Thư viện được cài:** libbz2.so
* **Thư mục được cài:** /usr/share/doc/bzip2-1.0.8

### Mô tả ngắn

* `bunzip2` — Giải nén các tệp bzip
* `bzcat` — Giải nén ra đầu ra chuẩn
* `bzcmp` — Chạy `cmp` trên các tệp bzip
* `bzdiff` — Chạy `diff` trên các tệp bzip
* `bzegrep` — Chạy `egrep` trên các tệp bzip
* `bzfgrep` — Chạy `fgrep` trên các tệp bzip
* `bzgrep` — Chạy `grep` trên các tệp bzip
* `bzip2` — Nén tệp bằng thuật toán nén văn bản sắp xếp khối Burrows-Wheeler kết hợp mã hóa Huffman; tỷ lệ nén tốt hơn các bộ nén thông thường dùng thuật toán “Lempel-Ziv”, như `gzip`
* `bzip2recover` — Cố gắng khôi phục dữ liệu từ các tệp bzip bị hỏng
* `bzless` — Chạy `less` trên các tệp bzip
* `bzmore` — Chạy `more` trên các tệp bzip
* `libbz2` — Thư viện cài đặt phương pháp nén dữ liệu không mất mát, sắp xếp theo khối, dùng thuật toán Burrows-Wheeler

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/bzip2.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/bzip2.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/bzip2.html)
