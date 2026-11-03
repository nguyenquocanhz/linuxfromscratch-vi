---
title: Dùng tmux và ghi log để không mất công khi rớt SSH
pages: chapter04/aboutsbus.html, partintro/generalinstructions.html
tags: năng suất
---
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
