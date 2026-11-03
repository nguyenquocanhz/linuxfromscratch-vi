---
description: "Phiên bản Perl này dựng các module Compress::Raw::Zlib và Compress::Raw::BZip2. Mặc định Perl sẽ dùng bản sao mã nguồn nội bộ để dựng. Chạy lệnh sau để Per"
---

# 8.43. Perl-5.42.0

Gói Perl chứa Practical Extraction and Report Language.

* **Thời gian dựng ước tính:** 1.3 SBU
* **Dung lượng đĩa cần:** 257 MB

## 8.43.1. Cài đặt Perl

Phiên bản Perl này dựng các module Compress::Raw::Zlib và Compress::Raw::BZip2. Mặc định Perl sẽ dùng bản sao mã nguồn nội bộ để dựng. Chạy lệnh sau để Perl dùng các thư viện đã cài trên hệ thống:

```bash
export BUILD_ZLIB=False
export BUILD_BZIP2=0
```

Để kiểm soát hoàn toàn cách thiết lập Perl, bạn có thể bỏ các tùy chọn “-des” khỏi lệnh dưới đây và tự chọn cách dựng gói. Hoặc dùng đúng lệnh như bên dưới để lấy các giá trị mặc định mà Perl tự phát hiện:

```bash
sh Configure -des                                          \
             -D prefix=/usr                                \
             -D vendorprefix=/usr                          \
             -D privlib=/usr/lib/perl5/5.42/core_perl      \
             -D archlib=/usr/lib/perl5/5.42/core_perl      \
             -D sitelib=/usr/lib/perl5/5.42/site_perl      \
             -D sitearch=/usr/lib/perl5/5.42/site_perl     \
             -D vendorlib=/usr/lib/perl5/5.42/vendor_perl  \
             -D vendorarch=/usr/lib/perl5/5.42/vendor_perl \
             -D man1dir=/usr/share/man/man1                \
             -D man3dir=/usr/share/man/man3                \
             -D pager="/usr/bin/less -isR"                 \
             -D useshrplib                                 \
             -D usethreads
```

**Ý nghĩa của các tùy chọn Configure mới:**

**`-D pager="/usr/bin/less -isR"`**

> Đảm bảo dùng `less` thay cho `more`.

**`-D man1dir=/usr/share/man/man1 -D man3dir=/usr/share/man/man3`**

> Vì Groff chưa được cài, `Configure` sẽ không tạo các trang man cho Perl. Các tham số này ghi đè hành vi đó.

**`-D usethreads`**

> Dựng Perl với hỗ trợ đa luồng (thread).

Biên dịch gói:

```bash
make
```

Để kiểm thử kết quả, chạy:

```bash
TEST_JOBS=$(nproc) make test_harness
```

Cài đặt gói và dọn dẹp:

```bash
make install
unset BUILD_ZLIB BUILD_BZIP2
```

## 8.43.2. Nội dung của Perl

* **Chương trình được cài:** corelist, cpan, enc2xs, encguess, h2ph, h2xs, instmodsh, json\_pp, libnetcfg, perl, perl5.42.0 (liên kết cứng tới perl), perlbug, perldoc, perlivp, perlthanks (liên kết cứng tới perlbug), piconv, pl2pm, pod2html, pod2man, pod2text, pod2usage, podchecker, podselect, prove, ptar, ptardiff, ptargrep, shasum, splain, xsubpp và zipdetails
* **Thư viện được cài:** Rất nhiều, không thể liệt kê hết ở đây
* **Thư mục được cài:** /usr/lib/perl5

### Mô tả ngắn

* `corelist` — Front end dòng lệnh cho Module::CoreList
* `cpan` — Tương tác với Comprehensive Perl Archive Network (CPAN) từ dòng lệnh
* `enc2xs` — Dựng một phần mở rộng Perl cho module Encode từ Unicode Character Mappings hoặc Tcl Encoding Files
* `encguess` — Đoán loại bảng mã của một hoặc nhiều tệp
* `h2ph` — Chuyển các tệp header C `.h` thành các tệp header Perl `.ph`
* `h2xs` — Chuyển các tệp header C `.h` thành các phần mở rộng Perl
* `instmodsh` — Shell script để kiểm tra các module Perl đã cài; có thể tạo tarball từ một module đã cài
* `json_pp` — Chuyển đổi dữ liệu giữa một số định dạng đầu vào và đầu ra
* `libnetcfg` — Có thể dùng để cấu hình module Perl `libnet`
* `perl` — Kết hợp một số tính năng hay nhất của C, `sed`, `awk` và `sh` thành một ngôn ngữ đa năng kiểu dao đa dụng Thụy Sĩ
* `perl5.42.0` — Liên kết cứng tới `perl`
* `perlbug` — Dùng để tạo báo cáo lỗi về Perl, hoặc các module đi kèm nó, rồi gửi qua email
* `perldoc` — Hiển thị một phần tài liệu định dạng pod được nhúng trong cây cài đặt Perl hoặc trong một script Perl
* `perlivp` — Perl Installation Verification Procedure (quy trình kiểm tra cài đặt Perl); dùng để xác minh Perl và các thư viện của nó đã được cài đúng
* `perlthanks` — Dùng để tạo thư cảm ơn gửi tới các nhà phát triển Perl
* `piconv` — Bản Perl của bộ chuyển đổi bảng mã ký tự `iconv`
* `pl2pm` — Công cụ sơ sài để chuyển các tệp Perl4 `.pl` thành các module Perl5 `.pm`
* `pod2html` — Chuyển tệp từ định dạng pod sang HTML
* `pod2man` — Chuyển dữ liệu pod thành đầu vào \*roff đã định dạng
* `pod2text` — Chuyển dữ liệu pod thành văn bản ASCII đã định dạng
* `pod2usage` — In thông báo cách dùng từ tài liệu pod nhúng trong các tệp
* `podchecker` — Kiểm tra cú pháp của các tệp tài liệu định dạng pod
* `podselect` — Hiển thị các phần được chọn của tài liệu pod
* `prove` — Công cụ dòng lệnh để chạy các bài kiểm thử với module Test::Harness
* `ptar` — Chương trình giống `tar` viết bằng Perl
* `ptardiff` — Chương trình Perl so sánh một kho lưu trữ đã giải nén với bản chưa giải nén
* `ptargrep` — Chương trình Perl áp dụng khớp mẫu lên nội dung các tệp trong một kho lưu trữ tar
* `shasum` — In hoặc kiểm tra checksum SHA
* `splain` — Dùng để buộc Perl in các chẩn đoán cảnh báo chi tiết
* `xsubpp` — Chuyển mã Perl XS thành mã C
* `zipdetails` — Hiển thị chi tiết về cấu trúc nội bộ của một tệp Zip

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/perl.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/perl.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/perl.html)
