---
description: "Setuptools là công cụ dùng để tải về, dựng, cài đặt, nâng cấp và gỡ cài đặt các gói Python."
---

# 8.55. Setuptools-80.9.0

Setuptools là công cụ dùng để tải về, dựng, cài đặt, nâng cấp và gỡ cài đặt các gói Python.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 25 MB

## 8.55.1. Cài đặt Setuptools

Dựng gói:

```bash
pip3 wheel -w dist --no-cache-dir --no-build-isolation --no-deps $PWD
```

Cài đặt gói:

```bash
pip3 install --no-index --find-links dist setuptools
```

## 8.55.2. Nội dung của Setuptools

* **Thư mục được cài:** /usr/lib/python3.13/site-packages/\_distutils\_hack, /usr/lib/python3.13/site-packages/pkg\_resources, /usr/lib/python3.13/site-packages/setuptools và /usr/lib/python3.13/site-packages/setuptools-80.9.0.dist-info

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/setuptools.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/setuptools.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/setuptools.html)
