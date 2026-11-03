---
description: "Bây giờ LFS đã hoàn tất và bạn có một hệ thống khởi động được, bạn làm gì tiếp? Bước kế tiếp là quyết định dùng nó như thế nào. Nhìn chung có hai nhóm lớn "
---

# 11.5. Bắt đầu sau LFS

## 11.5.1. Quyết định làm gì tiếp theo

Bây giờ LFS đã hoàn tất và bạn có một hệ thống khởi động được, bạn làm gì tiếp? Bước kế tiếp là quyết định dùng nó như thế nào. Nhìn chung có hai nhóm lớn để cân nhắc: máy trạm (workstation) hoặc máy chủ (server). Thực ra hai nhóm này không loại trừ nhau. Các ứng dụng cần cho mỗi nhóm có thể gộp trên cùng một hệ thống, nhưng hiện tại hãy xét riêng từng nhóm.

Máy chủ là nhóm đơn giản hơn. Thường nó gồm một máy chủ web như [Apache HTTP Server](https://www.linuxfromscratch.org/blfs/view/12.4/server/apache.html) và một máy chủ cơ sở dữ liệu như [MariaDB](https://www.linuxfromscratch.org/blfs/view/12.4/server/mariadb.html). Tuy nhiên cũng có thể có các dịch vụ khác. Hệ điều hành nhúng trong thiết bị chuyên dụng cũng thuộc nhóm này.

Ngược lại, máy trạm phức tạp hơn nhiều. Nó thường cần một môi trường người dùng đồ họa như [LXDE](https://www.linuxfromscratch.org/blfs/view/12.4/lxde/lxde.html), [XFCE](https://www.linuxfromscratch.org/blfs/view/12.4/xfce/xfce.html), [KDE](https://www.linuxfromscratch.org/blfs/view/12.4/kde/kde.html) hoặc [Gnome](https://www.linuxfromscratch.org/blfs/view/12.4/gnome/gnome.html) dựa trên một [môi trường đồ họa](https://www.linuxfromscratch.org/blfs/view/12.4/x/installing.html) cơ bản, cùng nhiều ứng dụng đồ họa như [trình duyệt web Firefox](https://www.linuxfromscratch.org/blfs/view/12.4/xsoft/firefox.html), [trình email Thunderbird](https://www.linuxfromscratch.org/blfs/view/12.4/xsoft/thunderbird.html) hoặc [bộ ứng dụng văn phòng LibreOffice](https://www.linuxfromscratch.org/blfs/view/12.4/xsoft/libreoffice.html). Các ứng dụng này đòi hỏi thêm nhiều gói ứng dụng và thư viện hỗ trợ (vài trăm gói, tùy khả năng mong muốn).

Ngoài những thứ trên, còn có một nhóm ứng dụng quản trị hệ thống dùng cho mọi loại hệ thống. Các ứng dụng này đều nằm trong sách BLFS. Không phải môi trường nào cũng cần mọi gói. Ví dụ [dhcpcd](https://www.linuxfromscratch.org/blfs/view/12.4/basicnet/dhcpcd.html) thường không phù hợp với máy chủ, còn [wireless\_tools](https://www.linuxfromscratch.org/blfs/view/12.4/basicnet/wireless_tools.html) thường chỉ hữu ích với laptop.

## 11.5.2. Làm việc trong môi trường LFS cơ bản

Khi mới khởi động vào LFS, bạn có đủ các công cụ nội bộ để dựng thêm gói. Đáng tiếc là môi trường người dùng khá sơ sài. Có vài cách để cải thiện:

### 11.5.2.1. Làm việc từ máy host LFS trong chroot

Cách này cung cấp môi trường đồ họa đầy đủ, với trình duyệt đủ tính năng và khả năng sao chép/dán. Cách này cho phép dùng các ứng dụng như wget của máy host để tải mã nguồn gói về một vị trí mà bạn truy cập được khi làm việc trong môi trường chroot.

Để dựng gói đúng cách trong chroot, bạn cũng cần nhớ mount các hệ thống tệp ảo nếu chúng chưa được mount. Một cách là tạo một script trên hệ thống **HOST**:

```text
cat > ~/mount-virt.sh << "EOF"
#!/bin/bash

function mountbind
{
   if ! mountpoint $LFS/$1 >/dev/null; then
     $SUDO mount --bind /$1 $LFS/$1
     echo $LFS/$1 mounted
   else
     echo $LFS/$1 already mounted
   fi
}

function mounttype
{
   if ! mountpoint $LFS/$1 >/dev/null; then
     $SUDO mount -t $2 $3 $4 $5 $LFS/$1
     echo $LFS/$1 mounted
   else
     echo $LFS/$1 already mounted
   fi
}

if [ $EUID -ne 0 ]; then
  SUDO=sudo
else
  SUDO=""
fi

if [ x$LFS == x ]; then
  echo "LFS not set"
  exit 1
fi

mountbind dev
mounttype dev/pts devpts devpts -o gid=5,mode=620
mounttype proc    proc   proc
mounttype sys     sysfs  sysfs
mounttype run     tmpfs  run
if [ -h $LFS/dev/shm ]; then
  install -v -d -m 1777 $LFS$(realpath /dev/shm)
else
  mounttype dev/shm tmpfs tmpfs -o nosuid,nodev
fi 

#mountbind usr/src
#mountbind boot
#mountbind home
EOF
```

Lưu ý ba lệnh cuối trong script đã được comment. Chúng hữu ích nếu các thư mục đó được mount thành phân vùng riêng trên hệ thống host và sẽ được mount khi khởi động hệ thống LFS/BLFS hoàn chỉnh.

Bạn có thể chạy script bằng `bash ~/mount-virt.sh` với tư cách người dùng thường (khuyến nghị) hoặc `root`. Nếu chạy bằng người dùng thường, hệ thống host cần có sudo.

Một vấn đề khác mà script nêu ra là nơi lưu các tệp gói đã tải. Vị trí này tùy ý. Có thể là thư mục home của người dùng thường như ~/sources hoặc một vị trí chung như /usr/src. Chúng tôi khuyên không nên trộn mã nguồn BLFS và mã nguồn LFS trong /sources (nhìn từ môi trường chroot). Dù thế nào, các gói phải truy cập được bên trong môi trường chroot.

Một tiện ích cuối cùng được giới thiệu ở đây là đơn giản hóa việc vào môi trường chroot. Bạn có thể làm bằng một alias đặt trong tệp ~/.bashrc của người dùng trên hệ thống host:

```text
alias lfs='sudo /usr/sbin/chroot /mnt/lfs /usr/bin/env -i HOME=/root TERM="$TERM" PS1="\u:\w\\\\$ "
PATH=/usr/bin:/usr/sbin /bin/bash --login'
```

Alias này hơi khó vì cách dùng dấu trích dẫn và các cấp dấu gạch chéo ngược. Nó phải nằm trọn trên một dòng. Lệnh ở trên được tách làm hai chỉ để tiện trình bày.

### 11.5.2.2. Làm việc từ xa qua ssh

Cách này cũng cung cấp môi trường đồ họa đầy đủ, nhưng trước hết cần cài [sshd](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/openssh.html) trên hệ thống LFS, thường là trong chroot. Nó cũng cần một máy tính thứ hai. Ưu điểm của cách này là đơn giản, không phải đối phó với sự phức tạp của môi trường chroot. Nó cũng dùng kernel do chính bạn dựng cho mọi gói bổ sung, và vẫn cho một hệ thống hoàn chỉnh để cài gói.

Bạn có thể dùng lệnh `scp` để tải mã nguồn gói cần dựng lên hệ thống LFS. Nếu muốn tải mã nguồn thẳng về hệ thống LFS, hãy cài [libtasn1](https://www.linuxfromscratch.org/blfs/view/12.4/general/libtasn1.html), [p11-kit](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/p11-kit.html), [make-ca](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/make-ca.html) và [wget](https://www.linuxfromscratch.org/blfs/view/12.4/basicnet/wget.html) trong chroot (hoặc tải mã nguồn của chúng lên bằng `scp` sau khi khởi động hệ thống LFS).

### 11.5.2.3. Làm việc từ dòng lệnh LFS

Cách này yêu cầu cài [libtasn1](https://www.linuxfromscratch.org/blfs/view/12.4/general/libtasn1.html), [p11-kit](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/p11-kit.html), [make-ca](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/make-ca.html), [wget](https://www.linuxfromscratch.org/blfs/view/12.4/basicnet/wget.html), [gpm](https://www.linuxfromscratch.org/blfs/view/12.4/general/gpm.html) và [links](https://www.linuxfromscratch.org/blfs/view/12.4/basicnet/links.html) (hoặc [lynx](https://www.linuxfromscratch.org/blfs/view/12.4/basicnet/lynx.html)) trong chroot rồi khởi động lại vào hệ thống LFS mới. Lúc này hệ thống mặc định có sáu console ảo. Chuyển console rất dễ bằng tổ hợp phím **Alt**+**Fx**, trong đó **Fx** từ **F1** đến **F6**. Các tổ hợp **Alt**+**←** và **Alt**+**→** cũng đổi console.

Lúc này bạn có thể đăng nhập vào hai console ảo khác nhau, chạy trình duyệt links hoặc lynx ở một console và bash ở console kia. GPM khi đó cho phép sao chép lệnh từ trình duyệt bằng nút chuột trái, chuyển console rồi dán sang console còn lại.

{% hint style="info" %}
**Ghi chú**

Nói thêm, bạn cũng có thể chuyển console ảo từ một phiên X Window bằng tổ hợp phím **Ctrl**+**Alt**+**Fx**, nhưng thao tác sao chép bằng chuột không hoạt động giữa giao diện đồ họa và console ảo. Bạn có thể quay lại màn hình X Window bằng tổ hợp **Ctrl**+**Alt**+**Fx**, trong đó **Fx** thường là **F1** nhưng cũng có thể là **F7**.
{% endhint %}

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter11/afterlfs.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter11/afterlfs.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter11/afterlfs.html)
