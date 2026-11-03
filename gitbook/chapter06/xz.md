---
description: "Gói Xz chứa các chương trình để nén và giải nén tệp. Nó hỗ trợ các định dạng nén lzma và xz (mới hơn). Nén tệp văn bản bằng xz cho tỷ lệ nén tốt hơn so với"
---

# 6.16. Xz-5.8.1

Gói Xz chứa các chương trình để nén và giải nén tệp. Nó hỗ trợ các định dạng nén lzma và xz (mới hơn). Nén tệp văn bản bằng `xz` cho tỷ lệ nén tốt hơn so với các lệnh truyền thống như `gzip` hay `bzip2`.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 23 MB

## 6.16.1. Cài đặt Xz

Chuẩn bị biên dịch Xz:

```bash
./configure --prefix=/usr                     \
            --host=$LFS_TGT                   \
            --build=$(build-aux/config.guess) \
            --disable-static                  \
            --docdir=/usr/share/doc/xz-5.8.1
```

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make DESTDIR=$LFS install
```

Xóa tệp lưu trữ libtool vì nó gây hại khi biên dịch chéo:

```bash
rm -v $LFS/usr/lib/liblzma.la
```

Chi tiết về gói này nằm trong [Mục 8.8.2, “Nội dung của Xz.”](../chapter08/xz.md#contents-xz)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/xz.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/xz.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/xz.html)
