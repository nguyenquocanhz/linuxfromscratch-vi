---
description: "Gói Kbd chứa các tệp bảng phím (key-table), phông chữ console và các tiện ích bàn phím."
---

# 8.67. Kbd-2.8.0

Gói Kbd chứa các tệp bảng phím (key-table), phông chữ console và các tiện ích bàn phím.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 43 MB

## 8.67.1. Cài đặt Kbd

Hành vi của phím backspace và delete không nhất quán giữa các keymap trong gói Kbd. Bản vá sau khắc phục vấn đề này cho các keymap i386:

```bash
patch -Np1 -i ../kbd-2.8.0-backspace-1.patch
```

Sau khi vá, phím backspace sinh ra ký tự có mã 127, còn phím delete sinh ra một chuỗi escape quen thuộc.

Xóa chương trình `resizecons` thừa (nó cần svgalib đã ngừng phát triển để cung cấp các tệp chế độ video - với mục đích dùng thông thường, `setfont` sẽ tự chỉnh kích thước console cho phù hợp) cùng với trang man của nó.

```bash
sed -i '/RESIZECONS_PROGS=/s/yes/no/' configure
sed -i 's/resizecons.8 //' docs/man/man8/Makefile.in
```

Chuẩn bị biên dịch Kbd:

```bash
./configure --prefix=/usr --disable-vlock
```

**Ý nghĩa của tùy chọn configure:**

**`--disable-vlock`**

> Tùy chọn này ngăn việc dựng tiện ích vlock vì nó cần thư viện PAM, thứ không có trong môi trường chroot.

Biên dịch gói:

```bash
make
```

Các bài kiểm thử của gói này đều sẽ thất bại trong môi trường chroot vì chúng cần `valgrind`. Ngoài ra, trên một hệ thống đầy đủ có `valgrind`, một số bài vẫn thất bại trong môi trường đồ họa. Các bài kiểm thử đều qua khi chạy trong môi trường không đồ họa.

Cài đặt gói:

```bash
make install
```

{% hint style="info" %}
**Ghi chú**

Với một số ngôn ngữ (ví dụ tiếng Belarus), gói Kbd không cung cấp keymap dùng được, vì keymap “by” mặc định giả định bảng mã ISO-8859-5, trong khi keymap CP1251 mới là loại thường dùng. Người dùng các ngôn ngữ như vậy phải tải keymap hoạt động được về riêng.
{% endhint %}

Nếu muốn, cài tài liệu:

```bash
cp -R -v docs/doc -T /usr/share/doc/kbd-2.8.0
```

## 8.67.2. Nội dung của Kbd

* **Chương trình được cài:** chvt, deallocvt, dumpkeys, fgconsole, getkeycodes, kbdinfo, kbd\_mode, kbdrate, loadkeys, loadunimap, mapscrn, openvt, psfaddtable (liên kết tới psfxtable), psfgettable (liên kết tới psfxtable), psfstriptable (liên kết tới psfxtable), psfxtable, setfont, setkeycodes, setleds, setmetamode, setvtrgb, showconsolefont, showkey, unicode\_start và unicode\_stop
* **Thư mục được cài:** /usr/share/consolefonts, /usr/share/consoletrans, /usr/share/keymaps, /usr/share/doc/kbd-2.8.0 và /usr/share/unimaps

### Mô tả ngắn

* `chvt` — Đổi sang terminal ảo (virtual terminal) ở nền trước
* `deallocvt` — Giải phóng các terminal ảo không dùng
* `dumpkeys` — Xuất các bảng chuyển đổi phím của bàn phím
* `fgconsole` — In ra số của terminal ảo đang hoạt động
* `getkeycodes` — In ra bảng ánh xạ scancode sang keycode của kernel
* `kbdinfo` — Lấy thông tin về trạng thái của một console
* `kbd_mode` — Hiển thị hoặc đặt chế độ bàn phím
* `kbdrate` — Đặt tốc độ lặp và độ trễ của bàn phím
* `loadkeys` — Nạp các bảng chuyển đổi phím của bàn phím
* `loadunimap` — Nạp bảng ánh xạ unicode sang phông chữ của kernel
* `mapscrn` — Chương trình lỗi thời, trước đây dùng để nạp bảng ánh xạ ký tự đầu ra do người dùng định nghĩa vào driver console; việc này giờ do `setfont` đảm nhận
* `openvt` — Chạy một chương trình trên một terminal ảo (VT) mới
* `psfaddtable` — Thêm bảng ký tự Unicode vào một phông chữ console
* `psfgettable` — Trích xuất bảng ký tự Unicode nhúng sẵn từ một phông chữ console
* `psfstriptable` — Xóa bảng ký tự Unicode nhúng sẵn khỏi một phông chữ console
* `psfxtable` — Xử lý các bảng ký tự Unicode cho phông chữ console
* `setfont` — Thay đổi phông chữ Enhanced Graphic Adapter (EGA) và Video Graphics Array (VGA) trên console
* `setkeycodes` — Nạp các mục của bảng ánh xạ scancode sang keycode của kernel; hữu ích khi bàn phím có những phím khác thường
* `setleds` — Đặt các cờ bàn phím và đèn LED (Light Emitting Diode)
* `setmetamode` — Định nghĩa cách xử lý phím meta của bàn phím
* `setvtrgb` — Đặt bảng màu của console trên mọi terminal ảo
* `showconsolefont` — Hiển thị phông chữ màn hình console EGA/VGA hiện tại
* `showkey` — Báo cáo scancode, keycode và mã ASCII của các phím được nhấn trên bàn phím
* `unicode_start` — Chuyển bàn phím và console sang chế độ UNICODE \[Đừng dùng chương trình này trừ khi tệp keymap của bạn dùng bảng mã ISO-8859-1. Với các bảng mã khác, tiện ích này cho kết quả sai.\]
* `unicode_stop` — Đưa bàn phím và console về lại từ chế độ UNICODE

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/kbd.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/kbd.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/kbd.html)
