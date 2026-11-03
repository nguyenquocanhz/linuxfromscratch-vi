---
description: "Gói Shadow chứa các chương trình để xử lý mật khẩu một cách an toàn."
---

# 8.28. Shadow-4.18.0

Gói Shadow chứa các chương trình để xử lý mật khẩu một cách an toàn.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 115 MB

## 8.28.1. Cài đặt Shadow

{% hint style="warning" %}
**Important**

Nếu bạn đã cài Linux-PAM, hãy làm theo [hướng dẫn của BLFS](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/shadow.html) thay cho trang này để dựng (hoặc dựng lại, hoặc nâng cấp) shadow.
{% endhint %}

{% hint style="info" %}
**Note**

Nếu muốn bắt buộc dùng mật khẩu mạnh, trước tiên hãy [cài đặt và cấu hình Linux-PAM](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/linux-pam.html). Sau đó [cài đặt và cấu hình shadow có hỗ trợ PAM](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/shadow.html). Cuối cùng [cài libpwquality và cấu hình PAM để dùng nó](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/libpwquality.html).
{% endhint %}

Tắt việc cài đặt chương trình `groups` cùng các trang man của nó, vì Coreutils đã cung cấp một phiên bản tốt hơn. Đồng thời, ngăn cài các trang hướng dẫn (man page) đã được cài ở [Mục 8.3, “Man-pages-6.15”](man-pages.md):

```bash
sed -i 's/groups$(EXEEXT) //' src/Makefile.in
find man -name Makefile.in -exec sed -i 's/groups\.1 / /'   {} \;
find man -name Makefile.in -exec sed -i 's/getspnam\.3 / /' {} \;
find man -name Makefile.in -exec sed -i 's/passwd\.5 / /'   {} \;
```

Thay vì dùng phương pháp *crypt* mặc định, hãy dùng phương pháp mã hóa mật khẩu *YESCRYPT* an toàn hơn nhiều, vốn cũng cho phép mật khẩu dài hơn 8 ký tự. Cũng cần đổi vị trí hộp thư người dùng `/var/spool/mail` đã lỗi thời mà Shadow dùng theo mặc định sang `/var/mail` được dùng hiện nay. Đồng thời, bỏ `/bin` và `/sbin` khỏi `PATH`, vì chúng chỉ là các liên kết mềm tới thư mục tương ứng trong `/usr`.

{% hint style="danger" %}
**Warning**

Đưa `/bin` và/hoặc `/sbin` vào biến `PATH` có thể khiến một số gói BLFS không dựng được, vì vậy đừng làm thế trong tệp `.bashrc` hay bất kỳ đâu khác.
{% endhint %}

```bash
sed -e 's:#ENCRYPT_METHOD DES:ENCRYPT_METHOD YESCRYPT:' \
    -e 's:/var/spool/mail:/var/mail:'                   \
    -e '/PATH=/{s@/sbin:@@;s@/bin:@@}'                  \
    -i etc/login.defs
```

Chuẩn bị biên dịch Shadow:

```bash
touch /usr/bin/passwd
./configure --sysconfdir=/etc   \
            --disable-static    \
            --with-{b,yes}crypt \
            --without-libbsd    \
            --with-group-name-max-length=32
```

**Ý nghĩa của các tùy chọn cấu hình mới:**

**`touch /usr/bin/passwd`**

> Tệp `/usr/bin/passwd` cần phải tồn tại vì vị trí của nó được ghi cứng trong một số chương trình; nếu nó chưa có, script cài đặt sẽ tạo nó ở sai chỗ.

**`--with-{b,yes}crypt`**

> Shell sẽ khai triển thành hai tùy chọn, `--with-bcrypt` và `--with-yescrypt`. Chúng cho phép shadow dùng các thuật toán Bcrypt và Yescrypt do `Libxcrypt` cài đặt để băm mật khẩu. Các thuật toán này an toàn hơn (đặc biệt là chống chịu tốt hơn nhiều trước các cuộc tấn công dùng GPU) so với các thuật toán SHA truyền thống.

**`--with-group-name-max-length=32`**

> Tên người dùng dài nhất được phép là 32 ký tự. Hãy đặt độ dài tối đa của tên nhóm bằng giá trị đó.

**`--without-libbsd`**

> Không dùng hàm readpassphrase của libbsd vì LFS không có thư viện này. Dùng bản sao nội bộ thay thế.

Biên dịch gói:

```bash
make
```

Gói này không đi kèm bộ kiểm thử.

Cài đặt gói:

```bash
make exec_prefix=/usr install
make -C man install-man
```

## 8.28.2. Configuring Shadow

Gói này chứa các tiện ích để thêm, sửa và xóa người dùng và nhóm; đặt và đổi mật khẩu của họ; cùng các tác vụ quản trị khác. Để hiểu đầy đủ *password shadowing* nghĩa là gì, hãy xem tệp `doc/HOWTO` trong cây mã nguồn đã giải nén. Nếu bạn dùng Shadow, hãy nhớ rằng các chương trình cần xác minh mật khẩu (trình quản lý đăng nhập đồ họa, chương trình FTP, daemon pop3, v.v.) phải tương thích với Shadow, tức là phải làm việc được với mật khẩu dạng shadow.

Để bật mật khẩu dạng shadow, chạy lệnh sau:

```bash
pwconv
```

Để bật mật khẩu nhóm dạng shadow, chạy:

```bash
grpconv
```

Cấu hình mặc định của Shadow cho tiện ích `useradd` cần được giải thích đôi chút. Trước hết, hành động mặc định của `useradd` là tạo người dùng và một nhóm cùng tên với người dùng đó. Theo mặc định, số ID người dùng (UID) và ID nhóm (GID) bắt đầu từ 1000. Nghĩa là nếu bạn không truyền thêm tham số cho `useradd`, mỗi người dùng sẽ là thành viên của một nhóm riêng trên hệ thống. Nếu không muốn như vậy, bạn cần truyền tham số `-g` hoặc `-N` cho `useradd`, hoặc đổi giá trị của `USERGROUPS_ENAB` trong `/etc/login.defs`. Xem [useradd(8)](https://man.archlinux.org/man/useradd.8) để biết thêm.

Thứ hai, để đổi các tham số mặc định, bạn phải tạo tệp `/etc/default/useradd` và chỉnh cho phù hợp nhu cầu. Tạo nó bằng:

```bash
mkdir -p /etc/default
useradd -D --gid 999
```

**Giải thích các tham số của `/etc/default/useradd`**

**`GROUP=999`**

> Tham số này đặt số bắt đầu của các số nhóm dùng trong tệp `/etc/group`. Giá trị 999 cụ thể này lấy từ tham số `--gid` ở trên. Bạn có thể đặt giá trị tùy ý. Lưu ý `useradd` sẽ không bao giờ dùng lại một UID hay GID. Nếu số chỉ định trong tham số này đã được dùng, nó sẽ lấy số trống kế tiếp. Cũng lưu ý rằng nếu hệ thống của bạn không có nhóm nào mang ID bằng số này, thì lần đầu bạn dùng `useradd` mà không có tham số `-g`, một thông báo lỗi sẽ xuất hiện—`useradd: unknown GID 999`, dù tài khoản vẫn được tạo đúng. Đó là lý do chúng ta đã tạo nhóm `users` với ID này ở [Mục 7.6, “Creating Essential Files and Symlinks.”](../chapter07/createfiles.md)

**`CREATE_MAIL_SPOOL=yes`**

> Tham số này khiến `useradd` tạo một tệp hộp thư cho mỗi người dùng mới. `useradd` sẽ gán quyền sở hữu nhóm của tệp này cho nhóm `mail` với quyền 0660. Nếu không muốn tạo các tệp này, hãy chạy lệnh sau:

> ```bash
> sed -i '/MAIL/s/yes/no/' /etc/default/useradd
> ```

## 8.28.3. Setting the Root Password

Chọn mật khẩu cho người dùng *root* và đặt bằng lệnh:

```bash
passwd root
```

## 8.28.4. Nội dung của Shadow

* **Chương trình được cài:** chage, chfn, chgpasswd, chpasswd, chsh, expiry, faillog, getsubids, gpasswd, groupadd, groupdel, groupmems, groupmod, grpck, grpconv, grpunconv, login, logoutd, newgidmap, newgrp, newuidmap, newusers, nologin, passwd, pwck, pwconv, pwunconv, sg (liên kết tới newgrp), su, useradd, userdel, usermod, vigr (liên kết tới vipw) và vipw
* **Thư mục được cài:** /etc/default và /usr/include/shadow
* **Thư viện được cài:** libsubid.so

### Mô tả ngắn

* `chage` — Dùng để đổi số ngày tối đa giữa các lần bắt buộc đổi mật khẩu
* `chfn` — Dùng để đổi họ tên đầy đủ và các thông tin khác của người dùng
* `chgpasswd` — Dùng để cập nhật mật khẩu nhóm theo lô
* `chpasswd` — Dùng để cập nhật mật khẩu người dùng theo lô
* `chsh` — Dùng để đổi shell đăng nhập mặc định của người dùng
* `expiry` — Kiểm tra và áp dụng chính sách hết hạn mật khẩu hiện hành
* `faillog` — Dùng để xem nhật ký các lần đăng nhập thất bại, đặt số lần thất bại tối đa trước khi khóa tài khoản và đặt lại bộ đếm lỗi
* `getsubids` — Dùng để liệt kê các dải id phụ (subordinate id) của một người dùng
* `gpasswd` — Dùng để thêm và xóa thành viên và quản trị viên của nhóm
* `groupadd` — Tạo một nhóm với tên cho trước
* `groupdel` — Xóa nhóm có tên cho trước
* `groupmems` — Cho phép người dùng tự quản lý danh sách thành viên nhóm của mình mà không cần quyền siêu người dùng.
* `groupmod` — Dùng để sửa tên hoặc GID của một nhóm
* `grpck` — Kiểm tra tính toàn vẹn của các tệp nhóm `/etc/group` và `/etc/gshadow`
* `grpconv` — Tạo hoặc cập nhật tệp nhóm shadow từ tệp nhóm thông thường
* `grpunconv` — Cập nhật `/etc/group` từ `/etc/gshadow` rồi xóa tệp sau
* `login` — Được hệ thống dùng để cho phép người dùng đăng nhập
* `logoutd` — Là một daemon dùng để áp dụng các giới hạn về thời gian và cổng đăng nhập
* `newgidmap` — Dùng để đặt ánh xạ gid của một user namespace
* `newgrp` — Dùng để đổi GID hiện tại trong một phiên đăng nhập
* `newuidmap` — Dùng để đặt ánh xạ uid của một user namespace
* `newusers` — Dùng để tạo hoặc cập nhật hàng loạt tài khoản người dùng
* `nologin` — Hiển thị thông báo tài khoản không khả dụng; được thiết kế để dùng làm shell mặc định cho các tài khoản bị vô hiệu hóa
* `passwd` — Dùng để đổi mật khẩu của tài khoản người dùng hoặc nhóm
* `pwck` — Kiểm tra tính toàn vẹn của các tệp mật khẩu `/etc/passwd` và `/etc/shadow`
* `pwconv` — Tạo hoặc cập nhật tệp mật khẩu shadow từ tệp mật khẩu thông thường
* `pwunconv` — Cập nhật `/etc/passwd` từ `/etc/shadow` rồi xóa tệp sau
* `sg` — Chạy một lệnh cho trước trong khi GID của người dùng được đặt thành GID của nhóm đã chỉ định
* `su` — Chạy một shell với ID người dùng và nhóm thay thế
* `useradd` — Tạo người dùng mới với tên cho trước, hoặc cập nhật thông tin mặc định cho người dùng mới
* `userdel` — Xóa tài khoản người dùng được chỉ định
* `usermod` — Dùng để sửa tên đăng nhập, mã định danh người dùng (UID), shell, nhóm ban đầu, thư mục chủ, v.v. của một người dùng
* `vigr` — Sửa các tệp `/etc/group` hoặc `/etc/gshadow`
* `vipw` — Sửa các tệp `/etc/passwd` hoặc `/etc/shadow`
* `libsubid` — Thư viện xử lý các dải id phụ cho người dùng và nhóm

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/shadow.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/shadow.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/shadow.html)
