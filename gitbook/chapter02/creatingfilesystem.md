---
description: "Phân vùng chỉ là một dải sector trên ổ đĩa, được giới hạn bởi các ranh giới ghi trong bảng phân vùng. Trước khi hệ điều hành có thể dùng phân vùng để lưu t"
---

# 2.5. Tạo hệ thống tệp trên phân vùng

Phân vùng chỉ là một dải sector trên ổ đĩa, được giới hạn bởi các ranh giới ghi trong bảng phân vùng. Trước khi hệ điều hành có thể dùng phân vùng để lưu tệp, phân vùng phải được định dạng để chứa một hệ thống tệp, thường gồm nhãn, các khối thư mục, các khối dữ liệu và cơ chế lập chỉ mục để tìm một tệp khi cần. Hệ thống tệp còn giúp hệ điều hành theo dõi dung lượng trống trên phân vùng, dành trước các sector cần thiết khi tạo tệp mới hoặc mở rộng tệp có sẵn, và tái sử dụng các vùng dữ liệu trống sinh ra khi tệp bị xóa. Nó cũng có thể hỗ trợ dự phòng dữ liệu và khôi phục lỗi.

LFS có thể dùng bất kỳ hệ thống tệp nào mà kernel Linux nhận biết, nhưng phổ biến nhất là ext3 và ext4. Việc chọn hệ thống tệp phù hợp có thể phức tạp, vì nó phụ thuộc vào đặc điểm của các tệp và kích thước phân vùng. Ví dụ:

**ext2**

> phù hợp với các phân vùng nhỏ, ít khi cập nhật, như /boot.

**ext3**

> là bản nâng cấp của ext2, có thêm nhật ký (journal) giúp khôi phục trạng thái phân vùng khi tắt máy không đúng cách. Nó thường được dùng như hệ thống tệp đa dụng.

**ext4**

> là phiên bản mới nhất của họ hệ thống tệp ext. Nó mang đến nhiều khả năng mới, gồm dấu thời gian đến nano giây, tạo và dùng tệp rất lớn (đến 16 TB), và cải thiện tốc độ.

Các hệ thống tệp khác, như FAT32, NTFS, JFS và XFS, hữu ích cho những mục đích chuyên biệt. Bạn có thể tìm thêm thông tin về các hệ thống tệp này và nhiều loại khác tại [https://en.wikipedia.org/wiki/Comparison\_of\_file\_systems](https://en.wikipedia.org/wiki/Comparison_of_file_systems).

LFS giả định hệ thống tệp gốc (/) thuộc loại ext4. Để tạo hệ thống tệp `ext4` trên phân vùng LFS, hãy chạy lệnh sau:

```bash
mkfs -v -t ext4 /dev/<xxx>
```

Thay `<xxx>` bằng tên của phân vùng LFS.

Nếu bạn dùng một phân vùng `swap` có sẵn thì không cần định dạng lại. Nếu vừa tạo phân vùng `swap` mới, bạn cần khởi tạo nó bằng lệnh sau:

```bash
mkswap /dev/<yyy>
```

Thay `<yyy>` bằng tên của phân vùng `swap`.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter02/creatingfilesystem.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter02/creatingfilesystem.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter02/creatingfilesystem.html)
