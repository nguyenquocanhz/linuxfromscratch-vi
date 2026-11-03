---
description: "Nhiều người muốn biết trước mỗi gói mất khoảng bao lâu để biên dịch và cài đặt. Vì Linux From Scratch có thể được dựng trên rất nhiều hệ thống khác nhau, k"
---

<details>

<summary>Trick lỏ: Dùng tmux và ghi log để không mất công khi rớt SSH</summary>

GCC hay Glibc dựng mất hàng chục phút. SSH rớt giữa chừng là mất luôn tiến trình và phải làm lại. Chạy mọi thứ trong `tmux`:

```bash
tmux new -s lfs        # tạo phiên
# ... rớt mạng ...
tmux attach -t lfs     # vào lại, mọi thứ vẫn chạy
```

Ghi log từng gói để khi lỗi còn có cái mà đọc (và đo luôn SBU):

```bash
mkdir -p $LFS/logs
{ time { ../configure --prefix=/usr && make && make install; } ; } 2>&1 | tee $LFS/logs/tengoi.log
```

Lưu ý: `tee` nuốt mã lỗi của `make`. Muốn dừng khi lỗi thì thêm `set -o pipefail` vào shell.

[Tất cả trick lỏ →](../trick-lo.md#tmux-va-log)

</details>

# 4.5. Về SBU

Nhiều người muốn biết trước mỗi gói mất khoảng bao lâu để biên dịch và cài đặt. Vì Linux From Scratch có thể được dựng trên rất nhiều hệ thống khác nhau, không thể đưa ra ước tính thời gian tuyệt đối. Gói lớn nhất (gcc) mất khoảng 5 phút trên những máy nhanh nhất, nhưng có thể mất hàng ngày trên máy chậm! Thay vì đưa thời gian thực, sách dùng thước đo Đơn vị dựng chuẩn (Standard Build Unit, SBU).

Cách tính SBU như sau. Gói đầu tiên được biên dịch là binutils trong [Chương 5](../chapter05/chapter05.md). Thời gian biên dịch nó bằng một lõi CPU chính là cái ta gọi là Đơn vị dựng chuẩn, hay SBU. Mọi thời gian biên dịch khác đều được biểu diễn theo đơn vị này.

Ví dụ, một gói có thời gian biên dịch là 4,5 SBU. Nghĩa là nếu máy bạn mất 4 phút để biên dịch và cài đặt binutils lượt đầu, thì dựng gói ví dụ đó sẽ mất *khoảng* 18 phút. May mắn là phần lớn thời gian dựng ngắn hơn một SBU.

SBU không hoàn toàn chính xác vì phụ thuộc nhiều yếu tố, trong đó có phiên bản GCC của hệ thống chủ. Chúng chỉ để bạn ước chừng thời gian cài một gói; con số thực tế có thể lệch tới vài chục phút trong một số trường hợp.

Trên một số máy đời mới, bo mạch chủ có thể điều khiển xung nhịp của hệ thống. Bạn có thể điều khiển nó bằng lệnh như `powerprofilesctl`. LFS không có lệnh này, nhưng distro host có thể có. Sau khi hoàn tất LFS, bạn có thể thêm nó vào hệ thống theo hướng dẫn ở trang [BLFS power-profiles-daemon](https://www.linuxfromscratch.org/blfs/view/12.4/sysutils/power-profiles-daemon.html). Trước khi đo thời gian dựng của bất kỳ gói nào, nên đặt hồ sơ năng lượng của hệ thống ở mức hiệu năng tối đa (và tiêu thụ điện tối đa). Nếu không, giá trị SBU đo được có thể sai lệch vì hệ thống có thể phản ứng khác nhau khi dựng [binutils-pass1](../chapter05/binutils-pass1.md) và các gói khác. Lưu ý rằng dù dùng cùng một hồ sơ cho cả hai gói, vẫn có thể có sai lệch đáng kể, vì hệ thống có thể đáp ứng chậm hơn nếu đang rảnh khi bắt đầu dựng. Đặt hồ sơ năng lượng thành “performance” sẽ giảm thiểu vấn đề này. Và hiển nhiên, làm vậy cũng giúp hệ thống dựng LFS nhanh hơn.

Nếu có `powerprofilesctl`, hãy chạy lệnh `powerprofilesctl set performance` để chọn hồ sơ `performance`. Một số distro cung cấp lệnh `tuned-adm` để quản lý hồ sơ thay cho `powerprofilesctl`; trên các distro này, hãy chạy lệnh `tuned-adm profile throughput-performance` để chọn hồ sơ `throughput-performance`.

{% hint style="info" %}
**Ghi chú**

Khi dùng nhiều bộ xử lý theo cách này, số SBU trong sách sẽ còn chênh lệch nhiều hơn bình thường. Trong một số trường hợp, bước make sẽ thất bại. Việc phân tích đầu ra của quá trình dựng cũng khó hơn vì các dòng từ những tiến trình khác nhau bị xen lẫn. Nếu gặp sự cố ở một bước dựng, hãy quay lại dựng bằng một bộ xử lý để phân tích đúng các thông báo lỗi.

Thời gian nêu ở đây cho mọi gói (trừ [binutils-pass1](../chapter05/binutils-pass1.md), tính theo một lõi) đều dựa trên việc dùng bốn lõi (-j4). Thời gian trong Chương 8 còn bao gồm cả thời gian chạy các bài kiểm tra hồi quy của gói, trừ khi có ghi chú khác.
{% endhint %}

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter04/aboutsbus.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter04/aboutsbus.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter04/aboutsbus.html)
