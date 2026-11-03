---
description: "Ngoài các gói, bạn còn cần một số bản vá (patch). Chúng sửa những lỗi trong gói mà lẽ ra người bảo trì phải sửa, đồng thời chỉnh nhẹ để các gói dễ dùng hơn"
---

# 3.3. Các bản vá cần thiết

Ngoài các gói, bạn còn cần một số bản vá (patch). Chúng sửa những lỗi trong gói mà lẽ ra người bảo trì phải sửa, đồng thời chỉnh nhẹ để các gói dễ dùng hơn. Để dựng hệ thống LFS, bạn cần các bản vá sau:

**Bản vá tài liệu Bzip2 - 1.6 KB:**

> Tải về: [https://www.linuxfromscratch.org/patches/lfs/12.4/bzip2-1.0.8-install\_docs-1.patch](https://www.linuxfromscratch.org/patches/lfs/12.4/bzip2-1.0.8-install_docs-1.patch)

> Tổng kiểm MD5: `6a5ac7e89b791aae556de0f745916f7f`

**Bản vá sửa lỗi upstream cho Coreutils - 4.1 KB:**

> Tải về: [https://www.linuxfromscratch.org/patches/lfs/12.4/coreutils-9.7-upstream\_fix-1.patch](https://www.linuxfromscratch.org/patches/lfs/12.4/coreutils-9.7-upstream_fix-1.patch)

> Tổng kiểm MD5: `96382a5aa85d6651a74f94ffb61785d9`

**Bản vá quốc tế hóa (i18n) cho Coreutils - 159 KB:**

> Tải về: [https://www.linuxfromscratch.org/patches/lfs/12.4/coreutils-9.7-i18n-1.patch](https://www.linuxfromscratch.org/patches/lfs/12.4/coreutils-9.7-i18n-1.patch)

> Tổng kiểm MD5: `33ebfad32b2dfb8417c3335c08671206`

**Bản vá GCC15 cho Expect - 12 KB:**

> Tải về: [https://www.linuxfromscratch.org/patches/lfs/12.4/expect-5.45.4-gcc15-1.patch](https://www.linuxfromscratch.org/patches/lfs/12.4/expect-5.45.4-gcc15-1.patch)

> Tổng kiểm MD5: `0ca4d6bb8d572fbcdb13cb36cd34833e`

**Bản vá FHS cho Glibc - 2.8 KB:**

> Tải về: [https://www.linuxfromscratch.org/patches/lfs/12.4/glibc-2.42-fhs-1.patch](https://www.linuxfromscratch.org/patches/lfs/12.4/glibc-2.42-fhs-1.patch)

> Tổng kiểm MD5: `9a5997c3452909b1769918c759eff8a2`

**Bản vá phím Backspace/Delete cho Kbd - 12 KB:**

> Tải về: [https://www.linuxfromscratch.org/patches/lfs/12.4/kbd-2.8.0-backspace-1.patch](https://www.linuxfromscratch.org/patches/lfs/12.4/kbd-2.8.0-backspace-1.patch)

> Tổng kiểm MD5: `f75cca16a38da6caa7d52151f7136895`

**Bản vá tổng hợp cho SysVinit - 2.5 KB:**

> Tải về: [https://www.linuxfromscratch.org/patches/lfs/12.4/sysvinit-3.14-consolidated-1.patch](https://www.linuxfromscratch.org/patches/lfs/12.4/sysvinit-3.14-consolidated-1.patch)

> Tổng kiểm MD5: `3af8fd8e13cad481eeeaa48be4247445`

Tổng dung lượng các bản vá này: khoảng 194 KB

Ngoài các bản vá bắt buộc ở trên, cộng đồng LFS còn tạo ra một số bản vá tùy chọn. Chúng giải quyết các vấn đề nhỏ hoặc bật những chức năng không được bật mặc định. Bạn cứ thoải mái xem cơ sở dữ liệu bản vá tại [https://www.linuxfromscratch.org/patches/downloads/](https://www.linuxfromscratch.org/patches/downloads/) và lấy thêm các bản vá phù hợp nhu cầu hệ thống của mình.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter03/patches.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter03/patches.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter03/patches.html)
