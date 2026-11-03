---
description: "Gói Binutils chứa trình liên kết (linker), trình hợp ngữ (assembler) và các công cụ khác để xử lý tệp đối tượng (object file)."
---

<details>

<summary>Trick lỏ: Năm lỗi ai làm LFS cũng từng dính</summary>

1. **Dựng Chương 5–6 bằng root** thay vì user `lfs` → file cài nhầm vào hệ thống chủ. Gõ `whoami` trước mỗi gói.
2. **Môi trường của user `lfs` không sạch**: file `/etc/bash.bashrc` của hệ thống chủ (Ubuntu, Debian có) chen biến vào. Sách đã bảo đổi tên nó đi — hãy làm thật.
3. **Không xóa thư mục nguồn** sau khi dựng → lần dựng pass 2 dùng lại bản pass 1 đã cấu hình.
4. **Quên `cd build`** với các gói dựng trong thư mục riêng (Binutils, GCC, Glibc) → `configure` chạy sai chỗ, lỗi khó hiểu.
5. **Copy lệnh thiếu dòng** khi lệnh có `\` xuống dòng. Dùng nút "Sao chép" trên trang này để chép trọn khối lệnh.

Hỏi cộng đồng thì gửi kèm: chương/mục, lệnh đã chạy, **20 dòng log cuối** và output của `version-check.sh`.

[Tất cả trick lỏ →](../trick-lo.md#loi-kinh-dien)

</details>

# 5.2. Binutils-2.45 - Lượt 1

Gói Binutils chứa trình liên kết (linker), trình hợp ngữ (assembler) và các công cụ khác để xử lý tệp đối tượng (object file).

* **Thời gian dựng ước tính:** 1 SBU
* **Dung lượng đĩa cần:** 678 MB

## 5.2.1. Cài đặt Binutils chéo (Cross Binutils)

{% hint style="info" %}
**Ghi chú**

Hãy quay lại đọc kỹ các ghi chú trong mục [Hướng dẫn biên dịch chung](../partintro/generalinstructions.md). Hiểu các ghi chú đánh dấu quan trọng có thể giúp bạn tránh được rất nhiều rắc rối về sau.
{% endhint %}

Binutils phải là gói đầu tiên được biên dịch, vì cả Glibc và GCC đều chạy nhiều phép thử trên trình liên kết và trình hợp ngữ hiện có để quyết định bật những tính năng nào của chúng.

Tài liệu của Binutils khuyên nên dựng Binutils trong một thư mục dựng riêng:

```bash
mkdir -v build
cd       build
```

{% hint style="info" %}
**Ghi chú**

Để các giá trị SBU nêu trong phần còn lại của sách có ích, hãy đo thời gian dựng gói này từ bước cấu hình cho đến hết lần cài đặt đầu tiên. Để làm việc này dễ dàng, hãy bọc các lệnh trong lệnh `time` như sau: `time { ../configure ... && make && make install; }`.
{% endhint %}

Bây giờ hãy chuẩn bị biên dịch Binutils:

```bash
../configure --prefix=$LFS/tools \
             --with-sysroot=$LFS \
             --target=$LFS_TGT   \
             --disable-nls       \
             --enable-gprofng=no \
             --disable-werror    \
             --enable-new-dtags  \
             --enable-default-hash-style=gnu
```

**Ý nghĩa các tùy chọn configure:**

{% hint style="info" %}
**Ghi chú**

Khác với các gói khác, không phải mọi tùy chọn liệt kê dưới đây đều xuất hiện khi chạy `./configure --help`. Ví dụ, để tìm tùy chọn `--with-sysroot`, bạn phải chạy `ld/configure --help`. Bạn có thể liệt kê tất cả tùy chọn cùng lúc bằng `./configure --help=recursive`.
{% endhint %}

**`--prefix=$LFS/tools`**

> Cho script configure biết cần chuẩn bị cài các chương trình Binutils vào thư mục `$LFS/tools`.

**`--with-sysroot=$LFS`**

> Với biên dịch chéo, tùy chọn này bảo hệ thống dựng tìm các thư viện của hệ thống target trong $LFS khi cần.

**`--target=$LFS_TGT`**

> Vì mô tả máy trong biến `LFS_TGT` hơi khác giá trị do script `config.guess` trả về, tùy chọn này bảo script `configure` điều chỉnh hệ thống dựng của binutils để dựng một trình liên kết chéo.

**`--disable-nls`**

> Tắt quốc tế hóa (i18n) vì các công cụ tạm không cần đến nó.

**`--enable-gprofng=no`**

> Tắt việc dựng gprofng vì các công cụ tạm không cần đến nó.

**`--disable-werror`**

> Ngăn quá trình dựng dừng lại khi trình biên dịch của máy host đưa ra cảnh báo.

**`--enable-new-dtags`**

> Làm cho trình liên kết dùng thẻ “runpath” để nhúng đường dẫn tìm thư viện vào tệp thực thi và thư viện chia sẻ, thay cho thẻ “rpath” truyền thống. Cách này giúp gỡ lỗi các tệp thực thi liên kết động dễ hơn và tránh được các sự cố tiềm ẩn trong bộ kiểm thử của một số gói.

**`--enable-default-hash-style=gnu`**

> Mặc định, trình liên kết sẽ tạo cả bảng băm kiểu GNU lẫn bảng băm ELF cổ điển cho các thư viện chia sẻ và tệp thực thi liên kết động. Các bảng băm này chỉ dành cho trình liên kết động tra cứu ký hiệu. Trên LFS, trình liên kết động (do gói Glibc cung cấp) luôn dùng bảng băm kiểu GNU vì truy vấn nhanh hơn, nên bảng băm ELF cổ điển hoàn toàn vô dụng. Tùy chọn này làm trình liên kết mặc định chỉ tạo bảng băm kiểu GNU, nhờ đó ta khỏi mất thời gian tạo bảng ELF cổ điển khi dựng các gói, cũng như khỏi tốn dung lượng đĩa để lưu nó.

Tiếp tục biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make install
```

Chi tiết về gói này có ở [Mục 8.20.2, “Contents of Binutils.”](../chapter08/binutils.md#contents-binutils)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter05/binutils-pass1.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter05/binutils-pass1.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter05/binutils-pass1.html)
