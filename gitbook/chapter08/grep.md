---
description: "Gói Grep chứa các chương trình để tìm kiếm trong nội dung tệp."
---

# 8.35. Grep-3.12

Gói Grep chứa các chương trình để tìm kiếm trong nội dung tệp.

* **Thời gian dựng ước tính:** 0.6 SBU
* **Dung lượng đĩa cần:** 48 MB

## 8.35.1. Cài đặt Grep

Trước tiên, hãy loại bỏ cảnh báo về việc dùng egrep và fgrep, vì cảnh báo này làm hỏng bài kiểm thử của một số gói:

```bash
sed -i "s/echo/#echo/" src/egrep.sh
```

Chuẩn bị biên dịch Grep:

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

## 8.35.2. Nội dung của Grep

* **Chương trình được cài:** egrep, fgrep, và grep

### Mô tả ngắn

* `egrep` — In các dòng khớp một biểu thức chính quy mở rộng. Đã lỗi thời, hãy dùng `grep -E` thay thế
* `fgrep` — In các dòng khớp một danh sách chuỗi cố định. Đã lỗi thời, hãy dùng `grep -F` thay thế
* `grep` — In các dòng khớp một biểu thức chính quy cơ bản

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/grep.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/grep.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/grep.html)
