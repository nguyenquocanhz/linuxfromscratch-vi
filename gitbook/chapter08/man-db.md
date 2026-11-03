---
description: "Gói Man-DB chứa các chương trình để tìm và xem các trang man."
---

# 8.77. Man-DB-2.13.1

Gói Man-DB chứa các chương trình để tìm và xem các trang man.

* **Thời gian dựng ước tính:** 0.3 SBU
* **Dung lượng đĩa cần:** 44 MB

## 8.77.1. Cài đặt Man-DB

Chuẩn bị biên dịch Man-DB:

```bash
./configure --prefix=/usr                         \
            --docdir=/usr/share/doc/man-db-2.13.1 \
            --sysconfdir=/etc                     \
            --disable-setuid                      \
            --enable-cache-owner=bin              \
            --with-browser=/usr/bin/lynx          \
            --with-vgrind=/usr/bin/vgrind         \
            --with-grap=/usr/bin/grap             \
            --with-systemdtmpfilesdir=            \
            --with-systemdsystemunitdir=
```

**Ý nghĩa các tùy chọn configure:**

**`--disable-setuid`**

> Tùy chọn này tắt việc đặt setuid của chương trình `man` cho người dùng `man`.

**`--enable-cache-owner=bin`**

> Tùy chọn này đổi chủ sở hữu của các tệp cache toàn hệ thống sang người dùng `bin`.

**`--with-...`**

> Ba tham số này dùng để đặt một số chương trình mặc định. `lynx` là trình duyệt web dạng văn bản (xem BLFS để biết cách cài), `vgrind` chuyển mã nguồn chương trình thành đầu vào cho Groff, còn `grap` hữu ích để dàn trang đồ thị trong các tài liệu Groff. Hai chương trình `vgrind` và `grap` thường không cần để xem trang hướng dẫn. Chúng không thuộc LFS hay BLFS, nhưng bạn có thể tự cài sau khi hoàn thành LFS nếu muốn.

**`--with-systemd...`**

> Các tham số này ngăn việc cài những thư mục và tệp systemd không cần thiết.

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

## 8.77.2. Các trang man không phải tiếng Anh trong LFS

Bảng sau cho biết bảng mã ký tự mà Man-DB giả định cho các trang man được cài trong `/usr/share/man/<ll>`. Ngoài ra, Man-DB cũng nhận diện đúng các trang man được cài trong thư mục đó nếu chúng mã hóa bằng UTF-8.

**Bảng 8.1. Bảng mã ký tự dự kiến của các trang man 8-bit cũ**

| Ngôn ngữ (mã) | Bảng mã | Ngôn ngữ (mã) | Bảng mã |
| --- | --- | --- | --- |
| Tiếng Đan Mạch (da) | ISO-8859-1 | Tiếng Croatia (hr) | ISO-8859-2 |
| Tiếng Đức (de) | ISO-8859-1 | Tiếng Hungary (hu) | ISO-8859-2 |
| Tiếng Anh (en) | ISO-8859-1 | Tiếng Nhật (ja) | EUC-JP |
| Tiếng Tây Ban Nha (es) | ISO-8859-1 | Tiếng Hàn (ko) | EUC-KR |
| Tiếng Estonia (et) | ISO-8859-1 | Tiếng Litva (lt) | ISO-8859-13 |
| Tiếng Phần Lan (fi) | ISO-8859-1 | Tiếng Latvia (lv) | ISO-8859-13 |
| Tiếng Pháp (fr) | ISO-8859-1 | Tiếng Macedonia (mk) | ISO-8859-5 |
| Tiếng Ireland (ga) | ISO-8859-1 | Tiếng Ba Lan (pl) | ISO-8859-2 |
| Tiếng Galicia (gl) | ISO-8859-1 | Tiếng Romania (ro) | ISO-8859-2 |
| Tiếng Indonesia (id) | ISO-8859-1 | Tiếng Hy Lạp (el) | ISO-8859-7 |
| Tiếng Iceland (is) | ISO-8859-1 | Tiếng Slovakia (sk) | ISO-8859-2 |
| Tiếng Ý (it) | ISO-8859-1 | Tiếng Slovenia (sl) | ISO-8859-2 |
| Tiếng Na Uy Bokmål (nb) | ISO-8859-1 | Tiếng Serbia chữ Latinh (sr@latin) | ISO-8859-2 |
| Tiếng Hà Lan (nl) | ISO-8859-1 | Tiếng Serbia (sr) | ISO-8859-5 |
| Tiếng Na Uy Nynorsk (nn) | ISO-8859-1 | Tiếng Thổ Nhĩ Kỳ (tr) | ISO-8859-9 |
| Tiếng Na Uy (no) | ISO-8859-1 | Tiếng Ukraina (uk) | KOI8-U |
| Tiếng Bồ Đào Nha (pt) | ISO-8859-1 | Tiếng Việt (vi) | TCVN5712-1 |
| Tiếng Thụy Điển (sv) | ISO-8859-1 | Tiếng Trung giản thể (zh\_CN) | GBK |
| Tiếng Belarus (be) | CP1251 | Tiếng Trung giản thể, Singapore (zh\_SG) | GBK |
| Tiếng Bulgaria (bg) | CP1251 | Tiếng Trung phồn thể, Hồng Kông (zh\_HK) | BIG5HKSCS |
| Tiếng Séc (cs) | ISO-8859-2 | Tiếng Trung phồn thể (zh\_TW) | BIG5 |

{% hint style="info" %}
**Ghi chú**

Các trang man bằng ngôn ngữ không có trong danh sách không được hỗ trợ.
{% endhint %}

## 8.77.3. Nội dung của Man-DB

* **Chương trình được cài:** accessdb, apropos (liên kết tới whatis), catman, lexgrog, man, man-recode, mandb, manpath và whatis
* **Thư viện được cài:** libman.so và libmandb.so (cả hai nằm trong /usr/lib/man-db)
* **Thư mục được cài:** /usr/lib/man-db, /usr/libexec/man-db và /usr/share/doc/man-db-2.13.1

### Mô tả ngắn

* `accessdb` — Xuất nội dung cơ sở dữ liệu `whatis` dưới dạng dễ đọc
* `apropos` — Tìm trong cơ sở dữ liệu `whatis` và hiển thị mô tả ngắn của các lệnh hệ thống có chứa một chuỗi cho trước
* `catman` — Tạo hoặc cập nhật các trang man đã được định dạng sẵn
* `lexgrog` — Hiển thị thông tin tóm tắt một dòng về một trang man cho trước
* `man` — Định dạng và hiển thị trang man được yêu cầu
* `man-recode` — Chuyển các trang man sang bảng mã khác
* `mandb` — Tạo hoặc cập nhật cơ sở dữ liệu `whatis`
* `manpath` — Hiển thị nội dung của $MANPATH hoặc (nếu $MANPATH chưa được đặt) một đường dẫn tìm kiếm phù hợp dựa trên các thiết lập trong man.conf và môi trường của người dùng
* `whatis` — Tìm trong cơ sở dữ liệu `whatis` và hiển thị mô tả ngắn của các lệnh hệ thống có chứa từ khóa cho trước như một từ riêng biệt
* `libman` — Chứa hỗ trợ lúc chạy cho `man`
* `libmandb` — Chứa hỗ trợ lúc chạy cho `man`

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/man-db.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/man-db.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/man-db.html)
