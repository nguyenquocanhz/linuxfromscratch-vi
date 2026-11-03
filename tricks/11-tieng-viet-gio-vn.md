---
title: Cho LFS nói tiếng Việt và chạy giờ Việt Nam
pages: chapter08/glibc.html, chapter09/locale.html
tags: tiếng Việt, locale
---
Khi cài locale ở bước Glibc, thêm locale tiếng Việt:

```bash
localedef -i vi_VN -f UTF-8 vi_VN.UTF-8
```

Múi giờ: thay vì chạy `tzselect` dò từng bước, đặt thẳng:

```bash
ln -sfv /usr/share/zoneinfo/Asia/Ho_Chi_Minh /etc/localtime
```

Ở Mục 9.7, muốn giao diện vẫn tiếng Anh (dễ tra lỗi trên mạng) nhưng ngày giờ, tiền tệ kiểu Việt:

```bash
cat > /etc/profile.d/i18n.sh << "EOF2"
export LANG=en_US.UTF-8
export LC_TIME=vi_VN.UTF-8
EOF2
```

Gõ tiếng Việt có dấu trên console thô không được — đợi lên BLFS, cài môi trường đồ họa và IBus/Fcitx5 với bộ gõ Unikey/Bamboo.
