---
description: "Gói Perl chứa Practical Extraction and Report Language (ngôn ngữ trích xuất và báo cáo thực dụng)."
---

# 7.9. Perl-5.42.0

Gói Perl chứa Practical Extraction and Report Language (ngôn ngữ trích xuất và báo cáo thực dụng).

* **Thời gian dựng ước tính:** 0.6 SBU
* **Dung lượng đĩa cần:** 295 MB

## 7.9.1. Cài đặt Perl

Chuẩn bị biên dịch Perl:

```bash
sh Configure -des                                         \
             -D prefix=/usr                               \
             -D vendorprefix=/usr                         \
             -D useshrplib                                \
             -D privlib=/usr/lib/perl5/5.42/core_perl     \
             -D archlib=/usr/lib/perl5/5.42/core_perl     \
             -D sitelib=/usr/lib/perl5/5.42/site_perl     \
             -D sitearch=/usr/lib/perl5/5.42/site_perl    \
             -D vendorlib=/usr/lib/perl5/5.42/vendor_perl \
             -D vendorarch=/usr/lib/perl5/5.42/vendor_perl
```

**Ý nghĩa của các tùy chọn Configure:**

**`-des`**

> Đây là tổ hợp của ba tùy chọn: -d dùng giá trị mặc định cho mọi mục; -e đảm bảo hoàn tất mọi tác vụ; -s tắt các thông tin xuất không thiết yếu.

**`-D vendorprefix=/usr`**

> Đảm bảo `perl` biết cách chỉ cho các gói nơi cài các module Perl của chúng.

**`-D useshrplib`**

> Dựng `libperl`, thứ một số module Perl cần, dưới dạng thư viện dùng chung thay vì thư viện tĩnh.

**`-D privlib,-D archlib,-D sitelib,...`**

> Các thiết lập này xác định nơi Perl tìm các module đã cài. Các biên tập viên LFS chọn đặt chúng trong cấu trúc thư mục dựa trên phiên bản MAJOR.MINOR của Perl (5.42), cho phép nâng cấp Perl lên các mức vá (patch level) mới hơn (mức vá là phần cuối phân tách bằng dấu chấm trong chuỗi phiên bản đầy đủ, như 5.42.0) mà không cần cài lại mọi module.

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make install
```

Chi tiết về gói này nằm trong [Mục 8.43.2, “Nội dung của Perl.”](../chapter08/perl.md#contents-perl)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/perl.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/perl.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/perl.html)
