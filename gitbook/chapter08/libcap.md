---
description: "Gói Libcap cài đặt giao diện userspace cho các capability POSIX 1003.1e có trong kernel Linux. Các capability này chia đặc quyền toàn năng của root thành m"
---

# 8.26. Libcap-2.76

Gói Libcap cài đặt giao diện userspace cho các capability POSIX 1003.1e có trong kernel Linux. Các capability này chia đặc quyền toàn năng của root thành một tập các đặc quyền riêng biệt.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 3.1 MB

## 8.26.1. Cài đặt Libcap

Ngăn không cho cài các thư viện tĩnh:

```bash
sed -i '/install -m.*STA/d' libcap/Makefile
```

Biên dịch gói:

```bash
make prefix=/usr lib=lib
```

**Ý nghĩa của tùy chọn make:**

**`lib=lib`**

> Tham số này đặt thư mục thư viện là `/usr/lib` thay vì `/usr/lib64` trên x86\_64. Nó không có tác dụng trên x86.

Để kiểm thử kết quả, chạy:

```bash
make test
```

Cài đặt gói:

```bash
make prefix=/usr lib=lib install
```

## 8.26.2. Nội dung của Libcap

* **Chương trình được cài:** capsh, getcap, getpcaps và setcap
* **Thư viện được cài:** libcap.so và libpsx.so

### Mô tả ngắn

* `capsh` — Một shell wrapper để khám phá và ràng buộc việc hỗ trợ capability
* `getcap` — Kiểm tra capability của tệp
* `getpcaps` — Hiển thị capability của các tiến trình được truy vấn
* `setcap` — Đặt capability cho tệp
* `libcap` — Chứa các hàm thư viện để thao tác với capability POSIX 1003.1e
* `libpsx` — Chứa các hàm hỗ trợ ngữ nghĩa POSIX cho các syscall liên quan đến thư viện pthread

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/libcap.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/libcap.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/libcap.html)
