---
description: "Xóa hai trang man của các hàm băm mật khẩu. Libxcrypt sẽ cung cấp phiên bản tốt hơn của các trang man này:"
---

# 8.3. Man-pages-6.15

Gói Man-pages chứa hơn 2.400 trang man.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 52 MB

## 8.3.1. Cài đặt Man-pages

Xóa hai trang man của các hàm băm mật khẩu. `Libxcrypt` sẽ cung cấp phiên bản tốt hơn của các trang man này:

```bash
rm -v man3/crypt*
```

Cài Man-pages bằng cách chạy:

```bash
make -R GIT=false prefix=/usr install
```

**Ý nghĩa của các tùy chọn:**

**`-R`**

> Tùy chọn này ngăn `make` đặt các biến dựng sẵn. Hệ thống dựng của man-pages không hoạt động tốt với các biến dựng sẵn, nhưng hiện chưa có cách nào tắt chúng ngoài việc truyền `-R` tường minh qua dòng lệnh.

**`GIT=false`**

> Tùy chọn này ngăn hệ thống dựng in ra nhiều dòng cảnh báo `git: command not found`.

## 8.3.2. Nội dung của Man-pages

* **Tệp được cài:** nhiều trang man khác nhau

### Mô tả ngắn

* `man pages` — Mô tả các hàm của ngôn ngữ lập trình C, các tệp thiết bị quan trọng và các tệp cấu hình thiết yếu

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/man-pages.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/man-pages.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/man-pages.html)
