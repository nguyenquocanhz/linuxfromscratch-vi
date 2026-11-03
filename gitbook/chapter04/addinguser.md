---
description: "Khi đăng nhập bằng người dùng root, chỉ một sai sót cũng có thể làm hỏng hoặc phá hủy hệ thống. Vì vậy, các gói trong hai chương tiếp theo được dựng bằng m"
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

# 4.3. Thêm người dùng LFS

Khi đăng nhập bằng người dùng `root`, chỉ một sai sót cũng có thể làm hỏng hoặc phá hủy hệ thống. Vì vậy, các gói trong hai chương tiếp theo được dựng bằng một người dùng không đặc quyền. Bạn có thể dùng tên người dùng của chính mình, nhưng để dễ thiết lập một môi trường làm việc sạch, chúng ta sẽ tạo người dùng mới tên `lfs` thuộc một nhóm mới (cũng tên `lfs`) và chạy lệnh bằng `lfs` trong quá trình cài đặt. Với tư cách `root`, hãy chạy các lệnh sau để thêm người dùng mới:

```bash
groupadd lfs
useradd -s /bin/bash -g lfs -m -k /dev/null lfs
```

**Ý nghĩa của các tùy chọn dòng lệnh:**

**`-s /bin/bash`**

> Đặt `bash` làm shell mặc định cho người dùng `lfs`.

**`-g lfs`**

> Tùy chọn này thêm người dùng `lfs` vào nhóm `lfs`.

**`-m`**

> Tạo thư mục home cho `lfs`.

**`-k /dev/null`**

> Tham số này ngăn việc có thể sao chép tệp từ thư mục khung (mặc định là `/etc/skel`) bằng cách đổi nguồn đầu vào thành thiết bị null đặc biệt.

**`lfs`**

> Đây là tên của người dùng mới.

Nếu bạn muốn đăng nhập bằng `lfs` hoặc chuyển sang `lfs` từ một người dùng không phải `root` (khác với việc chuyển sang người dùng `lfs` khi đang là `root`, trường hợp này không đòi hỏi `lfs` phải có mật khẩu), bạn cần đặt mật khẩu cho `lfs`. Hãy chạy lệnh sau bằng người dùng `root` để đặt mật khẩu:

```bash
passwd lfs
```

Cấp cho `lfs` toàn quyền truy cập mọi thư mục dưới `$LFS` bằng cách đặt `lfs` làm chủ sở hữu:

```bash
chown -v lfs $LFS/{usr{,/*},var,etc,tools}
case $(uname -m) in
  x86_64) chown -v lfs $LFS/lib64 ;;
esac
```

{% hint style="info" %}
**Ghi chú**

Trên một số hệ thống chủ, lệnh `su` bên dưới không hoàn tất đúng và đẩy phiên đăng nhập của người dùng `lfs` xuống nền. Nếu dấu nhắc "lfs:~$" không hiện ngay, hãy nhập lệnh `fg` để khắc phục.
{% endhint %}

Tiếp theo, hãy khởi chạy một shell dưới người dùng `lfs`. Bạn có thể làm vậy bằng cách đăng nhập `lfs` trên một console ảo, hoặc dùng lệnh chuyển người dùng sau:

```bash
su - lfs
```

Dấu “`-`” bảo `su` khởi chạy shell đăng nhập (login shell) thay vì shell không đăng nhập. Sự khác nhau giữa hai loại shell này được mô tả chi tiết trong [bash(1)](https://man.archlinux.org/man/bash.1) và `info bash`.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter04/addinguser.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter04/addinguser.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter04/addinguser.html)
