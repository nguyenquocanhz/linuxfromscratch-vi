---
title: Alias kiểm tra nhanh toolchain sau mỗi gói quan trọng
pages: chapter05/glibc.html, chapter05/gcc-libstdc++.html, chapter08/gcc.html
tags: kiểm tra
---
Sách có bước "sanity check" sau Glibc. Gói nó thành alias để chạy lại bất cứ lúc nào (ví dụ sau khi dựng libstdc++ hoặc khi nghi toolchain hỏng):

```bash
alias lfstc='echo "int main(){}" | $LFS_TGT-gcc -x c - -o /tmp/lfstc && readelf -l /tmp/lfstc | grep ld-linux; rm -f /tmp/lfstc'
```

Kết quả đúng phải có `[Requesting program interpreter: /lib64/ld-linux-x86-64.so.2]`. Không ra dòng nào, hoặc ra đường dẫn của hệ thống chủ → **dừng lại**, đừng làm tiếp, quay lại kiểm tra từng bước trước.
Trong chroot ở Chương 8 thì dùng `gcc` thay cho `$LFS_TGT-gcc`.
