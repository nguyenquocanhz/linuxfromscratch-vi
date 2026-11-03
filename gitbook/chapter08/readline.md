---
description: "Gói Readline là một bộ thư viện cung cấp khả năng chỉnh sửa dòng lệnh và lưu lịch sử lệnh."
---

# 8.12. Readline-8.3

Gói Readline là một bộ thư viện cung cấp khả năng chỉnh sửa dòng lệnh và lưu lịch sử lệnh.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 17 MB

## 8.12.1. Cài đặt Readline

Cài lại Readline sẽ khiến các thư viện cũ bị đổi tên thành &lt;libraryname&gt;.old. Thông thường điều này không sao, nhưng trong một số trường hợp nó có thể kích hoạt lỗi liên kết trong `ldconfig`. Bạn có thể tránh lỗi này bằng hai lệnh sed sau:

```bash
sed -i '/MV.*old/d' Makefile.in
sed -i '/{OLDSUFF}/c:' support/shlib-install
```

Ngăn việc ghi cứng đường dẫn tìm kiếm thư viện (rpath) vào các thư viện dùng chung. Gói này không cần rpath khi cài vào vị trí chuẩn, và rpath đôi khi gây ra tác dụng ngoài ý muốn, thậm chí là vấn đề bảo mật:

```bash
sed -i 's/-Wl,-rpath,[^ ]*//' support/shobj-conf
```

Chuẩn bị biên dịch Readline:

```bash
./configure --prefix=/usr    \
            --disable-static \
            --with-curses    \
            --docdir=/usr/share/doc/readline-8.3
```

**Ý nghĩa của tùy chọn configure mới:**

**`--with-curses`**

> Tùy chọn này cho Readline biết rằng các hàm của thư viện termcap nằm trong thư viện curses, chứ không phải một thư viện termcap riêng. Nhờ vậy tệp `readline.pc` sẽ được tạo đúng.

Biên dịch gói:

```bash
make SHLIB_LIBS="-lncursesw"
```

**Ý nghĩa của tùy chọn make:**

**`SHLIB_LIBS="-lncursesw"`**

> Tùy chọn này buộc Readline liên kết với thư viện `libncursesw`. Xem thêm chi tiết ở mục “Shared Libraries” trong tệp `README` của gói.

Gói này không đi kèm bộ kiểm thử.

Cài đặt gói:

```bash
make install
```

Nếu muốn, hãy cài đặt tài liệu:

```bash
install -v -m644 doc/*.{ps,pdf,html,dvi} /usr/share/doc/readline-8.3
```

## 8.12.2. Nội dung của Readline

* **Thư viện được cài:** libhistory.so và libreadline.so
* **Thư mục được cài:** /usr/include/readline và /usr/share/doc/readline-8.3

### Mô tả ngắn

* `libhistory` — Cung cấp giao diện người dùng nhất quán để gọi lại các dòng trong lịch sử
* `libreadline` — Cung cấp một bộ lệnh để thao tác văn bản nhập trong phiên tương tác của một chương trình

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/readline.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/readline.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/readline.html)
