---
description: "Hãy thiết lập một môi trường làm việc tốt bằng cách tạo hai tệp khởi động mới cho shell bash. Khi đang đăng nhập bằng người dùng lfs, hãy chạy lệnh sau để "
---

<details>

<summary>Trick lỏ: Máy ít RAM bị &quot;Killed&quot; khi dựng GCC? Giảm -j và thêm swap</summary>

`MAKEFLAGS=-j$(nproc)` rất tốt, nhưng mỗi tiến trình biên dịch C++ của GCC có thể ăn cả GB RAM. Máy 4 nhân, 4 GB RAM chạy `-j4` rất dễ bị OOM killer giết, báo lỗi kiểu `g++: fatal error: Killed signal terminated program cc1plus`.

Quy tắc thô: **mỗi luồng khoảng 1,5–2 GB RAM** cho GCC. Không đủ thì thêm swap file trên hệ thống chủ:

```bash
sudo fallocate -l 8G /swapfile && sudo chmod 600 /swapfile
sudo mkswap /swapfile && sudo swapon /swapfile
```

Hoặc chỉ hạ số luồng cho riêng gói nặng: `make -j2` thay vì `make`.

[Tất cả trick lỏ →](../trick-lo.md#it-ram)

</details>

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

# 4.4. Thiết lập môi trường

Hãy thiết lập một môi trường làm việc tốt bằng cách tạo hai tệp khởi động mới cho shell `bash`. Khi đang đăng nhập bằng người dùng `lfs`, hãy chạy lệnh sau để tạo `.bash_profile` mới:

```bash
cat > ~/.bash_profile << "EOF"
exec env -i HOME=$HOME TERM=$TERM PS1='\u:\w\$ ' /bin/bash
EOF
```

Khi đăng nhập bằng người dùng `lfs`, hoặc khi chuyển sang `lfs` bằng lệnh `su` với tùy chọn “`-`”, shell ban đầu là shell *đăng nhập* (login), nó đọc `/etc/profile` của máy host (có thể chứa một số thiết lập và biến môi trường) rồi đến `.bash_profile`. Lệnh `exec env -i.../bin/bash` trong tệp `.bash_profile` thay shell đang chạy bằng một shell mới có môi trường hoàn toàn trống, ngoại trừ các biến `HOME`, `TERM` và `PS1`. Nhờ vậy, không có biến môi trường không mong muốn và có thể gây hại nào từ hệ thống chủ lọt vào môi trường dựng.

Phiên bản shell mới này là shell *không đăng nhập* (non-login), nó không đọc và thực thi nội dung của `/etc/profile` hay `.bash_profile`, mà đọc và thực thi tệp `.bashrc`. Hãy tạo tệp `.bashrc` ngay bây giờ:

```bash
cat > ~/.bashrc << "EOF"
set +h
umask 022
LFS=/mnt/lfs
LC_ALL=POSIX
LFS_TGT=$(uname -m)-lfs-linux-gnu
PATH=/usr/bin
if [ ! -L /bin ]; then PATH=/bin:$PATH; fi
PATH=$LFS/tools/bin:$PATH
CONFIG_SITE=$LFS/usr/share/config.site
export LFS LC_ALL LFS_TGT PATH CONFIG_SITE
EOF
```

**Ý nghĩa các thiết lập trong `.bashrc`**

**`set +h`**

> Lệnh `set +h` tắt chức năng băm (hash) của `bash`. Băm thường là tính năng hữu ích — `bash` dùng bảng băm để nhớ đường dẫn đầy đủ tới các tệp thực thi, tránh phải tìm đi tìm lại trong `PATH` để ra cùng một tệp. Tuy nhiên, các công cụ mới nên được dùng ngay khi cài xong. Tắt chức năng băm buộc shell phải tìm trong `PATH` mỗi khi chạy một chương trình. Nhờ đó, shell sẽ thấy các công cụ mới biên dịch trong `$LFS/tools/bin` ngay khi chúng có mặt, mà không nhớ phiên bản cũ của cùng chương trình do distro host cung cấp trong `/usr/bin` hay `/bin`.

**`umask 022`**

> Đặt umask như đã giải thích trong [Mục 2.6, “Setting the $LFS Variable and the Umask.”](../chapter02/aboutlfs.md)

**`LFS=/mnt/lfs`**

> Biến `LFS` cần được đặt thành điểm mount bạn đã chọn.

**`LC_ALL=POSIX`**

> Biến `LC_ALL` điều khiển việc địa phương hóa của một số chương trình, làm thông báo của chúng theo quy ước của một quốc gia được chỉ định. Đặt `LC_ALL` thành “POSIX” hoặc “C” (hai giá trị tương đương) đảm bảo mọi thứ chạy như mong đợi trong môi trường biên dịch chéo.

**`LFS_TGT=$(uname -m)-lfs-linux-gnu`**

> Biến `LFS_TGT` đặt một mô tả máy không mặc định nhưng tương thích, dùng khi dựng trình biên dịch chéo và trình liên kết (linker) của chúng ta và khi biên dịch chéo toolchain tạm. Thêm thông tin có ở [Ghi chú kỹ thuật về toolchain](../partintro/toolchaintechnotes.md).

**`PATH=/usr/bin`**

> Nhiều bản phân phối Linux hiện đại đã gộp `/bin` và `/usr/bin`. Khi đó, biến `PATH` chuẩn nên được đặt thành `/usr/bin/` cho môi trường của [Chương 6](../chapter06/chapter06.md). Khi không phải vậy, dòng sau sẽ thêm `/bin` vào đường dẫn.

**`if [ ! -L /bin ]; then PATH=/bin:$PATH; fi`**

> Nếu `/bin` không phải là liên kết tượng trưng (symbolic link), nó phải được thêm vào biến `PATH`.

**`PATH=$LFS/tools/bin:$PATH`**

> Đặt `$LFS/tools/bin` lên trước `PATH` chuẩn thì trình biên dịch chéo cài ở đầu [Chương 5](../chapter05/chapter05.md) được shell dùng ngay sau khi cài. Kết hợp với việc tắt băm, điều này hạn chế nguy cơ trình biên dịch của máy host bị dùng thay cho trình biên dịch chéo.

**`CONFIG_SITE=$LFS/usr/share/config.site`**

> Trong [Chương 5](../chapter05/chapter05.md) và [Chương 6](../chapter06/chapter06.md), nếu biến này không được đặt, các script `configure` có thể cố nạp các mục cấu hình riêng của một số distro từ `/usr/share/config.site` trên hệ thống chủ. Hãy ghi đè nó để tránh bị nhiễm từ máy host.

**`export ...`**

> Các lệnh phía trên đã đặt một số biến; để chúng hiển thị trong mọi shell con, chúng ta export chúng.

{% hint style="warning" %}
**Quan trọng**

Một số bản phân phối thương mại thêm một bản `/etc/bash.bashrc` không được ghi tài liệu vào quá trình khởi tạo của `bash`. Tệp này có thể thay đổi môi trường của người dùng `lfs` theo cách ảnh hưởng đến việc dựng các gói LFS quan trọng. Để chắc chắn môi trường của người dùng `lfs` sạch, hãy kiểm tra sự tồn tại của `/etc/bash.bashrc` và nếu có thì dời nó đi chỗ khác. Với tư cách người dùng `root`, hãy chạy:

```bash
[ ! -e /etc/bash.bashrc ] || mv -v /etc/bash.bashrc /etc/bash.bashrc.NOUSE
```

Khi không còn cần người dùng `lfs` nữa (ở đầu [Chương 7](../chapter07/chapter07.md)), bạn có thể yên tâm khôi phục `/etc/bash.bashrc` (nếu muốn).

Lưu ý rằng gói Bash của LFS mà chúng ta sẽ dựng ở [Mục 8.36, “Bash-5.3”](../chapter08/bash.md) không được cấu hình để nạp hay thực thi `/etc/bash.bashrc`, nên tệp này vô dụng trên hệ thống LFS đã hoàn chỉnh.
{% endhint %}

Với nhiều hệ thống hiện đại có nhiều bộ xử lý (hoặc lõi), thời gian biên dịch một gói có thể giảm bằng cách chạy "make song song" (parallel make), tức là cho chương trình make biết có bao nhiêu bộ xử lý thông qua tùy chọn dòng lệnh hoặc biến môi trường. Ví dụ, bộ xử lý Intel Core i9-13900K có 8 lõi P (hiệu năng) và 16 lõi E (tiết kiệm điện), và mỗi lõi P chạy được hai luồng cùng lúc nên kernel Linux coi mỗi lõi P là hai lõi logic. Kết quả là có tổng cộng 32 lõi logic. Một cách hiển nhiên để dùng hết các lõi logic này là cho phép `make` sinh tối đa 32 tiến trình dựng. Bạn có thể làm vậy bằng cách truyền tùy chọn `-j32` cho `make`:

```bash
make -j32
```

Hoặc đặt biến môi trường `MAKEFLAGS`, nội dung của nó sẽ được `make` tự động dùng làm tùy chọn dòng lệnh:

```bash
export MAKEFLAGS=-j32
```

{% hint style="warning" %}
**Quan trọng**

Đừng bao giờ truyền tùy chọn `-j` không kèm số cho `make` hay đặt tùy chọn như vậy trong `MAKEFLAGS`. Làm thế sẽ cho phép `make` sinh vô hạn tiến trình dựng và gây mất ổn định hệ thống.
{% endhint %}

Để dùng tất cả các lõi logic hiện có khi dựng các gói trong [Chương 5](../chapter05/chapter05.md) và [Chương 6](../chapter06/chapter06.md), hãy đặt `MAKEFLAGS` ngay bây giờ trong `.bashrc`:

```bash
cat >> ~/.bashrc << "EOF"
export MAKEFLAGS=-j$(nproc)
EOF
```

Hãy thay `$(nproc)` bằng số lõi logic bạn muốn dùng nếu không muốn dùng hết.

Cuối cùng, để đảm bảo môi trường đã sẵn sàng hoàn toàn cho việc dựng các công cụ tạm, hãy buộc shell `bash` đọc hồ sơ người dùng mới:

```bash
source ~/.bash_profile
```

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter04/settingenvironment.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter04/settingenvironment.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter04/settingenvironment.html)
