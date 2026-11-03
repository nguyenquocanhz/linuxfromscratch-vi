---
description: "Gói Texinfo chứa các chương trình để đọc, viết và chuyển đổi các trang info."
---

# 8.72. Texinfo-7.2

Gói Texinfo chứa các chương trình để đọc, viết và chuyển đổi các trang info.

* **Thời gian dựng ước tính:** 0.4 SBU
* **Dung lượng đĩa cần:** 160 MB

## 8.72.1. Cài đặt Texinfo

Sửa một mẫu mã khiến Perl-5.42 trở lên hiển thị cảnh báo:

```bash
sed 's/! $output_file eq/$output_file ne/' -i tp/Texinfo/Convert/*.pm
```

Chuẩn bị biên dịch Texinfo:

```bash
./configure --prefix=/usr
```

Biên dịch gói:

```bash
make
```

Để kiểm thử kết quả, chạy:

```bash
make check
```

Cài đặt gói:

```bash
make install
```

Tùy chọn, cài các thành phần thuộc một bản cài đặt TeX:

```bash
make TEXMF=/usr/share/texmf install-tex
```

**Ý nghĩa của tham số make:**

**`TEXMF=/usr/share/texmf`**

> Biến makefile `TEXMF` chứa vị trí gốc của cây TeX, chẳng hạn khi sau này bạn cài một gói TeX.

Hệ thống tài liệu Info dùng một tệp văn bản thuần để lưu danh sách các mục menu. Tệp này nằm ở `/usr/share/info/dir`. Tiếc là do thỉnh thoảng có lỗi trong Makefile của nhiều gói, nó đôi khi không đồng bộ với các trang info đã cài trên hệ thống. Nếu cần tạo lại tệp `/usr/share/info/dir`, các lệnh tùy chọn sau sẽ làm được việc đó:

```bash
pushd /usr/share/info
  rm -v dir
  for f in *
    do install-info $f dir 2>/dev/null
  done
popd
```

## 8.72.2. Nội dung của Texinfo

* **Chương trình được cài:** info, install-info, makeinfo (liên kết tới texi2any), pdftexi2dvi, pod2texi, texi2any, texi2dvi, texi2pdf và texindex
* **Thư viện được cài:** MiscXS.so, Parsetexi.so và XSParagraph.so (tất cả nằm trong /usr/lib/texinfo)
* **Thư mục được cài:** /usr/share/texinfo và /usr/lib/texinfo

### Mô tả ngắn

* `info` — Dùng để đọc các trang info, tương tự trang man nhưng thường đi sâu hơn nhiều chứ không chỉ giải thích các tùy chọn dòng lệnh \[Ví dụ, hãy so sánh `man bison` với `info bison`.\]
* `install-info` — Dùng để cài các trang info; nó cập nhật các mục trong tệp chỉ mục của `info`
* `makeinfo` — Dịch các tài liệu nguồn Texinfo thành trang info, văn bản thuần hoặc HTML
* `pdftexi2dvi` — Dùng để định dạng tài liệu Texinfo thành tệp Portable Document Format (PDF)
* `pod2texi` — Chuyển Pod sang định dạng Texinfo
* `texi2any` — Dịch tài liệu nguồn Texinfo sang nhiều định dạng khác
* `texi2dvi` — Dùng để định dạng tài liệu Texinfo thành tệp độc lập thiết bị có thể in được
* `texi2pdf` — Dùng để định dạng tài liệu Texinfo thành tệp Portable Document Format (PDF)
* `texindex` — Dùng để sắp xếp các tệp chỉ mục Texinfo

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/texinfo.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/texinfo.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/texinfo.html)
