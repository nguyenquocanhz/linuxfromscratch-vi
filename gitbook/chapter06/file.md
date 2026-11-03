---
description: "Gói File chứa một tiện ích để xác định loại của một hoặc nhiều tệp."
---

# 6.7. File-5.46

Gói File chứa một tiện ích để xác định loại của một hoặc nhiều tệp.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 42 MB

## 6.7.1. Cài đặt File

Lệnh `file` trên máy host build phải cùng phiên bản với bản chúng ta sắp dựng thì mới tạo được tệp signature. Chạy các lệnh sau để tạo một bản sao tạm của lệnh `file`:

```bash
mkdir build
pushd build
  ../configure --disable-bzlib      \
               --disable-libseccomp \
               --disable-xzlib      \
               --disable-zlib
  make
popd
```

**Ý nghĩa của tùy chọn configure mới:**

**`--disable-*`**

> Script configure cố gắng dùng một số gói của bản phân phối host nếu thấy các tệp thư viện tương ứng. Việc này có thể làm biên dịch thất bại khi tệp thư viện tồn tại nhưng tệp header tương ứng thì không. Các tùy chọn này ngăn script dùng những tính năng không cần thiết từ host.

Chuẩn bị biên dịch File:

```bash
./configure --prefix=/usr --host=$LFS_TGT --build=$(./config.guess)
```

Biên dịch gói:

```bash
make FILE_COMPILE=$(pwd)/build/src/file
```

Cài đặt gói:

```bash
make DESTDIR=$LFS install
```

Xóa tệp lưu trữ libtool vì nó gây hại khi biên dịch chéo:

```bash
rm -v $LFS/usr/lib/libmagic.la
```

Chi tiết về gói này nằm trong [Mục 8.11.2, “Nội dung của File.”](../chapter08/file.md#contents-file)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/file.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/file.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/file.html)
