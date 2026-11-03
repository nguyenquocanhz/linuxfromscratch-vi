---
description: "Gói Binutils chứa trình liên kết (linker), trình hợp ngữ (assembler) và các công cụ khác để xử lý tệp đối tượng."
---

# 6.17. Binutils-2.45 - Lượt 2

Gói Binutils chứa trình liên kết (linker), trình hợp ngữ (assembler) và các công cụ khác để xử lý tệp đối tượng.

* **Thời gian dựng ước tính:** 0.4 SBU
* **Dung lượng đĩa cần:** 548 MB

## 6.17.1. Cài đặt Binutils

Hệ thống dựng Binutils dựa vào một bản libtool đi kèm để liên kết với các thư viện tĩnh nội bộ, nhưng các bản libiberty và zlib đi kèm trong gói lại không dùng libtool. Sự không nhất quán này có thể khiến các tệp nhị phân tạo ra bị liên kết nhầm với thư viện của distro host. Hãy xử lý vấn đề này:

```bash
sed '6031s/$add_dir//' -i ltmain.sh
```

Tạo lại một thư mục dựng riêng:

```bash
mkdir -v build
cd       build
```

Chuẩn bị biên dịch Binutils:

```bash
../configure                   \
    --prefix=/usr              \
    --build=$(../config.guess) \
    --host=$LFS_TGT            \
    --disable-nls              \
    --enable-shared            \
    --enable-gprofng=no        \
    --disable-werror           \
    --enable-64-bit-bfd        \
    --enable-new-dtags         \
    --enable-default-hash-style=gnu
```

**Ý nghĩa các tùy chọn configure mới:**

**`--enable-shared`**

> Dựng `libbfd` dưới dạng thư viện chia sẻ.

**`--enable-64-bit-bfd`**

> Bật hỗ trợ 64-bit (trên các máy host có độ dài từ nhỏ hơn). Có thể không cần trên hệ thống 64-bit, nhưng cũng không có hại.

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make DESTDIR=$LFS install
```

Xóa các tệp lưu trữ libtool vì chúng gây hại cho biên dịch chéo, và xóa các thư viện tĩnh không cần thiết:

```bash
rm -v $LFS/usr/lib/lib{bfd,ctf,ctf-nobfd,opcodes,sframe}.{a,la}
```

Chi tiết về gói này có ở [Mục 8.20.2, “Contents of Binutils.”](../chapter08/binutils.md#contents-binutils)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/binutils-pass2.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/binutils-pass2.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/binutils-pass2.html)
