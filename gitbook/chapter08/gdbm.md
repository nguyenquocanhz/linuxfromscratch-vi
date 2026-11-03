---
description: "Gói GDBM chứa GNU Database Manager. Đây là thư viện các hàm cơ sở dữ liệu dùng băm mở rộng (extensible hashing) và hoạt động giống dbm chuẩn của UNIX. Thư "
---

# 8.38. GDBM-1.26

Gói GDBM chứa GNU Database Manager. Đây là thư viện các hàm cơ sở dữ liệu dùng băm mở rộng (extensible hashing) và hoạt động giống dbm chuẩn của UNIX. Thư viện cung cấp các nguyên hàm để lưu cặp khóa/dữ liệu, tìm kiếm và lấy dữ liệu theo khóa, cũng như xóa một khóa cùng dữ liệu của nó.

* **Thời gian dựng ước tính:** dưới 0.2 SBU
* **Dung lượng đĩa cần:** 13 MB

## 8.38.1. Cài đặt GDBM

Chuẩn bị biên dịch GDBM:

```bash
./configure --prefix=/usr    \
            --disable-static \
            --enable-libgdbm-compat
```

**Ý nghĩa tùy chọn configure:**

**`--enable-libgdbm-compat`**

> Tùy chọn này bật việc dựng thư viện tương thích libgdbm. Một số gói ngoài LFS có thể cần các routine DBM cũ mà thư viện này cung cấp.

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

## 8.38.2. Nội dung của GDBM

* **Chương trình được cài:** gdbm\_dump, gdbm\_load, và gdbmtool
* **Thư viện được cài:** libgdbm.so và libgdbm\_compat.so

### Mô tả ngắn

* `gdbm_dump` — Dump một cơ sở dữ liệu GDBM ra tệp
* `gdbm_load` — Tạo lại cơ sở dữ liệu GDBM từ một tệp dump
* `gdbmtool` — Kiểm tra và sửa đổi một cơ sở dữ liệu GDBM
* `libgdbm` — Chứa các hàm để thao tác với cơ sở dữ liệu băm
* `libgdbm_compat` — Thư viện tương thích chứa các hàm DBM cũ hơn

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/gdbm.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/gdbm.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/gdbm.html)
