---
description: "Quản lý gói là phần bổ sung được yêu cầu nhiều nhất cho sách LFS. Một trình quản lý gói theo dõi việc cài đặt các tệp, giúp gỡ bỏ và nâng cấp gói dễ hơn. M"
---

<details>

<summary>Trick lỏ: Biết gói vừa cài những file gì bằng mẹo &quot;dấu thời gian&quot;</summary>

LFS không có trình quản lý gói. Cách đơn giản nhất để biết `make install` rải file đi đâu:

```bash
touch /tmp/truoc-cai
make install
find / -xdev -newer /tmp/truoc-cai -not -path '/proc/*' -not -path '/sys/*' \
     -not -path '/sources/*' -type f > /var/log/pkg-tengoi.list
```

Sau này muốn gỡ gói thì xem file `.list` đó. Nhược điểm: không chính xác nếu có tiến trình khác ghi file cùng lúc. Muốn bài bản hơn, đọc mục "DESTDIR" trong chính trang này.

[Tất cả trick lỏ →](../trick-lo.md#theo-doi-file-cai)

</details>

# 8.2. Quản lý gói

Quản lý gói là phần bổ sung được yêu cầu nhiều nhất cho sách LFS. Một trình quản lý gói theo dõi việc cài đặt các tệp, giúp gỡ bỏ và nâng cấp gói dễ hơn. Một trình quản lý gói tốt cũng xử lý riêng các tệp cấu hình để giữ lại cấu hình của người dùng khi gói được cài lại hoặc nâng cấp. Trước khi bạn thắc mắc: KHÔNG, mục này sẽ không bàn về hay giới thiệu một trình quản lý gói cụ thể nào. Điều nó cung cấp là tổng hợp các kỹ thuật phổ biến hơn và cách chúng hoạt động. Trình quản lý gói hoàn hảo cho bạn có thể nằm trong số các kỹ thuật này, hoặc là sự kết hợp của hai hay nhiều kỹ thuật. Mục này cũng nêu ngắn gọn các vấn đề có thể phát sinh khi nâng cấp gói.

Một số lý do vì sao LFS và BLFS không đề cập trình quản lý gói nào:

* Xử lý việc quản lý gói làm lệch trọng tâm khỏi mục tiêu của những cuốn sách này, vốn là dạy cách xây dựng một hệ thống Linux.
* Có nhiều giải pháp quản lý gói, mỗi giải pháp có điểm mạnh và điểm yếu riêng. Rất khó tìm một giải pháp làm hài lòng mọi đối tượng.

Đã có một số hint (gợi ý) viết về chủ đề quản lý gói. Hãy ghé [Hints Project](https://www.linuxfromscratch.org/hints/downloads/files/) xem có cái nào hợp với nhu cầu của bạn không.

## 8.2.1. Các vấn đề khi nâng cấp

Trình quản lý gói giúp nâng cấp lên phiên bản mới dễ dàng khi chúng được phát hành. Nhìn chung có thể dùng hướng dẫn trong sách LFS và BLFS để nâng cấp lên phiên bản mới. Dưới đây là những điểm bạn nên biết khi nâng cấp gói, đặc biệt trên một hệ thống đang chạy.

* Nếu cần nâng cấp kernel Linux (ví dụ từ 5.10.17 lên 5.10.18 hoặc 5.11.1), không cần dựng lại gì khác. Hệ thống vẫn chạy bình thường nhờ giao diện được định nghĩa rõ ràng giữa kernel và userspace. Cụ thể, header Linux API không cần nâng cấp cùng kernel. Bạn chỉ cần khởi động lại hệ thống để dùng kernel mới.
* Nếu cần nâng cấp Glibc lên phiên bản mới hơn (ví dụ từ Glibc-2.36 lên Glibc-2.42), cần thêm một số bước để tránh làm hỏng hệ thống. Đọc [Mục 8.5, “Glibc-2.42”](glibc.md) để biết chi tiết.
* Nếu một gói chứa thư viện chia sẻ được cập nhật, và tên của thư viện[\[1\]](#ftn.idm140163727796912) thay đổi, thì mọi gói liên kết động với thư viện đó phải được biên dịch lại để liên kết với thư viện mới. Ví dụ, xét gói foo-1.2.3 cài một thư viện chia sẻ tên `libfoo.so.1`. Giả sử bạn nâng cấp gói lên phiên bản foo-1.2.4 cài thư viện chia sẻ tên `libfoo.so.2`. Khi đó, mọi gói liên kết động với `libfoo.so.1` cần được biên dịch lại để liên kết với `libfoo.so.2` thì mới dùng được phiên bản thư viện mới. Bạn không nên xóa các thư viện cũ cho đến khi mọi gói phụ thuộc đã được biên dịch lại.
* Nếu một gói (trực tiếp hoặc gián tiếp) liên kết với cả tên cũ lẫn tên mới của một thư viện chia sẻ (ví dụ gói liên kết với cả `libfoo.so.2` và `libbar.so.1`, trong khi thư viện sau lại liên kết với `libfoo.so.3`), gói đó có thể hoạt động sai vì các bản sửa đổi khác nhau của thư viện chia sẻ đưa ra các định nghĩa không tương thích cho một số tên symbol. Nguyên nhân có thể là sau khi gói cung cấp thư viện chia sẻ được nâng cấp, một số (chứ không phải tất cả) gói liên kết với thư viện cũ được biên dịch lại. Để tránh vấn đề này, người dùng cần dựng lại mọi gói liên kết với thư viện chia sẻ có bản sửa đổi mới (ví dụ libfoo.so.2 lên libfoo.so.3) càng sớm càng tốt.
* Nếu một gói chứa thư viện chia sẻ được cập nhật, tên thư viện không đổi, nhưng số phiên bản của **tệp** thư viện giảm xuống (ví dụ thư viện vẫn tên `libfoo.so.1`, nhưng tên tệp thư viện đổi từ `libfoo.so.1.25` thành `libfoo.so.1.24`), bạn nên xóa tệp thư viện của phiên bản đã cài trước đó (trong trường hợp này là `libfoo.so.1.25`). Nếu không, lệnh `ldconfig` (do bạn tự chạy từ dòng lệnh, hoặc do việc cài một gói nào đó gọi) sẽ đặt lại liên kết mềm `libfoo.so.1` trỏ về tệp thư viện cũ vì nó có vẻ là phiên bản “mới hơn”; số phiên bản của nó lớn hơn. Tình huống này có thể xảy ra nếu bạn phải hạ cấp một gói, hoặc nếu tác giả đổi cách đánh số phiên bản cho tệp thư viện.
* Nếu một gói chứa thư viện chia sẻ được cập nhật, tên thư viện không đổi, nhưng một vấn đề nghiêm trọng (đặc biệt là lỗ hổng bảo mật) đã được sửa, mọi chương trình đang chạy liên kết với thư viện chia sẻ đó nên được khởi động lại. Lệnh sau, chạy bằng `root` sau khi cập nhật xong, sẽ liệt kê các tiến trình đang dùng phiên bản cũ của những thư viện đó (thay `libfoo` bằng tên thư viện):

  ```bash
  grep -l 'libfoo.*deleted' /proc/*/maps | tr -cd 0-9\\n | xargs -r ps u
  ```

  Nếu bạn đang dùng `OpenSSH` để truy cập hệ thống và nó liên kết với thư viện vừa được cập nhật, bạn phải khởi động lại dịch vụ `sshd`, sau đó đăng xuất, đăng nhập lại và chạy lại lệnh trên để xác nhận không còn gì dùng các thư viện đã bị xóa.
* Nếu một chương trình thực thi hoặc thư viện chia sẻ bị ghi đè, các tiến trình đang dùng mã hoặc dữ liệu của chương trình hay thư viện đó có thể bị sập. Cách đúng để cập nhật chương trình hoặc thư viện chia sẻ mà không làm sập tiến trình là xóa nó trước, rồi mới cài phiên bản mới. Lệnh `install` do `coreutils` cung cấp đã làm sẵn việc này, và hầu hết các gói dùng lệnh đó để cài tệp nhị phân và thư viện. Nghĩa là phần lớn thời gian bạn sẽ không gặp vấn đề này. Tuy nhiên, quá trình cài đặt của một số gói (đáng chú ý là SpiderMonkey trong BLFS) chỉ ghi đè tệp nếu nó tồn tại; điều này gây sập. Vì vậy an toàn hơn là lưu công việc và đóng các tiến trình đang chạy không cần thiết trước khi cập nhật một gói.

## 8.2.2. Các kỹ thuật quản lý gói

Sau đây là một số kỹ thuật quản lý gói phổ biến. Trước khi chọn trình quản lý gói, hãy tìm hiểu các kỹ thuật khác nhau, nhất là nhược điểm của từng cách.

### 8.2.2.1. Tất cả nằm trong đầu tôi!

Vâng, đây cũng là một kỹ thuật quản lý gói. Một số người không cần trình quản lý gói vì họ hiểu rõ các gói và biết mỗi gói cài những tệp nào. Một số người dùng cũng không cần quản lý gói vì họ định dựng lại toàn bộ hệ thống mỗi khi có gói thay đổi.

### 8.2.2.2. Cài vào các thư mục riêng

Đây là kỹ thuật quản lý gói đơn giản, không cần chương trình đặc biệt để quản lý. Mỗi gói được cài vào một thư mục riêng. Ví dụ, gói foo-1.1 được cài vào `/opt/foo-1.1` và tạo một liên kết mềm từ `/opt/foo` đến `/opt/foo-1.1`. Khi có phiên bản mới foo-1.2, nó được cài vào `/opt/foo-1.2` và liên kết mềm cũ được thay bằng liên kết tới phiên bản mới.

Các biến môi trường như `PATH`, `MANPATH`, `INFOPATH`, `PKG_CONFIG_PATH`, `CPPFLAGS`, `LDFLAGS` và tệp cấu hình `/etc/ld.so.conf` có thể cần được mở rộng để bao gồm các thư mục con tương ứng trong `/opt/foo-x.y`.

Sách BLFS dùng cách này để cài một số gói rất lớn nhằm nâng cấp chúng dễ hơn. Nếu bạn cài nhiều hơn vài gói, cách này sẽ trở nên khó quản lý. Và một số gói (ví dụ header Linux API và Glibc) có thể không hoạt động tốt với cách này. **Đừng bao giờ dùng cách này cho toàn hệ thống.**

### 8.2.2.3. Quản lý gói kiểu liên kết mềm

Đây là biến thể của kỹ thuật quản lý gói trước. Mỗi gói được cài như ở cách trước. Nhưng thay vì tạo liên kết mềm qua tên gói chung, từng tệp được tạo liên kết mềm vào cây thư mục `/usr`. Cách này loại bỏ nhu cầu mở rộng các biến môi trường. Dù người dùng có thể tự tạo các liên kết mềm, nhiều trình quản lý gói dùng cách này và tự động hóa việc tạo chúng. Một vài trình phổ biến gồm Stow, Epkg, Graft và Depot.

Script cài đặt cần bị đánh lừa, để gói tưởng rằng nó được cài vào `/usr` trong khi thực tế được cài vào cây `/usr/pkg`. Cài theo cách này thường không đơn giản. Ví dụ, giả sử bạn đang cài gói libfoo-1.1. Các hướng dẫn sau có thể không cài gói đúng cách:

```bash
./configure --prefix=/usr/pkg/libfoo/1.1
make
make install
```

Việc cài đặt sẽ chạy được, nhưng các gói phụ thuộc có thể không liên kết với libfoo như bạn mong đợi. Nếu bạn biên dịch một gói liên kết với libfoo, có thể bạn sẽ thấy nó liên kết tới `/usr/pkg/libfoo/1.1/lib/libfoo.so.1` thay vì `/usr/lib/libfoo.so.1` như mong đợi. Cách đúng là dùng biến `DESTDIR` để chỉ hướng việc cài đặt. Cách này hoạt động như sau:

```bash
./configure --prefix=/usr
make
make DESTDIR=/usr/pkg/libfoo/1.1 install
```

Hầu hết các gói hỗ trợ cách này, nhưng cũng có gói không. Với các gói không tuân thủ, bạn có thể phải cài gói thủ công, hoặc thấy rằng cài một số gói gây rắc rối vào `/opt` sẽ dễ hơn.

### 8.2.2.4. Dựa trên dấu thời gian

Trong kỹ thuật này, một tệp được đánh dấu thời gian trước khi cài gói. Sau khi cài, chỉ cần dùng lệnh `find` với các tùy chọn phù hợp là có thể tạo nhật ký mọi tệp được cài sau khi tệp dấu thời gian được tạo. Một trình quản lý gói dùng cách này là install-log.

Dù cách này có ưu điểm đơn giản, nó có hai nhược điểm. Nếu trong lúc cài đặt, các tệp được cài với dấu thời gian khác thời điểm hiện tại, các tệp đó sẽ không được trình quản lý gói theo dõi. Ngoài ra, cách này chỉ dùng được khi các gói được cài lần lượt từng cái. Nhật ký không đáng tin nếu hai gói được cài đồng thời từ hai console khác nhau.

### 8.2.2.5. Theo dõi các script cài đặt

Với cách này, các lệnh mà script cài đặt thực hiện được ghi lại. Có hai kỹ thuật có thể dùng:

Biến môi trường `LD_PRELOAD` có thể được đặt để trỏ tới một thư viện được nạp trước khi cài đặt. Trong lúc cài đặt, thư viện này theo dõi các gói đang được cài bằng cách gắn vào các tệp thực thi khác nhau như `cp`, `install`, `mv` và theo dõi các lời gọi hệ thống làm thay đổi hệ thống tệp. Để cách này hoạt động, mọi tệp thực thi cần được liên kết động và không có bit suid hay sgid. Việc nạp trước thư viện có thể gây một số tác dụng phụ không mong muốn khi cài đặt. Vì vậy, nên chạy vài bài kiểm tra để đảm bảo trình quản lý gói không làm hỏng gì và ghi nhật ký đầy đủ các tệp cần thiết.

Một kỹ thuật khác là dùng `strace`, công cụ ghi nhật ký mọi lời gọi hệ thống trong quá trình chạy các script cài đặt.

### 8.2.2.6. Tạo kho lưu trữ gói

Với cách này, việc cài đặt gói được giả lập vào một cây riêng như đã mô tả ở phần quản lý gói kiểu liên kết mềm. Sau khi cài, một kho lưu trữ gói được tạo từ các tệp đã cài. Kho lưu trữ này sau đó được dùng để cài gói trên máy cục bộ, thậm chí trên các máy khác.

Cách này được hầu hết các trình quản lý gói trong các bản phân phối thương mại sử dụng. Ví dụ về các trình quản lý gói theo cách này gồm RPM (tiện thể, RPM là thứ bắt buộc theo [Linux Standard Base Specification](https://refspecs.linuxfoundation.org/lsb.shtml)), pkg-utils, apt của Debian và hệ thống Portage của Gentoo. Có một hint mô tả cách áp dụng kiểu quản lý gói này cho hệ thống LFS tại [https://www.linuxfromscratch.org/hints/downloads/files/fakeroot.txt](https://www.linuxfromscratch.org/hints/downloads/files/fakeroot.txt).

Việc tạo các tệp gói có kèm thông tin phụ thuộc khá phức tạp và nằm ngoài phạm vi của LFS.

Slackware dùng hệ thống dựa trên `tar` cho các kho lưu trữ gói. Hệ thống này cố ý không xử lý phụ thuộc gói như các trình quản lý gói phức tạp hơn. Để biết chi tiết về quản lý gói của Slackware, xem [https://www.slackbook.org/html/package-management.html](https://www.slackbook.org/html/package-management.html).

### 8.2.2.7. Quản lý dựa trên người dùng

Cách này chỉ có ở LFS, do Matthias Benkmann nghĩ ra, và có trong [Hints Project](https://www.linuxfromscratch.org/hints/downloads/files/). Theo cách này, mỗi gói được cài bởi một người dùng riêng vào các vị trí chuẩn. Các tệp thuộc về một gói dễ nhận ra bằng cách kiểm tra ID người dùng. Các tính năng và hạn chế của cách này quá phức tạp để mô tả trong mục này. Để biết chi tiết, xem hint tại [https://www.linuxfromscratch.org/hints/downloads/files/more\_control\_and\_pkg\_man.txt](https://www.linuxfromscratch.org/hints/downloads/files/more_control_and_pkg_man.txt).

## 8.2.3. Triển khai LFS trên nhiều hệ thống

Một trong những ưu điểm của hệ thống LFS là không có tệp nào phụ thuộc vào vị trí của tệp trên hệ thống đĩa. Nhân bản bản dựng LFS sang máy khác có cùng kiến trúc với hệ thống gốc đơn giản như dùng `tar` trên phân vùng LFS chứa thư mục gốc (khoảng 900MB khi chưa nén với một bản LFS cơ bản), chép tệp đó qua mạng hoặc bằng CD-ROM / USB sang hệ thống mới rồi giải nén. Sau đó cần đổi một số tệp cấu hình. Các tệp cấu hình có thể cần cập nhật gồm: `/etc/hosts`, `/etc/fstab`, `/etc/passwd`, `/etc/group`, `/etc/shadow`, `/etc/ld.so.conf`, `/etc/sysconfig/rc.site`, `/etc/sysconfig/network` và `/etc/sysconfig/ifconfig.eth0`.

Hệ thống mới có thể cần một kernel tùy biến, tùy vào khác biệt về phần cứng và cấu hình kernel ban đầu.

{% hint style="warning" %}
**Quan trọng**

Nếu bạn muốn triển khai hệ thống LFS lên máy có CPU khác, khi dựng [Mục 8.21, “GMP-6.3.0”](gmp.md) và [Mục 8.50, “Libffi-3.5.2”](libffi.md) bạn phải làm theo các ghi chú về việc ghi đè tối ưu hóa theo kiến trúc cụ thể, để tạo ra các thư viện phù hợp với cả hệ thống host lẫn (các) hệ thống nơi bạn sẽ triển khai LFS. Nếu không, bạn sẽ gặp lỗi `Illegal Instruction` khi chạy LFS.
{% endhint %}

Cuối cùng, hệ thống mới phải được làm cho có thể khởi động qua [Mục 10.4, “Using GRUB to Set Up the Boot Process”](../chapter10/grub.md).

[\[1\]](#idm140163727796912) Tên của thư viện chia sẻ là chuỗi được mã hóa trong mục `DT_SONAME` của phần dynamic section ELF. Bạn có thể lấy nó bằng lệnh `readelf -d <library file> | grep SONAME`. Trong hầu hết trường hợp nó có hậu tố `.so.<a version number>`, nhưng có những trường hợp chứa nhiều số phiên bản (như `libbz2.so.1.0`), chứa số phiên bản trước hậu tố `.so` (như `libbfd-2.45`), hoặc không chứa số phiên bản nào (ví dụ `libmemusage.so`). Nhìn chung không có mối liên hệ giữa phiên bản gói và (các) số phiên bản trong tên thư viện.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/pkgmgt.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/pkgmgt.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/pkgmgt.html)
