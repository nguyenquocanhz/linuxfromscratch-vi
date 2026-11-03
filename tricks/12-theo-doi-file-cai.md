---
title: Biết gói vừa cài những file gì bằng mẹo "dấu thời gian"
pages: chapter08/pkgmgt.html
tags: quản lý gói
---
LFS không có trình quản lý gói. Cách đơn giản nhất để biết `make install` rải file đi đâu:

```bash
touch /tmp/truoc-cai
make install
find / -xdev -newer /tmp/truoc-cai -not -path '/proc/*' -not -path '/sys/*' \
     -not -path '/sources/*' -type f > /var/log/pkg-tengoi.list
```

Sau này muốn gỡ gói thì xem file `.list` đó. Nhược điểm: không chính xác nếu có tiến trình khác ghi file cùng lúc. Muốn bài bản hơn, đọc mục "DESTDIR" trong chính trang này.
