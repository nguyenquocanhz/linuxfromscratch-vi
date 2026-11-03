---
description: "Gói Diffutils chứa các chương trình hiển thị sự khác biệt giữa các tệp hoặc thư mục."
---

# 6.6. Diffutils-3.12

Gói Diffutils chứa các chương trình hiển thị sự khác biệt giữa các tệp hoặc thư mục.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 35 MB

## 6.6.1. Cài đặt Diffutils

Chuẩn bị biên dịch Diffutils:

```bash
./configure --prefix=/usr   \
            --host=$LFS_TGT \
            gl_cv_func_strcasecmp_works=y \
            --build=$(./build-aux/config.guess)
```

**Ý nghĩa các tùy chọn configure:**

**`gl_cv_func_strcasecmp_works=y`**

> Tùy chọn này chỉ định sẵn kết quả của phép kiểm tra `strcasecmp`. Phép kiểm tra đó cần chạy một chương trình C đã biên dịch, điều bất khả thi khi biên dịch chéo vì nói chung chương trình biên dịch chéo không chạy được trên distro host. Thông thường với phép kiểm tra như vậy, script `configure` sẽ dùng một giá trị dự phòng cho biên dịch chéo, nhưng phép kiểm tra này lại không có giá trị dự phòng, nên `configure` không có giá trị nào để dùng và báo lỗi. Upstream đã sửa vấn đề này, nhưng để áp dụng bản sửa ta phải chạy `autoconf`, thứ mà distro host có thể không có. Vì vậy ta chỉ cần chỉ định sẵn kết quả kiểm tra (`y`, vì ta biết hàm `strcasecmp` trong Glibc-2.42 hoạt động tốt), khi đó `configure` sẽ dùng giá trị được chỉ định và bỏ qua phép kiểm tra.

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make DESTDIR=$LFS install
```

Chi tiết về gói này có ở [Mục 8.60.2, “Contents of Diffutils.”](../chapter08/diffutils.md#contents-diffutils)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/diffutils.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/diffutils.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/diffutils.html)
