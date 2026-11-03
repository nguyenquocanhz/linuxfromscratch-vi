---
description: "Đã đến lúc tạo cấu trúc thư mục đầy đủ trong hệ thống tệp LFS."
---

# 7.5. Tạo các thư mục

Đã đến lúc tạo cấu trúc thư mục đầy đủ trong hệ thống tệp LFS.

{% hint style="info" %}
**Ghi chú**

Một số thư mục được nhắc trong mục này có thể đã được tạo trước đó bằng lệnh tường minh, hoặc khi cài một số gói. Chúng được lặp lại dưới đây cho đầy đủ.
{% endhint %}

Tạo một số thư mục cấp gốc không nằm trong tập hạn chế cần ở các chương trước bằng lệnh sau:

```bash
mkdir -pv /{boot,home,mnt,opt,srv}
```

Tạo tập các thư mục con cần thiết bên dưới cấp gốc bằng các lệnh sau:

```bash
mkdir -pv /etc/{opt,sysconfig}
mkdir -pv /lib/firmware
mkdir -pv /media/{floppy,cdrom}
mkdir -pv /usr/{,local/}{include,src}
mkdir -pv /usr/lib/locale
mkdir -pv /usr/local/{bin,lib,sbin}
mkdir -pv /usr/{,local/}share/{color,dict,doc,info,locale,man}
mkdir -pv /usr/{,local/}share/{misc,terminfo,zoneinfo}
mkdir -pv /usr/{,local/}share/man/man{1..8}
mkdir -pv /var/{cache,local,log,mail,opt,spool}
mkdir -pv /var/lib/{color,misc,locate}

ln -sfv /run /var/run
ln -sfv /run/lock /var/lock

install -dv -m 0750 /root
install -dv -m 1777 /tmp /var/tmp
```

Mặc định, thư mục được tạo với quyền 755, nhưng không phải chỗ nào cũng mong muốn như vậy. Trong các lệnh trên có hai thay đổi—một cho thư mục home của người dùng `root`, và một cho các thư mục tệp tạm.

Thay đổi quyền thứ nhất đảm bảo không phải ai cũng vào được thư mục `/root`—giống như người dùng thường làm với thư mục home của mình. Thay đổi thứ hai đảm bảo mọi người dùng đều ghi được vào các thư mục `/tmp` và `/var/tmp`, nhưng không xóa được tệp của người khác trong đó. Điều sau bị ngăn bởi cái gọi là “sticky bit,” bit cao nhất (1) trong mặt nạ bit 1777.

## 7.5.1. Ghi chú về tuân thủ FHS

Cây thư mục này dựa trên Filesystem Hierarchy Standard (FHS) (có tại [https://refspecs.linuxfoundation.org/fhs.shtml](https://refspecs.linuxfoundation.org/fhs.shtml)). FHS cũng quy định sự tồn tại tùy chọn của các thư mục bổ sung như `/usr/local/games` và `/usr/share/games`. Trong LFS, chúng ta chỉ tạo những thư mục thực sự cần thiết. Tuy vậy, bạn cứ thoải mái tạo thêm nếu muốn.

{% hint style="danger" %}
**Cảnh báo**

FHS không bắt buộc phải có thư mục `/usr/lib64`, và các biên tập viên LFS đã quyết định không dùng nó. Để hướng dẫn của LFS và BLFS hoạt động đúng, thư mục này bắt buộc không được tồn tại. Thỉnh thoảng bạn nên kiểm tra nó không tồn tại, vì rất dễ vô tình tạo ra và điều này có thể làm hỏng hệ thống của bạn.
{% endhint %}

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/creatingdirs.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/creatingdirs.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/creatingdirs.html)
