---
title: Tải toàn bộ mã nguồn nhanh và kiểm tra một lần
pages: chapter03/introduction.html, chapter03/packages.html
tags: tải về
---
Sách cho sẵn file `wget-list-sysv` và `md5sums`. Tải song song cho nhanh (cần gói `aria2`):

```bash
cd $LFS/sources
wget https://www.linuxfromscratch.org/lfs/view/12.4/wget-list-sysv
wget https://www.linuxfromscratch.org/lfs/view/12.4/md5sums
aria2c -x4 -j8 -c -i wget-list-sysv     # -c: tải tiếp nếu đứt mạng
md5sum -c md5sums | grep -v ': OK$'     # chỉ in file lỗi; không in gì = ngon
```

Có file tải hỏng từ server gốc? Mỗi gói thường có mirror khác trên trang dự án; tải tay rồi chạy lại `md5sum -c`.
Mẹo thêm: nén cả thư mục `sources` lại cất đi — lần làm LFS thứ hai khỏi tải lại.
