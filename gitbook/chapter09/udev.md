---
description: "Ở Chương 8, chúng ta đã cài daemon udev khi dựng udev. Trước khi đi vào chi tiết cách udev hoạt động, ta nên điểm qua lịch sử các phương pháp xử lý thiết b"
---

<details>

<summary>Trick lỏ: Không biết card mạng tên gì? Giữ kiểu eth0 cho d�</summary>

Udev đặt tên card mạng kiểu `enp0s3`, `ens33`... và tên có thể khác giữa máy ảo và máy thật, làm file `/etc/sysconfig/ifconfig.*` của bạn trỏ sai. Hai cách:

* Xem tên thật sau khi boot: `ip link`.
* Hoặc tắt tên "dự đoán được" bằng cách thêm `net.ifnames=0` vào dòng `linux` trong `grub.cfg` → card đầu tiên luôn là `eth0`, và file cấu hình đặt là `/etc/sysconfig/ifconfig.eth0`.

Mạng vẫn không lên? Kiểm tra kernel đã có driver card mạng chưa (`dmesg | grep -i eth`) — máy ảo VirtualBox thường cần `e1000`, QEMU cần `virtio_net`.

[Tất cả trick lỏ →](../trick-lo.md#ten-card-mang)

</details>

# 9.3. Tổng quan về xử lý thiết bị và module

Ở [Chương 8](../chapter08/chapter08.md), chúng ta đã cài daemon udev khi dựng udev. Trước khi đi vào chi tiết cách udev hoạt động, ta nên điểm qua lịch sử các phương pháp xử lý thiết bị trước đây.

Theo truyền thống, các hệ thống Linux dùng phương pháp tạo thiết bị tĩnh: rất nhiều device node (đôi khi lên tới hàng nghìn) được tạo sẵn trong `/dev`, bất kể thiết bị phần cứng tương ứng có thật sự tồn tại hay không. Việc này thường được thực hiện bằng script `MAKEDEV`, trong đó có hàng loạt lời gọi chương trình `mknod` với số major và minor tương ứng cho mọi thiết bị có thể tồn tại trên đời.

Với udev, device node chỉ được tạo cho những thiết bị mà kernel phát hiện được. Các device node này được tạo lại mỗi lần hệ thống khởi động; chúng nằm trong hệ thống tệp `devtmpfs` (một hệ thống tệp ảo nằm hoàn toàn trong bộ nhớ). Device node chiếm rất ít dung lượng nên bộ nhớ dùng cho chúng là không đáng kể.

## 9.3.1. Lịch sử

Tháng 2 năm 2000, một hệ thống tệp mới tên `devfs` được đưa vào kernel 2.3.46 và có mặt trong dòng kernel ổn định 2.4. Dù nằm ngay trong mã nguồn kernel, phương pháp tạo thiết bị động này chưa bao giờ nhận được sự ủng hộ mạnh mẽ từ các nhà phát triển kernel cốt lõi.

Vấn đề chính của cách tiếp cận trong `devfs` nằm ở việc nó phát hiện, tạo và đặt tên thiết bị. Vấn đề cuối cùng, tức đặt tên device node, có lẽ là nghiêm trọng nhất. Người ta thường đồng ý rằng nếu tên thiết bị có thể cấu hình, thì chính sách đặt tên nên do quản trị viên hệ thống chọn, chứ không phải do nhà phát triển áp đặt. Hệ thống tệp `devfs` cũng mắc các race condition vốn có từ thiết kế; không thể sửa chúng nếu không xem xét lại kernel một cách đáng kể. `devfs` bị đánh dấu lỗi thời trong một thời gian dài và cuối cùng bị gỡ khỏi kernel vào tháng 6 năm 2006.

Cùng với việc phát triển nhánh kernel 2.5 không ổn định, sau này phát hành thành dòng ổn định 2.6, một hệ thống tệp ảo mới tên `sysfs` ra đời. Nhiệm vụ của `sysfs` là cung cấp thông tin về cấu hình phần cứng của hệ thống cho các tiến trình userspace. Nhờ cách biểu diễn nhìn thấy được từ userspace này, người ta có thể phát triển một sản phẩm thay thế `devfs` chạy ở userspace.

## 9.3.2. Triển khai Udev

### 9.3.2.1. Sysfs

Phần trên đã nhắc ngắn gọn đến hệ thống tệp `sysfs`. Bạn có thể thắc mắc `sysfs` biết về các thiết bị trong hệ thống và số thiết bị cần dùng như thế nào. Các driver được biên dịch thẳng vào kernel sẽ đăng ký đối tượng của chúng trong `sysfs` (bên trong là devtmpfs) khi kernel phát hiện thiết bị. Với driver biên dịch thành module, việc đăng ký xảy ra khi module được nạp. Một khi hệ thống tệp `sysfs` được mount (tại `/sys`), dữ liệu mà driver đã đăng ký với `sysfs` sẽ sẵn sàng cho các tiến trình userspace và udevd xử lý (bao gồm cả việc chỉnh sửa device node).

### 9.3.2.2. Tạo device node

Các tệp thiết bị được kernel tạo trong hệ thống tệp `devtmpfs`. Bất kỳ driver nào muốn đăng ký device node đều dùng `devtmpfs` (thông qua driver core) để làm việc đó. Khi một thể hiện `devtmpfs` được mount tại `/dev`, device node ban đầu sẽ được đưa ra userspace với tên, quyền và chủ sở hữu cố định.

Một lúc sau, kernel gửi một uevent tới `udevd`. Dựa trên các quy tắc trong các tệp thuộc thư mục `/etc/udev/rules.d`, `/usr/lib/udev/rules.d` và `/run/udev/rules.d`, `udevd` sẽ tạo thêm symlink tới device node, hoặc đổi quyền, chủ sở hữu hay nhóm của nó, hoặc sửa mục (tên) trong cơ sở dữ liệu nội bộ của `udevd` cho đối tượng đó.

Các quy tắc trong ba thư mục này được đánh số và cả ba thư mục được gộp chung lại. Nếu `udevd` không tìm thấy quy tắc nào cho thiết bị đang tạo, nó sẽ giữ nguyên quyền và chủ sở hữu như `devtmpfs` đặt ban đầu.

### 9.3.2.3. Nạp module

Driver thiết bị biên dịch thành module có thể chứa sẵn các alias. Alias hiển thị trong kết quả của chương trình `modinfo` và thường liên quan đến định danh theo bus của các thiết bị mà module hỗ trợ. Ví dụ, driver *snd-fm801* hỗ trợ thiết bị PCI có vendor ID 0x1319 và device ID 0x0801, và có alias là `pci:v00001319d00000801sv*sd*bc04sc01i*`. Với hầu hết thiết bị, driver của bus xuất alias của driver sẽ xử lý thiết bị đó qua `sysfs`. Ví dụ, tệp `/sys/bus/pci/devices/0000:00:0d.0/modalias` có thể chứa chuỗi `pci:v00001319d00000801sv00001319sd00001319bc04sc01i00`. Các quy tắc mặc định đi kèm udev khiến `udevd` gọi `/sbin/modprobe` với nội dung biến môi trường uevent `MODALIAS` (phải trùng với nội dung tệp `modalias` trong sysfs), nhờ đó nạp mọi module có alias khớp với chuỗi này sau khi khai triển ký tự đại diện.

Trong ví dụ này, điều đó có nghĩa là ngoài *snd-fm801*, driver *forte* lỗi thời (và không mong muốn) cũng sẽ được nạp nếu có. Xem bên dưới để biết cách ngăn việc nạp các driver không mong muốn.

Bản thân kernel cũng có thể nạp theo yêu cầu các module cho giao thức mạng, hệ thống tệp và hỗ trợ NLS.

### 9.3.2.4. Xử lý thiết bị cắm nóng/động

Khi bạn cắm một thiết bị, chẳng hạn máy nghe nhạc MP3 qua Universal Serial Bus (USB), kernel nhận ra thiết bị vừa được kết nối và tạo một uevent. Uevent này sau đó được `udevd` xử lý như đã mô tả ở trên.

## 9.3.3. Các vấn đề khi nạp module và tạo thiết bị

Có vài vấn đề có thể xảy ra khi tạo device node tự động.

### 9.3.3.1. Module kernel không được nạp tự động

Udev chỉ nạp module nếu nó có alias theo bus và driver của bus xuất đúng các alias cần thiết sang `sysfs`. Trong các trường hợp khác, bạn phải sắp xếp việc nạp module bằng cách khác. Với Linux-6.16.1, udev được biết là nạp đúng các driver viết chuẩn cho thiết bị INPUT, IDE, PCI, USB, SCSI, SERIO và FireWire.

Để biết driver thiết bị bạn cần có hỗ trợ udev hay không, hãy chạy `modinfo` với tên module làm đối số. Sau đó thử tìm thư mục thiết bị dưới `/sys/bus` và kiểm tra xem ở đó có tệp `modalias` không.

Nếu tệp `modalias` tồn tại trong `sysfs`, tức driver hỗ trợ thiết bị và có thể giao tiếp trực tiếp với nó nhưng lại không có alias, thì đó là lỗi của driver. Hãy nạp driver mà không nhờ udev và chờ lỗi được sửa sau.

Nếu không có tệp `modalias` trong thư mục tương ứng dưới `/sys/bus`, nghĩa là các nhà phát triển kernel chưa thêm hỗ trợ modalias cho loại bus này. Với Linux-6.16.1, đây là trường hợp của bus ISA. Hãy chờ vấn đề này được sửa ở các phiên bản kernel sau.

Udev hoàn toàn không có ý định nạp các driver “wrapper” như *snd-pcm-oss* và các driver không thuộc phần cứng như *loop*.

### 9.3.3.2. Module kernel không được nạp tự động và udev không có ý định nạp nó

Nếu module “wrapper” chỉ bổ sung chức năng cho một module khác (ví dụ *snd-pcm-oss* bổ sung cho *snd-pcm* bằng cách cho các ứng dụng OSS dùng card âm thanh), hãy cấu hình `modprobe` để nạp wrapper sau khi udev nạp module được bọc. Muốn vậy, hãy thêm một dòng “softdep” vào tệp `/etc/modprobe.d/<filename>.conf` tương ứng. Ví dụ:

```text
softdep snd-pcm post: snd-pcm-oss
```

Lưu ý lệnh “softdep” còn cho phép phụ thuộc `pre:`, hoặc kết hợp cả `pre:` và `post:`. Xem trang man [modprobe.d(5)](https://man.archlinux.org/man/modprobe.d.5) để biết thêm về cú pháp và khả năng của “softdep”.

Nếu module đang xét không phải wrapper mà hữu ích độc lập, hãy cấu hình bootscript `modules` để nạp module này khi hệ thống khởi động. Muốn vậy, hãy thêm tên module vào tệp `/etc/sysconfig/modules`, mỗi module một dòng. Cách này cũng dùng được cho module wrapper nhưng khi đó chưa tối ưu.

### 9.3.3.3. Udev nạp một module không mong muốn

Hoặc là đừng dựng module đó, hoặc đưa nó vào danh sách đen trong tệp `/etc/modprobe.d/blacklist.conf`, như làm với module *forte* trong ví dụ dưới đây:

```text
blacklist forte
```

Module trong danh sách đen vẫn có thể được nạp thủ công bằng lệnh `modprobe` tường minh.

### 9.3.3.4. Udev tạo thiết bị sai hoặc tạo sai symlink

Điều này thường xảy ra khi một quy tắc khớp bất ngờ với một thiết bị. Ví dụ, một quy tắc viết kém có thể khớp theo nhà sản xuất cả với đĩa SCSI (như mong muốn) lẫn thiết bị SCSI generic tương ứng (sai). Hãy tìm quy tắc gây lỗi và làm nó cụ thể hơn, với sự trợ giúp của lệnh `udevadm info`.

### 9.3.3.5. Quy tắc udev hoạt động không ổn định

Đây có thể là biểu hiện khác của vấn đề trước. Nếu không phải, và quy tắc của bạn dùng thuộc tính `sysfs`, có thể đó là vấn đề thời điểm trong kernel, sẽ được sửa ở các kernel sau. Hiện tại, bạn có thể khắc phục bằng cách tạo một quy tắc chờ thuộc tính `sysfs` được dùng rồi thêm nó vào tệp `/etc/udev/rules.d/10-wait_for_sysfs.rules` (tạo tệp này nếu chưa có). Nếu bạn làm vậy và nó có hiệu quả, xin hãy báo cho danh sách thư LFS Development.

### 9.3.3.6. Udev không tạo thiết bị

Trước hết, hãy chắc rằng driver đã được dựng vào kernel hoặc đã nạp thành module, và udev không tạo ra thiết bị bị đặt sai tên.

Nếu driver kernel không xuất dữ liệu của nó sang `sysfs`, udev thiếu thông tin cần thiết để tạo device node. Điều này dễ xảy ra nhất với driver bên thứ ba nằm ngoài cây mã nguồn kernel. Hãy tạo một device node tĩnh trong `/usr/lib/udev/devices` với số major/minor phù hợp (xem tệp `devices.txt` trong tài liệu kernel hoặc tài liệu do nhà cung cấp driver bên thứ ba đưa ra). Device node tĩnh này sẽ được `udev` sao chép vào `/dev`.

### 9.3.3.7. Thứ tự đặt tên thiết bị thay đổi ngẫu nhiên sau khi khởi động lại

Nguyên nhân là udev, theo thiết kế, xử lý uevent và nạp module song song, nên theo thứ tự không thể đoán trước. Điều này sẽ không bao giờ được “sửa.” Bạn không nên trông cậy vào việc tên thiết bị của kernel ổn định. Thay vào đó, hãy tạo quy tắc riêng sinh symlink có tên ổn định dựa trên các thuộc tính ổn định của thiết bị, như số serial hay kết quả của các tiện ích \*\_id do udev cài. Xem ví dụ ở [Mục 9.4, “Managing Devices”](symlinks.md) và [Mục 9.5, “General Network Configuration”](network.md).

## 9.3.4. Tài liệu nên đọc

Các trang sau có thêm tài liệu hữu ích:

* A Userspace Implementation of `devfs` [http://www.kroah.com/linux/talks/ols\_2003\_udev\_paper/Reprint-Kroah-Hartman-OLS2003.pdf](http://www.kroah.com/linux/talks/ols_2003_udev_paper/Reprint-Kroah-Hartman-OLS2003.pdf)
* The `sysfs` Filesystem [https://www.kernel.org/pub/linux/kernel/people/mochel/doc/papers/ols-2005/mochel.pdf](https://www.kernel.org/pub/linux/kernel/people/mochel/doc/papers/ols-2005/mochel.pdf)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter09/udev.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter09/udev.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter09/udev.html)
