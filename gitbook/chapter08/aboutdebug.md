---
description: "Hầu hết chương trình và thư viện, theo mặc định, được biên dịch kèm ký hiệu gỡ lỗi (debugging symbol), qua tùy chọn -g của gcc. Nghĩa là khi gỡ lỗi một chư"
---

# 8.83. Về các ký hiệu gỡ lỗi

Hầu hết chương trình và thư viện, theo mặc định, được biên dịch kèm ký hiệu gỡ lỗi (debugging symbol), qua tùy chọn `-g` của `gcc`. Nghĩa là khi gỡ lỗi một chương trình hay thư viện được biên dịch cùng thông tin gỡ lỗi, trình gỡ lỗi không chỉ cho biết địa chỉ bộ nhớ mà còn cả tên các hàm và biến.

Việc đưa các ký hiệu gỡ lỗi vào làm chương trình hoặc thư viện to lên đáng kể. Dưới đây là hai ví dụ về dung lượng các ký hiệu này chiếm:

* Tệp nhị phân `bash` có ký hiệu gỡ lỗi: 1200 KB
* Tệp nhị phân `bash` không có ký hiệu gỡ lỗi: 480 KB (nhỏ hơn 60%)
* Các tệp Glibc và GCC (`/lib` và `/usr/lib`) có ký hiệu gỡ lỗi: 87 MB
* Các tệp Glibc và GCC không có ký hiệu gỡ lỗi: 16 MB (nhỏ hơn 82%)

Kích thước sẽ khác nhau tùy trình biên dịch và thư viện C đã dùng, nhưng chương trình đã được strip ký hiệu gỡ lỗi thường nhỏ hơn bản chưa strip khoảng 50% đến 80%. Vì đa số người dùng sẽ không bao giờ dùng trình gỡ lỗi cho phần mềm hệ thống, ta có thể thu hồi nhiều dung lượng đĩa bằng cách xóa các ký hiệu này. Mục tiếp theo hướng dẫn cách strip toàn bộ ký hiệu gỡ lỗi khỏi các chương trình và thư viện.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/aboutdebug.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/aboutdebug.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/aboutdebug.html)
