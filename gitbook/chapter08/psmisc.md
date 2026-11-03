---
description: "Gói Psmisc chứa các chương trình để hiển thị thông tin về các tiến trình đang chạy."
---

# 8.32. Psmisc-23.7

Gói Psmisc chứa các chương trình để hiển thị thông tin về các tiến trình đang chạy.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 6.7 MB

## 8.32.1. Cài đặt Psmisc

Chuẩn bị biên dịch Psmisc:

```bash
./configure --prefix=/usr
```

Biên dịch gói:

```bash
make
```

Để chạy bộ kiểm thử, chạy:

```bash
make check
```

Cài đặt gói:

```bash
make install
```

## 8.32.2. Nội dung của Psmisc

* **Chương trình được cài:** fuser, killall, peekfd, prtstat, pslog, pstree và pstree.x11 (liên kết tới pstree)

### Mô tả ngắn

* `fuser` — Báo cáo Process ID (PID) của các tiến trình đang dùng các tệp hoặc hệ thống tệp được chỉ định
* `killall` — Dừng tiến trình theo tên; gửi tín hiệu đến mọi tiến trình đang chạy bất kỳ lệnh nào được chỉ định
* `peekfd` — Xem trộm các file descriptor của một tiến trình đang chạy, dựa trên PID của nó
* `prtstat` — In thông tin về một tiến trình
* `pslog` — Báo cáo đường dẫn nhật ký hiện tại của một tiến trình
* `pstree` — Hiển thị các tiến trình đang chạy dưới dạng cây
* `pstree.x11` — Giống `pstree`, nhưng chờ xác nhận trước khi thoát

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/psmisc.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/psmisc.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/psmisc.html)
