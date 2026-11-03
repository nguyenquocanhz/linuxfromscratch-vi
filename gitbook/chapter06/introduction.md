---
description: "Chương này hướng dẫn biên dịch chéo các tiện ích cơ bản bằng cross-toolchain vừa dựng xong. Các tiện ích này được cài vào vị trí cuối cùng của chúng, nhưng"
---

<details>

<summary>Trick lỏ: Năm lỗi ai làm LFS cũng từng dính</summary>

1. **Dựng Chương 5–6 bằng root** thay vì user `lfs` → file cài nhầm vào hệ thống chủ. Gõ `whoami` trước mỗi gói.
2. **Môi trường của user `lfs` không sạch**: file `/etc/bash.bashrc` của hệ thống chủ (Ubuntu, Debian có) chen biến vào. Sách đã bảo đổi tên nó đi — hãy làm thật.
3. **Không xóa thư mục nguồn** sau khi dựng → lần dựng pass 2 dùng lại bản pass 1 đã cấu hình.
4. **Quên `cd build`** với các gói dựng trong thư mục riêng (Binutils, GCC, Glibc) → `configure` chạy sai chỗ, lỗi khó hiểu.
5. **Copy lệnh thiếu dòng** khi lệnh có `\` xuống dòng. Dùng nút "Sao chép" trên trang này để chép trọn khối lệnh.

Hỏi cộng đồng thì gửi kèm: chương/mục, lệnh đã chạy, **20 dòng log cuối** và output của `version-check.sh`.

[Tất cả trick lỏ →](../trick-lo.md#loi-kinh-dien)

</details>

# 6.1. Giới thiệu

Chương này hướng dẫn biên dịch chéo các tiện ích cơ bản bằng cross-toolchain vừa dựng xong. Các tiện ích này được cài vào vị trí cuối cùng của chúng, nhưng chưa dùng được ngay. Các tác vụ cơ bản vẫn dựa vào công cụ của host. Tuy nhiên, các thư viện đã cài sẽ được dùng khi liên kết (link).

Bạn sẽ dùng được các tiện ích này ở chương sau, sau khi vào môi trường “chroot”. Nhưng tất cả các gói trong chương này phải được dựng trước khi làm vậy. Vì thế chúng ta chưa thể độc lập khỏi hệ thống chủ (host).

Xin nhắc lại: thiết lập `LFS` sai cùng với việc dựng bằng `root` có thể khiến máy tính của bạn không dùng được. Toàn bộ chương này phải thực hiện bằng người dùng `lfs`, với môi trường như mô tả trong [Mục 4.4, “Thiết lập môi trường.”](../chapter04/settingenvironment.md)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/introduction.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/introduction.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/introduction.html)
