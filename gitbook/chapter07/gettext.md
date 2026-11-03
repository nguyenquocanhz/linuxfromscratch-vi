---
description: "Gói Gettext chứa các tiện ích để quốc tế hóa và địa phương hóa. Chúng cho phép biên dịch chương trình với NLS (Native Language Support), giúp chúng xuất th"
---

# 7.7. Gettext-0.26

Gói Gettext chứa các tiện ích để quốc tế hóa và địa phương hóa. Chúng cho phép biên dịch chương trình với NLS (Native Language Support), giúp chúng xuất thông báo bằng ngôn ngữ mẹ đẻ của người dùng.

* **Thời gian dựng ước tính:** 1.5 SBU
* **Dung lượng đĩa cần:** 463 MB

## 7.7.1. Cài đặt Gettext

Với bộ công cụ tạm, chúng ta chỉ cần cài ba chương trình từ Gettext.

Chuẩn bị biên dịch Gettext:

```bash
./configure --disable-shared
```

**Ý nghĩa của tùy chọn configure:**

**`--disable-shared`**

> Hiện chưa cần cài các thư viện Gettext dùng chung nên không cần dựng chúng.

Biên dịch gói:

```bash
make
```

Cài đặt các chương trình `msgfmt`, `msgmerge` và `xgettext`:

```bash
cp -v gettext-tools/src/{msgfmt,msgmerge,xgettext} /usr/bin
```

Chi tiết về gói này nằm trong [Mục 8.33.2, “Nội dung của Gettext.”](../chapter08/gettext.md#contents-gettext)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/gettext.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/gettext.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/gettext.html)
