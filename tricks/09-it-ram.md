---
title: Máy ít RAM bị "Killed" khi dựng GCC? Giảm -j và thêm swap
pages: chapter04/settingenvironment.html, chapter08/gcc.html
tags: hiệu năng
---
`MAKEFLAGS=-j$(nproc)` rất tốt, nhưng mỗi tiến trình biên dịch C++ của GCC có thể ăn cả GB RAM. Máy 4 nhân, 4 GB RAM chạy `-j4` rất dễ bị OOM killer giết, báo lỗi kiểu `g++: fatal error: Killed signal terminated program cc1plus`.

Quy tắc thô: **mỗi luồng khoảng 1,5–2 GB RAM** cho GCC. Không đủ thì thêm swap file trên hệ thống chủ:

```bash
sudo fallocate -l 8G /swapfile && sudo chmod 600 /swapfile
sudo mkswap /swapfile && sudo swapon /swapfile
```

Hoặc chỉ hạ số luồng cho riêng gói nặng: `make -j2` thay vì `make`.
