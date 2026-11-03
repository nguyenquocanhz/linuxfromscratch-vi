---
description: "Gói Expect chứa các công cụ tự động hóa, thông qua các đoạn hội thoại theo kịch bản, những ứng dụng tương tác như telnet, ftp, passwd, fsck, rlogin và tip."
---

# 8.17. Expect-5.45.4

Gói `Expect` chứa các công cụ tự động hóa, thông qua các đoạn hội thoại theo kịch bản, những ứng dụng tương tác như `telnet`, `ftp`, `passwd`, `fsck`, `rlogin` và `tip`. `Expect` cũng hữu ích để kiểm thử chính những ứng dụng đó, và giúp làm nhẹ đủ loại công việc vốn cực kỳ khó khăn nếu dùng công cụ khác. Framework `DejaGnu` được viết bằng `Expect`.

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 3.9 MB

## 8.17.1. Cài đặt Expect

Expect cần PTY để hoạt động. Hãy kiểm tra PTY có chạy đúng bên trong môi trường chroot bằng một phép thử đơn giản:

```bash
python3 -c 'from pty import spawn; spawn(["echo", "ok"])'
```

Lệnh này phải xuất ra `ok`. Nếu thay vào đó kết quả chứa `OSError: out of pty devices`, nghĩa là môi trường chưa được thiết lập để PTY hoạt động đúng. Bạn cần thoát khỏi môi trường chroot, đọc lại [Mục 7.3, “Preparing Virtual Kernel File Systems”](../chapter07/kernfs.md), và đảm bảo hệ thống tệp `devpts` (cùng các hệ thống tệp kernel ảo khác) đã được mount đúng. Sau đó vào lại môi trường chroot theo [Mục 7.4, “Entering the Chroot Environment”](../chapter07/chroot.md). Vấn đề này phải được giải quyết trước khi tiếp tục, nếu không các bộ kiểm thử cần Expect (ví dụ bộ kiểm thử của Bash, Binutils, GCC, GDBM và dĩ nhiên cả Expect) sẽ thất bại thảm hại, và có thể xảy ra những lỗi tinh vi khác.

Bây giờ, hãy thực hiện một số thay đổi để gói này dùng được với gcc-15.1 trở lên:

```bash
patch -Np1 -i ../expect-5.45.4-gcc15-1.patch
```

Chuẩn bị biên dịch Expect:

```bash
./configure --prefix=/usr           \
            --with-tcl=/usr/lib     \
            --enable-shared         \
            --disable-rpath         \
            --mandir=/usr/share/man \
            --with-tclinclude=/usr/include
```

**Ý nghĩa các tùy chọn configure:**

**`--with-tcl=/usr/lib`**

> Tham số này cần thiết để cho `configure` biết script `tclConfig.sh` nằm ở đâu.

**`--with-tclinclude=/usr/include`**

> Chỉ rõ cho Expect nơi tìm các header nội bộ của Tcl.

Dựng gói:

```bash
make
```

Để kiểm thử kết quả, chạy:

```bash
make test
```

Cài đặt gói:

```bash
make install
ln -svf expect5.45.4/libexpect5.45.4.so /usr/lib
```

## 8.17.2. Nội dung của Expect

* **Chương trình được cài:** expect
* **Thư viện được cài:** libexpect5.45.4.so

### Mô tả ngắn

* `expect` — Giao tiếp với các chương trình tương tác khác theo một kịch bản
* `libexpect-5.45.4.so` — Chứa các hàm cho phép dùng Expect như một phần mở rộng của Tcl, hoặc dùng trực tiếp từ C hoặc C++ (không cần Tcl)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/expect.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/expect.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/expect.html)
