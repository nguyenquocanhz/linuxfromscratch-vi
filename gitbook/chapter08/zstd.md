---
description: "Zstandard là thuật toán nén thời gian thực, cho tỷ lệ nén cao. Nó có dải đánh đổi giữa mức nén và tốc độ rất rộng, đồng thời được hỗ trợ bởi một bộ giải mã"
---

# 8.10. Zstd-1.5.7

Zstandard là thuật toán nén thời gian thực, cho tỷ lệ nén cao. Nó có dải đánh đổi giữa mức nén và tốc độ rất rộng, đồng thời được hỗ trợ bởi một bộ giải mã cực nhanh.

* **Thời gian dựng ước tính:** 0.4 SBU
* **Dung lượng đĩa cần:** 86 MB

## 8.10.1. Cài đặt Zstd

Biên dịch gói:

```bash
make prefix=/usr
```

{% hint style="info" %}
**Note**

Trong đầu ra kiểm thử có vài chỗ ghi 'failed'. Đó là điều bình thường; chỉ 'FAIL' mới là kiểm thử thất bại thật sự. Không được có kiểm thử nào thất bại.
{% endhint %}

Để kiểm thử kết quả, chạy:

```bash
make check
```

Cài đặt gói:

```bash
make prefix=/usr install
```

Xóa thư viện tĩnh:

```bash
rm -v /usr/lib/libzstd.a
```

## 8.10.2. Nội dung của Zstd

* **Chương trình được cài:** zstd, zstdcat (liên kết tới zstd), zstdgrep, zstdless, zstdmt (liên kết tới zstd) và unzstd (liên kết tới zstd)
* **Thư viện được cài:** libzstd.so

### Mô tả ngắn

* `zstd` — Nén hoặc giải nén tệp bằng định dạng ZSTD
* `zstdgrep` — Chạy `grep` trên các tệp nén bằng ZSTD
* `zstdless` — Chạy `less` trên các tệp nén bằng ZSTD
* `libzstd` — Thư viện cài đặt phương pháp nén dữ liệu không mất mát, dùng thuật toán ZSTD

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/zstd.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/zstd.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/zstd.html)
