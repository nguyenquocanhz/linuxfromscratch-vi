---
description: "Gói SysVinit chứa các chương trình điều khiển việc khởi động, vận hành và tắt hệ thống."
---

# 8.82. SysVinit-3.14

Gói SysVinit chứa các chương trình điều khiển việc khởi động, vận hành và tắt hệ thống.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 3.9 MB

## 8.82.1. Cài đặt SysVinit

Trước tiên, áp dụng một bản vá (patch) để loại bỏ vài chương trình do các gói khác cài, làm rõ một thông báo và sửa một cảnh báo của trình biên dịch:

```bash
patch -Np1 -i ../sysvinit-3.14-consolidated-1.patch
```

Biên dịch gói:

```bash
make
```

Gói này không đi kèm bộ kiểm thử.

Cài đặt gói:

```bash
make install
```

## 8.82.2. Nội dung của SysVinit

* **Chương trình được cài:** bootlogd, fstab-decode, halt, init, killall5, poweroff (liên kết tới halt), reboot (liên kết tới halt), runlevel, shutdown và telinit (liên kết tới init)

### Mô tả ngắn

* `bootlogd` — Ghi các thông điệp khởi động vào một tệp nhật ký
* `fstab-decode` — Chạy một lệnh với các đối số được mã hóa theo kiểu fstab
* `halt` — Thường gọi `shutdown` với tùy chọn `-h`, nhưng khi đang ở run-level 0 thì nó báo kernel dừng hệ thống; nó ghi vào tệp `/var/log/wtmp` rằng hệ thống đang tắt
* `init` — Tiến trình đầu tiên được khởi chạy sau khi kernel khởi tạo xong phần cứng; nó tiếp quản quá trình khởi động và chạy mọi tiến trình được chỉ định trong tệp cấu hình của nó
* `killall5` — Gửi tín hiệu tới mọi tiến trình, trừ các tiến trình thuộc cùng phiên (session) của nó; nó sẽ không giết shell cha của mình
* `poweroff` — Báo kernel dừng hệ thống và tắt máy (xem `halt`)
* `reboot` — Báo kernel khởi động lại hệ thống (xem `halt`)
* `runlevel` — Báo run-level trước đó và hiện tại, theo bản ghi run-level cuối cùng trong `/run/utmp`
* `shutdown` — Tắt hệ thống một cách an toàn, gửi tín hiệu tới mọi tiến trình và thông báo cho mọi người dùng đang đăng nhập
* `telinit` — Cho `init` biết cần chuyển sang run-level nào

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/sysvinit.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/sysvinit.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/sysvinit.html)
