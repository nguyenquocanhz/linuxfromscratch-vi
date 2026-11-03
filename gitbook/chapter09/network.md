---
description: "Các tệp trong \/etc\/sysconfig\/ thường quyết định những giao diện nào được script network bật và tắt. Thư mục này nên chứa một tệp cho mỗi giao diện cần cấu "
---

<details>

<summary>Trick lỏ: Không biết card mạng tên gì? Giữ kiểu eth0 cho d�</summary>

Udev đặt tên card mạng kiểu `enp0s3`, `ens33`... và tên có thể khác giữa máy ảo và máy thật, làm file `/etc/sysconfig/ifconfig.*` của bạn trỏ sai. Hai cách:

* Xem tên thật sau khi boot: `ip link`.
* Hoặc tắt tên "dự đoán được" bằng cách thêm `net.ifnames=0` vào dòng `linux` trong `grub.cfg` → card đầu tiên luôn là `eth0`, và file cấu hình đặt là `/etc/sysconfig/ifconfig.eth0`.

Mạng vẫn không lên? Kiểm tra kernel đã có driver card mạng chưa (`dmesg | grep -i eth`) — máy ảo VirtualBox thường cần `e1000`, QEMU cần `virtio_net`.

[Tất cả trick lỏ →](../trick-lo.md#ten-card-mang)

</details>

# 9.5. General Network Configuration

## 9.5.1. Creating Network Interface Configuration Files

Các tệp trong `/etc/sysconfig/` thường quyết định những giao diện nào được script network bật và tắt. Thư mục này nên chứa một tệp cho mỗi giao diện cần cấu hình, như `ifconfig.xyz`, trong đó “xyz” mô tả card mạng. Tên giao diện (ví dụ eth0) thường là phù hợp. Mỗi tệp chứa các thuộc tính của một giao diện, như địa chỉ IP, mặt nạ mạng con, v.v. Phần đầu của tên tệp phải là *ifconfig*.

{% hint style="info" %}
**Note**

Nếu không làm theo quy trình ở mục trước, udev sẽ đặt tên giao diện card mạng dựa trên đặc điểm vật lý của hệ thống, như enp2s1. Nếu không chắc tên giao diện của mình là gì, bạn luôn có thể chạy `ip link` hoặc `ls /sys/class/net` sau khi đã khởi động hệ thống.

Tên giao diện phụ thuộc vào cách cài đặt và cấu hình của daemon udev đang chạy trên hệ thống. Daemon udev của LFS (cài ở [Mục 8.76, “Udev from Systemd-257.8”](../chapter08/udev.md)) sẽ không chạy cho đến khi hệ thống LFS được khởi động. Vì vậy, không phải lúc nào cũng xác định được tên giao diện trong hệ thống LFS bằng cách chạy các lệnh đó trên distro host, *kể cả trong môi trường chroot*.
{% endhint %}

Lệnh sau tạo một tệp mẫu cho thiết bị *eth0* với địa chỉ IP tĩnh:

```bash
cd /etc/sysconfig/
cat > ifconfig.eth0 << "EOF"
ONBOOT=yes
IFACE=eth0
SERVICE=ipv4-static
IP=192.168.1.2
GATEWAY=192.168.1.1
PREFIX=24
BROADCAST=192.168.1.255
EOF
```

Các giá trị in nghiêng phải được đổi trong từng tệp để thiết lập giao diện cho đúng.

Nếu biến `ONBOOT` được đặt là `yes`, script network của System V sẽ bật Network Interface Card (NIC) trong quá trình khởi động hệ thống. Nếu đặt là giá trị khác `yes`, script network sẽ bỏ qua NIC và không tự khởi động nó. Bạn có thể bật hoặc tắt giao diện thủ công bằng lệnh `ifup` và `ifdown`.

Biến `IFACE` định nghĩa tên giao diện, ví dụ eth0. Biến này bắt buộc trong mọi tệp cấu hình thiết bị mạng. Phần mở rộng của tên tệp phải khớp với giá trị này.

Biến `SERVICE` định nghĩa phương thức lấy địa chỉ IP. Gói LFS-Bootscripts có định dạng gán IP theo kiểu module, và tạo thêm tệp trong thư mục `/lib/services/` sẽ cho phép dùng các phương thức gán IP khác. Cách này thường dùng cho Dynamic Host Configuration Protocol (DHCP), được đề cập trong sách BLFS.

Biến `GATEWAY` nên chứa địa chỉ IP của gateway mặc định, nếu có. Nếu không, hãy chú thích (comment out) hoàn toàn biến này.

Biến `PREFIX` chỉ định số bit dùng cho mạng con. Mỗi đoạn của địa chỉ IP là 8 bit. Nếu netmask của mạng con là 255.255.255.0, nó dùng ba đoạn đầu (24 bit) để xác định số mạng. Nếu netmask là 255.255.255.240, mạng con dùng 28 bit đầu. Tiền tố dài hơn 24 bit thường được các nhà cung cấp dịch vụ Internet (ISP) dùng DSL và cáp sử dụng. Trong ví dụ này (PREFIX=24), netmask là 255.255.255.0. Hãy điều chỉnh biến `PREFIX` cho phù hợp với mạng con của bạn. Nếu bỏ qua, PREFIX mặc định là 24.

Để biết thêm, xem trang man của `ifup`.

## 9.5.2. Creating the /etc/resolv.conf File

Hệ thống sẽ cần một cách để phân giải tên Domain Name Service (DNS), đổi tên miền Internet thành địa chỉ IP và ngược lại. Cách tốt nhất là đặt địa chỉ IP của máy chủ DNS, do ISP hoặc quản trị viên mạng cung cấp, vào `/etc/resolv.conf`. Tạo tệp bằng cách chạy:

```bash
cat > /etc/resolv.conf << "EOF"
# Begin /etc/resolv.conf

domain <Your Domain Name>
nameserver <IP address of your primary nameserver>
nameserver <IP address of your secondary nameserver>

# End /etc/resolv.conf
EOF
```

Câu lệnh `domain` có thể bỏ đi hoặc thay bằng câu lệnh `search`. Xem trang man của resolv.conf để biết thêm chi tiết.

Hãy thay `<IP address of the nameserver>` bằng địa chỉ IP của DNS phù hợp nhất với hệ thống của bạn. Thường sẽ có nhiều hơn một mục (theo yêu cầu cần máy chủ dự phòng). Nếu bạn chỉ cần hoặc chỉ muốn một máy chủ DNS, hãy xóa dòng *nameserver* thứ hai khỏi tệp. Địa chỉ IP cũng có thể là của một router trong mạng cục bộ.

{% hint style="info" %}
**Note**

Địa chỉ DNS IPv4 công cộng của Google là 8.8.8.8 và 8.8.4.4.
{% endhint %}

## 9.5.3. Configuring the System Hostname

Trong quá trình khởi động, tệp `/etc/hostname` được dùng để đặt tên máy (hostname) của hệ thống.

Tạo tệp `/etc/hostname` và nhập tên máy bằng cách chạy:

```bash
echo "<lfs>" > /etc/hostname
```

`<lfs>` cần được thay bằng tên bạn đặt cho máy tính. Đừng nhập Fully Qualified Domain Name (FQDN) ở đây. Thông tin đó nằm trong tệp `/etc/hosts`.

## 9.5.4. Customizing the /etc/hosts File

Hãy chọn một fully-qualified domain name (FQDN), và các bí danh có thể dùng trong tệp `/etc/hosts`. Nếu dùng địa chỉ IP tĩnh, bạn cũng cần chọn một địa chỉ IP. Cú pháp của một dòng trong tệp hosts là:

```text
IP_address myhost.example.org aliases
```

Trừ khi máy tính cần hiển thị với Internet (tức là có tên miền đã đăng ký và một dải địa chỉ IP hợp lệ được cấp—hầu hết người dùng không có), hãy bảo đảm địa chỉ IP nằm trong dải địa chỉ mạng riêng. Các dải hợp lệ là:

```text
Private Network Address Range      Normal Prefix
10.0.0.1 - 10.255.255.254           8
172.x.0.1 - 172.x.255.254           16
192.168.y.1 - 192.168.y.254         24
```

x có thể là số bất kỳ trong khoảng 16-31. y có thể là số bất kỳ trong khoảng 0-255.

Một địa chỉ IP riêng hợp lệ có thể là 192.168.1.2.

Nếu máy tính cần hiển thị với Internet, FQDN hợp lệ có thể là chính tên miền đó, hoặc một chuỗi ghép từ một tiền tố (thường là hostname) và tên miền bằng ký tự “.”. Và bạn cần liên hệ nhà cung cấp tên miền để phân giải FQDN đó về địa chỉ IP công cộng của bạn.

Dù máy tính không hiển thị với Internet, một số chương trình, như MTA, vẫn cần FQDN để hoạt động đúng. Có thể dùng một FQDN đặc biệt, `localhost.localdomain`, cho mục đích này.

Tạo tệp `/etc/hosts` bằng cách chạy:

```bash
cat > /etc/hosts << "EOF"
# Begin /etc/hosts

127.0.0.1 localhost.localdomain localhost
127.0.1.1 <FQDN> <HOSTNAME>
<192.168.1.2> <FQDN> <HOSTNAME> [alias1] [alias2 ...]
::1       localhost ip6-localhost ip6-loopback
ff02::1   ip6-allnodes
ff02::2   ip6-allrouters

# End /etc/hosts
EOF
```

Các giá trị `<192.168.1.2>`, `<FQDN>` và `<HOSTNAME>` cần được đổi cho phù hợp nhu cầu cụ thể (nếu được quản trị viên mạng/hệ thống cấp địa chỉ IP và máy sẽ kết nối vào một mạng sẵn có). Có thể bỏ qua tên bí danh tùy chọn.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter09/network.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter09/network.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter09/network.html)
