---
description: "Nếu bạn thích một trình soạn thảo khác—như Emacs, Joe hay Nano—hãy xem https:\/\/www.linuxfromscratch.org\/blfs\/view\/12.4\/postlfs\/editors.html để biết hướng d"
---

# 8.73. Vim-9.1.1629

Gói Vim chứa một trình soạn thảo văn bản mạnh mẽ.

* **Thời gian dựng ước tính:** 3.7 SBU
* **Dung lượng đĩa cần:** 259 MB

{% hint style="success" %}
**Các lựa chọn thay thế Vim**

Nếu bạn thích một trình soạn thảo khác—như Emacs, Joe hay Nano—hãy xem [https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/editors.html](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/editors.html) để biết hướng dẫn cài đặt gợi ý.
{% endhint %}

## 8.73.1. Cài đặt Vim

Trước hết, đổi vị trí mặc định của tệp cấu hình `vimrc` sang `/etc`:

```bash
echo '#define SYS_VIMRC_FILE "/etc/vimrc"' >> src/feature.h
```

Chuẩn bị biên dịch Vim:

```bash
./configure --prefix=/usr
```

Biên dịch gói:

```bash
make
```

Để chuẩn bị chạy kiểm thử, hãy đảm bảo người dùng `tester` có thể ghi vào cây mã nguồn và loại trừ một tệp chứa các bài kiểm thử cần `curl` hoặc `wget`:

```bash
chown -R tester .
sed '/test_plugin_glvs/d' -i src/testdir/Make_all.mak
```

Bây giờ chạy kiểm thử bằng người dùng `tester`:

```bash
su tester -c "TERM=xterm-256color LANG=en_US.UTF-8 make -j1 test" \
   &> vim-test.log
```

Bộ kiểm thử in ra màn hình rất nhiều dữ liệu nhị phân. Điều này có thể gây rắc rối với thiết lập của terminal hiện tại (nhất là khi ta đang ghi đè biến `TERM` để thỏa một số giả định của bộ kiểm thử). Bạn có thể tránh vấn đề này bằng cách chuyển hướng đầu ra vào tệp nhật ký như trên. Kiểm thử thành công sẽ có dòng chữ `ALL DONE` trong tệp nhật ký khi kết thúc.

Cài đặt gói:

```bash
make install
```

Nhiều người dùng theo phản xạ gõ `vi` thay vì `vim`. Để `vim` vẫn chạy khi người dùng quen tay gõ `vi`, hãy tạo liên kết mềm cho cả tệp nhị phân lẫn trang man trong các ngôn ngữ có sẵn:

```bash
ln -sv vim /usr/bin/vi
for L in  /usr/share/man/{,*/}man1/vim.1; do
    ln -sv vim.1 $(dirname $L)/vi.1
done
```

Theo mặc định, tài liệu của Vim được cài vào `/usr/share/vim`. Liên kết mềm sau cho phép truy cập tài liệu qua `/usr/share/doc/vim-9.1.1629`, nhất quán với vị trí tài liệu của các gói khác:

```bash
ln -sv ../vim/vim91/doc /usr/share/doc/vim-9.1.1629
```

Nếu sau này bạn định cài X Window System lên hệ thống LFS, có thể cần biên dịch lại Vim sau khi cài X. Vim đi kèm phiên bản giao diện đồ họa của trình soạn thảo, vốn cần X và một số thư viện bổ sung. Để biết thêm về quy trình này, hãy xem tài liệu Vim và trang cài đặt Vim trong sách BLFS tại [https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/vim.html](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/vim.html).

## 8.73.2. Configuring Vim

Theo mặc định, `vim` chạy ở chế độ không tương thích với vi. Điều này có thể mới lạ với những ai từng dùng các trình soạn thảo khác. Thiết lập “nocompatible” được đưa vào bên dưới để nhấn mạnh rằng đang dùng một hành vi mới. Nó cũng nhắc những ai muốn đổi sang chế độ “compatible” rằng đó phải là thiết lập đầu tiên trong tệp cấu hình. Điều này cần thiết vì nó làm thay đổi các thiết lập khác, và các thiết lập ghi đè phải nằm sau nó. Tạo tệp cấu hình `vim` mặc định bằng cách chạy:

```bash
cat > /etc/vimrc << "EOF"
" Begin /etc/vimrc

" Ensure defaults are set before customizing settings, not after
source $VIMRUNTIME/defaults.vim
let skip_defaults_vim=1

set nocompatible
set backspace=2
set mouse=
syntax on
if (&term == "xterm") || (&term == "putty")
  set background=dark
endif

" End /etc/vimrc
EOF
```

Thiết lập `set nocompatible` khiến `vim` hoạt động hữu ích hơn (mặc định) so với kiểu tương thích vi. Bỏ chữ “no” nếu muốn giữ hành vi `vi` cũ. Thiết lập `set backspace=2` cho phép xóa lùi qua ngắt dòng, thụt lề tự động và điểm bắt đầu chèn. Tham số `syntax on` bật tô sáng cú pháp của vim. Thiết lập `set mouse=` cho phép dán văn bản bằng chuột đúng cách khi làm việc trong chroot hoặc qua kết nối từ xa. Cuối cùng, câu lệnh *if* với thiết lập `set background=dark` sửa lại phán đoán của `vim` về màu nền của một số trình giả lập terminal. Nhờ đó phần tô sáng có bảng màu tốt hơn trên nền đen của các chương trình này.

Bạn có thể xem tài liệu về các tùy chọn khác bằng lệnh sau:

```bash
vim -c ':options'
```

{% hint style="info" %}
**Note**

Theo mặc định, vim chỉ cài tệp kiểm tra chính tả cho tiếng Anh. Để cài tệp kiểm tra chính tả cho ngôn ngữ bạn muốn, hãy sao chép tệp `.spl` và (tùy chọn) tệp `.sug` cho ngôn ngữ và bảng mã của bạn từ `runtime/spell` vào `/usr/share/vim/vim91/spell/`.

Để dùng các tệp kiểm tra chính tả này, cần cấu hình thêm trong `/etc/vimrc`, ví dụ:

```text
set spelllang=en,ru
set spell
```

Để biết thêm, xem `runtime/spell/README.txt`.
{% endhint %}

## 8.73.3. Nội dung của Vim

* **Chương trình được cài:** ex (liên kết tới vim), rview (liên kết tới vim), rvim (liên kết tới vim), vi (liên kết tới vim), view (liên kết tới vim), vim, vimdiff (liên kết tới vim), vimtutor và xxd
* **Thư mục được cài:** /usr/share/vim

### Mô tả ngắn

* `ex` — Khởi chạy `vim` ở chế độ ex
* `rview` — Là phiên bản hạn chế của `view`; không thể chạy lệnh shell và không thể tạm dừng `view`
* `rvim` — Là phiên bản hạn chế của `vim`; không thể chạy lệnh shell và không thể tạm dừng `vim`
* `vi` — Liên kết tới `vim`
* `view` — Khởi chạy `vim` ở chế độ chỉ đọc
* `vim` — Là trình soạn thảo
* `vimdiff` — Sửa hai hoặc ba phiên bản của một tệp bằng `vim` và hiển thị các điểm khác biệt
* `vimtutor` — Dạy các phím và lệnh cơ bản của `vim`
* `xxd` — Tạo bản hex dump của tệp cho trước; nó cũng làm được thao tác ngược lại, nên có thể dùng để vá nhị phân

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/vim.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/vim.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/vim.html)
