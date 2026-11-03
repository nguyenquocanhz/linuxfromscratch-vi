---
description: "Chương này hướng dẫn dựng một trình biên dịch chéo và các công cụ đi kèm. Dù ở đây việc biên dịch chéo chỉ là giả lập, các nguyên lý vẫn giống như với một "
---

<details>

<summary>Trick lỏ: Viết một hàm nhỏ để giải nén – dựng – dọn, khỏi quên bước</summary>

Quy trình cho mỗi gói luôn là: giải nén → `cd` vào → làm theo sách → quay ra → **xóa thư mục nguồn**. Quên bước xóa là lần dựng sau dùng nhầm thư mục cũ. Đặt hàm này vào `~/.bashrc`:

```bash
pkg() {   # dùng: pkg gcc-15.2.0.tar.xz
  cd $LFS/sources || return
  local dir; dir=$(tar -tf "$1" | head -1 | cut -d/ -f1)
  rm -rf "$dir" && tar -xf "$1" && cd "$dir" && echo ">>> Đang ở $(pwd)"
}
done_pkg() { local d; d=$(basename "$PWD"); cd $LFS/sources && rm -rf "$d" && echo ">>> Đã dọn $d"; }
```

Trong chroot (Chương 7 trở đi) `$LFS` không còn — dùng `/sources` thay cho `$LFS/sources`. Đừng tự động hoá hết từ lần đầu: gõ tay từng lệnh mới hiểu được LFS, đó mới là mục đích.

[Tất cả trick lỏ →](../trick-lo.md#ham-build)

</details>

# 5.1. Giới thiệu

Chương này hướng dẫn dựng một trình biên dịch chéo và các công cụ đi kèm. Dù ở đây việc biên dịch chéo chỉ là giả lập, các nguyên lý vẫn giống như với một toolchain chéo thật.

Các chương trình biên dịch trong chương này sẽ được cài vào thư mục `$LFS/tools` để tách khỏi các tệp cài ở những chương sau. Ngược lại, các thư viện được cài vào đúng vị trí cuối cùng của chúng, vì chúng thuộc về hệ thống ta muốn dựng.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter05/introduction.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter05/introduction.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter05/introduction.html)
