---
title: Năm lỗi ai làm LFS cũng từng dính
pages: chapter05/binutils-pass1.html, chapter04/settingenvironment.html, chapter06/introduction.html
tags: gỡ lỗi
---
1. **Dựng Chương 5–6 bằng root** thay vì user `lfs` → file cài nhầm vào hệ thống chủ. Gõ `whoami` trước mỗi gói.
2. **Môi trường của user `lfs` không sạch**: file `/etc/bash.bashrc` của hệ thống chủ (Ubuntu, Debian có) chen biến vào. Sách đã bảo đổi tên nó đi — hãy làm thật.
3. **Không xóa thư mục nguồn** sau khi dựng → lần dựng pass 2 dùng lại bản pass 1 đã cấu hình.
4. **Quên `cd build`** với các gói dựng trong thư mục riêng (Binutils, GCC, Glibc) → `configure` chạy sai chỗ, lỗi khó hiểu.
5. **Copy lệnh thiếu dòng** khi lệnh có `\` xuống dòng. Dùng nút "Sao chép" trên trang này để chép trọn khối lệnh.

Hỏi cộng đồng thì gửi kèm: chương/mục, lệnh đã chạy, **20 dòng log cuối** và output của `version-check.sh`.
