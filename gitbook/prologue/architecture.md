---
description: "Các kiến trúc đích chính của LFS là CPU AMD\/Intel x86 (32-bit) và x86_64 (64-bit). Bên cạnh đó, các hướng dẫn trong sách này cũng được biết là dùng được, v"
---

# iii. Các kiến trúc đích của LFS

Các kiến trúc đích chính của LFS là CPU AMD/Intel x86 (32-bit) và x86\_64 (64-bit). Bên cạnh đó, các hướng dẫn trong sách này cũng được biết là dùng được, với một số điều chỉnh, trên CPU Power PC và ARM. Để dựng hệ thống chạy trên một trong các CPU thay thế này, điều kiện tiên quyết chính, ngoài những yêu cầu ở trang sau, là phải có sẵn một hệ thống Linux nhắm tới kiến trúc đó, chẳng hạn một bản LFS cài trước đó, Ubuntu, Red Hat/Fedora, SuSE hoặc một bản phân phối nào khác. (Lưu ý rằng bạn có thể cài và dùng bản phân phối 32-bit làm hệ thống chủ trên máy tính AMD/Intel 64-bit.)

Dựng trên hệ thống 64-bit so với 32-bit mang lại lợi ích không đáng kể. Ví dụ, trong một lần dựng thử LFS-9.1 trên máy dùng CPU Core i7-4790, với 4 nhân, các số liệu đo được như sau:

```text
Architecture Build Time     Build Size
32-bit       239.9 minutes  3.6 GB
64-bit       233.2 minutes  4.4 GB
```

Như bạn thấy, trên cùng phần cứng, bản dựng 64-bit chỉ nhanh hơn 3% (và lớn hơn 22%) so với bản 32-bit. Nếu bạn định dùng LFS làm máy chủ LAMP hoặc tường lửa, CPU 32-bit có thể đã đủ. Mặt khác, một số gói trong BLFS hiện cần hơn 4 GB RAM để dựng và/hoặc chạy; nếu bạn định dùng LFS làm máy tính để bàn, các tác giả LFS khuyên nên dựng hệ thống 64-bit.

Bản dựng 64-bit mặc định của LFS là hệ thống 64-bit “thuần”, tức là chỉ hỗ trợ tệp thực thi 64-bit. Dựng hệ thống “multi-lib” đòi hỏi biên dịch nhiều ứng dụng hai lần, một lần cho 32-bit và một lần cho 64-bit. LFS không hỗ trợ trực tiếp điều này vì nó đi ngược mục tiêu giáo dục là đưa ra những hướng dẫn tối thiểu cho một hệ thống Linux cơ bản. Một số biên tập viên LFS/BLFS duy trì một nhánh multilib của LFS, truy cập tại [https://www.linuxfromscratch.org/~thomas/multilib/index.html](https://www.linuxfromscratch.org/~thomas/multilib/index.html). Nhưng đó là chủ đề nâng cao.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/prologue/architecture.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/prologue/architecture.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/prologue/architecture.html)
