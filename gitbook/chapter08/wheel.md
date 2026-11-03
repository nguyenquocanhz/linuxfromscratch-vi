---
description: "Wheel là một thư viện Python, là bản cài đặt tham chiếu của chuẩn đóng gói wheel trong Python."
---

# 8.54. Wheel-0.46.1

Wheel là một thư viện Python, là bản cài đặt tham chiếu của chuẩn đóng gói wheel trong Python.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 608 KB

## 8.54.1. Cài đặt Wheel

Biên dịch Wheel bằng lệnh sau:

```bash
pip3 wheel -w dist --no-cache-dir --no-build-isolation --no-deps $PWD
```

Cài đặt Wheel bằng lệnh sau:

```bash
pip3 install --no-index --find-links dist wheel
```

## 8.54.2. Nội dung của Wheel

* **Chương trình được cài:** wheel
* **Thư mục được cài:** /usr/lib/python3.13/site-packages/wheel và /usr/lib/python3.13/site-packages/wheel-0.46.1.dist-info

### Mô tả ngắn

* `wheel` — là tiện ích để giải nén, đóng gói hoặc chuyển đổi các kho wheel

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/wheel.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/wheel.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/wheel.html)
