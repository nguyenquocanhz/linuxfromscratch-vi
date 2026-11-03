---
description: "Module packaging là thư viện Python cung cấp các tiện ích cài đặt các đặc tả về khả năng tương tác vốn có một cách hành xử đúng rõ ràng (PEP440) hoặc hưởng"
---

# 8.53. Packaging-25.0

Module packaging là thư viện Python cung cấp các tiện ích cài đặt các đặc tả về khả năng tương tác vốn có một cách hành xử đúng rõ ràng (PEP440) hoặc hưởng lợi lớn từ việc có một bản cài đặt dùng chung duy nhất (PEP425). Gồm các tiện ích xử lý phiên bản, specifier, marker, tag và requirement.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 3.3 MB

## 8.53.1. Cài đặt Packaging

Biên dịch packaging bằng lệnh sau:

```bash
pip3 wheel -w dist --no-cache-dir --no-build-isolation --no-deps $PWD
```

Cài đặt packaging bằng lệnh sau:

```bash
pip3 install --no-index --find-links dist packaging
```

## 8.53.2. Nội dung của Packaging

* **Thư mục được cài:** /usr/lib/python3.13/site-packages/packaging và /usr/lib/python3.13/site-packages/packaging-25.0.dist-info

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/packaging.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/packaging.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/packaging.html)
