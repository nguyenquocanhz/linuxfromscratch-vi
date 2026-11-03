---
description: "Theo mặc định, Udev đặt tên thiết bị mạng dựa trên dữ liệu Firmware\/BIOS hoặc các đặc điểm vật lý như bus, slot hay địa chỉ MAC. Mục đích của cách đặt tên "
---

# 9.4. Quản lý thiết bị

## 9.4.1. Thiết bị mạng

Theo mặc định, Udev đặt tên thiết bị mạng dựa trên dữ liệu Firmware/BIOS hoặc các đặc điểm vật lý như bus, slot hay địa chỉ MAC. Mục đích của cách đặt tên này là để tên thiết bị mạng luôn nhất quán, không phụ thuộc vào thứ tự card mạng được phát hiện. Ở các phiên bản Linux cũ, chẳng hạn trên máy có hai card mạng của Intel và Realtek, card của Intel có thể là eth0 còn card Realtek là eth1. Sau khi khởi động lại, đôi khi hai card lại bị đánh số ngược nhau.

Với cách đặt tên mới, tên thiết bị mạng thường có dạng như enp5s0 hoặc wlp3s0. Nếu bạn không muốn dùng cách này, bạn có thể quay về cách đặt tên truyền thống hoặc tự định nghĩa một quy tắc riêng.

### 9.4.1.1. Tắt đặt tên cố định trên dòng lệnh kernel

Bạn có thể khôi phục cách đặt tên truyền thống eth0, eth1,... bằng cách thêm `net.ifnames=0` vào dòng lệnh kernel. Cách này phù hợp nhất với hệ thống chỉ có một thiết bị ethernet mỗi loại. Laptop thường có hai kết nối là eth0 và wlan0 nên cũng có thể dùng cách này. Dòng lệnh kernel nằm trong tệp cấu hình GRUB. Xem [Mục 10.4.4, “Creating the GRUB Configuration File.”](../chapter10/grub.md#grub-cfg)

### 9.4.1.2. Tạo quy tắc Udev tùy chỉnh

Bạn có thể tùy biến cách đặt tên bằng các quy tắc udev riêng. Sách có kèm một script tạo ra các quy tắc ban đầu. Hãy tạo chúng bằng lệnh:

```text
bash /usr/lib/udev/init-net-rules.sh
```

Bây giờ hãy xem tệp `/etc/udev/rules.d/70-persistent-net.rules` để biết tên nào được gán cho thiết bị mạng nào:

```bash
cat /etc/udev/rules.d/70-persistent-net.rules
```

{% hint style="info" %}
**Ghi chú**

Trong một số trường hợp, chẳng hạn khi địa chỉ MAC của card mạng được gán thủ công, hoặc trong môi trường ảo hóa như Qemu hay Xen, tệp quy tắc mạng có thể không được tạo vì địa chỉ không được gán cố định. Khi đó bạn không thể dùng cách này.
{% endhint %}

Tệp bắt đầu bằng một khối chú thích, sau đó là hai dòng cho mỗi NIC. Dòng đầu của mỗi NIC là phần mô tả được comment, cho biết ID phần cứng (ví dụ ID nhà sản xuất và ID thiết bị PCI nếu là card PCI) cùng driver của nó (trong ngoặc, nếu tìm được driver). Cả ID phần cứng lẫn driver đều không dùng để quyết định tên giao diện; thông tin này chỉ để tham khảo. Dòng thứ hai là quy tắc udev khớp với NIC này và thực sự gán tên cho nó.

Mọi quy tắc udev đều gồm nhiều từ khóa, ngăn cách bằng dấu phẩy và khoảng trắng tùy chọn. Các từ khóa và ý nghĩa của chúng như sau:

* `SUBSYSTEM=="net"` - Từ khóa này bảo udev bỏ qua các thiết bị không phải card mạng.
* `ACTION=="add"` - Từ khóa này bảo udev bỏ qua quy tắc với các uevent không phải "add" (uevent "remove" và "change" cũng xảy ra nhưng không cần đổi tên giao diện mạng).
* `DRIVERS=="?*"` - Từ khóa này giúp udev bỏ qua các giao diện con VLAN hoặc bridge (vì chúng không có driver). Các giao diện con này bị bỏ qua vì tên được gán sẽ trùng với thiết bị cha.
* `ATTR{address}` - Giá trị của từ khóa này là địa chỉ MAC của NIC.
* `ATTR{type}=="1"` - Từ khóa này đảm bảo quy tắc chỉ khớp với giao diện chính, trong trường hợp một số driver wireless tạo nhiều giao diện ảo. Các giao diện phụ bị bỏ qua vì cùng lý do với giao diện con VLAN và bridge: nếu không sẽ bị trùng tên.
* `NAME` - Giá trị của từ khóa này là tên mà udev sẽ gán cho giao diện.

Giá trị của `NAME` là phần quan trọng nhất. Hãy chắc chắn bạn biết tên nào được gán cho từng card mạng trước khi tiếp tục, và dùng đúng giá trị `NAME` đó khi tạo các tệp cấu hình mạng.

Dù đã tạo tệp quy tắc udev tùy chỉnh, udev vẫn có thể gán thêm một hoặc nhiều tên thay thế cho NIC dựa trên đặc điểm vật lý. Nếu một quy tắc tùy chỉnh đổi tên NIC thành tên đã được gán làm tên thay thế của NIC khác, quy tắc đó sẽ thất bại. Khi gặp tình huống này, bạn có thể tạo tệp cấu hình `/etc/udev/network/99-default.link` với chính sách gán tên thay thế để trống, ghi đè tệp cấu hình mặc định `/usr/lib/udev/network/99-default.link`:

```bash
sed -e '/^AlternativeNamesPolicy/s/=.*$/=/'  \
       /usr/lib/udev/network/99-default.link \
     > /etc/udev/network/99-default.link
```

## 9.4.2. Symlink cho CD-ROM

Một số phần mềm bạn có thể cài sau này (ví dụ các trình phát media) mong đợi các symlink `/dev/cdrom` và `/dev/dvd` tồn tại và trỏ tới thiết bị CD-ROM hoặc DVD-ROM. Ngoài ra, việc đưa các symlink này vào `/etc/fstab` cũng khá tiện. Udev có sẵn một script tạo tệp quy tắc để sinh các symlink này cho bạn, tùy theo khả năng của từng thiết bị, nhưng bạn cần chọn một trong hai chế độ hoạt động cho script.

Thứ nhất, script có thể chạy ở chế độ “by-path” (mặc định cho thiết bị USB và FireWire), trong đó quy tắc được tạo ra phụ thuộc vào đường dẫn vật lý tới ổ CD hoặc DVD. Thứ hai, nó có thể chạy ở chế độ “by-id” (mặc định cho thiết bị IDE và SCSI), trong đó quy tắc phụ thuộc vào chuỗi định danh lưu trên chính ổ CD hoặc DVD. Đường dẫn được xác định bằng script `path_id` của udev, còn chuỗi định danh được đọc từ phần cứng bằng chương trình `ata_id` hoặc `scsi_id`, tùy loại thiết bị của bạn.

Mỗi cách đều có ưu điểm riêng; cách đúng phụ thuộc vào kiểu thay đổi thiết bị có thể xảy ra. Nếu bạn dự đoán đường dẫn vật lý tới thiết bị (tức cổng và/hoặc khe cắm) sẽ thay đổi, chẳng hạn vì định chuyển ổ sang cổng IDE hay đầu nối USB khác, hãy dùng chế độ “by-id”. Ngược lại, nếu bạn dự đoán định danh của thiết bị sẽ thay đổi, chẳng hạn ổ có thể hỏng và bạn định thay bằng ổ khác cắm vào cùng đầu nối, hãy dùng chế độ “by-path”.

Nếu cả hai kiểu thay đổi đều có thể xảy ra với ổ của bạn, hãy chọn chế độ theo kiểu thay đổi mà bạn nghĩ sẽ xảy ra thường xuyên hơn.

{% hint style="warning" %}
**Quan trọng**

Thiết bị ngoài (ví dụ ổ CD kết nối USB) không nên dùng by-path, vì mỗi lần cắm vào một cổng ngoài khác, đường dẫn vật lý của nó sẽ thay đổi. Mọi thiết bị kết nối ngoài đều gặp vấn đề này nếu bạn viết quy tắc udev nhận diện chúng theo đường dẫn vật lý; vấn đề này không chỉ giới hạn ở ổ CD và DVD.
{% endhint %}

Nếu muốn xem các giá trị mà script udev sẽ dùng, hãy tìm thư mục tương ứng với thiết bị CD-ROM trong `/sys` (ví dụ có thể là `/sys/block/hdd`) và chạy lệnh tương tự như sau:

```bash
udevadm test /sys/block/hdd
```

Hãy xem các dòng chứa kết quả của các chương trình \*\_id. Chế độ “by-id” sẽ dùng giá trị ID\_SERIAL nếu nó tồn tại và không rỗng, nếu không sẽ dùng kết hợp ID\_MODEL và ID\_REVISION. Chế độ “by-path” sẽ dùng giá trị ID\_PATH.

Nếu chế độ mặc định không phù hợp với tình huống của bạn, bạn có thể chỉnh tệp `/etc/udev/rules.d/83-cdrom-symlinks.rules` như sau (trong đó `mode` là “by-id” hoặc “by-path”):

```bash
sed -e 's/"write_cd_rules"/"write_cd_rules mode"/' \
    -i /etc/udev/rules.d/83-cdrom-symlinks.rules
```

Lưu ý rằng bây giờ bạn chưa cần tạo tệp quy tắc hay symlink, vì bạn đã bind-mount thư mục `/dev` của máy host vào hệ thống LFS và ta giả định các symlink đã tồn tại trên host. Các quy tắc và symlink sẽ được tạo ở lần đầu bạn khởi động hệ thống LFS.

Tuy nhiên, nếu bạn có nhiều thiết bị CD-ROM, các symlink được tạo lúc đó có thể trỏ tới thiết bị khác với trên máy host, vì thiết bị không được phát hiện theo thứ tự cố định. Các gán được tạo ở lần khởi động đầu tiên của hệ thống LFS sẽ ổn định, nên đây chỉ là vấn đề nếu bạn cần symlink trên cả hai hệ thống trỏ tới cùng một thiết bị. Nếu cần, hãy kiểm tra (và có thể chỉnh sửa) tệp `/etc/udev/rules.d/70-persistent-cd.rules` được tạo ra sau khi khởi động, để đảm bảo các symlink khớp với nhu cầu của bạn.

## 9.4.3. Xử lý thiết bị trùng lặp

Như đã giải thích ở [Mục 9.3, “Overview of Device and Module Handling,”](udev.md), thứ tự xuất hiện trong `/dev` của các thiết bị cùng chức năng về cơ bản là ngẫu nhiên. Ví dụ, nếu bạn có một webcam USB và một TV tuner, đôi khi `/dev/video0` là camera còn `/dev/video1` là tuner, và đôi khi sau khi khởi động lại thứ tự lại đổi. Với mọi loại phần cứng trừ card âm thanh và card mạng, bạn có thể khắc phục bằng cách tạo quy tắc udev sinh symlink cố định. Trường hợp card mạng được nói riêng ở [Mục 9.5, “General Network Configuration,”](network.md), còn cấu hình card âm thanh có thể xem trong [BLFS](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/devices.html).

Với mỗi thiết bị có khả năng gặp vấn đề này (kể cả khi bản phân phối Linux hiện tại của bạn không gặp), hãy tìm thư mục tương ứng trong `/sys/class` hoặc `/sys/block`. Với thiết bị video, đó có thể là `/sys/class/video4linux/videoX`. Hãy tìm các thuộc tính định danh duy nhất cho thiết bị (thường ID nhà sản xuất, ID sản phẩm và/hoặc số serial là dùng được):

```bash
udevadm info -a -p /sys/class/video4linux/video0
```

Sau đó viết các quy tắc tạo symlink, ví dụ:

```bash
cat > /etc/udev/rules.d/83-duplicate_devs.rules << "EOF"

# Persistent symlinks for webcam and tuner
KERNEL=="video*", ATTRS{idProduct}=="1910", ATTRS{idVendor}=="0d81", SYMLINK+="webcam"
KERNEL=="video*", ATTRS{device}=="0x036f",  ATTRS{vendor}=="0x109e", SYMLINK+="tvtuner"

EOF
```

Kết quả là các thiết bị `/dev/video0` và `/dev/video1` vẫn ngẫu nhiên trỏ tới tuner hoặc webcam (nên không bao giờ dùng trực tiếp), nhưng các symlink `/dev/tvtuner` và `/dev/webcam` luôn trỏ đúng thiết bị.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter09/symlinks.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter09/symlinks.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter09/symlinks.html)
