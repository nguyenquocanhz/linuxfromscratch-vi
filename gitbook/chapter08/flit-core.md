---
description: "Flit-core là các phần dùng để dựng bản phân phối của Flit (một công cụ đóng gói cho các module Python đơn giản)."
---

# 8.52. Flit-Core-3.12.0

Flit-core là các phần dùng để dựng bản phân phối của Flit (một công cụ đóng gói cho các module Python đơn giản).

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 1.3 MB

## 8.52.1. Cài đặt Flit-Core

Dựng gói:

```bash
pip3 wheel -w dist --no-cache-dir --no-build-isolation --no-deps $PWD
```

Cài đặt gói:

```bash
pip3 install --no-index --find-links dist flit_core
```

**Ý nghĩa các tùy chọn cấu hình và lệnh pip3:**

**`wheel`**

> Lệnh này dựng tệp nén wheel cho gói.

**`-w dist`**

> Yêu cầu pip đặt wheel vừa tạo vào thư mục `dist`.

**`--no-cache-dir`**

> Ngăn pip sao chép wheel vừa tạo vào thư mục `/root/.cache/pip`.

**`install`**

> Lệnh này cài đặt gói.

**`--no-build-isolation`, `--no-deps`, và `--no-index`**

> Các tùy chọn này ngăn việc tải tệp từ kho gói trực tuyến (PyPI). Nếu các gói được cài theo đúng thứ tự thì ngay từ đầu pip đã không cần tải tệp nào; các tùy chọn này chỉ thêm một lớp an toàn phòng khi người dùng nhầm lẫn.

**`--find-links dist`**

> Yêu cầu pip tìm các tệp nén wheel trong thư mục `dist`.

## 8.52.2. Nội dung của Flit-Core

* **Thư mục được cài:** /usr/lib/python3.13/site-packages/flit\_core và /usr/lib/python3.13/site-packages/flit\_core-3.12.0.dist-info

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/flit-core.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/flit-core.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/flit-core.html)
