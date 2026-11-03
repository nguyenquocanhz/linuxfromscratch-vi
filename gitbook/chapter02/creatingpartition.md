---
description: "Giống hầu hết hệ điều hành khác, LFS thường được cài trên một phân vùng riêng. Cách được khuyến nghị để dựng LFS là dùng một phân vùng trống sẵn có, hoặc n"
---

<details>

<summary>Trick lỏ: Đừng làm trên máy thật — dựng LFS trong máy ảo hoặc file ảnh đĩa</summary>

Lần đầu làm LFS, gõ nhầm một lệnh với quyền root là đủ hỏng hệ thống chủ. Cách an toàn nhất:

* Cài một distro nhẹ (Debian, Ubuntu Server, Fedora...) trong **VirtualBox/QEMU/VMware** rồi làm LFS trong đó. Snapshot máy ảo trước mỗi chương lớn.
* Không muốn chia lại ổ cứng? Dùng **file ảnh đĩa** thay cho phân vùng thật:

```bash
truncate -s 30G ~/lfs.img                       # file thưa, chỉ tốn chỗ khi ghi thật
sudo losetup -fP --show ~/lfs.img               # in ra ví dụ /dev/loop0
sudo fdisk /dev/loop0                           # tạo phân vùng như sách hướng dẫn
sudo mkfs -v -t ext4 /dev/loop0p1
```

Sau này file `lfs.img` boot thẳng được bằng QEMU (xem trick ở Chương 10). Gỡ bằng `sudo losetup -d /dev/loop0`.

[Tất cả trick lỏ →](../trick-lo.md#chay-trong-may-ao)

</details>

# 2.4. Tạo phân vùng mới

Giống hầu hết hệ điều hành khác, LFS thường được cài trên một phân vùng riêng. Cách được khuyến nghị để dựng LFS là dùng một phân vùng trống sẵn có, hoặc nếu còn đủ dung lượng chưa phân vùng thì tạo mới một phân vùng.

Một hệ thống tối thiểu cần phân vùng khoảng 10 gigabyte (GB). Dung lượng này đủ để chứa mọi tarball mã nguồn và biên dịch các gói. Tuy nhiên, nếu bạn định dùng LFS làm hệ thống Linux chính, bạn có thể sẽ cài thêm phần mềm và cần thêm chỗ. Phân vùng 30 GB là kích thước hợp lý để còn chỗ phát triển. Bản thân hệ thống LFS không chiếm nhiều như vậy. Phần lớn dung lượng này dành để có đủ chỗ trống lưu tạm, cũng như để thêm các tính năng sau khi hoàn tất LFS. Ngoài ra, việc biên dịch các gói có thể cần nhiều dung lượng đĩa, và phần đó sẽ được thu hồi sau khi gói được cài đặt.

Vì không phải lúc nào cũng có đủ bộ nhớ truy cập ngẫu nhiên (RAM) cho quá trình biên dịch, nên dùng một phân vùng đĩa nhỏ làm không gian `swap` là ý hay. Kernel dùng nó để lưu dữ liệu ít khi được dùng, nhường thêm bộ nhớ cho các tiến trình đang hoạt động. Phân vùng `swap` của hệ thống LFS có thể dùng chung với máy host, khi đó bạn không cần tạo thêm.

Hãy chạy một chương trình phân vùng đĩa như `cfdisk` hoặc `fdisk` với tùy chọn dòng lệnh chỉ rõ ổ cứng sẽ tạo phân vùng mới, ví dụ `/dev/sda` cho ổ đĩa chính. Hãy tạo một phân vùng Linux native và, nếu cần, một phân vùng `swap`. Nếu chưa biết cách dùng các chương trình này, xem [cfdisk(8)](https://man.archlinux.org/man/cfdisk.8) hoặc [fdisk(8)](https://man.archlinux.org/man/fdisk.8).

{% hint style="info" %}
**Ghi chú**

Với người dùng có kinh nghiệm, còn nhiều cách phân vùng khác. Hệ thống LFS mới có thể nằm trên một mảng [RAID](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/raid.html) phần mềm hoặc một volume logic [LVM](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/aboutlvm.html). Tuy nhiên, một số lựa chọn này cần có [initramfs](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/initramfs.html), vốn là chủ đề nâng cao. Các phương pháp phân vùng này không được khuyên dùng cho người mới làm LFS lần đầu.
{% endhint %}

Hãy nhớ tên của phân vùng mới (ví dụ `sda5`). Sách này sẽ gọi đó là phân vùng LFS. Cũng hãy nhớ tên của phân vùng `swap`. Các tên này sẽ cần dùng sau đó cho tệp `/etc/fstab`.

## 2.4.1. Một số vấn đề khác về phân vùng

Các yêu cầu tư vấn về cách phân vùng hệ thống thường được đăng lên danh sách thư LFS. Đây là chủ đề mang tính chủ quan cao. Mặc định của hầu hết bản phân phối là dùng toàn bộ ổ đĩa, trừ một phân vùng swap nhỏ. Cách này không tối ưu cho LFS vì nhiều lý do: nó làm giảm tính linh hoạt, khiến việc chia sẻ dữ liệu giữa nhiều bản phân phối hoặc nhiều bản dựng LFS khó hơn, việc sao lưu tốn thời gian hơn, và có thể lãng phí dung lượng đĩa do cấu trúc hệ thống tệp được cấp phát kém hiệu quả.

### 2.4.1.1. Phân vùng gốc (Root)

Một phân vùng LFS gốc (đừng nhầm với thư mục `/root`) dung lượng hai mươi gigabyte là sự dung hòa tốt cho hầu hết hệ thống. Nó đủ chỗ để dựng LFS và phần lớn BLFS, nhưng vẫn đủ nhỏ để dễ dàng tạo nhiều phân vùng cho việc thử nghiệm.

### 2.4.1.2. Phân vùng swap

Hầu hết bản phân phối tự động tạo phân vùng swap. Thông thường kích thước khuyến nghị của phân vùng swap bằng khoảng hai lần RAM vật lý, nhưng hiếm khi cần đến vậy. Nếu dung lượng đĩa hạn chế, hãy giữ phân vùng swap ở mức hai gigabyte và theo dõi lượng swap đĩa.

Nếu bạn muốn dùng tính năng ngủ đông (suspend-to-disk) của Linux, nó sẽ ghi toàn bộ nội dung RAM vào phân vùng swap trước khi tắt máy. Khi đó, kích thước phân vùng swap ít nhất phải bằng dung lượng RAM đã lắp trong máy.

Việc swap không bao giờ là tốt. Với ổ cứng cơ, thường bạn có thể biết hệ thống đang swap chỉ bằng cách nghe tiếng ổ đĩa và quan sát phản ứng của máy với các lệnh. Với SSD thì bạn không nghe được, nhưng có thể biết lượng swap đang dùng bằng cách chạy `top` hoặc `free`. Nên tránh dùng SSD làm phân vùng swap nếu có thể. Phản ứng đầu tiên khi thấy swap là kiểm tra xem có lệnh nào bất hợp lý không, chẳng hạn mở sửa một tệp năm gigabyte. Nếu swap trở thành chuyện thường xuyên, giải pháp tốt nhất là mua thêm RAM cho máy.

### 2.4.1.3. Phân vùng Grub Bios

Nếu *đĩa khởi động* được phân vùng bằng bảng phân vùng GUID (GPT), bạn phải tạo một phân vùng nhỏ, thường là 1 MB, nếu chưa có. Phân vùng này không được định dạng, nhưng phải sẵn có để GRUB dùng khi cài bộ nạp khởi động. Phân vùng này thường được gán nhãn 'BIOS Boot' nếu dùng `fdisk`, hoặc có mã *EF02* nếu dùng lệnh `gdisk`.

{% hint style="info" %}
**Ghi chú**

Phân vùng Grub Bios phải nằm trên ổ đĩa mà BIOS dùng để khởi động hệ thống. Ổ đó không nhất thiết là ổ chứa phân vùng gốc của LFS. Các đĩa trong một hệ thống có thể dùng nhiều loại bảng phân vùng khác nhau. Việc có cần phân vùng Grub Bios hay không chỉ phụ thuộc vào loại bảng phân vùng của đĩa khởi động.
{% endhint %}

### 2.4.1.4. Các phân vùng tiện dụng

Còn một số phân vùng khác không bắt buộc nhưng nên cân nhắc khi thiết kế cách bố trí đĩa. Danh sách sau không đầy đủ, chỉ mang tính tham khảo.

* /boot – Rất nên có. Dùng phân vùng này để lưu kernel và các thông tin khởi động khác. Để giảm thiểu các sự cố khởi động tiềm ẩn với ổ đĩa lớn, hãy đặt nó làm phân vùng vật lý đầu tiên trên ổ đĩa đầu tiên. Kích thước 200 megabyte là đủ.
* /boot/efi – Phân vùng hệ thống EFI (EFI System Partition), cần thiết để khởi động hệ thống bằng UEFI. Xem chi tiết tại [trang BLFS](https://www.linuxfromscratch.org/blfs/view/12.4/postlfs/grub-setup.html).
* /home – Rất nên có. Chia sẻ thư mục home và các tùy chỉnh người dùng giữa nhiều bản phân phối hoặc nhiều bản dựng LFS. Kích thước thường khá lớn và tùy theo dung lượng đĩa hiện có.
* /usr – Trong LFS, `/bin`, `/lib` và `/sbin` là các symlink trỏ đến bản tương ứng trong `/usr`. Vì vậy `/usr` chứa mọi tệp nhị phân cần để hệ thống chạy. Với LFS, thường không cần phân vùng `/usr` riêng. Nếu vẫn tạo, bạn nên làm phân vùng đủ lớn để chứa mọi chương trình và thư viện của hệ thống. Khi đó phân vùng gốc có thể rất nhỏ (có lẽ chỉ một gigabyte), nên phù hợp cho thin client hoặc máy trạm không đĩa (nơi `/usr` được mount từ máy chủ từ xa). Tuy vậy, hãy lưu ý rằng cần có initramfs (LFS không đề cập) để khởi động hệ thống có phân vùng `/usr` riêng.
* /opt – Thư mục này hữu ích nhất với BLFS, nơi nhiều gói lớn như KDE hay Texlive có thể được cài mà không nhúng tệp vào cây thư mục /usr. Nếu dùng, 5 đến 10 gigabyte thường là đủ.
* /tmp – Phân vùng /tmp riêng hiếm khi có, nhưng hữu ích khi cấu hình thin client. Nếu dùng, phân vùng này thường không cần quá vài gigabyte. Nếu có đủ RAM, bạn có thể mount một `tmpfs` lên /tmp để truy cập tệp tạm nhanh hơn.
* /usr/src – Phân vùng này rất hữu ích để làm nơi lưu các tệp mã nguồn BLFS và chia sẻ chúng giữa các bản dựng LFS. Nó cũng có thể dùng làm nơi dựng các gói BLFS. Một phân vùng khá lớn, 30-50 gigabyte, là quá đủ chỗ.

Mọi phân vùng riêng mà bạn muốn tự động mount khi hệ thống khởi động đều phải được khai báo trong tệp `/etc/fstab`. Chi tiết về cách khai báo phân vùng sẽ được bàn ở [Mục 10.2, “Tạo tệp /etc/fstab”](../chapter10/fstab.md).

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter02/creatingpartition.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter02/creatingpartition.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter02/creatingpartition.html)
