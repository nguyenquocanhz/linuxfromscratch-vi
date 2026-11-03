---
description: "Gói Xz chứa các chương trình để nén và giải nén tệp. Nó hỗ trợ các định dạng nén lzma và xz (mới hơn). Nén tệp văn bản bằng xz cho tỷ lệ nén tốt hơn so với"
---

# 8.8. Xz-5.8.1

Gói Xz chứa các chương trình để nén và giải nén tệp. Nó hỗ trợ các định dạng nén lzma và xz (mới hơn). Nén tệp văn bản bằng `xz` cho tỷ lệ nén tốt hơn so với các lệnh truyền thống `gzip` hay `bzip2`.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 24 MB

## 8.8.1. Cài đặt Xz

Chuẩn bị biên dịch Xz bằng:

```bash
./configure --prefix=/usr    \
            --disable-static \
            --docdir=/usr/share/doc/xz-5.8.1
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

## 8.8.2. Nội dung của Xz

* **Chương trình được cài:** lzcat (liên kết tới xz), lzcmp (liên kết tới xzdiff), lzdiff (liên kết tới xzdiff), lzegrep (liên kết tới xzgrep), lzfgrep (liên kết tới xzgrep), lzgrep (liên kết tới xzgrep), lzless (liên kết tới xzless), lzma (liên kết tới xz), lzmadec, lzmainfo, lzmore (liên kết tới xzmore), unlzma (liên kết tới xz), unxz (liên kết tới xz), xz, xzcat (liên kết tới xz), xzcmp (liên kết tới xzdiff), xzdec, xzdiff, xzegrep (liên kết tới xzgrep), xzfgrep (liên kết tới xzgrep), xzgrep, xzless và xzmore
* **Thư viện được cài:** liblzma.so
* **Thư mục được cài:** /usr/include/lzma và /usr/share/doc/xz-5.8.1

### Mô tả ngắn

* `lzcat` — Giải nén ra đầu ra chuẩn
* `lzcmp` — Chạy `cmp` trên các tệp nén bằng LZMA
* `lzdiff` — Chạy `diff` trên các tệp nén bằng LZMA
* `lzegrep` — Chạy `egrep` trên các tệp nén bằng LZMA
* `lzfgrep` — Chạy `fgrep` trên các tệp nén bằng LZMA
* `lzgrep` — Chạy `grep` trên các tệp nén bằng LZMA
* `lzless` — Chạy `less` trên các tệp nén bằng LZMA
* `lzma` — Nén hoặc giải nén tệp bằng định dạng LZMA
* `lzmadec` — Bộ giải mã nhỏ và nhanh cho các tệp nén bằng LZMA
* `lzmainfo` — Hiển thị thông tin lưu trong phần đầu của tệp nén bằng LZMA
* `lzmore` — Chạy `more` trên các tệp nén bằng LZMA
* `unlzma` — Giải nén tệp bằng định dạng LZMA
* `unxz` — Giải nén tệp bằng định dạng XZ
* `xz` — Nén hoặc giải nén tệp bằng định dạng XZ
* `xzcat` — Giải nén ra đầu ra chuẩn
* `xzcmp` — Chạy `cmp` trên các tệp nén bằng XZ
* `xzdec` — Bộ giải mã nhỏ và nhanh cho các tệp nén bằng XZ
* `xzdiff` — Chạy `diff` trên các tệp nén bằng XZ
* `xzegrep` — Chạy `egrep` trên các tệp nén bằng XZ
* `xzfgrep` — Chạy `fgrep` trên các tệp nén bằng XZ
* `xzgrep` — Chạy `grep` trên các tệp nén bằng XZ
* `xzless` — Chạy `less` trên các tệp nén bằng XZ
* `xzmore` — Chạy `more` trên các tệp nén bằng XZ
* `liblzma` — Thư viện cài đặt phương pháp nén dữ liệu không mất mát theo kiểu sắp xếp khối (block-sorting), dùng thuật toán chuỗi Lempel-Ziv-Markov

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/xz.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/xz.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/xz.html)
