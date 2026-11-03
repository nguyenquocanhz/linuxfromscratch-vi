---
description: "Meson là hệ thống dựng mã nguồn mở, được thiết kế để vừa cực nhanh vừa thân thiện với người dùng nhất có thể."
---

# 8.57. Meson-1.8.3

Meson là hệ thống dựng mã nguồn mở, được thiết kế để vừa cực nhanh vừa thân thiện với người dùng nhất có thể.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 45 MB

## 8.57.1. Cài đặt Meson

Biên dịch Meson bằng lệnh sau:

```bash
pip3 wheel -w dist --no-cache-dir --no-build-isolation --no-deps $PWD
```

Bộ kiểm thử cần một số gói nằm ngoài phạm vi của LFS.

Cài đặt gói:

```bash
pip3 install --no-index --find-links dist meson
install -vDm644 data/shell-completions/bash/meson /usr/share/bash-completion/completions/meson
install -vDm644 data/shell-completions/zsh/_meson /usr/share/zsh/site-functions/_meson
```

**Ý nghĩa của các tham số cài đặt:**

**`-w dist`**

> Đặt các wheel được tạo ra vào thư mục `dist`.

**`--find-links dist`**

> Cài các wheel từ thư mục `dist`.

## 8.57.2. Nội dung của Meson

* **Chương trình được cài:** meson
* **Thư mục được cài:** /usr/lib/python3.13/site-packages/meson-1.8.3.dist-info và /usr/lib/python3.13/site-packages/mesonbuild

### Mô tả ngắn

* `meson` — Hệ thống dựng giúp tăng năng suất

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/meson.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/meson.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/meson.html)
