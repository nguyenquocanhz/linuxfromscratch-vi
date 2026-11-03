---
description: "Các lệnh trong phần còn lại của sách phải được thực hiện khi đăng nhập bằng người dùng root, không còn là người dùng lfs nữa. Đồng thời, hãy kiểm tra lại r"
---

<details>

<summary>Trick lỏ: Luôn kiểm tra $LFS trước khi chạy lệnh nguy hiểm</summary>

Lỗi kinh điển nhất của LFS: mở terminal mới, quên `export LFS=/mnt/lfs`, rồi chạy `chown -R root:root $LFS/...` hoặc `rm -rf $LFS/...`. Khi `$LFS` rỗng, lệnh đó chạy thẳng trên **thư mục gốc của máy chủ**.

Thói quen nên có:

```bash
echo "LFS=$LFS"                 # nhìn bằng mắt trước mỗi phiên
set -u                          # biến chưa đặt -> shell báo lỗi thay vì coi là chuỗi rỗng
alias lfscheck='[ "$LFS" = /mnt/lfs ] && echo OK || echo "LFS SAI: [$LFS]"'
```

Ghi `export LFS=/mnt/lfs` vào `~/.bash_profile` của **cả root lẫn lfs** để khỏi quên.

[Tất cả trick lỏ →](../trick-lo.md#kiem-tra-bien-lfs)

</details>

# 7.2. Đổi chủ sở hữu

{% hint style="info" %}
**Ghi chú**

Các lệnh trong phần còn lại của sách phải được thực hiện khi đăng nhập bằng người dùng `root`, không còn là người dùng `lfs` nữa. Đồng thời, hãy kiểm tra lại rằng `$LFS` đã được đặt trong môi trường của `root`.
{% endhint %}

Hiện tại, toàn bộ cây thư mục trong `$LFS` thuộc sở hữu của người dùng `lfs`, một người dùng chỉ tồn tại trên hệ thống chủ. Nếu giữ nguyên các thư mục và tệp dưới `$LFS`, chúng sẽ thuộc về một user ID không có tài khoản tương ứng. Điều này nguy hiểm vì một tài khoản được tạo sau này có thể nhận đúng user ID đó và sở hữu toàn bộ tệp dưới `$LFS`, khiến các tệp này có nguy cơ bị thao túng độc hại.

Để giải quyết vấn đề này, hãy đổi chủ sở hữu của các thư mục `$LFS/*` thành người dùng `root` bằng lệnh sau:

```bash
chown --from lfs -R root:root $LFS/{usr,var,etc,tools}
case $(uname -m) in
  x86_64) chown --from lfs -R root:root $LFS/lib64 ;;
esac
```

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/changingowner.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/changingowner.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/changingowner.html)
