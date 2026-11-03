---
title: Luôn kiểm tra $LFS trước khi chạy lệnh nguy hiểm
pages: chapter02/aboutlfs.html, chapter04/addinguser.html, chapter07/changingowner.html
tags: an toàn
---
Lỗi kinh điển nhất của LFS: mở terminal mới, quên `export LFS=/mnt/lfs`, rồi chạy `chown -R root:root $LFS/...` hoặc `rm -rf $LFS/...`. Khi `$LFS` rỗng, lệnh đó chạy thẳng trên **thư mục gốc của máy chủ**.

Thói quen nên có:

```bash
echo "LFS=$LFS"                 # nhìn bằng mắt trước mỗi phiên
set -u                          # biến chưa đặt -> shell báo lỗi thay vì coi là chuỗi rỗng
alias lfscheck='[ "$LFS" = /mnt/lfs ] && echo OK || echo "LFS SAI: [$LFS]"'
```

Ghi `export LFS=/mnt/lfs` vào `~/.bash_profile` của **cả root lẫn lfs** để khỏi quên.
