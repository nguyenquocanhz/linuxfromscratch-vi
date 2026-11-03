---
description: "Hầu hết các gói đều có bộ kiểm thử. Chạy bộ kiểm thử cho gói vừa dựng là việc nên làm vì nó là một lần “kiểm tra tỉnh táo” cho thấy mọi thứ đã biên dịch đú"
---

<details>

<summary>Trick lỏ: Bộ kiểm thử — chỗ nào được lười, chỗ nào tuyệt đối không</summary>

Chạy hết test ở Chương 8 có thể mất lâu hơn cả thời gian dựng. Ưu tiên thế này:

* **Bắt buộc chạy**: Glibc, GCC, Binutils (và GMP, MPFR như sách nhấn mạnh). Toolchain hỏng thì mọi gói sau đều hỏng theo.
* **Có vài test lỗi là bình thường**: sách luôn liệt kê các test "known to fail". So kết quả của bạn với danh sách đó trước khi hoảng.
* Gói nhỏ (ví dụ man-pages, less) mà bạn vội thì bỏ test cũng chấp nhận được ở lần dựng đầu tiên.

So kết quả với người khác: `../contrib/test_summary | grep -A7 Summ` (GCC) rồi đối chiếu tại trang [buildlogs của LFS](https://www.linuxfromscratch.org/lfs/build-logs/).

[Tất cả trick lỏ →](../trick-lo.md#kiem-thu)

</details>

# 4.6. Về các bộ kiểm thử

Hầu hết các gói đều có bộ kiểm thử. Chạy bộ kiểm thử cho gói vừa dựng là việc nên làm vì nó là một lần “kiểm tra tỉnh táo” cho thấy mọi thứ đã biên dịch đúng. Bộ kiểm thử vượt qua các phép kiểm tra thường chứng tỏ gói hoạt động như nhà phát triển mong muốn. Tuy vậy, điều đó không đảm bảo gói hoàn toàn không có lỗi.

Một số bộ kiểm thử quan trọng hơn số khác. Ví dụ, bộ kiểm thử của các gói toolchain cốt lõi — GCC, binutils và glibc — cực kỳ quan trọng vì vai trò trung tâm của chúng trong một hệ thống hoạt động đúng. Bộ kiểm thử của GCC và glibc có thể chạy rất lâu, nhất là trên phần cứng chậm, nhưng chúng tôi rất khuyến khích chạy.

{% hint style="info" %}
**Ghi chú**

Chạy các bộ kiểm thử trong [Chương 5](../chapter05/chapter05.md) và [Chương 6](../chapter06/chapter06.md) là vô nghĩa; vì các chương trình kiểm thử được biên dịch bằng trình biên dịch chéo, nhiều khả năng chúng không chạy được trên máy build.
{% endhint %}

Một vấn đề thường gặp khi chạy bộ kiểm thử của binutils và GCC là hết pseudo terminal (PTY), dẫn đến rất nhiều bài kiểm tra thất bại. Nguyên nhân có thể nhiều, nhưng khả năng cao nhất là hệ thống chủ chưa thiết lập đúng hệ thống tệp `devpts`. Vấn đề này được bàn kỹ hơn tại [https://www.linuxfromscratch.org/lfs/faq.html\#no-ptys](https://www.linuxfromscratch.org/lfs/faq.html#no-ptys).

Đôi khi bộ kiểm thử của gói thất bại vì những lý do mà nhà phát triển đã biết và cho là không nghiêm trọng. Hãy tra nhật ký tại [https://www.linuxfromscratch.org/lfs/build-logs/12.4/](https://www.linuxfromscratch.org/lfs/build-logs/12.4/) để xác nhận những lỗi này có nằm trong dự kiến hay không. Trang này áp dụng cho mọi bộ kiểm thử trong suốt cuốn sách.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter04/abouttestsuites.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter04/abouttestsuites.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter04/abouttestsuites.html)
