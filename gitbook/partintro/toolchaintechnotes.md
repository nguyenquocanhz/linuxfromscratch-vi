---
description: "Mục này giải thích một số lý do và chi tiết kỹ thuật đằng sau phương pháp dựng tổng thể. Đừng cố hiểu hết mọi thứ ngay lập tức. Phần lớn thông tin sẽ sáng "
---

# ii. Ghi chú kỹ thuật về toolchain

Mục này giải thích một số lý do và chi tiết kỹ thuật đằng sau phương pháp dựng tổng thể. Đừng cố hiểu hết mọi thứ ngay lập tức. Phần lớn thông tin sẽ sáng tỏ hơn sau khi bạn thực sự dựng. Hãy quay lại đọc lại chương này bất cứ lúc nào trong quá trình dựng.

Mục tiêu tổng thể của [Chương 5](../chapter05/chapter05.md) và [Chương 6](../chapter06/chapter06.md) là tạo ra một vùng tạm chứa bộ công cụ đã được biết là tốt và tách biệt khỏi hệ thống chủ (host). Nhờ lệnh `chroot`, việc biên dịch ở các chương còn lại sẽ được cô lập trong môi trường đó, bảo đảm dựng sạch sẽ, không rắc rối hệ thống LFS đích. Quy trình dựng được thiết kế để giảm thiểu rủi ro cho người đọc mới và đồng thời mang lại giá trị học tập cao nhất.

Quy trình dựng này dựa trên *biên dịch chéo (cross-compilation)*. Biên dịch chéo thường được dùng để dựng một trình biên dịch và toolchain đi kèm cho một máy khác với máy dùng để dựng. Với LFS, điều này không thật sự bắt buộc, vì máy sẽ chạy hệ thống mới cũng chính là máy dùng để dựng. Nhưng biên dịch chéo có một ưu điểm lớn: bất cứ thứ gì được biên dịch chéo đều không thể phụ thuộc vào môi trường host.

## Về biên dịch chéo

{% hint style="info" %}
**Ghi chú**

Sách LFS không phải (và không chứa) một hướng dẫn tổng quát về dựng toolchain chéo (hay native). Đừng dùng các lệnh trong sách để dựng toolchain chéo cho mục đích nào khác ngoài dựng LFS, trừ khi bạn thật sự hiểu mình đang làm gì.

Người ta biết rằng cài GCC pass 2 sẽ làm hỏng toolchain chéo. Chúng tôi không coi đó là lỗi vì GCC pass 2 là gói cuối cùng được biên dịch chéo trong sách, và chúng tôi sẽ không “sửa” nó cho đến khi thật sự cần biên dịch chéo một gói nào đó sau GCC pass 2 trong tương lai.
{% endhint %}

Biên dịch chéo liên quan đến một số khái niệm đáng có một mục riêng. Dù có thể bỏ qua mục này khi đọc lần đầu, quay lại đọc sau sẽ giúp bạn hiểu quy trình đầy đủ hơn.

Trước hết hãy định nghĩa một số thuật ngữ dùng trong ngữ cảnh này.

**Máy build**

> là máy nơi chúng ta dựng các chương trình. Lưu ý máy này cũng còn được gọi là “host.”

**Máy host**

> là máy/hệ thống nơi các chương trình đã dựng sẽ chạy. Lưu ý cách dùng “host” này không giống với ở các mục khác.

**Máy target**

> chỉ dùng cho trình biên dịch. Đó là máy mà trình biên dịch sinh mã cho. Nó có thể khác với cả máy build lẫn máy host.

Làm ví dụ, hãy hình dung kịch bản sau (đôi khi gọi là “Canadian Cross”). Chúng ta chỉ có một trình biên dịch trên một máy chậm, gọi là máy A, và trình biên dịch là ccA. Chúng ta cũng có một máy nhanh (B), nhưng không có trình biên dịch cho (B), và muốn tạo mã cho một máy chậm thứ ba (C). Chúng ta sẽ dựng trình biên dịch cho máy C qua ba giai đoạn.

| Giai đoạn | Build | Host | Target | Hành động |
| --- | --- | --- | --- | --- |
| 1 | A | A | B | Dựng trình biên dịch chéo cc1 bằng ccA trên máy A. |
| 2 | A | B | C | Dựng trình biên dịch chéo cc2 bằng cc1 trên máy A. |
| 3 | B | C | C | Dựng trình biên dịch ccC bằng cc2 trên máy B. |

Sau đó, mọi chương trình máy C cần đều có thể được biên dịch bằng cc2 trên máy nhanh B. Lưu ý rằng trừ khi B chạy được các chương trình tạo ra cho C, sẽ không có cách nào kiểm thử các chương trình mới dựng cho đến khi chính máy C hoạt động. Chẳng hạn, để chạy bộ kiểm thử cho ccC, ta có thể muốn thêm giai đoạn thứ tư:

| Giai đoạn | Build | Host | Target | Hành động |
| --- | --- | --- | --- | --- |
| 4 | C | C | C | Dựng lại và kiểm thử ccC bằng ccC trên máy C. |

Trong ví dụ trên, chỉ cc1 và cc2 là trình biên dịch chéo, tức là chúng sinh mã cho một máy khác với máy chạy chúng. Các trình biên dịch còn lại ccA và ccC sinh mã cho chính máy chạy chúng. Những trình biên dịch như vậy gọi là trình biên dịch *native* (bản địa).

## Triển khai biên dịch chéo cho LFS

{% hint style="info" %}
**Ghi chú**

Mọi gói được biên dịch chéo trong sách đều dùng hệ thống dựng dựa trên autoconf. Hệ thống dựng autoconf chấp nhận kiểu hệ thống ở dạng cpu-vendor-kernel-os, gọi là system triplet. Vì trường vendor thường không quan trọng, autoconf cho phép bỏ qua nó.

Một độc giả tinh ý có thể thắc mắc vì sao “triplet” (bộ ba) lại chỉ một tên gồm bốn thành phần. Trường kernel và trường os ban đầu là một trường “system” duy nhất. Dạng ba trường như vậy ngày nay vẫn hợp lệ với một số hệ thống, ví dụ `x86_64-unknown-freebsd`. Nhưng hai hệ thống có thể dùng chung kernel mà vẫn khác nhau quá nhiều để dùng chung một triplet mô tả. Chẳng hạn, Android chạy trên điện thoại hoàn toàn khác Ubuntu chạy trên máy chủ ARM64, dù cả hai chạy trên cùng loại CPU (ARM64) và dùng cùng kernel (Linux).

Nếu không có lớp giả lập, bạn không thể chạy tệp thực thi của máy chủ trên điện thoại hoặc ngược lại. Vì vậy trường “system” được tách thành trường kernel và os để chỉ định các hệ thống này một cách rõ ràng. Trong ví dụ của chúng ta, hệ thống Android được ghi là `aarch64-unknown-linux-android`, còn hệ thống Ubuntu là `aarch64-unknown-linux-gnu`.

Từ “triplet” vẫn còn nằm lại trong từ vựng. Một cách đơn giản để xác định system triplet của bạn là chạy script `config.guess` đi kèm mã nguồn của nhiều gói. Hãy giải nén mã nguồn binutils, chạy script `./config.guess` và ghi lại kết quả. Ví dụ, với bộ xử lý Intel 32-bit, kết quả sẽ là *i686-pc-linux-gnu*. Trên hệ thống 64-bit là *x86\_64-pc-linux-gnu*. Trên hầu hết hệ thống Linux, lệnh còn đơn giản hơn `gcc -dumpmachine` cũng cho thông tin tương tự.

Bạn cũng nên biết tên của trình liên kết động (dynamic linker) của nền tảng, thường gọi là dynamic loader (đừng nhầm với trình liên kết chuẩn `ld` thuộc binutils). Trình liên kết động do gói glibc cung cấp tìm và nạp các thư viện chia sẻ mà chương trình cần, chuẩn bị chương trình để chạy rồi chạy nó. Tên trình liên kết động của máy Intel 32-bit là `ld-linux.so.2`; còn trên hệ thống 64-bit là `ld-linux-x86-64.so.2`. Cách chắc chắn để xác định tên trình liên kết động là kiểm tra một tệp nhị phân bất kỳ của hệ thống host bằng cách chạy: `readelf -l <name of binary> | grep interpreter` rồi ghi lại kết quả. Tài liệu tham chiếu chính thức bao quát mọi nền tảng nằm ở [một trang wiki của Glibc](https://sourceware.org/glibc/wiki/ABIList).
{% endhint %}

Có hai điểm mấu chốt khi biên dịch chéo:

* Khi tạo và xử lý mã máy dự định chạy trên “máy host,” bắt buộc phải dùng toolchain chéo. Lưu ý toolchain native của “máy build” vẫn có thể được gọi để sinh mã máy dự định chạy trên “máy build.” Ví dụ, hệ thống dựng có thể biên dịch một bộ sinh mã bằng toolchain native, rồi dùng bộ sinh đó tạo ra một tệp nguồn C, và cuối cùng biên dịch tệp nguồn C đó bằng toolchain chéo để mã sinh ra chạy được trên “máy host.”

  Với hệ thống dựng dựa trên autoconf, yêu cầu này được bảo đảm bằng cách dùng tùy chọn `--host` để chỉ định triplet của “máy host”. Với tùy chọn này, hệ thống dựng sẽ dùng các thành phần toolchain có tiền tố `<the host triplet>` để sinh và xử lý mã máy cho “máy host”; ví dụ trình biên dịch sẽ là `<the host triplet>-gcc` và công cụ `readelf` sẽ là `<the host triplet>-readelf`.
* Hệ thống dựng không được cố chạy bất kỳ mã máy nào sinh ra dự định chạy trên “máy host.” Ví dụ, khi dựng một tiện ích theo kiểu native, man page của nó có thể được sinh bằng cách chạy tiện ích với tùy chọn `--help` rồi xử lý đầu ra, nhưng nhìn chung không thể làm vậy khi biên dịch chéo vì tiện ích có thể không chạy được trên “máy build”: rõ ràng không thể chạy mã máy ARM64 trên CPU x86 (nếu không có trình giả lập).

  Với hệ thống dựng dựa trên autoconf, yêu cầu này được đáp ứng trong “chế độ biên dịch chéo”, khi các tính năng tùy chọn đòi hỏi chạy mã máy của “máy host” lúc dựng bị tắt. Khi triplet của “máy host” được chỉ định tường minh, “chế độ biên dịch chéo” được bật khi và chỉ khi script `configure` không chạy được một chương trình giả được biên dịch ra mã máy của “máy host”, hoặc triplet của “máy build” được chỉ định tường minh qua tùy chọn `--build` và khác với triplet của “máy host”.

Để biên dịch chéo một gói cho hệ thống tạm của LFS, tên system triplet được điều chỉnh đôi chút bằng cách đổi trường "vendor" trong biến `LFS_TGT` thành "lfs", rồi `LFS_TGT` được chỉ định làm triplet của “máy host” qua `--host`, để toolchain chéo được dùng nhằm sinh và xử lý mã máy chạy như một phần của hệ thống tạm LFS. Chúng ta cũng cần bật “chế độ biên dịch chéo”: dù mã máy của “máy host”, tức mã máy cho hệ thống tạm LFS, có thể chạy được trên CPU hiện tại, nó vẫn có thể tham chiếu đến thư viện không có trên “máy build” (bản phân phối host), hoặc một số mã hay dữ liệu không tồn tại hay được định nghĩa khác trong thư viện dù thư viện tình cờ có sẵn. Khi biên dịch chéo một gói cho hệ thống tạm LFS, ta không thể trông cậy vào script `configure` để phát hiện vấn đề này bằng chương trình giả: chương trình giả chỉ dùng vài thành phần trong `libc` mà `libc` của bản phân phối host nhiều khả năng đều có (trừ khi bản phân phối host dùng một bản triển khai `libc` khác như Musl), nên nó sẽ không thất bại như các chương trình thực sự hữu ích. Vì vậy ta phải chỉ định tường minh triplet của “máy build” để bật “chế độ biên dịch chéo.” Giá trị ta dùng chỉ là giá trị mặc định, tức system triplet gốc từ đầu ra của `config.guess`, nhưng “chế độ biên dịch chéo” phụ thuộc vào việc chỉ định tường minh như đã bàn.

Chúng ta dùng tùy chọn `--with-sysroot` khi dựng trình liên kết chéo và trình biên dịch chéo, để cho chúng biết nơi tìm các tệp cần thiết cho “máy host.” Điều này gần như bảo đảm không chương trình nào khác dựng trong [Chương 6](../chapter06/chapter06.md) có thể liên kết với thư viện trên “máy build.” Dùng chữ “gần như” vì `libtool`, một lớp bọc “tương thích” của trình biên dịch và trình liên kết cho các hệ thống dựng autoconf, có thể tỏ ra quá thông minh và truyền nhầm các tùy chọn cho phép trình liên kết tìm thư viện của “máy build.” Để ngăn hậu quả này, ta cần xóa các tệp lưu trữ libtool (`.la`) và sửa một bản libtool cũ đi kèm mã nguồn Binutils.

| Giai đoạn | Build | Host | Target | Hành động |
| --- | --- | --- | --- | --- |
| 1 | pc | pc | lfs | Dựng trình biên dịch chéo cc1 bằng cc-pc trên pc. |
| 2 | pc | lfs | lfs | Dựng trình biên dịch cc-lfs bằng cc1 trên pc. |
| 3 | lfs | lfs | lfs | Dựng lại (và có thể kiểm thử) cc-lfs bằng cc-lfs trên lfs. |

Trong bảng trên, “on pc” nghĩa là các lệnh được chạy trên máy dùng bản phân phối đã cài sẵn. “On lfs” nghĩa là các lệnh được chạy trong môi trường chroot.

Câu chuyện vẫn chưa kết thúc. Ngôn ngữ C không chỉ là một trình biên dịch; nó còn định nghĩa một thư viện chuẩn. Trong sách này dùng thư viện C của GNU, tên glibc (còn có lựa chọn khác là "musl"). Thư viện này phải được biên dịch cho máy LFS, tức là bằng trình biên dịch chéo cc1. Nhưng bản thân trình biên dịch lại dùng một thư viện nội bộ cung cấp các chương trình con phức tạp cho những hàm không có trong tập lệnh hợp ngữ. Thư viện nội bộ này tên libgcc, và nó phải được liên kết với thư viện glibc mới hoạt động đầy đủ. Hơn nữa, thư viện chuẩn của C++ (libstdc++) cũng phải được liên kết với glibc. Giải pháp cho bài toán con gà và quả trứng này là trước hết dựng một libgcc "suy giảm" dựa trên cc1, thiếu một số chức năng như đa luồng và xử lý ngoại lệ, rồi dựng glibc bằng trình biên dịch suy giảm này (bản thân glibc không bị suy giảm), và dựng cả libstdc++. Thư viện cuối này sẽ thiếu một số chức năng của libgcc.

Hệ quả của đoạn trên là cc1 không thể dựng libstdc++ đầy đủ chức năng với libgcc suy giảm, nhưng cc1 lại là trình biên dịch duy nhất có sẵn để dựng các thư viện C/C++ ở giai đoạn 2. Như đã bàn, chúng ta không thể chạy cc-lfs trên pc (bản phân phối host) vì nó có thể cần thư viện, mã hoặc dữ liệu không có trên “máy build” (bản phân phối host). Vì vậy khi dựng gcc giai đoạn 2, ta ghi đè đường dẫn tìm thư viện để liên kết libstdc++ với libgcc vừa dựng lại thay vì bản cũ bị suy giảm. Nhờ đó libstdc++ dựng lại hoạt động đầy đủ chức năng.

Trong [Chương 8](../chapter08/chapter08.md) (hay “giai đoạn 3”), mọi gói cần cho hệ thống LFS được dựng. Ngay cả khi một gói đã được cài vào hệ thống LFS ở chương trước, chúng ta vẫn dựng lại nó. Lý do chính là để làm cho chúng ổn định: nếu cài lại một gói LFS trên hệ thống LFS đã hoàn chỉnh, nội dung cài lại của gói phải giống nội dung của chính gói đó lúc cài lần đầu ở [Chương 8](../chapter08/chapter08.md). Các gói tạm cài ở [Chương 6](../chapter06/chapter06.md) hoặc [Chương 7](../chapter07/chapter07.md) không thỏa yêu cầu này, vì một số tính năng tùy chọn của chúng bị tắt do thiếu phụ thuộc hoặc do “chế độ biên dịch chéo.” Ngoài ra, một lý do nhỏ hơn để dựng lại các gói là để chạy bộ kiểm thử.

## Các chi tiết quy trình khác

Trình biên dịch chéo sẽ được cài trong thư mục riêng `$LFS/tools`, vì nó sẽ không là một phần của hệ thống cuối cùng.

Binutils được cài đầu tiên vì các lần chạy `configure` của cả gcc và glibc đều thực hiện nhiều phép thử tính năng trên trình hợp ngữ và trình liên kết để quyết định bật hay tắt tính năng phần mềm nào. Điều này quan trọng hơn ta tưởng lúc đầu. Một gcc hay glibc được cấu hình sai có thể cho ra toolchain hỏng ngầm, mà hậu quả có thể không lộ ra cho đến gần cuối quá trình dựng cả một bản phân phối. Lỗi ở bộ kiểm thử thường sẽ chỉ ra sự cố này trước khi bạn làm thêm quá nhiều việc.

Binutils cài trình hợp ngữ và trình liên kết của nó ở hai vị trí, `$LFS/tools/bin` và `$LFS/tools/$LFS_TGT/bin`. Các công cụ ở vị trí này là liên kết cứng (hard link) tới vị trí kia. Một khía cạnh quan trọng của trình liên kết là thứ tự tìm thư viện. Có thể lấy thông tin chi tiết từ `ld` bằng cách truyền cờ `--verbose`. Ví dụ, `$LFS_TGT-ld --verbose | grep SEARCH` sẽ cho thấy các đường dẫn tìm kiếm hiện tại và thứ tự của chúng. (Lưu ý ví dụ này chỉ chạy đúng như viết khi đã đăng nhập với người dùng `lfs`. Nếu sau này quay lại trang này, hãy thay `$LFS_TGT-ld` bằng `ld`).

Gói tiếp theo được cài là gcc. Ví dụ về những gì có thể thấy trong lúc chạy `configure` của nó:

```text
checking what assembler to use... /mnt/lfs/tools/i686-lfs-linux-gnu/bin/as
checking what linker to use... /mnt/lfs/tools/i686-lfs-linux-gnu/bin/ld
```

Điều này quan trọng vì các lý do đã nêu ở trên. Nó cũng cho thấy script configure của gcc không tìm trong các thư mục của PATH để biết dùng công cụ nào. Tuy nhiên, trong quá trình chạy thực tế của chính `gcc`, các đường dẫn tìm kiếm đó không nhất thiết được dùng. Để biết `gcc` sẽ dùng trình liên kết chuẩn nào, hãy chạy: `$LFS_TGT-gcc -print-prog-name=ld`. (Một lần nữa, hãy bỏ tiền tố `$LFS_TGT-` nếu quay lại sau này.)

Có thể lấy thông tin chi tiết từ `gcc` bằng cách truyền tùy chọn dòng lệnh `-v` khi biên dịch một chương trình. Ví dụ, `$LFS_TGT-gcc -v example.c` (hoặc không có `$LFS_TGT-` nếu quay lại sau) sẽ hiển thị thông tin chi tiết về các giai đoạn tiền xử lý, biên dịch và hợp ngữ, bao gồm các đường dẫn tìm tệp header của `gcc` và thứ tự của chúng.

Tiếp theo: các header API Linux đã được làm sạch. Chúng cho phép thư viện C chuẩn (glibc) giao tiếp với các tính năng mà kernel Linux sẽ cung cấp.

Tiếp đến là glibc. Đây là gói đầu tiên chúng ta biên dịch chéo. Chúng ta dùng tùy chọn `--host=$LFS_TGT` để hệ thống dựng dùng các công cụ có tiền tố `$LFS_TGT-`, và tùy chọn `--build=$(../scripts/config.guess)` để bật “chế độ biên dịch chéo” như đã bàn. Biến `DESTDIR` được dùng để buộc cài đặt vào hệ thống tệp LFS.

Như đã nói ở trên, thư viện C++ chuẩn được biên dịch tiếp theo, rồi đến [Chương 6](../chapter06/chapter06.md) với các chương trình khác cần biên dịch chéo để phá vỡ các phụ thuộc vòng lúc dựng. Các bước cho những gói đó tương tự các bước của glibc.

Cuối [Chương 6](../chapter06/chapter06.md), trình biên dịch LFS native được cài. Đầu tiên binutils-pass2 được dựng, trong cùng thư mục `DESTDIR` với các chương trình khác, sau đó đến lượt gcc lần thứ hai, bỏ qua một số thư viện không quan trọng.

Khi vào môi trường chroot ở [Chương 7](../chapter07/chapter07.md), các chương trình tạm cần cho toolchain hoạt động đúng được cài. Từ đây trở đi, toolchain lõi tự đủ và tự lưu trữ (self-hosted). Trong [Chương 8](../chapter08/chapter08.md), các phiên bản cuối cùng của mọi gói cần cho một hệ thống hoạt động đầy đủ được dựng, kiểm thử và cài đặt.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/partintro/toolchaintechnotes.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/partintro/toolchaintechnotes.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/partintro/toolchaintechnotes.html)
