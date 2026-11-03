---
description: "Gói DejaGnu chứa một framework để chạy các bộ kiểm thử cho công cụ GNU. Nó được viết bằng expect, vốn dùng Tcl (Tool Command Language)."
---

# 8.18. DejaGNU-1.6.3

Gói `DejaGnu` chứa một framework để chạy các bộ kiểm thử cho công cụ GNU. Nó được viết bằng `expect`, vốn dùng `Tcl` (Tool Command Language).

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 6.9 MB

## 8.18.1. Cài đặt DejaGNU

Upstream khuyến nghị dựng DejaGNU trong một thư mục build riêng:

```bash
mkdir -v build
cd       build
```

Chuẩn bị biên dịch DejaGNU:

```bash
../configure --prefix=/usr
makeinfo --html --no-split -o doc/dejagnu.html ../doc/dejagnu.texi
makeinfo --plaintext       -o doc/dejagnu.txt  ../doc/dejagnu.texi
```

Để kiểm thử kết quả, chạy:

```bash
make check
```

Cài đặt gói:

```bash
make install
install -v -dm755  /usr/share/doc/dejagnu-1.6.3
install -v -m644   doc/dejagnu.{html,txt} /usr/share/doc/dejagnu-1.6.3
```

## 8.18.2. Nội dung của DejaGNU

* **Chương trình được cài:** dejagnu và runtest

### Mô tả ngắn

* `dejagnu` — Trình khởi chạy lệnh phụ trợ của DejaGNU
* `runtest` — Một script bao bọc, tìm shell `expect` phù hợp rồi chạy DejaGNU

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/dejagnu.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/dejagnu.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/dejagnu.html)
