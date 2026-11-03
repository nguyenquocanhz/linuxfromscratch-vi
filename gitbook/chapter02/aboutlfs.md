---
description: "Xuyên suốt cuốn sách này, biến môi trường LFS sẽ được dùng nhiều lần. Bạn cần bảo đảm biến này luôn được định nghĩa trong suốt quá trình dựng LFS. Nó phải "
---

<details>

<summary>Trick lỏ: Luôn kiểm tra $LFS trước khi chạy lệnh nguy hiểm</summary>

Lỗi kinh điển nhất của LFS: mở terminal mới, quên `export LFS=/mnt/lfs`, rồi chạy `chown -R root:root $LFS/...` hoặc `rm -rf $LFS/...`. Khi `$LFS` rỗng, lệnh đó chạy thẳng trên **thư mục gốc của máy chủ**.

Thói quen nên có:

```bash
echo "LFS=$LFS"                 # nhìn bằng mắt trước mỗi phiên
set -u                          # biến chưa đặt -> shell báo lỗi thay vì coi là chuỗi rỗng
alias lfscheck='[ "$LFS" = /mnt/lfs ] && echo OK || echo "LFS SAI: [$LFS]"'
```

Ghi `export LFS=/mnt/lfs` vào `~/.bash_profile` của **cả root lẫn lfs** để khỏi quên.

[Tất cả trick lỏ →](../trick-lo.md#kiem-tra-bien-lfs)

</details>

# 2.6. Đặt biến $LFS và umask

Xuyên suốt cuốn sách này, biến môi trường `LFS` sẽ được dùng nhiều lần. Bạn cần bảo đảm biến này luôn được định nghĩa trong suốt quá trình dựng LFS. Nó phải được đặt thành tên thư mục nơi bạn sẽ dựng hệ thống LFS. Ở đây ta dùng `/mnt/lfs` làm ví dụ, nhưng bạn có thể chọn bất kỳ tên thư mục nào. Nếu dựng LFS trên một phân vùng riêng, thư mục này sẽ là điểm mount của phân vùng đó. Hãy chọn vị trí thư mục và đặt biến bằng lệnh sau:

```bash
export LFS=/mnt/lfs
```

Đặt biến này có lợi ở chỗ các lệnh như `mkdir -v $LFS/tools` có thể gõ nguyên văn. Shell sẽ tự thay “$LFS” bằng “/mnt/lfs” (hoặc giá trị bạn đã đặt) khi xử lý dòng lệnh.

Bây giờ hãy đặt mặt nạ tạo tệp (umask) thành `022`, phòng khi bản phân phối host dùng mặc định khác:

```bash
umask 022
```

Đặt umask là 022 bảo đảm các tệp và thư mục mới tạo chỉ có chủ sở hữu được ghi, còn mọi người đều có thể đọc và duyệt (chỉ với thư mục). Giả sử system call [open(2)](https://man.archlinux.org/man/open.2) dùng chế độ mặc định, tệp mới sẽ có quyền 644 và thư mục có quyền 755. Mặc định quá thoáng có thể để lại lỗ hổng bảo mật trong hệ thống LFS, còn mặc định quá chặt có thể gây ra những sự cố lạ khi dựng hoặc dùng hệ thống LFS.

{% hint style="danger" %}
**Thận trọng**

Đừng quên kiểm tra rằng `LFS` đã được đặt và umask là `022` mỗi khi bạn rời rồi vào lại môi trường làm việc hiện tại (chẳng hạn khi dùng `su` sang `root` hoặc người dùng khác). Kiểm tra biến `LFS` đã đặt đúng chưa bằng:

```bash
echo $LFS
```

Hãy chắc rằng kết quả hiển thị đường dẫn đến nơi dựng hệ thống LFS của bạn, tức là `/mnt/lfs` nếu bạn làm theo ví dụ.

Kiểm tra umask đã đặt đúng chưa bằng:

```bash
umask
```

Kết quả có thể là `0022` hoặc `022` (số chữ số 0 ở đầu phụ thuộc vào bản phân phối host).

Nếu kết quả của một trong hai lệnh trên không đúng, hãy dùng lệnh đã nêu ở phần trước của trang này để đặt `$LFS` thành đúng tên thư mục và đặt umask là `022`.
{% endhint %}

{% hint style="info" %}
**Ghi chú**

Một cách để bảo đảm biến `LFS` và umask luôn được đặt đúng là sửa tệp `.bash_profile` trong thư mục home của bạn và trong `/root/.bash_profile`, rồi thêm các lệnh `export` và `umask` ở trên. Ngoài ra, shell được chỉ định trong tệp `/etc/passwd` của mọi người dùng cần biến `LFS` phải là bash, để tệp `.bash_profile` được nạp khi đăng nhập.

Cũng cần cân nhắc cách bạn đăng nhập vào hệ thống host. Nếu đăng nhập qua trình quản lý màn hình đồ họa, tệp `.bash_profile` của người dùng thường không được dùng khi mở một terminal ảo. Trong trường hợp này, hãy thêm các lệnh vào tệp `.bashrc` của người dùng và của `root`. Ngoài ra, một số bản phân phối dùng câu lệnh kiểm tra "if" và bỏ qua phần còn lại của `.bashrc` khi bash chạy ở chế độ không tương tác. Hãy chắc chắn đặt các lệnh phía trước đoạn kiểm tra đó.
{% endhint %}

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter02/aboutlfs.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter02/aboutlfs.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter02/aboutlfs.html)
