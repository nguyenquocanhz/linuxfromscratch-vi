---
description: "Trong một chu kỳ phát triển của LFS, các hướng dẫn trong sách thường được sửa để thích ứng với việc cập nhật gói hoặc tận dụng tính năng mới của các gói đã"
---

<details>

<summary>Trick lỏ: Dùng tmux và ghi log để không mất công khi rớt SSH</summary>

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

[Tất cả trick lỏ →](../trick-lo.md#tmux-va-log)

</details>

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

# iii. Hướng dẫn biên dịch chung

{% hint style="danger" %}
**Thận trọng**

Trong một chu kỳ phát triển của LFS, các hướng dẫn trong sách thường được sửa để thích ứng với việc cập nhật gói hoặc tận dụng tính năng mới của các gói đã nâng cấp. Trộn lẫn hướng dẫn của các phiên bản sách LFS khác nhau có thể gây ra những lỗi khó phát hiện. Vấn đề này thường xuất phát từ việc dùng lại một số script viết cho bản LFS trước. Chúng tôi rất khuyến cáo không nên làm vậy. Nếu vì lý do nào đó bạn vẫn dùng lại script của bản LFS cũ, bạn cần hết sức cẩn thận cập nhật chúng cho khớp với phiên bản sách LFS hiện tại.
{% endhint %}

Dưới đây là một số điều bạn nên biết khi dựng từng gói:

* Một số gói được vá trước khi biên dịch, nhưng chỉ khi bản vá là cần thiết để khắc phục một vấn đề. Bản vá thường cần ở cả chương này lẫn chương sau, nhưng đôi khi, khi cùng một gói được dựng nhiều lần, bản vá chưa cần ngay. Vì vậy, đừng lo nếu thấy thiếu hướng dẫn cho một bản vá đã tải về. Bạn cũng có thể gặp các cảnh báo về *offset* hoặc *fuzz* khi áp dụng bản vá. Đừng bận tâm, bản vá vẫn được áp dụng thành công.
* Khi biên dịch hầu hết các gói, sẽ có một số cảnh báo chạy qua màn hình. Đây là chuyện bình thường và bạn có thể yên tâm bỏ qua. Các cảnh báo này thường nói về cách dùng cú pháp C hoặc C++ đã lỗi thời nhưng chưa phải là không hợp lệ. Chuẩn C thay đổi khá thường xuyên và một số gói chưa kịp cập nhật. Đây không phải vấn đề nghiêm trọng, chỉ là nguyên nhân khiến các cảnh báo xuất hiện.
* Hãy kiểm tra lần cuối rằng biến môi trường `LFS` đã được thiết lập đúng:

  ```bash
  echo $LFS
  ```

  Hãy chắc chắn kết quả hiển thị đường dẫn tới điểm mount của phân vùng LFS, tức là `/mnt/lfs` trong ví dụ của chúng ta.
* Cuối cùng, cần nhấn mạnh hai điều quan trọng:

  {% hint style="warning" %}
  **Quan trọng**

  Các hướng dẫn dựng giả định rằng [Yêu cầu đối với hệ thống chủ](../chapter02/hostreqs.md), kể cả các liên kết mềm, đã được thiết lập đúng:

  * `bash` là shell đang dùng.
  * `sh` là liên kết mềm tới `bash`.
  * `/usr/bin/awk` là liên kết mềm tới `gawk`.
  * `/usr/bin/yacc` là liên kết mềm tới `bison`, hoặc tới một script nhỏ chạy bison.
  {% endhint %}

  {% hint style="warning" %}
  **Quan trọng**

  Sau đây là tóm tắt quy trình dựng.

  1. Đặt toàn bộ mã nguồn và các bản vá vào một thư mục mà môi trường chroot truy cập được, chẳng hạn `/mnt/lfs/sources/`.
  2. Chuyển vào thư mục `/mnt/lfs/sources/`.
  3. Với mỗi gói:

     1. Dùng chương trình `tar` để giải nén gói cần dựng. Trong [Chương 5](../chapter05/chapter05.md) và [Chương 6](../chapter06/chapter06.md), hãy bảo đảm bạn đang là người dùng *lfs* khi giải nén gói.

        Không dùng cách nào khác ngoài lệnh `tar` để giải nén mã nguồn. Đặc biệt, dùng lệnh `cp -R` để chép cây mã nguồn sang nơi khác có thể làm mất dấu thời gian (timestamp) trong cây nguồn và khiến quá trình dựng thất bại.
     2. Chuyển vào thư mục được tạo ra khi giải nén gói.
     3. Làm theo hướng dẫn dựng gói.
     4. Khi dựng xong, quay lại thư mục sources.
     5. Xóa thư mục mã nguồn đã giải nén, trừ khi có hướng dẫn khác.
  {% endhint %}

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/partintro/generalinstructions.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/partintro/generalinstructions.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/partintro/generalinstructions.html)
