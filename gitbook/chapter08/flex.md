---
description: "Gói Flex chứa một tiện ích để sinh ra các chương trình nhận dạng mẫu (pattern) trong văn bản."
---

# 8.15. Flex-2.6.4

Gói Flex chứa một tiện ích để sinh ra các chương trình nhận dạng mẫu (pattern) trong văn bản.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 33 MB

## 8.15.1. Cài đặt Flex

Chuẩn bị biên dịch Flex:

```bash
./configure --prefix=/usr \
            --docdir=/usr/share/doc/flex-2.6.4 \
            --disable-static
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

Một số chương trình chưa biết đến `flex` và cố chạy tiền thân của nó là `lex`. Để hỗ trợ các chương trình đó, hãy tạo một liên kết tượng trưng tên `lex` chạy `flex` ở chế độ giả lập `lex`, đồng thời tạo trang man của `lex` dưới dạng symlink:

```bash
ln -sv flex   /usr/bin/lex
ln -sv flex.1 /usr/share/man/man1/lex.1
```

## 8.15.2. Nội dung của Flex

* **Chương trình được cài:** flex, flex++ (liên kết tới flex) và lex (liên kết tới flex)
* **Thư viện được cài:** libfl.so
* **Thư mục được cài:** /usr/share/doc/flex-2.6.4

### Mô tả ngắn

* `flex` — Công cụ sinh chương trình nhận dạng mẫu trong văn bản; cho phép đặt quy tắc tìm mẫu một cách linh hoạt, không cần viết một chương trình chuyên dụng
* `flex++` — Phần mở rộng của flex, dùng để sinh mã và lớp C++. Nó là một liên kết tượng trưng tới `flex`
* `lex` — Một liên kết tượng trưng chạy `flex` ở chế độ giả lập `lex`
* `libfl` — Thư viện `flex`

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/flex.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/flex.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/flex.html)
