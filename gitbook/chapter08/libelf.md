---
description: "Libelf là thư viện để xử lý các tệp ELF (Executable and Linkable Format)."
---

# 8.49. Libelf từ Elfutils-0.193

Libelf là thư viện để xử lý các tệp ELF (Executable and Linkable Format).

* **Thời gian dựng ước tính:** 0.3 SBU
* **Dung lượng đĩa cần:** 156 MB

## 8.49.1. Cài đặt Libelf

Libelf là một phần của gói elfutils-0.193. Hãy dùng tệp elfutils-0.193.tar.bz2 làm tarball nguồn.

Chuẩn bị biên dịch Libelf:

```bash
./configure --prefix=/usr        \
            --disable-debuginfod \
            --enable-libdebuginfod=dummy
```

Biên dịch gói:

```bash
make
```

Để kiểm thử kết quả, chạy:

```bash
make check
```

Có hai bài kiểm thử được biết là sẽ thất bại: dwarf\_srclang\_check và run-backtrace-native-core.sh.

Chỉ cài Libelf:

```bash
make -C libelf install
install -vm644 config/libelf.pc /usr/lib/pkgconfig
rm /usr/lib/libelf.a
```

## 8.49.2. Nội dung của Libelf

* **Thư viện được cài:** libelf.so
* **Thư mục được cài:** /usr/include/elfutils

### Mô tả ngắn

* `libelf.so` — Chứa các hàm API để xử lý các tệp đối tượng ELF

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/libelf.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/libelf.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/libelf.html)
