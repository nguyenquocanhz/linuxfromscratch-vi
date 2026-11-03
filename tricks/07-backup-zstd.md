---
title: Sao lưu sau Chương 7 bằng zstd — nhanh hơn xz rất nhiều
pages: chapter07/cleanup.html
tags: sao lưu
---
Sách gợi ý nén `$LFS` bằng `xz`, khá chậm trên máy yếu. `zstd` nén gần tốt bằng mà nhanh gấp nhiều lần (nhớ thoát chroot và umount các hệ thống file ảo trước, đúng như sách dặn):

```bash
cd $LFS
tar --exclude=./sources -cf - . | zstd -T0 -10 > $HOME/lfs-ch7.tar.zst
# khôi phục:
cd $LFS && rm -rf ./* && zstd -dc $HOME/lfs-ch7.tar.zst | tar -xpf -
```

Làm trong máy ảo thì còn nhàn hơn: chụp **snapshot** máy ảo ở mốc này, hỏng gì ở Chương 8 thì quay lại trong vài giây.
