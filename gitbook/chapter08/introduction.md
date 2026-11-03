---
description: "Trong chương này, chúng ta bắt đầu xây dựng hệ thống LFS một cách nghiêm túc."
---

<details>

<summary>Trick lỏ: Tắt máy giữa chừng? Checklist vào lại chroot</summary>

Tắt máy rồi bật lại, mọi mount đều mất. Lưu đoạn này thành `~/vao-lfs.sh` rồi chạy bằng root (đổi `/dev/sdb2` thành phân vùng của bạn):

```bash
#!/bin/bash
set -e
export LFS=/mnt/lfs
mountpoint -q $LFS || mount -v -t ext4 /dev/sdb2 $LFS
mountpoint -q $LFS/dev || mount -v --bind /dev $LFS/dev
mountpoint -q $LFS/dev/pts || mount -vt devpts devpts -o gid=5,mode=0620 $LFS/dev/pts
mountpoint -q $LFS/proc || mount -vt proc proc $LFS/proc
mountpoint -q $LFS/sys || mount -vt sysfs sysfs $LFS/sys
mountpoint -q $LFS/run || mount -vt tmpfs tmpfs $LFS/run
if [ -h $LFS/dev/shm ]; then install -v -d -m 1777 $LFS$(realpath /dev/shm); else mountpoint -q $LFS/dev/shm || mount -vt tmpfs -o nosuid,nodev tmpfs $LFS/dev/shm; fi
chroot "$LFS" /usr/bin/env -i HOME=/root TERM="$TERM" PS1='(lfs chroot) \u:\w\$ ' \
  PATH=/usr/bin:/usr/sbin MAKEFLAGS="-j$(nproc)" TESTSUITEFLAGS="-j$(nproc)" /bin/bash --login
```

Đây đúng là các lệnh trong Mục 7.3 và 7.4, chỉ thêm `mountpoint -q` để chạy lại nhiều lần không bị mount chồng.

[Tất cả trick lỏ →](../trick-lo.md#vao-lai-chroot)

</details>

# 8.1. Giới thiệu

Trong chương này, chúng ta bắt đầu xây dựng hệ thống LFS một cách nghiêm túc.

Việc cài đặt phần mềm này khá đơn giản. Dù nhiều chỗ có thể rút gọn và viết chung hơn, chúng tôi vẫn chọn đưa hướng dẫn đầy đủ cho từng gói để giảm thiểu khả năng sai sót. Chìa khóa để hiểu một hệ thống Linux vận hành ra sao là biết mỗi gói dùng để làm gì và vì sao bạn (hoặc hệ thống) cần đến nó.

Chúng tôi không khuyến khích dùng các tối ưu hóa tùy biến. Chúng có thể giúp chương trình chạy nhanh hơn một chút, nhưng cũng có thể gây khó khăn khi biên dịch và lỗi khi chạy chương trình. Nếu một gói không chịu biên dịch với tối ưu hóa tùy biến, hãy thử biên dịch không tối ưu hóa xem có hết lỗi không. Ngay cả khi gói biên dịch được với tối ưu hóa tùy biến, vẫn có nguy cơ nó bị biên dịch sai do sự tương tác phức tạp giữa mã nguồn và các công cụ dựng. Cũng lưu ý rằng các tùy chọn `-march` và `-mtune` với giá trị không được nêu trong sách chưa hề được kiểm thử. Điều này có thể gây vấn đề cho các gói toolchain (Binutils, GCC và Glibc). Lợi ích nhỏ nhoi từ việc tùy biến tối ưu hóa của trình biên dịch thường không bù được rủi ro. Nếu bạn dựng LFS lần đầu, nên dựng mà không dùng tối ưu hóa tùy biến.

Mặt khác, chúng tôi vẫn giữ các tối ưu hóa được bật theo cấu hình mặc định của các gói. Ngoài ra, đôi khi chúng tôi chủ động bật một cấu hình tối ưu do gói cung cấp nhưng không bật mặc định. Người bảo trì gói đã kiểm thử các cấu hình này và coi là an toàn, nên khó có khả năng chúng làm hỏng quá trình dựng. Nhìn chung cấu hình mặc định đã bật `-O2` hoặc `-O3`, nên hệ thống tạo ra vẫn chạy rất nhanh mà không cần tối ưu hóa tùy biến, đồng thời vẫn ổn định.

Trước phần hướng dẫn cài đặt, mỗi trang cài đặt đều có thông tin về gói, gồm mô tả ngắn gọn về nội dung gói, thời gian dựng ước tính và dung lượng đĩa cần trong quá trình dựng. Sau phần hướng dẫn cài đặt là danh sách các chương trình và thư viện (kèm mô tả ngắn) mà gói cài vào hệ thống.

{% hint style="info" %}
**Ghi chú**

Giá trị SBU và dung lượng đĩa cần đã bao gồm dữ liệu của bộ kiểm thử cho mọi gói có áp dụng trong [Chương 8](chapter08.md). Giá trị SBU được tính với bốn nhân CPU (-j4) cho mọi thao tác, trừ khi có ghi chú khác.
{% endhint %}

## 8.1.1. Về các thư viện

Nhìn chung, các biên tập viên LFS không khuyến khích dựng và cài thư viện tĩnh. Hầu hết thư viện tĩnh đã lỗi thời trên một hệ thống Linux hiện đại. Ngoài ra, liên kết thư viện tĩnh vào chương trình có thể gây hại: nếu thư viện cần cập nhật để vá lỗ hổng bảo mật, mọi chương trình dùng thư viện tĩnh đó đều phải được liên kết lại với thư viện mới. Vì việc dùng thư viện tĩnh không phải lúc nào cũng dễ nhận ra, nên có khi bạn còn không biết những chương trình nào liên quan (và cách liên kết ra sao).

Các bước trong chương này gỡ bỏ hoặc tắt việc cài hầu hết thư viện tĩnh. Thường việc này được làm bằng cách truyền tùy chọn `--disable-static` cho `configure`. Ở các trường hợp khác cần dùng cách khác. Trong một vài trường hợp, nhất là Glibc và GCC, thư viện tĩnh vẫn là phần thiết yếu của quá trình dựng gói.

Để tìm hiểu đầy đủ hơn về thư viện, xem [Libraries: Static or shared?](https://www.linuxfromscratch.org/blfs/view/12.4/introduction/libraries.html) trong sách BLFS.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/introduction.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/introduction.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/introduction.html)
