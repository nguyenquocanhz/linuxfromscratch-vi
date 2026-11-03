---
description: "Trước tiên, xóa các tệp tài liệu đang cài để chúng không lọt vào hệ thống cuối cùng, đồng thời tiết kiệm khoảng 35 MB:"
---

<details>

<summary>Trick lỏ: Sao lưu sau Chương 7 bằng zstd — nhanh hơn xz rất nhiều</summary>

Sách gợi ý nén `$LFS` bằng `xz`, khá chậm trên máy yếu. `zstd` nén gần tốt bằng mà nhanh gấp nhiều lần (nhớ thoát chroot và umount các hệ thống file ảo trước, đúng như sách dặn):

```bash
cd $LFS
tar --exclude=./sources -cf - . | zstd -T0 -10 > $HOME/lfs-ch7.tar.zst
# khôi phục:
cd $LFS && rm -rf ./* && zstd -dc $HOME/lfs-ch7.tar.zst | tar -xpf -
```

Làm trong máy ảo thì còn nhàn hơn: chụp **snapshot** máy ảo ở mốc này, hỏng gì ở Chương 8 thì quay lại trong vài giây.

[Tất cả trick lỏ →](../trick-lo.md#backup-zstd)

</details>

# 7.13. Dọn dẹp và lưu lại hệ thống tạm

## 7.13.1. Dọn dẹp

Trước tiên, xóa các tệp tài liệu đang cài để chúng không lọt vào hệ thống cuối cùng, đồng thời tiết kiệm khoảng 35 MB:

```bash
rm -rf /usr/share/{info,man,doc}/*
```

Thứ hai, trên hệ thống Linux hiện đại, các tệp .la của libtool chỉ hữu ích cho libltdl. Không thư viện nào trong LFS được nạp bằng libltdl, và biết rằng một số tệp .la có thể làm các gói BLFS lỗi. Hãy xóa chúng ngay bây giờ:

```bash
find /usr/{lib,libexec} -name \*.la -delete
```

Kích thước hệ thống hiện khoảng 3 GB, nhưng thư mục /tools không còn cần nữa. Nó chiếm khoảng 1 GB dung lượng đĩa. Hãy xóa nó:

```bash
rm -rf /tools
```

## 7.13.2. Sao lưu

Đến đây các chương trình và thư viện thiết yếu đã được tạo và hệ thống LFS hiện tại đang ở trạng thái tốt. Bạn có thể sao lưu hệ thống để dùng lại sau này. Nếu gặp lỗi nghiêm trọng ở các chương sau, thường cách khắc phục tốt nhất là xóa hết và làm lại (cẩn thận hơn). Tiếc là mọi tệp tạm cũng sẽ bị xóa. Để khỏi mất thời gian làm lại những gì đã thành công, bản sao lưu của hệ thống LFS hiện tại có thể rất hữu ích.

{% hint style="info" %}
**Ghi chú**

Tất cả các bước còn lại trong mục này là tùy chọn. Tuy nhiên, ngay khi bạn bắt đầu cài gói ở [Chương 8](../chapter08/chapter08.md), các tệp tạm sẽ bị ghi đè. Vì vậy nên sao lưu hệ thống hiện tại như mô tả dưới đây.
{% endhint %}

Các bước sau được thực hiện từ bên ngoài môi trường chroot. Nghĩa là bạn phải thoát khỏi môi trường chroot trước khi tiếp tục. Lý do là để truy cập các vị trí hệ thống tệp bên ngoài chroot nhằm lưu/đọc kho sao lưu, vốn không nên đặt trong cây thư mục `$LFS`.

Nếu đã quyết định sao lưu, hãy thoát khỏi môi trường chroot:

```bash
exit
```

{% hint style="warning" %}
**Quan trọng**

Mọi hướng dẫn dưới đây đều do `root` thực hiện trên hệ thống host của bạn. Hãy hết sức cẩn thận với các lệnh sắp chạy vì sai sót ở đây có thể làm thay đổi hệ thống host. Lưu ý biến môi trường `LFS` mặc định được đặt cho người dùng `lfs` nhưng có thể *không* được đặt cho `root`.

Mỗi khi chạy lệnh bằng `root`, hãy chắc chắn bạn đã đặt `LFS`.

Điều này đã được bàn tới trong [Mục 2.6, “Đặt biến $LFS và umask.”](../chapter02/aboutlfs.md)
{% endhint %}

Trước khi sao lưu, hãy umount các hệ thống tệp ảo:

```bash
mountpoint -q $LFS/dev/shm && umount $LFS/dev/shm
umount $LFS/dev/pts
umount $LFS/{sys,proc,run,dev}
```

Hãy chắc chắn hệ thống tệp chứa thư mục nơi bạn tạo kho sao lưu còn trống ít nhất 1 GB (các tarball mã nguồn cũng nằm trong kho sao lưu).

Lưu ý các hướng dẫn dưới đây chỉ định thư mục home của người dùng `root` trên hệ thống host, thường nằm trên hệ thống tệp gốc. Hãy thay `$HOME` bằng thư mục bạn chọn nếu không muốn lưu bản sao lưu trong thư mục home của `root`.

Tạo kho sao lưu bằng lệnh sau:

{% hint style="info" %}
**Ghi chú**

Vì kho sao lưu được nén nên cần tương đối nhiều thời gian (trên 10 phút) ngay cả trên hệ thống khá nhanh.
{% endhint %}

```bash
cd $LFS
tar -cJpf $HOME/lfs-temp-tools-12.4.tar.xz .
```

{% hint style="info" %}
**Ghi chú**

Nếu tiếp tục sang chương 8, đừng quên vào lại môi trường chroot như giải thích trong khung “Quan trọng” bên dưới.
{% endhint %}

## 7.13.3. Khôi phục

Nếu có sai sót và bạn cần làm lại từ đầu, bạn có thể dùng bản sao lưu này để khôi phục hệ thống và tiết kiệm thời gian. Vì mã nguồn nằm dưới `$LFS` nên chúng cũng nằm trong kho sao lưu và không cần tải lại. Sau khi kiểm tra `$LFS` đã được đặt đúng, bạn có thể khôi phục bằng các lệnh sau:

{% hint style="danger" %}
**Cảnh báo**

Các lệnh sau cực kỳ nguy hiểm. Nếu bạn chạy `rm -rf ./*` bằng người dùng `root` mà không chuyển vào thư mục $LFS hoặc biến môi trường `LFS` chưa được đặt cho `root`, nó sẽ phá hủy toàn bộ hệ thống host của bạn. BẠN ĐÃ ĐƯỢC CẢNH BÁO.
{% endhint %}

```text
cd $LFS
rm -rf ./*
tar -xpf $HOME/lfs-temp-tools-12.4.tar.xz
```

Một lần nữa, hãy kiểm tra kỹ môi trường đã được thiết lập đúng rồi tiếp tục dựng phần còn lại của hệ thống.

{% hint style="warning" %}
**Quan trọng**

Nếu bạn đã rời môi trường chroot để sao lưu hoặc dựng lại từ bản khôi phục, nhớ kiểm tra các hệ thống tệp ảo vẫn còn được mount (`findmnt | grep $LFS`). Nếu chưa, hãy mount lại như mô tả trong [Mục 7.3, “Chuẩn bị các hệ thống tệp ảo của kernel”](kernfs.md) và vào lại môi trường chroot (xem [Mục 7.4, “Vào môi trường chroot”](chroot.md)) trước khi tiếp tục.
{% endhint %}

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/cleanup.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/cleanup.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/cleanup.html)
