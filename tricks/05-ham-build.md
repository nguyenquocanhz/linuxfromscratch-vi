---
title: Viết một hàm nhỏ để giải nén – dựng – dọn, khỏi quên bước
pages: partintro/generalinstructions.html, chapter05/introduction.html
tags: năng suất, script
---
Quy trình cho mỗi gói luôn là: giải nén → `cd` vào → làm theo sách → quay ra → **xóa thư mục nguồn**. Quên bước xóa là lần dựng sau dùng nhầm thư mục cũ. Đặt hàm này vào `~/.bashrc`:

```bash
pkg() {   # dùng: pkg gcc-15.2.0.tar.xz
  cd $LFS/sources || return
  local dir; dir=$(tar -tf "$1" | head -1 | cut -d/ -f1)
  rm -rf "$dir" && tar -xf "$1" && cd "$dir" && echo ">>> Đang ở $(pwd)"
}
done_pkg() { local d; d=$(basename "$PWD"); cd $LFS/sources && rm -rf "$d" && echo ">>> Đã dọn $d"; }
```

Trong chroot (Chương 7 trở đi) `$LFS` không còn — dùng `/sources` thay cho `$LFS/sources`.
Đừng tự động hoá hết từ lần đầu: gõ tay từng lệnh mới hiểu được LFS, đó mới là mục đích.
