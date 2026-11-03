---
description: "Mục tiêu của LFS là dựng một hệ thống nền tảng hoàn chỉnh và dùng được — gồm mọi gói cần thiết để tự tái tạo chính nó — đồng thời cung cấp một nền tảng tươ"
---

# vi. Lý do chọn các gói trong sách

Mục tiêu của LFS là dựng một hệ thống nền tảng hoàn chỉnh và dùng được — gồm mọi gói cần thiết để tự tái tạo chính nó — đồng thời cung cấp một nền tảng tương đối tối giản để bạn tùy biến thành hệ thống đầy đủ hơn theo lựa chọn của mình. Điều này không có nghĩa LFS là hệ thống nhỏ nhất có thể. Sách có kèm một số gói quan trọng mà nói chặt chẽ thì không bắt buộc. Danh sách dưới đây ghi lại lý do mỗi gói trong sách được đưa vào.

* Acl

  Gói này chứa các tiện ích quản trị Access Control List (danh sách kiểm soát truy cập), dùng để định nghĩa quyền truy cập tùy ý ở mức chi tiết cho tệp và thư mục.
* Attr

  Gói này chứa các chương trình quản lý thuộc tính mở rộng trên các đối tượng của hệ thống tệp.
* Autoconf

  Gói này cung cấp các chương trình tạo shell script có thể tự động cấu hình mã nguồn từ khuôn mẫu của nhà phát triển. Nó thường cần để dựng lại một gói sau khi quy trình dựng được cập nhật.
* Automake

  Gói này chứa các chương trình sinh Makefile từ một khuôn mẫu. Nó thường cần để dựng lại một gói sau khi quy trình dựng được cập nhật.
* Bash

  Gói này đáp ứng một yêu cầu cốt lõi của LSB là cung cấp giao diện Bourne Shell cho hệ thống. Bash được chọn thay vì các shell khác vì phổ biến và có khả năng phong phú.
* Bc

  Gói này cung cấp một ngôn ngữ xử lý số với độ chính xác tùy ý. Nó đáp ứng một yêu cầu để dựng kernel Linux.
* Binutils

  Gói này cung cấp trình liên kết (linker), trình hợp ngữ (assembler) và các công cụ khác để xử lý tệp đối tượng. Các chương trình trong gói này cần để biên dịch hầu hết các gói trong hệ thống LFS.
* Bison

  Gói này chứa phiên bản GNU của yacc (Yet Another Compiler Compiler), cần để dựng một số chương trình của LFS.
* Bzip2

  Gói này chứa các chương trình nén và giải nén tệp. Nó cần để giải nén nhiều gói của LFS.
* Check

  Gói này cung cấp khung kiểm thử (test harness) cho các chương trình khác.
* Coreutils

  Gói này chứa nhiều chương trình thiết yếu để xem và thao tác với tệp và thư mục. Các chương trình này cần cho việc quản lý tệp trên dòng lệnh và là điều kiện cho quy trình cài đặt của mọi gói trong LFS.
* DejaGNU

  Gói này cung cấp một framework để kiểm thử các chương trình khác.
* Diffutils

  Gói này chứa các chương trình hiển thị sự khác biệt giữa các tệp hoặc thư mục. Chúng có thể dùng để tạo bản vá và cũng được dùng trong quy trình dựng của nhiều gói.
* E2fsprogs

  Gói này cung cấp các tiện ích xử lý hệ thống tệp ext2, ext3 và ext4. Đây là những hệ thống tệp phổ biến nhất và được kiểm chứng kỹ nhất mà Linux hỗ trợ.
* Expat

  Gói này cho ra một thư viện phân tích cú pháp XML khá nhỏ. Nó cần cho module Perl XML::Parser.
* Expect

  Gói này chứa một chương trình để thực hiện các đoạn hội thoại theo kịch bản với các chương trình tương tác khác. Nó thường được dùng để kiểm thử các gói khác.
* File

  Gói này chứa một tiện ích xác định loại của một hoặc nhiều tệp. Một vài gói cần nó trong script dựng.
* Findutils

  Gói này cung cấp các chương trình tìm tệp trong hệ thống tệp. Nó được dùng trong script dựng của nhiều gói.
* Flex

  Gói này chứa một tiện ích sinh chương trình nhận dạng mẫu trong văn bản. Đây là phiên bản GNU của chương trình lex (lexical analyzer). Nó cần để dựng một số gói LFS.
* Gawk

  Gói này cung cấp các chương trình thao tác với tệp văn bản. Đây là phiên bản GNU của awk (Aho-Weinberg-Kernighan). Nó được dùng trong script dựng của nhiều gói khác.
* GCC

  Đây là Gnu Compiler Collection. Nó chứa các trình biên dịch C và C++ cùng một số trình biên dịch khác mà LFS không dựng.
* GDBM

  Gói này chứa thư viện GNU Database Manager. Một gói LFS khác dùng nó là Man-DB.
* Gettext

  Gói này cung cấp các tiện ích và thư viện để quốc tế hóa và địa phương hóa nhiều gói.
* Glibc

  Gói này chứa thư viện C chính. Các chương trình Linux không chạy được nếu thiếu nó.
* GMP

  Gói này cung cấp các thư viện toán học với các hàm hữu ích cho số học độ chính xác tùy ý. Nó cần để dựng GCC.
* Gperf

  Gói này tạo ra một chương trình sinh hàm băm hoàn hảo từ một tập khóa. Nó cần cho Udev .
* Grep

  Gói này chứa các chương trình tìm kiếm trong tệp. Các chương trình này được dùng bởi script dựng của hầu hết các gói.
* Groff

  Gói này cung cấp các chương trình xử lý và định dạng văn bản. Một chức năng quan trọng của chúng là định dạng man page.
* GRUB

  Đây là Grand Unified Boot Loader. Nó là trình nạp khởi động linh hoạt nhất trong số các trình nạp hiện có.
* Gzip

  Gói này chứa các chương trình nén và giải nén tệp. Nó cần để giải nén nhiều gói trong LFS.
* Iana-etc

  Gói này cung cấp dữ liệu về các dịch vụ và giao thức mạng. Nó cần để mạng hoạt động đúng cách.
* Inetutils

  Gói này cung cấp các chương trình quản trị mạng cơ bản.
* Intltool

  Gói này cung cấp các công cụ trích xuất chuỗi cần dịch từ tệp mã nguồn.
* IProute2

  Gói này chứa các chương trình cho mạng IPv4 và IPv6 cơ bản lẫn nâng cao. Nó được chọn thay cho gói công cụ mạng phổ biến khác (net-tools) nhờ hỗ trợ IPv6.
* Kbd

  Gói này tạo ra các tệp bảng phím, tiện ích bàn phím cho bàn phím không phải kiểu Mỹ và một số phông chữ console.
* Kmod

  Gói này cung cấp các chương trình cần để quản trị các module kernel Linux.
* Less

  Gói này chứa một trình xem tệp văn bản rất tiện, cho phép cuộn lên xuống khi xem tệp. Nhiều gói dùng nó để phân trang đầu ra.
* Libcap

  Gói này triển khai các giao diện không gian người dùng cho capability POSIX 1003.1e có trong kernel Linux.
* Libelf

  Dự án elfutils cung cấp các thư viện và công cụ cho tệp ELF và dữ liệu DWARF. Hầu hết tiện ích trong gói này có sẵn ở các gói khác, nhưng thư viện thì cần để dựng kernel Linux với cấu hình mặc định (và hiệu quả nhất).
* Libffi

  Gói này triển khai một giao diện lập trình cấp cao, di động cho nhiều quy ước gọi hàm (calling convention). Một số chương trình lúc biên dịch chưa biết các đối số sẽ được truyền cho hàm. Chẳng hạn, một trình thông dịch có thể chỉ biết số lượng và kiểu đối số khi chạy để gọi một hàm nhất định. Libffi có thể dùng trong các chương trình như vậy để làm cầu nối từ trình thông dịch tới mã đã biên dịch.
* Libpipeline

  Gói Libpipeline cung cấp một thư viện thao tác với các pipeline của tiến trình con một cách linh hoạt và thuận tiện. Nó cần cho gói Man-DB.
* Libtool

  Gói này chứa script hỗ trợ thư viện tổng quát của GNU. Nó gói gọn sự phức tạp khi dùng thư viện chia sẻ vào một giao diện nhất quán, di động. Nó cần cho các bộ kiểm thử của một số gói LFS khác.
* Libxcrypt

  Gói này cung cấp thư viện `libcrypt` mà nhiều gói (đáng chú ý là Shadow) cần để băm mật khẩu. Nó thay thế bản cài đặt `libcrypt` đã lỗi thời trong Glibc.
* Linux Kernel

  Gói này chính là Hệ điều hành. Nó là phần Linux trong môi trường GNU/Linux.
* M4

  Gói này cung cấp một bộ xử lý macro văn bản tổng quát, hữu ích như công cụ dựng cho các chương trình khác.
* Make

  Gói này chứa một chương trình điều phối việc dựng các gói. Gần như gói nào trong LFS cũng cần nó.
* Man-DB

  Gói này chứa các chương trình tìm và xem man page. Nó được chọn thay cho gói `man` vì khả năng quốc tế hóa vượt trội. Nó cung cấp chương trình man.
* Man-pages

  Gói này cung cấp nội dung thực tế của các man page Linux cơ bản.
* Meson

  Gói này cung cấp công cụ phần mềm tự động hóa việc dựng phần mềm. Mục tiêu chính của Meson là giảm thiểu thời gian nhà phát triển phải dành để cấu hình hệ thống dựng. Nó cần để dựng Systemd cũng như nhiều gói BLFS.
* MPC

  Gói này cung cấp các hàm số học cho số phức. Nó cần cho GCC.
* MPFR

  Gói này chứa các hàm số học độ chính xác nhiều bậc. Nó cần cho GCC.
* Ninja

  Gói này cung cấp một hệ thống dựng nhỏ, chú trọng tốc độ. Nó được thiết kế để tệp đầu vào do một hệ thống dựng cấp cao hơn sinh ra, và chạy bản dựng nhanh nhất có thể. Gói này cần cho Meson.
* Ncurses

  Gói này chứa các thư viện xử lý màn hình ký tự không phụ thuộc loại terminal. Nó thường được dùng để điều khiển con trỏ cho hệ thống menu. Nhiều gói trong LFS cần nó.
* Openssl

  Gói này cung cấp các công cụ quản lý và thư viện liên quan đến mật mã học. Chúng cung cấp các hàm mật mã cho các gói khác, kể cả kernel Linux.
* Patch

  Gói này chứa một chương trình sửa đổi hoặc tạo tệp bằng cách áp dụng một tệp *patch* (bản vá) thường do chương trình `diff` tạo ra. Nó cần cho quy trình dựng của một số gói LFS.
* Perl

  Gói này là trình thông dịch cho ngôn ngữ chạy PERL. Nó cần để cài đặt và chạy bộ kiểm thử của một số gói LFS.
* Pkgconf

  Gói này chứa một chương trình giúp cấu hình cờ trình biên dịch và trình liên kết cho các thư viện phát triển. Chương trình có thể thay thế trực tiếp `pkg-config`, vốn cần cho hệ thống dựng của nhiều gói. Nó được bảo trì tích cực hơn và nhanh hơn một chút so với gói Pkg-config gốc.
* Procps-NG

  Gói này chứa các chương trình giám sát tiến trình. Chúng hữu ích cho quản trị hệ thống và cũng được LFS Bootscripts sử dụng.
* Psmisc

  Gói này tạo ra các chương trình hiển thị thông tin về các tiến trình đang chạy. Chúng hữu ích cho quản trị hệ thống.
* Python 3

  Gói này cung cấp một ngôn ngữ thông dịch với triết lý thiết kế đề cao khả năng đọc hiểu mã.
* Readline

  Gói này là tập hợp các thư viện cung cấp khả năng chỉnh sửa dòng lệnh và lịch sử lệnh. Bash sử dụng nó.
* Sed

  Gói này cho phép chỉnh sửa văn bản mà không cần mở trong trình soạn thảo. Nó cũng cần cho các script configure của nhiều gói LFS.
* Shadow

  Gói này chứa các chương trình xử lý mật khẩu một cách an toàn.
* Sysklogd

  Gói này cung cấp các chương trình ghi nhật ký thông điệp hệ thống, chẳng hạn những thông điệp do kernel hoặc tiến trình daemon phát ra khi có sự kiện bất thường.
* SysVinit

  Gói này cung cấp chương trình `init`, tiến trình cha của mọi tiến trình khác trên một hệ thống Linux đang chạy.
* Udev

  Gói này là trình quản lý thiết bị. Nó điều khiển động quyền sở hữu, quyền truy cập, tên và liên kết mềm của các nút thiết bị trong thư mục /dev khi thiết bị được thêm vào hoặc gỡ khỏi hệ thống.
* Tar

  Gói này cung cấp khả năng lưu trữ (archive) và giải nén cho hầu như mọi gói dùng trong LFS.
* Tcl

  Gói này chứa Tool Command Language, được dùng trong nhiều bộ kiểm thử.
* Texinfo

  Gói này cung cấp các chương trình đọc, viết và chuyển đổi trang info. Nó được dùng trong quy trình cài đặt của nhiều gói LFS.
* Util-linux

  Gói này chứa nhiều chương trình tiện ích khác nhau. Trong đó có các tiện ích xử lý hệ thống tệp, console, phân vùng và thông điệp.
* Vim

  Gói này cung cấp một trình soạn thảo. Nó được chọn nhờ tương thích với trình soạn thảo vi cổ điển và có rất nhiều tính năng mạnh. Trình soạn thảo là lựa chọn rất cá nhân của nhiều người dùng. Bạn có thể thay bằng trình soạn thảo khác nếu muốn.
* Wheel

  Gói này cung cấp một module Python là bản triển khai tham chiếu của chuẩn đóng gói wheel trong Python.
* XML::Parser

  Gói này là một module Perl giao tiếp với Expat.
* XZ Utils

  Gói này chứa các chương trình nén và giải nén tệp. Nó cho tỷ lệ nén cao nhất hiện có và hữu ích để giải nén các gói định dạng XZ hoặc LZMA.
* Zlib

  Gói này chứa các hàm nén và giải nén được một số chương trình sử dụng.
* Zstd

  Gói này cung cấp các hàm nén và giải nén được một số chương trình sử dụng. Nó cho tỷ lệ nén cao và dải đánh đổi giữa nén / tốc độ rất rộng.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/prologue/package-choices.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/prologue/package-choices.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/prologue/package-choices.html)
