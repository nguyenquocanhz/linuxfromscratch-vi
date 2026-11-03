---
description: "Giờ hệ thống tệp đã được tạo, phân vùng cần được mount để máy host truy cập được. Sách này giả định hệ thống tệp được mount tại thư mục chỉ định bởi biến m"
---

# 2.7. Mount phân vùng mới

Giờ hệ thống tệp đã được tạo, phân vùng cần được mount để máy host truy cập được. Sách này giả định hệ thống tệp được mount tại thư mục chỉ định bởi biến môi trường `LFS` đã nói ở mục trước.

Nói chính xác thì không thể “mount một phân vùng.” Thứ được mount là *hệ thống tệp* nằm trong phân vùng đó. Nhưng vì một phân vùng không thể chứa nhiều hơn một hệ thống tệp, người ta thường nói về phân vùng và hệ thống tệp đi kèm như thể chúng là một.

Tạo điểm mount và mount hệ thống tệp LFS bằng các lệnh sau:

```bash
mkdir -pv $LFS
mount -v -t ext4 /dev/<xxx> $LFS
```

Thay `<xxx>` bằng tên của phân vùng LFS.

Nếu bạn dùng nhiều phân vùng cho LFS (ví dụ một cho `/` và một cho `/home`), hãy mount chúng như sau:

```bash
mkdir -pv $LFS
mount -v -t ext4 /dev/<xxx> $LFS
mkdir -v $LFS/home
mount -v -t ext4 /dev/<yyy> $LFS/home
```

Thay `<xxx>` và `<yyy>` bằng tên các phân vùng tương ứng.

Đặt chủ sở hữu và quyền của thư mục `$LFS` (tức thư mục gốc trong hệ thống tệp mới tạo cho hệ thống LFS) thành `root` và `755`, phòng khi bản phân phối host được cấu hình mặc định khác cho `mkfs`:

```bash
chown root:root $LFS
chmod 755 $LFS
```

Hãy bảo đảm phân vùng mới này không được mount với quyền quá hạn chế (như các tùy chọn `nosuid` hoặc `nodev`). Chạy lệnh `mount` không kèm tham số để xem các tùy chọn đang đặt cho phân vùng LFS đã mount. Nếu `nosuid` và/hoặc `nodev` được đặt, bạn phải mount lại phân vùng.

{% hint style="danger" %}
**Cảnh báo**

Các hướng dẫn trên giả định bạn sẽ không khởi động lại máy trong suốt quá trình dựng LFS. Nếu tắt máy, mỗi lần tiếp tục dựng bạn sẽ phải mount lại phân vùng LFS, hoặc sửa tệp `/etc/fstab` của máy host để nó tự mount lại khi khởi động. Ví dụ, bạn có thể thêm dòng này vào `/etc/fstab`:

```text
/dev/<xxx>  /mnt/lfs ext4   defaults      1     1
```

Nếu bạn dùng thêm các phân vùng tùy chọn khác, nhớ thêm chúng vào luôn.
{% endhint %}

Nếu bạn dùng phân vùng `swap`, hãy bảo đảm nó được bật bằng lệnh `swapon`:

```bash
/sbin/swapon -v /dev/<zzz>
```

Thay `<zzz>` bằng tên của phân vùng `swap`.

Giờ phân vùng LFS mới đã sẵn sàng hoạt động, đến lúc tải các gói về.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter02/mounting.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter02/mounting.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter02/mounting.html)
