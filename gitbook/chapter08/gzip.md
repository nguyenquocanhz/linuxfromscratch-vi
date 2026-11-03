---
description: "Ép phần mở rộng .gz lên mọi tệp gzip được chỉ định, để gzip không nén chúng lần nữa; hữu ích khi tên tệp bị cắt ngắn trong lúc truyền"
---

# 8.65. Gzip-1.14

Gói Gzip chứa các chương trình để nén và giải nén tệp.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 21 MB

## 8.65.1. Cài đặt Gzip

Chuẩn bị biên dịch Gzip:

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

## 8.65.2. Nội dung của Gzip

* **Chương trình được cài:** gunzip, gzexe, gzip, uncompress (hard link tới gunzip), zcat, zcmp, zdiff, zegrep, zfgrep, zforce, zgrep, zless, zmore và znew

### Mô tả ngắn

* `gunzip` — Giải nén các tệp gzip
* `gzexe` — Tạo các tệp thực thi tự giải nén
* `gzip` — Nén các tệp đã cho bằng mã hóa Lempel-Ziv (LZ77)
* `uncompress` — Giải nén các tệp đã nén
* `zcat` — Giải nén các tệp gzip đã cho ra đầu ra chuẩn
* `zcmp` — Chạy `cmp` trên các tệp gzip
* `zdiff` — Chạy `diff` trên các tệp gzip
* `zegrep` — Chạy `egrep` trên các tệp gzip
* `zfgrep` — Chạy `fgrep` trên các tệp gzip
* `zforce` — Ép phần mở rộng `.gz` lên mọi tệp gzip được chỉ định, để `gzip` không nén chúng lần nữa; hữu ích khi tên tệp bị cắt ngắn trong lúc truyền
* `zgrep` — Chạy `grep` trên các tệp gzip
* `zless` — Chạy `less` trên các tệp gzip
* `zmore` — Chạy `more` trên các tệp gzip
* `znew` — Nén lại các tệp từ định dạng `compress` sang định dạng `gzip`—từ `.Z` sang `.gz`

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/gzip.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/gzip.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/gzip.html)
