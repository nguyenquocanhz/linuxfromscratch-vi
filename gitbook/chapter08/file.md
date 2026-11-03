---
description: "Gói File chứa một tiện ích để xác định loại của một hoặc nhiều tệp."
---

# 8.11. File-5.46

Gói File chứa một tiện ích để xác định loại của một hoặc nhiều tệp.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 19 MB

## 8.11.1. Cài đặt File

Chuẩn bị biên dịch File:

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

## 8.11.2. Nội dung của File

* **Chương trình được cài:** file
* **Thư viện được cài:** libmagic.so

### Mô tả ngắn

* `file` — Cố gắng phân loại từng tệp được cho; nó làm vậy bằng nhiều phép thử—thử theo hệ thống tệp, thử theo magic number và thử theo ngôn ngữ
* `libmagic` — Chứa các routine nhận dạng magic number, được chương trình `file` sử dụng

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/file.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/file.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/file.html)
