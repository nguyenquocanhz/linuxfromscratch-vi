---
description: "Chương này liệt kê các gói cần tải về để dựng một hệ thống Linux cơ bản. Số phiên bản trong danh sách là những phiên bản phần mềm đã được biết là chạy tốt,"
---

<details>

<summary>Trick lỏ: Tải toàn bộ mã nguồn nhanh và kiểm tra một lần</summary>

Sách cho sẵn file `wget-list-sysv` và `md5sums`. Tải song song cho nhanh (cần gói `aria2`):

```bash
cd $LFS/sources
wget https://www.linuxfromscratch.org/lfs/view/12.4/wget-list-sysv
wget https://www.linuxfromscratch.org/lfs/view/12.4/md5sums
aria2c -x4 -j8 -c -i wget-list-sysv     # -c: tải tiếp nếu đứt mạng
md5sum -c md5sums | grep -v ': OK$'     # chỉ in file lỗi; không in gì = ngon
```

Có file tải hỏng từ server gốc? Mỗi gói thường có mirror khác trên trang dự án; tải tay rồi chạy lại `md5sum -c`. Mẹo thêm: nén cả thư mục `sources` lại cất đi — lần làm LFS thứ hai khỏi tải lại.

[Tất cả trick lỏ →](../trick-lo.md#tai-nguon-nhanh)

</details>

# 3.1. Giới thiệu

Chương này liệt kê các gói cần tải về để dựng một hệ thống Linux cơ bản. Số phiên bản trong danh sách là những phiên bản phần mềm đã được biết là chạy tốt, và cuốn sách này được viết dựa trên chúng. Chúng tôi khuyên bạn không nên dùng phiên bản khác, vì lệnh dựng của phiên bản này có thể không chạy với phiên bản kia, trừ khi phiên bản khác đó được nêu trong một errata (đính chính) hoặc thông báo bảo mật của LFS. Các phiên bản gói mới nhất cũng có thể có vấn đề cần cách xử lý tạm thời; các cách này sẽ được phát triển và ổn định trong bản phát triển (development) của sách.

Với một số gói, tarball phát hành và tarball snapshot của kho mã (Git hoặc SVN) cho bản phát hành đó có thể được đăng với tên tệp gần giống hoặc thậm chí giống hệt nhau. Nhưng tarball phát hành có thể chứa một số tệp thiết yếu mà kho mã không lưu (ví dụ script `configure` do `autoconf` sinh ra), bên cạnh nội dung của snapshot kho mã tương ứng. Sách dùng tarball phát hành bất cứ khi nào có thể. Nếu dùng snapshot kho mã thay cho tarball phát hành mà sách chỉ định, bạn sẽ gặp lỗi.

Địa chỉ tải không phải lúc nào cũng truy cập được. Nếu một địa chỉ tải đã đổi kể từ khi sách được xuất bản, Google ([https://www.google.com/](https://www.google.com/)) là công cụ tìm kiếm hữu ích cho hầu hết các gói. Nếu tìm không ra, hãy thử một trong các cách tải khác tại [https://www.linuxfromscratch.org/lfs/mirrors.html\#files](https://www.linuxfromscratch.org/lfs/mirrors.html#files).

Các gói và bản vá đã tải cần được lưu ở nơi tiện truy cập trong suốt quá trình dựng. Bạn cũng cần một thư mục làm việc để giải nén và dựng mã nguồn. Có thể dùng `$LFS/sources` vừa để chứa tarball và bản vá, vừa làm thư mục làm việc. Dùng thư mục này thì mọi thứ cần thiết nằm sẵn trên phân vùng LFS và dùng được ở mọi giai đoạn dựng.

Để tạo thư mục này, hãy chạy lệnh sau bằng người dùng `root` trước khi bắt đầu tải:

```bash
mkdir -v $LFS/sources
```

Hãy đặt thư mục này ở chế độ ghi được và sticky. “Sticky” nghĩa là dù nhiều người dùng có quyền ghi vào một thư mục, chỉ chủ sở hữu của tệp mới xóa được tệp đó trong thư mục sticky. Lệnh sau bật chế độ ghi và sticky:

```bash
chmod -v a+wt $LFS/sources
```

Có nhiều cách để lấy tất cả gói và bản vá cần thiết cho việc dựng LFS:

* Bạn có thể tải từng tệp riêng lẻ như mô tả trong hai mục tiếp theo.
* Với các bản ổn định của sách, bạn có thể tải một tarball chứa mọi tệp cần thiết từ một trong các trang mirror liệt kê tại [https://www.linuxfromscratch.org/mirrors.html\#files](https://www.linuxfromscratch.org/mirrors.html#files).
* Bạn có thể tải các tệp bằng `wget` cùng một wget-list như mô tả dưới đây.

Để tải tất cả gói và bản vá bằng cách dùng [wget-list-sysv](https://linuxfromscratch.wrenevil.tech/12.4/wget-list-sysv) làm đầu vào cho lệnh `wget`, hãy chạy:

```bash
wget --input-file=wget-list-sysv --continue --directory-prefix=$LFS/sources
```

Ngoài ra, kể từ LFS-7.0 còn có một tệp riêng, [md5sums](https://linuxfromscratch.wrenevil.tech/12.4/md5sums), dùng để kiểm tra xem đã có đủ và đúng các gói trước khi tiếp tục hay chưa. Hãy đặt tệp đó vào `$LFS/sources` và chạy:

```bash
pushd $LFS/sources
  md5sum -c md5sums
popd
```

Bạn có thể dùng bước kiểm tra này sau khi lấy các tệp cần thiết bằng bất kỳ cách nào kể trên.

Nếu bạn tải các gói và bản vá bằng người dùng không phải `root`, các tệp này sẽ thuộc sở hữu của người dùng đó. Hệ thống tệp ghi chủ sở hữu theo UID, mà UID của một người dùng thường trên distro host không được gán trong LFS. Vì vậy, trong hệ thống LFS cuối cùng các tệp sẽ thuộc về một UID không có tên. Nếu bạn sẽ không gán cùng UID đó cho người dùng của mình trong hệ thống LFS, hãy đổi chủ sở hữu các tệp này sang `root` ngay bây giờ để tránh vấn đề này:

```bash
chown root:root $LFS/sources/*
```

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter03/introduction.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter03/introduction.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter03/introduction.html)
