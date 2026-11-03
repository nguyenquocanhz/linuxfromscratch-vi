---
description: "Nếu bạn gặp sự cố khi dựng một gói theo hướng dẫn của LFS, chúng tôi khuyên bạn đừng đăng thẳng vấn đề lên kênh hỗ trợ của dự án upstream (thượng nguồn) tr"
---

# 1.5. Trợ giúp

{% hint style="info" %}
**Ghi chú**

Nếu bạn gặp sự cố khi dựng một gói theo hướng dẫn của LFS, chúng tôi khuyên bạn đừng đăng thẳng vấn đề lên kênh hỗ trợ của dự án upstream (thượng nguồn) trước khi trao đổi qua một kênh hỗ trợ của LFS được liệt kê trong [Mục 1.4, “Tài nguyên.”](resources.md) Làm vậy thường kém hiệu quả vì những người bảo trì upstream hiếm khi quen với quy trình dựng của LFS. Ngay cả khi bạn thực sự gặp lỗi của upstream, cộng đồng LFS vẫn có thể giúp bạn tách ra thông tin mà người bảo trì upstream cần và viết báo cáo đúng cách.

Nếu buộc phải hỏi trực tiếp qua kênh hỗ trợ của upstream, ít nhất bạn nên biết rằng nhiều dự án upstream tách riêng kênh hỗ trợ khỏi bug tracker. Những báo cáo “bug” chỉ để đặt câu hỏi bị coi là không hợp lệ và có thể làm phiền các nhà phát triển của những dự án đó.
{% endhint %}

Nếu gặp vấn đề hay thắc mắc khi làm theo sách, hãy xem trang FAQ tại [https://www.linuxfromscratch.org/faq/\#generalfaq](https://www.linuxfromscratch.org/faq/#generalfaq). Câu hỏi của bạn thường đã được trả lời ở đó. Nếu trang đó không có, hãy thử tìm nguyên nhân của vấn đề. Tài liệu hint sau sẽ hướng dẫn bạn cách khắc phục sự cố: [https://www.linuxfromscratch.org/hints/downloads/files/errors.txt](https://www.linuxfromscratch.org/hints/downloads/files/errors.txt).

Nếu không thấy vấn đề của mình trong FAQ, hãy tìm trong các danh sách thư tại [https://www.linuxfromscratch.org/search.html](https://www.linuxfromscratch.org/search.html).

Chúng tôi cũng có một cộng đồng LFS tuyệt vời sẵn lòng giúp đỡ qua danh sách thư và IRC (xem mục [Mục 1.4, “Tài nguyên”](resources.md) của sách này). Tuy nhiên, mỗi ngày chúng tôi nhận được rất nhiều câu hỏi, và nhiều câu trong số đó có thể được giải đáp dễ dàng nếu xem FAQ hoặc tìm trong danh sách thư trước. Vì vậy, để chúng tôi hỗ trợ bạn tốt nhất, hãy tự tìm hiểu trước. Như vậy chúng tôi có thể tập trung vào những trường hợp khác thường hơn. Nếu tìm kiếm không ra giải pháp, hãy kèm theo mọi thông tin liên quan (nêu bên dưới) khi nhờ giúp đỡ.

## 1.5.1. Những điều cần nêu

Ngoài lời giải thích ngắn gọn về vấn đề đang gặp, mọi yêu cầu trợ giúp nên có các thông tin thiết yếu sau:

* Phiên bản sách đang dùng (ở đây là 12.4)
* Bản phân phối host và phiên bản dùng để tạo LFS
* Kết quả đầu ra của script trong [Yêu cầu đối với hệ thống host](../chapter02/hostreqs.md#version-check)
* Gói hoặc mục nơi bạn gặp vấn đề
* Thông báo lỗi chính xác, hoặc mô tả rõ ràng về vấn đề
* Cho biết bạn có làm khác sách ở chỗ nào không

{% hint style="info" %}
**Ghi chú**

Làm khác sách *không* có nghĩa là chúng tôi sẽ không giúp bạn. Suy cho cùng, LFS là sự lựa chọn của mỗi người. Nói thẳng về những thay đổi so với quy trình chuẩn giúp chúng tôi đánh giá và tìm ra nguyên nhân có thể của vấn đề.
{% endhint %}

## 1.5.2. Sự cố với script configure

Nếu có gì trục trặc khi chạy script `configure`, hãy xem tệp `config.log`. Tệp này có thể chứa các lỗi xảy ra trong lúc `configure` mà không được in ra màn hình. Khi nhờ giúp đỡ, hãy kèm theo các dòng *liên quan*.

## 1.5.3. Sự cố khi biên dịch

Cả kết quả hiển thị trên màn hình lẫn nội dung của nhiều tệp khác nhau đều hữu ích để xác định nguyên nhân lỗi biên dịch. Kết quả của script `configure` và của lần chạy `make` có thể giúp ích. Bạn không cần đưa toàn bộ kết quả, nhưng hãy đưa đủ mọi thông tin liên quan. Dưới đây là ví dụ về loại thông tin nên lấy từ kết quả `make` trên màn hình.

```text
gcc -D ALIASPATH=\"/mnt/lfs/usr/share/locale:.\"
-D LOCALEDIR=\"/mnt/lfs/usr/share/locale\"
-D LIBDIR=\"/mnt/lfs/usr/lib\"
-D INCLUDEDIR=\"/mnt/lfs/usr/include\" -D HAVE_CONFIG_H -I. -I.
-g -O2 -c getopt1.c
gcc -g -O2 -static -o make ar.o arscan.o commands.o dir.o
expand.o file.o function.o getopt.o implicit.o job.o main.o
misc.o read.o remake.o rule.o signame.o variable.o vpath.o
default.o remote-stub.o version.o opt1.o
-lutil job.o: In function `load_too_high':
/lfs/tmp/make-3.79.1/job.c:1565: undefined reference
to `getloadavg'
collect2: ld returned 1 exit status
make[2]: *** [make] Error 1
make[2]: Leaving directory `/lfs/tmp/make-3.79.1'
make[1]: *** [all-recursive] Error 1
make[1]: Leaving directory `/lfs/tmp/make-3.79.1'
make: *** [all-recursive-am] Error 2
```

Trong trường hợp này, nhiều người chỉ đưa phần cuối:

```text
make [2]: *** [make] Error 1
```

Như vậy chưa đủ thông tin để chẩn đoán, vì nó chỉ cho biết có gì đó hỏng, chứ không cho biết *cái gì* hỏng. Bạn nên lưu cả đoạn như ví dụ ở trên, vì nó gồm lệnh đã chạy và tất cả thông báo lỗi liên quan.

Có một bài viết rất hay về cách đặt câu hỏi trên Internet tại [http://catb.org/~esr/faqs/smart-questions.html](http://catb.org/~esr/faqs/smart-questions.html). Hãy đọc tài liệu này và làm theo các gợi ý. Làm vậy sẽ tăng khả năng bạn nhận được sự giúp đỡ cần thiết.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter01/askforhelp.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter01/askforhelp.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter01/askforhelp.html)
