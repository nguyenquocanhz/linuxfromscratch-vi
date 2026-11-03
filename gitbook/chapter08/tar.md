---
description: "Gói Tar cho phép tạo các kho lưu trữ tar cũng như thực hiện nhiều thao tác khác trên kho lưu trữ. Tar có thể dùng trên các kho đã tạo để giải nén tệp, thêm"
---

# 8.71. Tar-1.35

Gói Tar cho phép tạo các kho lưu trữ tar cũng như thực hiện nhiều thao tác khác trên kho lưu trữ. Tar có thể dùng trên các kho đã tạo để giải nén tệp, thêm tệp mới, hoặc cập nhật và liệt kê các tệp đã lưu.

* **Thời gian dựng ước tính:** 0.6 SBU
* **Dung lượng đĩa cần:** 43 MB

## 8.71.1. Cài đặt Tar

Chuẩn bị biên dịch Tar:

```bash
FORCE_UNSAFE_CONFIGURE=1  \
./configure --prefix=/usr
```

**Ý nghĩa của tùy chọn configure:**

**`FORCE_UNSAFE_CONFIGURE=1`**

> Tùy chọn này buộc bài kiểm tra `mknod` chạy bằng `root`. Thông thường chạy bài kiểm tra này với người dùng `root` được coi là nguy hiểm, nhưng vì nó đang chạy trên một hệ thống mới dựng dở nên bỏ qua cảnh báo này là chấp nhận được.

Biên dịch gói:

```bash
make
```

Để kiểm thử kết quả, chạy:

```bash
make check
```

Có một bài kiểm thử, capabilities: binary store/restore, được biết là sẽ thất bại nếu chạy vì LFS không có selinux, nhưng nó sẽ bị bỏ qua nếu kernel của máy host không hỗ trợ thuộc tính mở rộng hoặc nhãn bảo mật trên hệ thống tệp dùng để dựng LFS.

Cài đặt gói:

```bash
make install
make -C doc install-html docdir=/usr/share/doc/tar-1.35
```

## 8.71.2. Nội dung của Tar

* **Chương trình được cài:** tar
* **Thư mục được cài:** /usr/share/doc/tar-1.35

### Mô tả ngắn

* `tar` — Tạo, giải nén và liệt kê nội dung của các kho lưu trữ, còn gọi là tarball

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/tar.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/tar.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/tar.html)
