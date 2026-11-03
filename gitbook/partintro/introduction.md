---
description: "Phần này chia làm ba giai đoạn: đầu tiên là dựng một trình biên dịch chéo cùng các thư viện đi kèm; thứ hai là dùng toolchain chéo đó để dựng một số tiện í"
---

# i. Giới thiệu

Phần này chia làm ba giai đoạn: đầu tiên là dựng một trình biên dịch chéo cùng các thư viện đi kèm; thứ hai là dùng toolchain chéo đó để dựng một số tiện ích theo cách tách biệt chúng khỏi bản phân phối host; thứ ba là vào môi trường chroot (giúp cô lập khỏi host tốt hơn nữa) và dựng nốt các công cụ còn lại để xây hệ thống cuối cùng.

{% hint style="warning" %}
**Quan trọng**

Đây là lúc công việc thực sự của việc dựng một hệ thống mới bắt đầu. Hãy thật cẩn thận làm đúng từng bước như sách hướng dẫn. Bạn nên cố hiểu mỗi lệnh làm gì, và dù háo hức hoàn thành đến đâu, cũng đừng gõ lệnh một cách máy móc. Khi gặp điều chưa hiểu, hãy đọc tài liệu. Ngoài ra, hãy ghi lại những gì bạn gõ và kết quả của các lệnh bằng tiện ích `tee` để lưu đầu ra của terminal vào một tệp. Việc này giúp gỡ lỗi dễ hơn nếu có sự cố.
{% endhint %}

Mục tiếp theo là phần giới thiệu kỹ thuật về quá trình dựng, còn mục sau đó trình bày các hướng dẫn chung **rất quan trọng**.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/partintro/introduction.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/partintro/introduction.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/partintro/introduction.html)
