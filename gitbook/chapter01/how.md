---
description: "Hệ thống LFS được dựng bằng cách dùng một bản phân phối Linux đã cài sẵn (như Debian, OpenMandriva, Fedora hoặc openSUSE). Hệ thống Linux có sẵn này (máy h"
---

# 1.1. Cách dựng một hệ thống LFS

Hệ thống LFS được dựng bằng cách dùng một bản phân phối Linux đã cài sẵn (như Debian, OpenMandriva, Fedora hoặc openSUSE). Hệ thống Linux có sẵn này (máy host) là điểm xuất phát, cung cấp các chương trình cần thiết như trình biên dịch, trình liên kết (linker) và shell để dựng hệ thống mới. Hãy chọn tùy chọn “development” (phát triển) khi cài bản phân phối để có đủ các công cụ này.

{% hint style="info" %}
**Ghi chú**

Có nhiều cách để cài một bản phân phối Linux và cấu hình mặc định thường không tối ưu cho việc dựng LFS. Để xem gợi ý cách thiết lập một bản phân phối thương mại, hãy đọc: [https://www.linuxfromscratch.org/hints/downloads/files/partitioning-for-lfs.txt](https://www.linuxfromscratch.org/hints/downloads/files/partitioning-for-lfs.txt).
{% endhint %}

Thay vì cài một bản phân phối riêng lên máy, bạn cũng có thể dùng LiveCD của một bản phân phối thương mại.

[Chương 2](../chapter02/chapter02.md) của sách này mô tả cách tạo một phân vùng Linux native và hệ thống tệp mới, nơi hệ thống LFS sẽ được biên dịch và cài đặt. [Chương 3](../chapter03/chapter03.md) giải thích những gói và bản vá (patch) nào cần tải về để dựng LFS, cũng như cách lưu chúng trên hệ thống tệp mới. [Chương 4](../chapter04/chapter04.md) bàn về việc thiết lập môi trường làm việc phù hợp. Hãy đọc kỹ [Chương 4](../chapter04/chapter04.md), vì nó giải thích nhiều điều quan trọng bạn cần biết trước khi bắt tay vào [Chương 5](../chapter05/chapter05.md) và các chương sau.

[Chương 5](../chapter05/chapter05.md) hướng dẫn cài toolchain (bộ công cụ biên dịch) ban đầu gồm binutils, gcc và glibc bằng kỹ thuật biên dịch chéo, nhằm tách biệt các công cụ mới khỏi hệ thống host.

[Chương 6](../chapter06/chapter06.md) chỉ cho bạn cách biên dịch chéo các tiện ích cơ bản bằng toolchain chéo vừa dựng xong.

[Chương 7](../chapter07/chapter07.md) sau đó vào môi trường chroot, nơi ta dùng các công cụ mới để dựng toàn bộ phần công cụ còn lại cần cho hệ thống LFS.

Việc cô lập hệ thống mới khỏi bản phân phối host như vậy có vẻ hơi quá mức. Phần giải thích kỹ thuật đầy đủ về lý do nằm ở [Ghi chú kỹ thuật về toolchain](../partintro/toolchaintechnotes.md).

Ở [Chương 8](../chapter08/chapter08.md), hệ thống LFS hoàn chỉnh được dựng nên. Môi trường chroot còn có một lợi thế nữa: bạn vẫn dùng được máy host trong lúc LFS đang được dựng. Trong khi chờ các gói biên dịch xong, bạn cứ tiếp tục dùng máy như bình thường.

Để hoàn tất cài đặt, cấu hình cơ bản của hệ thống được thiết lập ở [Chương 9](../chapter09/chapter09.md), còn kernel (nhân) và bộ nạp khởi động (boot loader) được tạo ở [Chương 10](../chapter10/chapter10.md). [Chương 11](../chapter11/chapter11.md) có thông tin giúp bạn tiếp tục hành trình LFS sau cuốn sách này. Sau khi làm xong các bước trong chương đó, máy tính đã sẵn sàng khởi động vào hệ thống LFS mới.

Đó là quy trình tóm tắt. Thông tin chi tiết cho từng bước nằm ở các chương sau. Những điều giờ nghe có vẻ phức tạp sẽ dần sáng tỏ, và mọi thứ sẽ khớp vào nhau khi bạn bắt đầu cuộc phiêu lưu LFS của mình.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter01/how.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter01/how.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter01/how.html)
