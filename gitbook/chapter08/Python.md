---
description: "Gói Python 3 chứa môi trường phát triển Python. Nó hữu ích cho lập trình hướng đối tượng, viết script, tạo nguyên mẫu cho chương trình lớn và phát triển cả"
---

# 8.51. Python-3.13.7

Gói Python 3 chứa môi trường phát triển Python. Nó hữu ích cho lập trình hướng đối tượng, viết script, tạo nguyên mẫu cho chương trình lớn và phát triển cả ứng dụng hoàn chỉnh. Python là một ngôn ngữ máy tính thông dịch.

* **Thời gian dựng ước tính:** 2.0 SBU
* **Dung lượng đĩa cần:** 453 MB

## 8.51.1. Cài đặt Python 3

Chuẩn bị biên dịch Python:

```bash
./configure --prefix=/usr          \
            --enable-shared        \
            --with-system-expat    \
            --enable-optimizations \
            --without-static-libpython
```

**Ý nghĩa các tùy chọn configure:**

**`--with-system-expat`**

> Tùy chọn này bật việc liên kết với phiên bản `Expat` của hệ thống.

**`--enable-optimizations`**

> Tùy chọn này bật các bước tối ưu hóa mở rộng nhưng tốn thời gian. Trình thông dịch được dựng hai lần; các bài kiểm tra chạy trên bản dựng đầu được dùng để cải thiện bản cuối đã tối ưu.

Biên dịch gói:

```bash
make
```

Một số bài kiểm thử đôi khi bị treo vô thời hạn. Vì vậy, để kiểm thử kết quả, hãy chạy bộ kiểm thử nhưng đặt giới hạn thời gian 2 phút cho mỗi test case:

```bash
make test TESTOPTS="--timeout 120"
```

Với hệ thống tương đối chậm, bạn có thể cần tăng giới hạn thời gian, và 1 SBU (đo khi dựng Binutils pass 1 với một nhân CPU) là đủ. Một số bài kiểm thử không ổn định, nên bộ kiểm thử sẽ tự động chạy lại các bài thất bại. Nếu một bài thất bại nhưng chạy lại thì đạt, hãy coi như nó đã đạt. Có một bài, test\_ssl, được biết là sẽ thất bại trong môi trường chroot.

Cài đặt gói:

```bash
make install
```

Ở nhiều chỗ trong sách này, chúng ta dùng lệnh `pip3` để cài các chương trình và module Python 3 cho mọi người dùng bằng `root`. Điều này đi ngược khuyến nghị của các nhà phát triển Python: cài gói vào môi trường ảo, hoặc vào thư mục home của người dùng thường (bằng cách chạy `pip3` với người dùng đó). Một cảnh báo nhiều dòng sẽ hiện ra mỗi khi người dùng `root` chạy `pip3`.

Lý do chính của khuyến nghị này là tránh xung đột với trình quản lý gói của hệ thống (ví dụ `dpkg`). LFS không có trình quản lý gói toàn hệ thống nên đây không phải vấn đề. Ngoài ra, `pip3` sẽ kiểm tra phiên bản mới của chính nó mỗi khi chạy. Vì phân giải tên miền chưa được cấu hình trong môi trường chroot của LFS, `pip3` không thể kiểm tra phiên bản mới của chính nó và sẽ in ra một cảnh báo.

Sau khi khởi động hệ thống LFS và thiết lập kết nối mạng, một cảnh báo khác sẽ hiện, bảo người dùng cập nhật `pip3` từ wheel dựng sẵn trên PyPI (mỗi khi có phiên bản mới). Nhưng LFS coi `pip3` là một phần của Python 3, nên không nên cập nhật riêng. Hơn nữa, cập nhật từ wheel dựng sẵn sẽ đi chệch mục tiêu của chúng ta: dựng một hệ thống Linux từ mã nguồn. Vì vậy cảnh báo về phiên bản mới của `pip3` cũng nên được bỏ qua. Nếu muốn, bạn có thể tắt toàn bộ các cảnh báo này bằng lệnh sau, lệnh này tạo một tệp cấu hình:

```bash
cat > /etc/pip.conf << EOF
[global]
root-user-action = ignore
disable-pip-version-check = true
EOF
```

{% hint style="warning" %}
**Quan trọng**

Trong LFS và BLFS, chúng ta thường dựng và cài các module Python bằng lệnh `pip3`. Hãy chắc chắn các lệnh `pip3 install` trong cả hai sách được chạy bằng người dùng `root` (trừ khi dành cho môi trường ảo Python). Chạy `pip3 install` bằng người dùng không phải `root` có vẻ vẫn chạy được, nhưng module được cài sẽ không truy cập được đối với những người dùng khác.

`pip3 install` sẽ không tự động cài lại một module đã được cài. Khi dùng lệnh `pip3 install` để nâng cấp module (ví dụ từ meson-0.61.3 lên meson-0.62.0), hãy thêm tùy chọn `--upgrade` vào dòng lệnh. Nếu thực sự cần hạ cấp một module, hoặc cài lại cùng phiên bản vì lý do nào đó, hãy thêm `--force-reinstall --no-deps` vào dòng lệnh.
{% endhint %}

Nếu muốn, cài tài liệu đã định dạng sẵn:

```bash
install -v -dm755 /usr/share/doc/python-3.13.7/html

tar --strip-components=1  \
    --no-same-owner       \
    --no-same-permissions \
    -C /usr/share/doc/python-3.13.7/html \
    -xvf ../python-3.13.7-docs-html.tar.bz2
```

**Ý nghĩa của các lệnh cài tài liệu:**

**`--no-same-owner` và `--no-same-permissions`**

> Đảm bảo các tệp được cài có quyền sở hữu và quyền truy cập đúng. Nếu không có các tùy chọn này, `tar` sẽ cài các tệp của gói với giá trị của người tạo gốc.

## 8.51.2. Nội dung của Python 3

* **Chương trình được cài:** 2to3, idle3, pip3, pydoc3, python3 và python3-config
* **Thư viện được cài:** libpython3.13.so và libpython3.so
* **Thư mục được cài:** /usr/include/python3.13, /usr/lib/python3 và /usr/share/doc/python-3.13.7

### Mô tả ngắn

* `2to3` — là chương trình `Python` đọc mã nguồn `Python 2.x` và áp dụng một loạt bản sửa để chuyển nó thành mã `Python 3.x` hợp lệ
* `idle3` — là script bao bọc (wrapper) mở trình soạn thảo GUI nhận biết `Python`. Để script này chạy, bạn phải cài `Tk` trước Python, để module Python Tkinter được dựng.
* `pip3` — Trình cài đặt gói cho Python. Bạn có thể dùng pip để cài các gói từ Python Package Index và các index khác.
* `pydoc3` — là công cụ tài liệu của `Python`
* `python3` — là trình thông dịch của Python, một ngôn ngữ lập trình thông dịch, tương tác, hướng đối tượng

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/Python.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/Python.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/Python.html)
