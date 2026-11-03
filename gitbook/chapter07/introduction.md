---
description: "Chương này hướng dẫn dựng những phần còn thiếu cuối cùng của hệ thống tạm: các công cụ cần để dựng các gói khác nhau. Giờ mọi phụ thuộc vòng đã được giải q"
---

# 7.1. Giới thiệu

Chương này hướng dẫn dựng những phần còn thiếu cuối cùng của hệ thống tạm: các công cụ cần để dựng các gói khác nhau. Giờ mọi phụ thuộc vòng đã được giải quyết, có thể dùng môi trường “chroot”, cách ly hoàn toàn khỏi hệ điều hành host (ngoại trừ kernel đang chạy) để dựng.

Để môi trường cách ly hoạt động đúng, cần thiết lập một số giao tiếp với kernel đang chạy. Việc này thực hiện qua cái gọi là *Hệ thống tệp ảo của Kernel* (Virtual Kernel File Systems), được mount trước khi vào môi trường chroot. Bạn có thể kiểm tra chúng đã được mount hay chưa bằng lệnh `findmnt`.

Cho tới [Mục 7.4, “Vào môi trường chroot”](chroot.md), các lệnh phải chạy bằng `root`, với biến `LFS` đã đặt. Sau khi vào chroot, mọi lệnh đều chạy bằng `root`, may là không truy cập được hệ điều hành của máy bạn dùng để dựng LFS. Dù vậy vẫn cần cẩn thận, vì rất dễ phá hỏng cả hệ thống LFS bằng lệnh sai.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/introduction.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/introduction.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/introduction.html)
