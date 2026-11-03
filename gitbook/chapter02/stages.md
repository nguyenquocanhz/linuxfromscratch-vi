---
description: "LFS được thiết kế để dựng trong một phiên làm việc, nghĩa là các hướng dẫn giả định hệ thống không bị tắt giữa chừng. Điều này không có nghĩa là bạn phải d"
---

# 2.3. Dựng LFS theo từng giai đoạn

LFS được thiết kế để dựng trong một phiên làm việc, nghĩa là các hướng dẫn giả định hệ thống không bị tắt giữa chừng. Điều này không có nghĩa là bạn phải dựng xong một mạch. Vấn đề là một số thao tác cần được lặp lại sau khi khởi động lại, nếu bạn muốn tiếp tục LFS từ những điểm khác nhau.

## 2.3.1. Chương 1–4

Các chương này chạy lệnh trên hệ thống chủ (host). Khi khởi động lại, hãy nhớ chắc chắn một điều:

* Những thao tác thực hiện bằng người dùng `root` sau Mục 2.4 phải có biến môi trường LFS được đặt *CHO NGƯỜI DÙNG ROOT*.

## 2.3.2. Chương 5–6

* Phân vùng /mnt/lfs phải được mount.
* Hai chương này *phải* được thực hiện bằng người dùng `lfs`. Bạn phải chạy lệnh `su - lfs` trước khi làm bất cứ việc gì trong các chương này. Nếu không, bạn có nguy cơ cài gói vào máy host và có thể làm hỏng nó.
* Các thao tác trong [Hướng dẫn biên dịch chung](../partintro/generalinstructions.md) rất quan trọng. Nếu nghi ngờ một gói chưa được cài đúng, hãy chắc chắn đã xóa thư mục tarball giải nén trước đó, rồi giải nén lại gói và làm lại toàn bộ hướng dẫn trong mục đó.

## 2.3.3. Chương 7–10

* Phân vùng /mnt/lfs phải được mount.
* Một vài thao tác, từ “Chuẩn bị các hệ thống tệp kernel ảo” đến “Vào môi trường chroot,” phải được thực hiện bằng người dùng `root`, với biến môi trường LFS được đặt cho `root`.
* Khi vào chroot, biến môi trường LFS phải được đặt cho `root`. Biến LFS không còn được dùng sau khi đã vào môi trường chroot.
* Các hệ thống tệp ảo phải được mount. Bạn có thể làm việc này trước hoặc sau khi vào chroot: chuyển sang một terminal ảo của máy host và, với tư cách `root`, chạy các lệnh trong [Mục 7.3.1, “Mounting and Populating /dev”](../chapter07/kernfs.md#ch-tools-bindmount) và [Mục 7.3.2, “Mounting Virtual Kernel File Systems.”](../chapter07/kernfs.md#ch-tools-kernfsmount)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter02/stages.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter02/stages.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter02/stages.html)
