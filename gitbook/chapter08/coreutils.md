---
description: "Gói Coreutils chứa các chương trình tiện ích cơ bản mà mọi hệ điều hành đều cần."
---

# 8.59. Coreutils-9.7

Gói Coreutils chứa các chương trình tiện ích cơ bản mà mọi hệ điều hành đều cần.

* **Thời gian dựng ước tính:** 1.2 SBU
* **Dung lượng đĩa cần:** 180 MB

## 8.59.1. Cài đặt Coreutils

Trước tiên, áp dụng bản vá cho một vấn đề bảo mật đã được upstream xác định:

```bash
patch -Np1 -i ../coreutils-9.7-upstream_fix-1.patch
```

POSIX yêu cầu các chương trình của Coreutils nhận biết đúng ranh giới ký tự ngay cả trong locale đa byte. Bản vá sau sửa lỗi không tuân thủ này và các lỗi khác liên quan đến quốc tế hóa.

```bash
patch -Np1 -i ../coreutils-9.7-i18n-1.patch
```

{% hint style="info" %}
**Ghi chú**

Nhiều lỗi đã được tìm thấy trong bản vá này. Khi báo lỗi mới cho người bảo trì Coreutils, hãy kiểm tra trước xem lỗi đó có tái hiện được khi không có bản vá này không.
{% endhint %}

Bây giờ chuẩn bị biên dịch Coreutils:

```bash
autoreconf -fv
automake -af
FORCE_UNSAFE_CONFIGURE=1 ./configure \
            --prefix=/usr            \
            --enable-no-install-program=kill,uptime
```

**Ý nghĩa của các lệnh và tùy chọn configure:**

**`autoreconf -fv`**

> Bản vá quốc tế hóa đã sửa hệ thống build, nên các tệp cấu hình phải được sinh lại. Thông thường ta dùng tùy chọn `-i` để cập nhật các tệp phụ trợ chuẩn, nhưng với gói này nó không hoạt động vì `configure.ac` chỉ định một phiên bản gettext cũ.

**`automake -af`**

> Các tệp phụ trợ của automake không được `autoreconf` cập nhật do thiếu tùy chọn `-i`. Lệnh này cập nhật chúng để tránh lỗi khi dựng.

**`FORCE_UNSAFE_CONFIGURE=1`**

> Biến môi trường này cho phép người dùng `root` dựng gói.

**`--enable-no-install-program=kill,uptime`**

> Mục đích của tùy chọn này là ngăn Coreutils cài các chương trình sẽ được cài bởi gói khác.

Biên dịch gói:

```bash
make
```

Nếu không chạy bộ kiểm thử, hãy nhảy tới “Cài đặt gói”.

Giờ bộ kiểm thử đã sẵn sàng chạy. Trước tiên, chạy các bài kiểm thử dành cho người dùng `root`:

```bash
make NON_ROOT_USERNAME=tester check-root
```

Phần kiểm thử còn lại sẽ chạy bằng người dùng `tester`. Một số bài đòi hỏi người dùng thuộc nhiều hơn một nhóm. Để các bài này không bị bỏ qua, hãy thêm một nhóm tạm và cho người dùng `tester` vào nhóm đó:

```bash
groupadd -g 102 dummy -U tester
```

Sửa một số quyền để người dùng không phải `root` có thể biên dịch và chạy kiểm thử:

```bash
chown -R tester .
```

Bây giờ chạy kiểm thử (dùng `/dev/null` làm đầu vào chuẩn, nếu không hai bài kiểm thử có thể hỏng khi dựng LFS trong terminal đồ họa, phiên SSH hoặc GNU Screen, vì đầu vào chuẩn nối với một PTY của distro host, và device node của PTY đó không truy cập được từ môi trường chroot LFS):

```bash
su tester -c "PATH=$PATH make -k RUN_EXPENSIVE_TESTS=yes check" \
   < /dev/null
```

Xóa nhóm tạm:

```bash
groupdel dummy
```

Cài đặt gói:

```bash
make install
```

Di chuyển các chương trình đến vị trí do FHS quy định:

```bash
mv -v /usr/bin/chroot /usr/sbin
mv -v /usr/share/man/man1/chroot.1 /usr/share/man/man8/chroot.8
sed -i 's/"1"/"8"/' /usr/share/man/man8/chroot.8
```

## 8.59.2. Nội dung của Coreutils

* **Chương trình được cài:** \[, b2sum, base32, base64, basename, basenc, cat, chcon, chgrp, chmod, chown, chroot, cksum, comm, cp, csplit, cut, date, dd, df, dir, dircolors, dirname, du, echo, env, expand, expr, factor, false, fmt, fold, groups, head, hostid, id, install, join, link, ln, logname, ls, md5sum, mkdir, mkfifo, mknod, mktemp, mv, nice, nl, nohup, nproc, numfmt, od, paste, pathchk, pinky, pr, printenv, printf, ptx, pwd, readlink, realpath, rm, rmdir, runcon, seq, sha1sum, sha224sum, sha256sum, sha384sum, sha512sum, shred, shuf, sleep, sort, split, stat, stdbuf, stty, sum, sync, tac, tail, tee, test, timeout, touch, tr, true, truncate, tsort, tty, uname, unexpand, uniq, unlink, users, vdir, wc, who, whoami và yes
* **Thư viện được cài:** libstdbuf.so (trong /usr/libexec/coreutils)
* **Thư mục được cài:** /usr/libexec/coreutils

### Mô tả ngắn

* `[` — Là một lệnh thực sự, /usr/bin/\[; nó là từ đồng nghĩa với lệnh `test`
* `base32` — Mã hóa và giải mã dữ liệu theo đặc tả base32 (RFC 4648)
* `base64` — Mã hóa và giải mã dữ liệu theo đặc tả base64 (RFC 4648)
* `b2sum` — In hoặc kiểm tra checksum BLAKE2 (512-bit)
* `basename` — Bỏ mọi đường dẫn và hậu tố cho trước khỏi tên tệp
* `basenc` — Mã hóa hoặc giải mã dữ liệu bằng nhiều thuật toán
* `cat` — Nối các tệp rồi xuất ra đầu ra chuẩn
* `chcon` — Đổi ngữ cảnh bảo mật của tệp và thư mục
* `chgrp` — Đổi nhóm sở hữu của tệp và thư mục
* `chmod` — Đổi quyền của từng tệp theo chế độ cho trước; chế độ có thể là biểu diễn ký hiệu của các thay đổi cần làm, hoặc số bát phân biểu diễn quyền mới
* `chown` — Đổi người dùng và/hoặc nhóm sở hữu của tệp và thư mục
* `chroot` — Chạy một lệnh với thư mục chỉ định làm thư mục `/`
* `cksum` — In checksum Cyclic Redundancy Check (CRC) và số byte của từng tệp chỉ định
* `comm` — So sánh hai tệp đã sắp xếp, xuất ra ba cột gồm các dòng chỉ có ở một tệp và các dòng chung
* `cp` — Sao chép tệp
* `csplit` — Tách một tệp cho trước thành nhiều tệp mới, phân cách theo mẫu hoặc số dòng cho trước, và xuất số byte của từng tệp mới
* `cut` — In các phần của dòng, chọn theo trường hoặc vị trí cho trước
* `date` — Hiển thị ngày giờ hiện tại theo định dạng cho trước, hoặc đặt ngày giờ hệ thống
* `dd` — Sao chép tệp theo kích thước khối và số lượng cho trước, có thể kèm chuyển đổi
* `df` — Báo cáo dung lượng đĩa còn trống (và đã dùng) trên mọi hệ thống tệp đã mount, hoặc chỉ trên hệ thống tệp chứa các tệp được chọn
* `dir` — Liệt kê nội dung từng thư mục cho trước (giống lệnh `ls`)
* `dircolors` — Xuất các lệnh đặt biến môi trường `LS_COLOR` để đổi bảng màu mà `ls` dùng
* `dirname` — Trích phần thư mục từ (các) tên cho trước
* `du` — Báo cáo dung lượng đĩa mà thư mục hiện tại, từng thư mục cho trước (gồm mọi thư mục con) hoặc từng tệp cho trước chiếm
* `echo` — Hiển thị các chuỗi cho trước
* `env` — Chạy một lệnh trong môi trường đã sửa đổi
* `expand` — Chuyển tab thành dấu cách
* `expr` — Tính giá trị biểu thức
* `factor` — In các thừa số nguyên tố của các số nguyên chỉ định
* `false` — Không làm gì và báo thất bại; luôn thoát với mã trạng thái chỉ thất bại
* `fmt` — Định dạng lại các đoạn văn trong các tệp cho trước
* `fold` — Ngắt dòng cho các tệp cho trước
* `groups` — Báo cáo các nhóm mà một người dùng thuộc về
* `head` — In mười dòng đầu (hoặc số dòng cho trước) của từng tệp cho trước
* `hostid` — Báo cáo định danh số (hệ thập lục phân) của máy chủ
* `id` — Báo cáo ID người dùng hiệu lực, ID nhóm và các nhóm của người dùng hiện tại hoặc người dùng chỉ định
* `install` — Sao chép tệp đồng thời đặt quyền và, nếu có thể, cả chủ sở hữu và nhóm
* `join` — Nối các dòng có trường nối giống nhau từ hai tệp riêng biệt
* `link` — Tạo một hard link (với tên cho trước) tới một tệp
* `ln` — Tạo liên kết cứng hoặc mềm (symbolic) giữa các tệp
* `logname` — Báo cáo tên đăng nhập của người dùng hiện tại
* `ls` — Liệt kê nội dung từng thư mục cho trước
* `md5sum` — In hoặc kiểm tra checksum Message Digest 5 (MD5)
* `mkdir` — Tạo các thư mục với tên cho trước
* `mkfifo` — Tạo First-In, First-Outs (FIFO), hay còn gọi là "named pipe" trong thuật ngữ UNIX, với tên cho trước
* `mknod` — Tạo các device node với tên cho trước; device node là tệp đặc biệt dạng ký tự, tệp đặc biệt dạng khối hoặc FIFO
* `mktemp` — Tạo tệp tạm một cách an toàn; dùng trong script
* `mv` — Di chuyển hoặc đổi tên tệp hoặc thư mục
* `nice` — Chạy chương trình với độ ưu tiên lập lịch đã thay đổi
* `nl` — Đánh số các dòng của các tệp cho trước
* `nohup` — Chạy lệnh không bị ngắt khi treo (hangup), với đầu ra chuyển hướng vào tệp nhật ký
* `nproc` — In số đơn vị xử lý mà một tiến trình dùng được
* `numfmt` — Chuyển số sang hoặc từ chuỗi dễ đọc cho người
* `od` — Kết xuất tệp ở dạng bát phân và các định dạng khác
* `paste` — Trộn các tệp cho trước, nối lần lượt các dòng tương ứng cạnh nhau, phân cách bằng ký tự tab
* `pathchk` — Kiểm tra tên tệp có hợp lệ hoặc portable hay không
* `pinky` — Là một finger client gọn nhẹ; nó báo một số thông tin về người dùng cho trước
* `pr` — Phân trang và chia cột cho tệp để in
* `printenv` — In môi trường
* `printf` — In các đối số cho trước theo định dạng cho trước, giống hàm printf của C
* `ptx` — Tạo chỉ mục hoán vị từ nội dung các tệp cho trước, với mỗi từ khóa trong ngữ cảnh của nó
* `pwd` — Báo cáo tên thư mục làm việc hiện tại
* `readlink` — Báo cáo giá trị của symlink cho trước
* `realpath` — In đường dẫn đã được phân giải
* `rm` — Xóa tệp hoặc thư mục
* `rmdir` — Xóa thư mục nếu chúng rỗng
* `runcon` — Chạy lệnh với ngữ cảnh bảo mật chỉ định
* `seq` — In một dãy số trong khoảng cho trước với bước tăng cho trước
* `sha1sum` — In hoặc kiểm tra checksum Secure Hash Algorithm 1 (SHA1) 160-bit
* `sha224sum` — In hoặc kiểm tra checksum Secure Hash Algorithm 224-bit
* `sha256sum` — In hoặc kiểm tra checksum Secure Hash Algorithm 256-bit
* `sha384sum` — In hoặc kiểm tra checksum Secure Hash Algorithm 384-bit
* `sha512sum` — In hoặc kiểm tra checksum Secure Hash Algorithm 512-bit
* `shred` — Ghi đè lặp lại lên các tệp cho trước bằng các mẫu phức tạp, khiến việc khôi phục dữ liệu trở nên khó khăn
* `shuf` — Xáo trộn các dòng văn bản
* `sleep` — Tạm dừng trong khoảng thời gian cho trước
* `sort` — Sắp xếp các dòng của các tệp cho trước
* `split` — Chia tệp cho trước thành nhiều phần theo kích thước hoặc số dòng
* `stat` — Hiển thị trạng thái của tệp hoặc hệ thống tệp
* `stdbuf` — Chạy lệnh với thao tác đệm (buffering) đã thay đổi cho các luồng chuẩn của nó
* `stty` — Đặt hoặc báo cáo các thiết lập dòng của terminal
* `sum` — In checksum và số khối của từng tệp cho trước
* `sync` — Xả bộ đệm hệ thống tệp; buộc các khối đã thay đổi ghi xuống đĩa và cập nhật super block
* `tac` — Nối các tệp cho trước theo thứ tự ngược
* `tail` — In mười dòng cuối (hoặc số dòng cho trước) của từng tệp cho trước
* `tee` — Đọc từ đầu vào chuẩn đồng thời ghi ra cả đầu ra chuẩn lẫn các tệp cho trước
* `test` — So sánh các giá trị và kiểm tra loại tệp
* `timeout` — Chạy lệnh với giới hạn thời gian
* `touch` — Đổi dấu thời gian của tệp, đặt thời gian truy cập và sửa đổi của các tệp cho trước thành thời điểm hiện tại; tệp chưa tồn tại được tạo với độ dài bằng 0
* `tr` — Dịch, nén và xóa các ký tự cho trước từ đầu vào chuẩn
* `true` — Không làm gì và báo thành công; luôn thoát với mã trạng thái chỉ thành công
* `truncate` — Thu nhỏ hoặc mở rộng tệp đến kích thước chỉ định
* `tsort` — Thực hiện sắp xếp tô-pô; ghi ra danh sách có thứ tự hoàn chỉnh theo thứ tự bộ phận trong tệp cho trước
* `tty` — Báo cáo tên tệp của terminal nối với đầu vào chuẩn
* `uname` — Báo cáo thông tin hệ thống
* `unexpand` — Chuyển dấu cách thành tab
* `uniq` — Loại bỏ các dòng giống nhau liên tiếp, chỉ giữ lại một
* `unlink` — Xóa tệp cho trước
* `users` — Báo cáo tên các người dùng đang đăng nhập
* `vdir` — Giống như `ls -l`
* `wc` — Báo cáo số dòng, từ và byte của từng tệp cho trước, cùng tổng cộng khi có nhiều hơn một tệp
* `who` — Báo cáo ai đang đăng nhập
* `whoami` — Báo cáo tên người dùng ứng với ID người dùng hiệu lực hiện tại
* `yes` — Liên tục xuất `y` hoặc một chuỗi cho trước, cho đến khi bị kill
* `libstdbuf` — Thư viện mà `stdbuf` sử dụng

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/coreutils.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/coreutils.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/coreutils.html)
