---
description: "Mục này là tùy chọn. Nếu người dùng dự định không phải lập trình viên và không định gỡ lỗi phần mềm hệ thống, bạn có thể giảm dung lượng hệ thống khoảng 2 "
---

# 8.84. Stripping

Mục này là tùy chọn. Nếu người dùng dự định không phải lập trình viên và không định gỡ lỗi phần mềm hệ thống, bạn có thể giảm dung lượng hệ thống khoảng 2 GB bằng cách loại bỏ các ký hiệu gỡ lỗi và một số mục bảng ký hiệu không cần thiết khỏi các tệp nhị phân và thư viện. Việc này không gây bất tiện thực sự nào cho người dùng Linux thông thường.

Hầu hết những người dùng các lệnh dưới đây đều không gặp khó khăn nào. Tuy nhiên, rất dễ nhầm lẫn và khiến hệ thống mới không dùng được. Vì vậy, trước khi chạy các lệnh `strip`, nên sao lưu hệ thống LFS ở trạng thái hiện tại.

Lệnh `strip` với tùy chọn `--strip-unneeded` sẽ xóa mọi ký hiệu gỡ lỗi khỏi một tệp nhị phân hoặc thư viện. Nó cũng xóa mọi mục bảng ký hiệu mà trình liên kết (với thư viện tĩnh) hoặc trình liên kết động (với tệp nhị phân liên kết động và thư viện dùng chung) thường không cần đến. Dùng `--strip-debug` thì không xóa các mục bảng ký hiệu mà một số ứng dụng có thể cần. Sự khác biệt giữa `unneeded` và `debug` rất nhỏ. Ví dụ, `libc.a` chưa strip nặng 22,4 MB. Sau khi strip với `--strip-debug` còn 5,9 MB. Dùng `--strip-unneeded` chỉ giảm thêm xuống 5,8 MB.

Các ký hiệu gỡ lỗi của một số thư viện được chọn sẽ được nén bằng `Zstd` và giữ lại trong các tệp riêng. Thông tin gỡ lỗi đó cần thiết để chạy các bài kiểm thử hồi quy với [valgrind](https://www.linuxfromscratch.org/blfs/view/12.4//general/valgrind.html) hoặc [gdb](https://www.linuxfromscratch.org/blfs/view/12.4//general/gdb.html) sau này, trong BLFS.

Lưu ý `strip` sẽ ghi đè lên tệp nhị phân hoặc thư viện mà nó đang xử lý. Điều này có thể làm sập các tiến trình đang dùng mã hoặc dữ liệu của tệp đó. Nếu tiến trình chạy `strip` bị ảnh hưởng, tệp nhị phân hoặc thư viện đang được strip có thể bị hỏng; điều này có thể khiến hệ thống hoàn toàn không dùng được. Để tránh vấn đề này, chúng ta sao chép một số thư viện và tệp nhị phân vào `/tmp`, strip ở đó, rồi cài lại bằng lệnh `install`. (Mục liên quan trong [Mục 8.2.1, “Upgrade Issues”](pkgmgt.md#pkgmgmt-upgrade-issues) giải thích lý do dùng lệnh `install` ở đây.)

{% hint style="info" %}
**Note**

Tên trình nạp ELF là ld-linux-x86-64.so.2 trên hệ thống 64-bit và ld-linux.so.2 trên hệ thống 32-bit. Đoạn lệnh dưới đây chọn đúng tên cho kiến trúc hiện tại, loại trừ mọi tên kết thúc bằng `g`, phòng trường hợp các lệnh bên dưới đã được chạy rồi.
{% endhint %}

{% hint style="warning" %}
**Important**

Nếu có gói nào mang phiên bản khác với phiên bản trong sách (do theo một thông báo bảo mật hoặc theo ý thích cá nhân), có thể bạn cần cập nhật tên tệp thư viện trong `save_usrlib` hoặc `online_usrlib`. **Nếu không làm vậy, hệ thống có thể hoàn toàn không dùng được.**
{% endhint %}

```bash
save_usrlib="$(cd /usr/lib; ls ld-linux*[^g])
             libc.so.6
             libthread_db.so.1
             libquadmath.so.0.0.0
             libstdc++.so.6.0.34
             libitm.so.1.0.0
             libatomic.so.1.2.0"

cd /usr/lib

for LIB in $save_usrlib; do
    objcopy --only-keep-debug --compress-debug-sections=zstd $LIB $LIB.dbg
    cp $LIB /tmp/$LIB
    strip --strip-debug /tmp/$LIB
    objcopy --add-gnu-debuglink=$LIB.dbg /tmp/$LIB
    install -vm755 /tmp/$LIB /usr/lib
    rm /tmp/$LIB
done

online_usrbin="bash find strip"
online_usrlib="libbfd-2.45.so
               libsframe.so.2.0.0
               libhistory.so.8.3
               libncursesw.so.6.5
               libm.so.6
               libreadline.so.8.3
               libz.so.1.3.1
               libzstd.so.1.5.7
               $(cd /usr/lib; find libnss*.so* -type f)"

for BIN in $online_usrbin; do
    cp /usr/bin/$BIN /tmp/$BIN
    strip --strip-debug /tmp/$BIN
    install -vm755 /tmp/$BIN /usr/bin
    rm /tmp/$BIN
done

for LIB in $online_usrlib; do
    cp /usr/lib/$LIB /tmp/$LIB
    strip --strip-debug /tmp/$LIB
    install -vm755 /tmp/$LIB /usr/lib
    rm /tmp/$LIB
done

for i in $(find /usr/lib -type f -name \*.so* ! -name \*dbg) \
         $(find /usr/lib -type f -name \*.a)                 \
         $(find /usr/{bin,sbin,libexec} -type f); do
    case "$online_usrbin $online_usrlib $save_usrlib" in
        *$(basename $i)* )
            ;;
        * ) strip --strip-debug $i
            ;;
    esac
done

unset BIN LIB save_usrlib online_usrbin online_usrlib
```

Nhiều tệp sẽ bị báo lỗi vì không nhận ra định dạng tệp. Bạn có thể yên tâm bỏ qua các cảnh báo này. Chúng cho biết các tệp đó là script chứ không phải tệp nhị phân.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/stripping.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/stripping.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/stripping.html)
