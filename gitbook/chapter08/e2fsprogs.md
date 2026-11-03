---
description: "Gói E2fsprogs chứa các tiện ích để xử lý hệ thống tệp ext2. Nó cũng hỗ trợ các hệ thống tệp có journal ext3 và ext4."
---

# 8.80. E2fsprogs-1.47.3

Gói E2fsprogs chứa các tiện ích để xử lý hệ thống tệp `ext2`. Nó cũng hỗ trợ các hệ thống tệp có journal `ext3` và `ext4`.

* **Thời gian dựng ước tính:** 2.4 SBU trên đĩa quay (HDD), 0.5 SBU trên SSD
* **Dung lượng đĩa cần:** 100 MB

## 8.80.1. Cài đặt E2fsprogs

Tài liệu của E2fsprogs khuyến nghị dựng gói trong một thư mục con của cây mã nguồn:

```bash
mkdir -v build
cd       build
```

Chuẩn bị biên dịch E2fsprogs:

```bash
../configure --prefix=/usr       \
             --sysconfdir=/etc   \
             --enable-elf-shlibs \
             --disable-libblkid  \
             --disable-libuuid   \
             --disable-uuidd     \
             --disable-fsck
```

**Ý nghĩa các tùy chọn configure:**

**`--enable-elf-shlibs`**

> Tạo các thư viện chia sẻ mà một số chương trình trong gói này sử dụng.

**`--disable-*`**

> Các tùy chọn này ngăn việc dựng và cài đặt các thư viện `libuuid` và `libblkid`, daemon `uuidd` và trình bao bọc `fsck`; util-linux sẽ cài các phiên bản mới hơn.

Biên dịch gói:

```bash
make
```

Để chạy bộ kiểm thử, hãy chạy:

```bash
make check
```

Có một bài kiểm thử tên `m_assume_storage_prezeroed` được biết là sẽ thất bại. Một bài khác tên `m_rootdir_acl` cũng được biết là thất bại nếu hệ thống tệp dùng cho hệ thống LFS không phải `ext4`.

Cài đặt gói:

```bash
make install
```

Xóa các thư viện tĩnh vô dụng:

```bash
rm -fv /usr/lib/{libcom_err,libe2p,libext2fs,libss}.a
```

Gói này cài một tệp `.info` đã nén gzip nhưng không cập nhật tệp `dir` của toàn hệ thống. Hãy giải nén tệp này rồi cập nhật tệp `dir` của hệ thống bằng các lệnh sau:

```bash
gunzip -v /usr/share/info/libext2fs.info.gz
install-info --dir-file=/usr/share/info/dir /usr/share/info/libext2fs.info
```

Nếu muốn, hãy tạo và cài đặt thêm một số tài liệu bằng các lệnh sau:

```bash
makeinfo -o      doc/com_err.info ../lib/et/com_err.texinfo
install -v -m644 doc/com_err.info /usr/share/info
install-info --dir-file=/usr/share/info/dir /usr/share/info/com_err.info
```

## 8.80.2. Cấu hình E2fsprogs

`/etc/mke2fs.conf` chứa giá trị mặc định của nhiều tùy chọn dòng lệnh của `mke2fs`. Bạn có thể sửa tệp này để các giá trị mặc định phù hợp với nhu cầu. Ví dụ, một số tiện ích (không có trong LFS hay BLFS) không nhận ra được hệ thống tệp `ext4` bật tính năng `metadata_csum_seed`. **Nếu** bạn cần một tiện ích như vậy, có thể gỡ tính năng đó khỏi danh sách tính năng mặc định của `ext4` bằng lệnh:

```bash
sed 's/metadata_csum_seed,//' -i /etc/mke2fs.conf
```

Đọc trang man [mke2fs.conf(5)](https://man.archlinux.org/man/mke2fs.conf.5) để biết chi tiết.

## 8.80.3. Nội dung của E2fsprogs

* **Chương trình được cài:** badblocks, chattr, compile\_et, debugfs, dumpe2fs, e2freefrag, e2fsck, e2image, e2label, e2mmpstatus, e2scrub, e2scrub\_all, e2undo, e4crypt, e4defrag, filefrag, fsck.ext2, fsck.ext3, fsck.ext4, logsave, lsattr, mk\_cmds, mke2fs, mkfs.ext2, mkfs.ext3, mkfs.ext4, mklost+found, resize2fs, và tune2fs
* **Thư viện được cài:** libcom\_err.so, libe2p.so, libext2fs.so, và libss.so
* **Thư mục được cài:** /usr/include/e2p, /usr/include/et, /usr/include/ext2fs, /usr/include/ss, /usr/lib/e2fsprogs, /usr/share/et, và /usr/share/ss

### Mô tả ngắn

* `badblocks` — Tìm các khối hỏng (bad block) trên một thiết bị (thường là một phân vùng đĩa)
* `chattr` — Thay đổi thuộc tính của tệp trên các hệ thống tệp `ext{234}`
* `compile_et` — Trình biên dịch bảng lỗi; chuyển bảng tên mã lỗi và thông điệp thành tệp nguồn C dùng được với thư viện `com_err`
* `debugfs` — Trình gỡ lỗi hệ thống tệp; dùng để xem xét và thay đổi trạng thái của các hệ thống tệp `ext{234}`
* `dumpe2fs` — In thông tin super block và nhóm khối của hệ thống tệp trên một thiết bị cho trước
* `e2freefrag` — Báo cáo thông tin phân mảnh của dung lượng trống
* `e2fsck` — Dùng để kiểm tra và tùy chọn sửa chữa các hệ thống tệp `ext{234}`
* `e2image` — Dùng để lưu dữ liệu quan trọng của hệ thống tệp `ext{234}` vào một tệp
* `e2label` — Hiển thị hoặc thay đổi nhãn hệ thống tệp `ext{234}` trên một thiết bị cho trước
* `e2mmpstatus` — Kiểm tra trạng thái MMP (Multiple Mount Protection) của hệ thống tệp `ext4`
* `e2scrub` — Kiểm tra nội dung của một hệ thống tệp `ext{234}` đang được mount
* `e2scrub_all` — Kiểm tra lỗi trên mọi hệ thống tệp `ext{234}` đang được mount
* `e2undo` — Phát lại undo log của hệ thống tệp `ext{234}` trên một thiết bị. \[Có thể dùng để hoàn tác một thao tác thất bại của chương trình thuộc E2fsprogs.\]
* `e4crypt` — Tiện ích mã hóa hệ thống tệp `Ext4`
* `e4defrag` — Trình chống phân mảnh trực tuyến cho hệ thống tệp `ext4`
* `filefrag` — Báo cáo mức độ phân mảnh của một tệp cụ thể
* `fsck.ext2` — Mặc định kiểm tra hệ thống tệp `ext2` và là một hard link tới `e2fsck`
* `fsck.ext3` — Mặc định kiểm tra hệ thống tệp `ext3` và là một hard link tới `e2fsck`
* `fsck.ext4` — Mặc định kiểm tra hệ thống tệp `ext4` và là một hard link tới `e2fsck`
* `logsave` — Lưu đầu ra của một lệnh vào tệp log
* `lsattr` — Liệt kê thuộc tính của các tệp trên hệ thống tệp ext thế hệ thứ hai (second extended)
* `mk_cmds` — Chuyển bảng tên lệnh và thông điệp trợ giúp thành tệp nguồn C dùng được với thư viện hệ con `libss`
* `mke2fs` — Tạo hệ thống tệp `ext{234}` trên thiết bị cho trước
* `mkfs.ext2` — Mặc định tạo hệ thống tệp `ext2` và là một hard link tới `mke2fs`
* `mkfs.ext3` — Mặc định tạo hệ thống tệp `ext3` và là một hard link tới `mke2fs`
* `mkfs.ext4` — Mặc định tạo hệ thống tệp `ext4` và là một hard link tới `mke2fs`
* `mklost+found` — Tạo thư mục `lost+found` trên hệ thống tệp `ext{234}`; nó cấp phát trước các khối đĩa cho thư mục này để giảm bớt công việc của `e2fsck`
* `resize2fs` — Dùng để phóng to hoặc thu nhỏ hệ thống tệp `ext{234}`
* `tune2fs` — Điều chỉnh các tham số có thể tinh chỉnh của hệ thống tệp `ext{234}`
* `libcom_err` — Routine hiển thị lỗi dùng chung
* `libe2p` — Được `dumpe2fs`, `chattr` và `lsattr` sử dụng
* `libext2fs` — Chứa các routine cho phép chương trình ở mức người dùng thao tác với hệ thống tệp `ext{234}`
* `libss` — Được `debugfs` sử dụng

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/e2fsprogs.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/e2fsprogs.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/e2fsprogs.html)
