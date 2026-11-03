---
description: "Gói Groff chứa các chương trình để xử lý và định dạng văn bản và hình ảnh."
---

# 8.63. Groff-1.23.0

Gói Groff chứa các chương trình để xử lý và định dạng văn bản và hình ảnh.

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 108 MB

## 8.63.1. Cài đặt Groff

Groff mong đợi biến môi trường `PAGE` chứa khổ giấy mặc định. Với người dùng ở Hoa Kỳ, `PAGE=letter` là phù hợp. Ở nơi khác, `PAGE=A4` có thể thích hợp hơn. Khổ giấy mặc định được cấu hình lúc biên dịch, nhưng sau này có thể ghi đè bằng cách echo “A4” hoặc “letter” vào tệp `/etc/papersize`.

Chuẩn bị biên dịch Groff:

```bash
PAGE=<paper_size> ./configure --prefix=/usr
```

Dựng gói:

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

## 8.63.2. Nội dung của Groff

* **Chương trình được cài:** addftinfo, afmtodit, chem, eqn, eqn2graph, gdiffmk, glilypond, gperl, gpinyin, grap2graph, grn, grodvi, groff, groffer, grog, grolbp, grolj4, gropdf, grops, grotty, hpftodit, indxbib, lkbib, lookbib, mmroff, neqn, nroff, pdfmom, pdfroff, pfbtops, pic, pic2graph, post-grohtml, preconv, pre-grohtml, refer, roff2dvi, roff2html, roff2pdf, roff2ps, roff2text, roff2x, soelim, tbl, tfmtodit, và troff
* **Thư mục được cài:** /usr/lib/groff và /usr/share/doc/groff-1.23.0, /usr/share/groff

### Mô tả ngắn

* `addftinfo` — Đọc một tệp phông troff và bổ sung một số thông tin đo phông (font-metric) mà hệ thống `groff` sử dụng
* `afmtodit` — Tạo tệp phông để dùng với `groff` và `grops`
* `chem` — Bộ tiền xử lý của Groff để vẽ sơ đồ cấu trúc hóa học
* `eqn` — Biên dịch các mô tả phương trình nhúng trong tệp đầu vào troff thành các lệnh mà `troff` hiểu được
* `eqn2graph` — Chuyển một phương trình EQN của troff thành ảnh đã cắt gọn
* `gdiffmk` — Đánh dấu sự khác biệt giữa các tệp groff/nroff/troff
* `glilypond` — Chuyển bản nhạc viết bằng ngôn ngữ lilypond sang ngôn ngữ groff
* `gperl` — Bộ tiền xử lý cho groff, cho phép chèn mã perl vào các tệp groff
* `gpinyin` — Bộ tiền xử lý cho groff, cho phép chèn Pinyin (tiếng Quan Thoại viết bằng bảng chữ cái Latin) vào các tệp groff.
* `grap2graph` — Chuyển tệp chương trình grap thành ảnh bitmap đã cắt gọn (grap là một ngôn ngữ lập trình Unix cũ để tạo sơ đồ)
* `grn` — Bộ tiền xử lý `groff` cho các tệp gremlin
* `grodvi` — Một driver cho `groff` xuất ra tệp định dạng TeX dvi
* `groff` — Giao diện phía trước của hệ thống định dạng tài liệu groff; thông thường nó chạy chương trình `troff` và một bộ hậu xử lý phù hợp với thiết bị được chọn
* `groffer` — Hiển thị các tệp groff và trang man trên X và terminal tty
* `grog` — Đọc các tệp và đoán xem trong các tùy chọn `groff` `-e`, `-man`, `-me`, `-mm`, `-ms`, `-p`, `-s` và `-t`, tùy chọn nào cần thiết để in các tệp, rồi báo lệnh `groff` kèm các tùy chọn đó
* `grolbp` — Là driver `groff` cho máy in Canon CAPSL (máy in laser dòng LBP-4 và LBP-8)
* `grolj4` — Là driver cho `groff` xuất ra định dạng PCL5, phù hợp với máy in HP LaserJet 4
* `gropdf` — Chuyển đầu ra của GNU `troff` sang PDF
* `grops` — Chuyển đầu ra của GNU `troff` sang PostScript
* `grotty` — Chuyển đầu ra của GNU `troff` sang dạng phù hợp với các thiết bị kiểu máy chữ
* `hpftodit` — Tạo tệp phông để dùng với `groff -Tlj4` từ tệp đo phông gắn thẻ HP
* `indxbib` — Tạo chỉ mục đảo cho các cơ sở dữ liệu thư mục (bibliographic) từ một tệp chỉ định, để dùng với `refer`, `lookbib` và `lkbib`
* `lkbib` — Tìm trong các cơ sở dữ liệu thư mục những tài liệu tham khảo chứa các khóa chỉ định và báo các tham khảo tìm thấy
* `lookbib` — In lời nhắc ra lỗi chuẩn (trừ khi đầu vào chuẩn không phải terminal), đọc một dòng chứa tập từ khóa từ đầu vào chuẩn, tìm trong các cơ sở dữ liệu thư mục của một tệp chỉ định những tham khảo chứa các từ khóa đó, in các tham khảo tìm thấy ra đầu ra chuẩn, và lặp lại cho đến hết đầu vào
* `mmroff` — Một bộ tiền xử lý đơn giản cho `groff`
* `neqn` — Định dạng phương trình cho đầu ra American Standard Code for Information Interchange (ASCII)
* `nroff` — Script giả lập lệnh `nroff` bằng `groff`
* `pdfmom` — Là wrapper quanh groff, giúp tạo tài liệu PDF từ các tệp định dạng bằng macro mom.
* `pdfroff` — Tạo tài liệu pdf bằng groff
* `pfbtops` — Chuyển phông PostScript định dạng `.pfb` sang ASCII
* `pic` — Biên dịch các mô tả hình ảnh nhúng trong tệp đầu vào troff hoặc TeX thành các lệnh mà TeX hoặc `troff` hiểu được
* `pic2graph` — Chuyển sơ đồ PIC thành ảnh đã cắt gọn
* `post-grohtml` — Chuyển đầu ra của GNU `troff` sang HTML
* `preconv` — Chuyển bảng mã của các tệp đầu vào sang dạng mà GNU `troff` hiểu được
* `pre-grohtml` — Chuyển đầu ra của GNU `troff` sang HTML
* `refer` — Sao chép nội dung một tệp ra đầu ra chuẩn, ngoại trừ các dòng nằm giữa *.\[* và *.\]* được hiểu là trích dẫn, còn các dòng giữa *.R1* và *.R2* được hiểu là lệnh chỉ cách xử lý các trích dẫn
* `roff2dvi` — Chuyển các tệp roff sang định dạng DVI
* `roff2html` — Chuyển các tệp roff sang định dạng HTML
* `roff2pdf` — Chuyển các tệp roff sang PDF
* `roff2ps` — Chuyển các tệp roff sang tệp ps
* `roff2text` — Chuyển các tệp roff sang tệp văn bản
* `roff2x` — Chuyển các tệp roff sang các định dạng khác
* `soelim` — Đọc các tệp và thay các dòng dạng *.so file* bằng nội dung của *file* được nêu
* `tbl` — Biên dịch các mô tả bảng nhúng trong tệp đầu vào troff thành các lệnh mà `troff` hiểu được
* `tfmtodit` — Tạo tệp phông để dùng với `groff -Tdvi`
* `troff` — Tương thích cao với `troff` của Unix; thường nên gọi nó qua lệnh `groff`, lệnh này cũng sẽ chạy các bộ tiền xử lý và hậu xử lý theo đúng thứ tự và với đúng tùy chọn

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/groff.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/groff.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/groff.html)
