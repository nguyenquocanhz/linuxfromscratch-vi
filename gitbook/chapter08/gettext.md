---
description: "Gói Gettext chứa các tiện ích cho quốc tế hóa (internationalization) và địa phương hóa (localization). Chúng cho phép biên dịch chương trình với NLS (Nativ"
---

# 8.33. Gettext-0.26

Gói Gettext chứa các tiện ích cho quốc tế hóa (internationalization) và địa phương hóa (localization). Chúng cho phép biên dịch chương trình với NLS (Native Language Support, hỗ trợ ngôn ngữ bản địa), để chương trình xuất thông báo bằng ngôn ngữ mẹ đẻ của người dùng.

* **Thời gian dựng ước tính:** 2.1 SBU
* **Dung lượng đĩa cần:** 395 MB

## 8.33.1. Cài đặt Gettext

Chuẩn bị biên dịch Gettext:

```bash
./configure --prefix=/usr    \
            --disable-static \
            --docdir=/usr/share/doc/gettext-0.26
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
chmod -v 0755 /usr/lib/preloadable_libintl.so
```

## 8.33.2. Nội dung của Gettext

* **Chương trình được cài:** autopoint, envsubst, gettext, gettext.sh, gettextize, msgattrib, msgcat, msgcmp, msgcomm, msgconv, msgen, msgexec, msgfilter, msgfmt, msggrep, msginit, msgmerge, msgunfmt, msguniq, ngettext, recode-sr-latin, và xgettext
* **Thư viện được cài:** libasprintf.so, libgettextlib.so, libgettextpo.so, libgettextsrc.so, libtextstyle.so, và preloadable\_libintl.so
* **Thư mục được cài:** /usr/lib/gettext, /usr/share/doc/gettext-0.26, /usr/share/gettext, và /usr/share/gettext-0.26

### Mô tả ngắn

* `autopoint` — Sao chép các tệp hạ tầng chuẩn của Gettext vào một gói mã nguồn
* `envsubst` — Thay thế biến môi trường trong các chuỗi định dạng shell
* `gettext` — Dịch một thông báo ngôn ngữ tự nhiên sang ngôn ngữ của người dùng bằng cách tra bản dịch trong một message catalog
* `gettext.sh` — Chủ yếu đóng vai trò thư viện hàm shell cho gettext
* `gettextize` — Sao chép mọi tệp Gettext chuẩn vào thư mục cấp cao nhất của một gói để bắt đầu quốc tế hóa gói đó
* `msgattrib` — Lọc các thông báo trong một translation catalog theo thuộc tính của chúng và thao tác với các thuộc tính đó
* `msgcat` — Nối và trộn các tệp `.po` đã cho
* `msgcmp` — So sánh hai tệp `.po` để kiểm tra cả hai có cùng một tập chuỗi msgid
* `msgcomm` — Tìm các thông báo chung giữa các tệp `.po` đã cho
* `msgconv` — Chuyển một translation catalog sang bảng mã ký tự khác
* `msgen` — Tạo một translation catalog tiếng Anh
* `msgexec` — Áp dụng một lệnh lên mọi bản dịch của một translation catalog
* `msgfilter` — Áp dụng một bộ lọc lên mọi bản dịch của một translation catalog
* `msgfmt` — Sinh một message catalog nhị phân từ một translation catalog
* `msggrep` — Trích mọi thông báo của một translation catalog khớp một mẫu cho trước hoặc thuộc một số tệp nguồn cho trước
* `msginit` — Tạo một tệp `.po` mới, khởi tạo thông tin meta bằng các giá trị từ môi trường của người dùng
* `msgmerge` — Kết hợp hai bản dịch thô thành một tệp duy nhất
* `msgunfmt` — Dịch ngược một message catalog nhị phân thành văn bản dịch thô
* `msguniq` — Hợp nhất các bản dịch trùng lặp trong một translation catalog
* `ngettext` — Hiển thị bản dịch ngôn ngữ bản địa của một thông báo văn bản mà dạng ngữ pháp phụ thuộc vào một con số
* `recode-sr-latin` — Chuyển mã văn bản tiếng Serbia từ chữ Cyrillic sang chữ Latin
* `xgettext` — Trích các dòng thông báo có thể dịch từ các tệp nguồn đã cho để tạo mẫu dịch đầu tiên
* `libasprintf` — Định nghĩa lớp *autosprintf*, giúp dùng các routine xuất có định dạng của C trong chương trình C++, để dùng với chuỗi *&lt;string&gt;* và luồng *&lt;iostream&gt;*
* `libgettextlib` — Chứa các routine chung được nhiều chương trình Gettext sử dụng; không dành cho mục đích sử dụng thông thường
* `libgettextpo` — Dùng để viết các chương trình chuyên biệt xử lý tệp `.po`; thư viện này được dùng khi các ứng dụng chuẩn đi kèm Gettext (như `msgcomm`, `msgcmp`, `msgattrib` và `msgen`) không đáp ứng đủ
* `libgettextsrc` — Cung cấp các routine chung được nhiều chương trình Gettext sử dụng; không dành cho mục đích sử dụng thông thường
* `libtextstyle` — Thư viện tạo kiểu văn bản (text styling)
* `preloadable_libintl` — Thư viện dùng với LD\_PRELOAD, giúp `libintl` ghi log các thông báo chưa được dịch

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/gettext.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/gettext.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/gettext.html)
